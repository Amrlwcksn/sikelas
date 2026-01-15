<?php

namespace Database\Seeders;

use App\Models\Account;
use App\Models\Transaction;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class StudentTransactionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create 10 Students with Real Names
        $names = [
            'Aditya Pratama',
            'Budi Santoso',
            'Citra Dewi',
            'Dewi Lestari',
            'Eko Kurniawan',
            'Fajar Nugraha',
            'Gita Gutawa',
            'Hendra Setiawan',
            'Indah Permata',
            'Joko Widodo'
        ];

        foreach ($names as $index => $name) {
            $i = $index + 1;
            // Generate email from name (lowercase, no spaces)
            $emailName = strtolower(str_replace(' ', '', $name));
            
            $user = User::create([
                'name' => $name,
                'npm' => "2024" . str_pad($i, 4, '0', STR_PAD_LEFT),
                'email' => "{$emailName}@student.com",
                'password' => Hash::make('password'),
                'role' => 'mahasiswa',
            ]);

            $account = Account::create(['user_id' => $user->id]);

            // Determine if this student is "diligent" (full payment) or "irregular"
            // Let's say 70% are diligent, 30% have missed some
            $isDiligent = rand(1, 100) <= 70;

            // Loop through last 4 weeks
            for ($w = 0; $w < 4; $w++) {
                // If not diligent, random chance to skip a week
                if (!$isDiligent && rand(0, 1) === 1) {
                    continue;
                }

                // Generate date within the current month (Weeks 1-4)
                $date = Carbon::now()->startOfMonth()->addWeeks($w)->addDays(rand(0, 4));
                
                // Ensure we don't go into next month just in case
                if ($date->month != Carbon::now()->month) {
                   $date = Carbon::now()->endOfMonth()->subDays(rand(1, 5));
                }

                Transaction::create([
                    'account_id' => $account->id,
                    'jenis' => 'setor',
                    'jumlah' => 10000,
                    'tanggal' => $date,
                    'keterangan' => 'Tabungan Mingguan',
                    // Assuming created_by is required and references an admin/user. 
                    // We'll use the first user (likely admin) or the user themselves if allowed.
                    // Ideally this should be an admin ID. Let's assume ID 1 is Admin.
                    'created_by' => 1, 
                ]);
            }
        }
    }
}
