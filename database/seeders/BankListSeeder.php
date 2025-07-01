<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\BankList;

class BankListSeeder extends Seeder
{
    public function run(): void
    {
        $banks = [
            ['bank_name' => 'Affin Bank'],
            ['bank_name' => 'Alliance Bank'],
            ['bank_name' => 'AmBank'],
            ['bank_name' => 'Bank Islam'],
            ['bank_name' => 'Bank Muamalat'],
            ['bank_name' => 'Bank Rakyat'],
            ['bank_name' => 'Bank Simpanan Nasional'],
            ['bank_name' => 'CIMB Bank'],
            ['bank_name' => 'Citibank Malaysia'],
            ['bank_name' => 'Hong Leong Bank'],
            ['bank_name' => 'HSBC Bank Malaysia'],
            ['bank_name' => 'Maybank'],
            ['bank_name' => 'OCBC Bank Malaysia'],
            ['bank_name' => 'Public Bank'],
            ['bank_name' => 'RHB Bank'],
            ['bank_name' => 'Standard Chartered Bank Malaysia'],
            ['bank_name' => 'UOB Malaysia'],
            ['bank_name' => 'TNG eWallet'],
        ];

        foreach ($banks as $bank) {
            BankList::firstOrCreate(['bank_name' => $bank['bank_name']]);
        }
    }
}
