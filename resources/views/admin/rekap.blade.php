@extends('layouts.admin')

@section('title', 'Rekap Kas')

@push('styles')
    <style>
        .view-btn {
            padding: 0.625rem 1.25rem;
            text-decoration: none;
            color: var(--text-muted);
            font-size: 0.875rem;
            font-weight: 700;
            border-radius: 0.875rem;
            transition: all 0.25s;
        }
        .view-btn.active {
            background: white;
            color: var(--primary);
            box-shadow: var(--shadow);
        }

        /* Matrix Specifics */
        .excel-table td { padding: 0.75rem 0.5rem; text-align: center; border: 1px solid var(--bg-main); font-size: 0.8125rem; }
        .excel-table th { border: 1px solid var(--bg-main); font-size: 0.75rem; }
        .cell-has-data { background: #ecfdf5; color: #059669; font-weight: 800; }
        .cell-has-out { background: #fff1f2; color: #e11d48; font-weight: 800; }
        .cell-empty { color: #e2e8f0; }

        @media print {
            .no-print, .sidebar, .main-content > .mb-8, .btn, .btn-primary { display: none !important; }
            .main-content { margin-left: 0 !important; padding: 0 !important; width: 100% !important; }
            .card { box-shadow: none !important; border: 1px solid #000 !important; border-radius: 0 !important; }
            .table-container { box-shadow: none !important; border: 1px solid #000 !important; border-radius: 0 !important; }
            table { font-size: 0.6rem !important; }
            th, td { border: 1px solid #000 !important; padding: 0.2rem !important; }
            @page { size: landscape; margin: 1cm; }
        }
    </style>
@endpush

@section('content')
    <div class="no-print mb-8" style="display: flex; justify-content: space-between; align-items: flex-end;">
        <div>
            <h2 class="text-2xl font-black">Rekapitulasi Kas</h2>
            <p style="color: var(--text-muted); font-size: 1.125rem;">Laporan periode <strong>{{ date('F Y', mktime(0, 0, 0, $month, 1, $year)) }}</strong></p>
        </div>
        <div style="display: flex; gap: 1.25rem; align-items: center;">
            <form action="{{ route('admin.rekap') }}" method="GET" style="display: flex; gap: 0.25rem; background: #fff; padding: 0.35rem; border-radius: 1.125rem; box-shadow: var(--shadow);">
                <input type="hidden" name="view" value="{{ $viewType }}">
                <select name="month" onchange="this.form.submit()" style="padding: 0.5rem 0.75rem; border: none; font-weight: 800; cursor: pointer; background: transparent; outline: none; color: var(--text-main); font-size: 0.875rem; margin-top: 0;">
                    @for ($m = 1; $m <= 12; $m++)
                        <option value="{{ sprintf('%02d', $m) }}" {{ $month == sprintf('%02d', $m) ? 'selected' : '' }}>
                            {{ date('F', mktime(0, 0, 0, $m, 1)) }}
                        </option>
                    @endfor
                </select>
                <div style="width: 2px; background: var(--bg-main); height: 20px; align-self: center;"></div>
                <select name="year" onchange="this.form.submit()" style="padding: 0.5rem 0.75rem; border: none; font-weight: 800; cursor: pointer; background: transparent; outline: none; color: var(--text-main); font-size: 0.875rem; margin-top: 0;">
                    @for ($y = date('Y'); $y >= date('Y') - 2; $y--)
                        <option value="{{ $y }}" {{ $year == $y ? 'selected' : '' }}>{{ $y }}</option>
                    @endfor
                </select>
            </form>

            <div style="display: flex; gap: 0.25rem; background: var(--primary-light); padding: 0.35rem; border-radius: 1.125rem;">
                <a href="{{ route('admin.rekap', ['view' => 'summary', 'month' => $month, 'year' => $year]) }}" class="view-btn {{ $viewType === 'summary' ? 'active' : '' }}">Ringkasan</a>
                <a href="{{ route('admin.rekap', ['view' => 'matrix', 'month' => $month, 'year' => $year]) }}" class="view-btn {{ $viewType === 'matrix' ? 'active' : '' }}">Matriks</a>
            </div>

            <button onclick="window.print()" class="btn btn-primary">
                <i data-lucide="printer"></i> Cetak
            </button>
        </div>
    </div>

    <!-- Print Header Only -->
    <div class="print-only" style="display: none; text-align: center; margin-bottom: 3rem; border-bottom: 3px solid #000; padding-bottom: 1.5rem;">
        <h1 style="font-size: 2rem; font-weight: 900; margin-bottom: 0.5rem;">LAPORAN ARUS KAS KELAS</h1>
        <p style="font-size: 1.25rem; font-weight: 700; color: var(--primary);">Periode: {{ date('F Y', mktime(0, 0, 0, $month, 1, $year)) }}</p>
    </div>

    <div class="table-container">
        <div style="padding: 2rem; border-bottom: 2px solid var(--bg-main); display: flex; justify-content: space-between; align-items: center;" class="no-print">
            <h3 class="text-xl font-bold">{{ $viewType === 'summary' ? 'Ringkasan Iuran' : 'Matriks Setoran Harian' }}</h3>
            <div class="status-badge status-success" style="font-size: 0.65rem;">
                <i data-lucide="check-circle-2" style="width: 14px;"></i> TERVERIFIKASI
            </div>
        </div>

        <div style="overflow-x: auto;">
            <table class="{{ $viewType === 'matrix' ? 'excel-table' : '' }}">
                <thead>
                    @if ($viewType === 'summary')
                        <tr>
                            <th style="width: 80px;">No</th>
                            <th>Mahasiswa</th>
                            <th style="text-align: right;">Setoran (Bulan Ini)</th>
                            <th style="text-align: right;">Penarikan (Bulan Ini)</th>
                            <th style="text-align: right; background: var(--primary-light); color: var(--primary);">Saldo Akhir</th>
                        </tr>
                    @else
                        <tr>
                            <th rowspan="2" style="width: 50px;">No</th>
                            <th rowspan="2" style="min-width: 200px;">Nama Mahasiswa</th>
                            <th colspan="{{ $numDays }}" style="text-align: center; border-bottom: 2px solid var(--bg-main);">Tanggal</th>
                            <th rowspan="2" style="text-align: right; min-width: 120px;">Total</th>
                        </tr>
                        <tr>
                            @for ($d = 1; $d <= $numDays; $d++)
                                <th style="text-align: center; width: 40px; font-size: 0.65rem;">{{ $d }}</th>
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
                            $totalSaldo = $balances[$accId] ?? 0;
                        @endphp
                        <tr>
                            <td style="text-align: center; font-weight: 800; color: var(--text-muted);">{{ str_pad($index + 1, 2, '0', STR_PAD_LEFT) }}</td>
                            <td>
                                <div style="font-weight: 700; color: var(--text-main);">{{ $s->name }}</div>
                                <div style="font-size: 0.75rem; color: var(--text-muted);">{{ $s->npm }}</div>
                            </td>

                            @if ($viewType === 'summary')
                                <td style="text-align: right; color: var(--success); font-weight: 800;">Rp {{ number_format($setor, 0, ',', '.') }}</td>
                                <td style="text-align: right; color: var(--danger); font-weight: 700;">Rp {{ number_format($keluar, 0, ',', '.') }}</td>
                                <td style="text-align: right; font-weight: 900; color: var(--primary); background: var(--primary-light);">Rp {{ number_format($totalSaldo, 0, ',', '.') }}</td>
                            @else
                                @for ($d = 1; $d <= $numDays; $d++)
                                    @php $dayVal = $matrix[$accId][$d] ?? 0; @endphp
                                    <td class="{{ $dayVal > 0 ? 'cell-has-data' : ($dayVal < 0 ? 'cell-has-out' : 'cell-empty') }}">
                                        @if ($dayVal > 0)
                                            {{ number_format($dayVal, 0, ',', '.') }}
                                        @elseif ($dayVal < 0)
                                            ({{ number_format(abs($dayVal), 0, ',', '.') }})
                                        @else
                                            -
                                        @endif
                                    </td>
                                @endfor
                                <td style="text-align: right; font-weight: 900; color: {{ ($setor - $keluar) >= 0 ? 'var(--primary)' : 'var(--danger)' }};">
                                    {{ number_format($setor - $keluar, 0, ',', '.') }}
                                </td>
                            @endif
                        </tr>
                    @endforeach
                </tbody>
                <tfoot style="background: var(--bg-main);">
                    <tr style="font-weight: 900;">
                        <td colspan="2" style="text-align: right; text-transform: uppercase; font-size: 0.75rem;">Total Kolektif</td>
                        @if ($viewType === 'summary')
                            <td style="text-align: right; color: var(--success);">Rp {{ number_format(collect($monthlyTotals)->sum('setor'), 0, ',', '.') }}</td>
                            <td style="text-align: right; color: var(--danger);">Rp {{ number_format(collect($monthlyTotals)->sum('keluar'), 0, ',', '.') }}</td>
                            <td style="text-align: right; background: var(--primary); color: white;">Rp {{ number_format(collect($balances)->sum(), 0, ',', '.') }}</td>
                        @else
                            @for ($d = 1; $d <= $numDays; $d++)
                                @php
                                    $colSum = 0;
                                    foreach($matrix as $userDays) $colSum += $userDays[$d] ?? 0;
                                @endphp
                                <td style="text-align: center; font-size: 0.65rem; color: {{ $colSum >= 0 ? 'inherit' : 'var(--danger)' }};">
                                    @if ($colSum != 0)
                                        {{ number_format($colSum, 0, ',', '.') }}
                                    @else
                                        -
                                    @endif
                                </td>
                            @endfor
                            <td style="text-align: right; background: var(--primary); color: white;">
                                {{ number_format(collect($monthlyTotals)->sum('setor') - collect($monthlyTotals)->sum('keluar'), 0, ',', '.') }}
                            </td>
                        @endif
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
@endsection
