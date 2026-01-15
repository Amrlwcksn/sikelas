@extends('layouts.admin')

@section('title', 'Rekapitulasi Kas')

@push('styles')
    <style>
        .view-toggle {
            display: flex;
            background: var(--bg-main);
            padding: 0.35rem;
            border-radius: 1rem;
            gap: 0.25rem;
        }
        .view-toggle-btn {
            padding: 0.625rem 1.25rem;
            text-decoration: none;
            color: var(--secondary);
            font-size: 0.8125rem;
            font-weight: 800;
            border-radius: 0.75rem;
            transition: all 0.2s;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }
        .view-toggle-btn.active {
            background: white;
            color: var(--primary);
            box-shadow: var(--shadow-soft);
        }

        /* Matrix Table Specifics - Compressed for Laptop */
        .excel-table td { 
            padding: 0.35rem 0.25rem; 
            text-align: center; 
            border: 1px solid var(--border); 
            font-size: 0.7rem; 
            font-weight: 700;
        }
        .excel-table th { 
            background: #f8fafc;
            border: 1px solid var(--border); 
            font-size: 0.6rem; 
            text-transform: uppercase;
            font-weight: 800;
            color: var(--secondary);
            padding: 0.35rem 0.25rem;
        }
        .cell-has-data { background: rgba(16, 185, 129, 0.08); color: var(--success); }
        .cell-has-out { background: rgba(239, 68, 68, 0.08); color: var(--danger); }
        .cell-empty { color: #cbd5e1; font-weight: 400 !important; }

        @media print {
            /* Reset Page & Body */
            @page { size: landscape; margin: 1cm; }
            body, html { width: 100% !important; height: auto !important; margin: 0 !important; padding: 0 !important; background: white !important; -webkit-print-color-adjust: exact; overflow: visible !important; }
            
            /* Unset Flex/Grid Layouts */
            .admin-container, .main-content { display: block !important; width: 100% !important; margin: 0 !important; padding: 0 !important; height: auto !important; overflow: visible !important; }
            
            /* Aggressively Hide Web UI */
            .sidebar, #sidebar, .mobile-nav-toggle, #menuToggle, .header-content, header, .no-print, .view-toggle, .btn { display: none !important; }
            
            /* Hide Alerts or other siblings */
            .main-content > div:not(.glass-card):not(.print-header):not(.print-signatures) { display: none !important; }

            /* Fix Table Container Clipping */
            .glass-card { 
                background: transparent !important; 
                border: none !important; 
                box-shadow: none !important; 
                border-radius: 0 !important; 
                padding: 0 !important; 
                margin: 0 !important;
                overflow: visible !important; /* Critical Fix */
                display: block !important;
            }
            .glass-card > div { overflow: visible !important; } /* Fix inner wrapper scrolling */

            /* Table Styling */
            table { width: 100% !important; border-collapse: collapse !important; font-size: 8pt !important; table-layout: auto !important; }
            th, td { border: 1px solid #000 !important; padding: 4px 6px !important; color: black !important; background: white !important; }
            th { border-bottom: 2px solid #000 !important; font-weight: 800 !important; text-align: center !important; text-transform: uppercase !important; white-space: nowrap !important; }

            /* Fix Total Font Visibility (Override inline styles) */
            td[style*="background: var(--primary)"], td[style*="background: var(--danger)"], td[style*="background: #f8fafc"] { 
                background: white !important; 
                color: black !important; 
                font-weight: 800 !important;
            }

            /* Fix Alignment */
            td { vertical-align: middle !important; }
            
            /* Remove digital indicators */
            .cell-has-data, .cell-has-out, .cell-empty { background: transparent !important; color: black !important; }

            /* Ensure Headers and Signatures are Visible */
            .print-header { display: block !important; margin-bottom: 1.5rem !important; page-break-after: avoid; }
            .print-signatures { display: flex !important; margin-top: 3rem !important; page-break-inside: avoid; }
        }
    </style>
@endpush

@section('content')
    <div class="print-header" style="display: none; border-bottom: 2px solid black; margin-bottom: 2rem; padding-bottom: 1rem; position: relative;">
        <!-- Document Code -->
        <div style="position: absolute; top: 0; right: 0; text-align: right;">
            <p style="font-size: 8pt; font-weight: bold; border: 1px solid black; padding: 2px 6px; display: inline-block;">DOK.ID: FIN-01.REKAP</p>
            <p style="font-size: 7pt; margin-top: 2px;">REKAPITULASI BUKTI KAS KELAS</p>
        </div>

        <div style="display: flex; align-items: center; gap: 1.5rem;">
            <div>
                <h1 style="font-size: 18pt; font-weight: 900; text-transform: uppercase; line-height: 1;">GENITE24 FINANCE</h1>
                <p style="font-size: 10pt; font-weight: bold; letter-spacing: 2px; text-transform: uppercase; margin-top: 4px;">Sikelas Integrated System</p>
                <p style="font-size: 9pt; margin-top: 4px;">Laporan Keuangan Periode: {{ date('F Y', mktime(0, 0, 0, $month, 1, $year)) }}</p>
            </div>
        </div>
    </div>
    <div class="no-print mb-8" style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 1.5rem;">
        <div>
            <h2 class="text-2xl font-black">Financial Statements</h2>
            <p style="color: var(--text-muted); font-size: 1.125rem;">Laporan periode <strong>{{ date('F Y', mktime(0, 0, 0, $month, 1, $year)) }}</strong></p>
        </div>
        
        <div style="display: flex; gap: 1rem; align-items: center; flex-wrap: wrap;">
            <!-- Period Selector -->
            <form action="{{ route('admin.rekap') }}" method="GET" class="glass-card" style="padding: 0.4rem; display: flex; align-items: center; gap: 0.5rem; border-radius: 1.25rem; background: white;">
                <input type="hidden" name="view" value="{{ $viewType }}">
                <select name="month" onchange="this.form.submit()" style="padding: 0.5rem 1rem; border: none; font-weight: 800; background: transparent; color: var(--primary); font-size: 0.8125rem; cursor: pointer; border-radius: 0.875rem;">
                    @for ($m = 1; $m <= 12; $m++)
                        <option value="{{ sprintf('%02d', $m) }}" {{ $month == sprintf('%02d', $m) ? 'selected' : '' }}>
                            {{ date('F', mktime(0, 0, 0, $m, 1)) }}
                        </option>
                    @endfor
                </select>
                <div style="height: 20px; width: 1px; background: var(--border);"></div>
                <select name="year" onchange="this.form.submit()" style="padding: 0.5rem 1rem; border: none; font-weight: 800; background: transparent; color: var(--primary); font-size: 0.8125rem; cursor: pointer; border-radius: 0.875rem;">
                    @for ($y = date('Y'); $y >= date('Y') - 2; $y--)
                        <option value="{{ $y }}" {{ $year == $y ? 'selected' : '' }}>{{ $y }}</option>
                    @endfor
                </select>
            </form>

            <div class="view-toggle">
                <a href="{{ route('admin.rekap', ['view' => 'summary', 'month' => $month, 'year' => $year]) }}" class="view-toggle-btn {{ $viewType === 'summary' ? 'active' : '' }}">Summary</a>
                <a href="{{ route('admin.rekap', ['view' => 'matrix', 'month' => $month, 'year' => $year]) }}" class="view-toggle-btn {{ $viewType === 'matrix' ? 'active' : '' }}">Matrix</a>
            </div>

            <button onclick="window.print()" class="btn btn-outline" style="padding: 0.875rem 1.5rem; border-radius: 1rem;">
                <i data-lucide="printer"></i> Print Report
            </button>
        </div>
    </div>

    <!-- Professional Print Header (Hidden on Screen) -->
    <div class="print-header" style="display: none; text-align: center; margin-bottom: 2rem; border-bottom: 2px solid #000; padding-bottom: 1.5rem;">
        <h1 style="font-size: 1.5rem; font-weight: 950; text-transform: uppercase; margin-bottom: 0.25rem;">Sikelas Financial Ecosystem</h1>
        <h2 style="font-size: 1.1rem; font-weight: 800;">Monthly Cashflow Audit Report</h2>
        <p style="font-size: 0.85rem; color: #444; margin-top: 0.25rem;">Period: {{ date('F Y', mktime(0, 0, 0, $month, 1, $year)) }}</p>
    </div>

    <div class="glass-card" style="background: white; padding: 0; overflow: hidden; border-radius: 1.5rem;">
        <div style="padding: 1.5rem; border-bottom: 1px solid var(--border); display: flex; justify-content: space-between; align-items: center;" class="no-print">
            <h3 class="text-xl font-bold" style="color: var(--primary);">{{ $viewType === 'summary' ? 'Kolektif Ringkasan Iuran' : 'Daily Contribution Matrix' }}</h3>
            <div style="display: flex; align-items: center; gap: 0.5rem; background: var(--bg-main); padding: 0.5rem 1rem; border-radius: 2rem;">
                <div style="width: 8px; height: 8px; background: #10b981; border-radius: 50%;"></div>
                <span style="font-size: 0.65rem; font-weight: 900; color: var(--secondary); text-transform: uppercase; letter-spacing: 0.05em;">Audited System</span>
            </div>
        </div>

        <div style="overflow-x: auto;">
            <table class="{{ $viewType === 'matrix' ? 'excel-table' : '' }}" style="width: 100%; border-collapse: collapse;">
                <thead>
                    @if ($viewType === 'summary')
                        <tr>
                            <th style="padding: 1rem 1.5rem; background: #f8fafc; text-align: left; font-size: 0.7rem; text-transform: uppercase; color: var(--secondary); border-bottom: 1px solid var(--border); width: 60px;">ID</th>
                            <th style="padding: 1rem 1.5rem; background: #f8fafc; text-align: left; font-size: 0.7rem; text-transform: uppercase; color: var(--secondary); border-bottom: 1px solid var(--border);">Account Holder</th>
                            <th style="padding: 1rem 1.5rem; background: #f8fafc; text-align: right; font-size: 0.7rem; text-transform: uppercase; color: var(--secondary); border-bottom: 1px solid var(--border);">Credit (+)</th>
                            <th style="padding: 1rem 1.5rem; background: #f8fafc; text-align: right; font-size: 0.7rem; text-transform: uppercase; color: var(--secondary); border-bottom: 1px solid var(--border);">Debit (-)</th>
                            <th style="padding: 1rem 1.5rem; background: var(--primary-light); text-align: right; font-size: 0.7rem; text-transform: uppercase; color: var(--primary); border-bottom: 1px solid var(--border);">Saldo Periode</th>
                        </tr>
                    @else
                        <tr>
                            <th rowspan="2" style="width: 40px;">NO</th>
                            <th rowspan="2" style="min-width: 180px; text-align: left; padding-left: 0.5rem;">CASH ACCOUNT NAME</th>
                            <th colspan="{{ $numDays }}" style="text-align: center;">SETTLEMENT DATES ({{ date('M Y', mktime(0, 0, 0, $month, 1, $year)) }})</th>
                            <th rowspan="2" style="text-align: right; min-width: 100px; padding-right: 0.5rem;">Total</th>
                        </tr>
                        <tr>
                            @for ($d = 1; $d <= $numDays; $d++)
                                <th style="text-align: center;">{{ $d }}</th>
                            @endfor
                        </tr>
                    @endif
                </thead>
                <tbody>
                    @foreach ($students as $index => $s)
                        @php
                            $accId = $s->account->id ?? 0;
                            $setor = $monthlyTotals[$accId]['setor'] ?? 0;
                            $keluar = $monthlyTotals[$accId]['keluar'] ?? 0;
                            $totalSaldo = $setor - $keluar;
                        @endphp
                        <tr>
                            @if ($viewType === 'summary')
                                <td style="padding: 1rem 1.5rem; border-bottom: 1px solid var(--border); font-weight: 800; color: var(--text-muted); font-size: 0.8125rem;">{{ str_pad($index + 1, 2, '0', STR_PAD_LEFT) }}</td>
                                <td style="padding: 1rem 1.5rem; border-bottom: 1px solid var(--border);">
                                    <div style="font-weight: 800; color: var(--primary);">{{ $s->name }}</div>
                                    <div style="font-size: 0.65rem; color: var(--secondary); font-weight: 700; text-transform: uppercase; margin-top: 2px;">{{ $s->npm }}</div>
                                </td>
                                <td style="padding: 1rem 1.5rem; border-bottom: 1px solid var(--border); text-align: right; color: var(--success); font-weight: 800;">Rp {{ number_format($setor, 0, ',', '.') }}</td>
                                <td style="padding: 1rem 1.5rem; border-bottom: 1px solid var(--border); text-align: right; color: var(--danger); font-weight: 700;">Rp {{ number_format($keluar, 0, ',', '.') }}</td>
                                <td style="padding: 1rem 1.5rem; border-bottom: 1px solid var(--border); text-align: right; font-weight: 900; color: var(--primary); background: rgba(37, 99, 235, 0.02);">Rp {{ number_format($totalSaldo, 0, ',', '.') }}</td>
                            @else
                                <td style="text-align: center; font-weight: 800; color: var(--secondary);">{{ $index + 1 }}</td>
                                <td style="padding-left: 0.5rem; text-align: left; font-weight: 800; color: var(--primary); font-size: 0.7rem;">
                                    {{ Str::limit($s->name, 20) }}
                                </td>
                                @for ($d = 1; $d <= $numDays; $d++)
                                    @php $dayVal = $matrix[$accId][$d] ?? 0; @endphp
                                    <td class="{{ $dayVal > 0 ? 'cell-has-data' : ($dayVal < 0 ? 'cell-has-out' : 'cell-empty') }}">
                                        @if ($dayVal > 0)
                                            {{ number_format($dayVal / 1000, 0, ',', '.') }}k
                                        @elseif ($dayVal < 0)
                                            <span style="font-size: 0.6rem;">({{ number_format(abs($dayVal) / 1000, 0, ',', '.') }}k)</span>
                                        @else
                                            -
                                        @endif
                                    </td>
                                @endfor
                                <td style="text-align: right; padding-right: 0.5rem; font-weight: 900; color: {{ ($setor - $keluar) >= 0 ? 'var(--primary)' : 'var(--danger)' }}; background: #f8fafc;">
                                    {{ number_format(($setor - $keluar)/1000, 0, ',', '.') }}k
                                </td>
                            @endif
                        </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr style="background: var(--bg-main); border-top: 2px solid var(--border);">
                        @if ($viewType === 'summary')
                            <td colspan="2" style="padding: 1.5rem 2rem; text-align: right; text-transform: uppercase; font-size: 0.65rem; font-weight: 900; color: var(--secondary);">CONSOLIDATED TOTAL</td>
                            <td style="padding: 1.5rem 2rem; text-align: right; color: var(--success); font-weight: 900; font-size: 1rem;">Rp {{ number_format(collect($monthlyTotals)->sum('setor'), 0, ',', '.') }}</td>
                            <td style="padding: 1.5rem 2rem; text-align: right; color: var(--danger); font-weight: 900; font-size: 1rem;">Rp {{ number_format(collect($monthlyTotals)->sum('keluar'), 0, ',', '.') }}</td>
                            <td style="padding: 1.5rem 2rem; text-align: right; background: var(--primary); color: white; font-weight: 950; font-size: 1.125rem;">Rp {{ number_format(collect($monthlyTotals)->sum('setor') - collect($monthlyTotals)->sum('keluar'), 0, ',', '.') }}</td>
                        @else
                            <td colspan="2" style="text-align: right; padding-right: 0.5rem; text-transform: uppercase; font-size: 0.6rem; font-weight: 900; color: var(--secondary);">Daily Vault Sum</td>
                            @for ($d = 1; $d <= $numDays; $d++)
                                @php
                                    $colSum = 0;
                                    foreach($matrix as $userDays) $colSum += $userDays[$d] ?? 0;
                                @endphp
                                <td style="text-align: center; font-size: 0.6rem; font-weight: 800; color: {{ $colSum >= 0 ? 'var(--primary)' : 'var(--danger)' }};">
                                    @if ($colSum != 0)
                                        {{ number_format(abs($colSum) / 1000, 0, ',', '.') }}k{{ $colSum < 0 ? '-' : '' }}
                                    @else
                                        -
                                    @endif
                                </td>
                            @endfor
                            <td style="text-align: right; padding-right: 0.5rem; background: var(--primary); color: white; font-weight: 950;">
                                {{ number_format((collect($monthlyTotals)->sum('setor') - collect($monthlyTotals)->sum('keluar'))/1000, 0, ',', '.') }}k
                            </td>
                        @endif
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>

    <!-- Signatures for Print -->
    <div class="print-signatures" style="display: none; margin-top: 3rem; justify-content: space-between; padding: 0 4rem;">
        <div style="text-align: center; width: 200px;">
            <p style="margin-bottom: 5rem; font-weight: 700; font-size: 0.8rem; text-transform: uppercase; color: #000;">Komting Kelas</p>
            <p style="font-weight: 800; text-decoration: underline; color: #000;">( ........................... )</p>
        </div>
        <div style="text-align: center; width: 200px;">
            <p style="margin-bottom: 5rem; font-weight: 700; font-size: 0.8rem; text-transform: uppercase; color: #000;">Bendahara Kelas</p>
            <p style="font-weight: 800; text-decoration: underline; color: #000;">( ........................... )</p>
        </div>
    </div>
@endsection
