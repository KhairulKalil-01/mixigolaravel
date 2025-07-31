<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Nationality;

class NationalitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $nationalities = [
            [
                'country_name' => 'Malaysia',
                'nationality' => 'Malaysian',
            ],
            [
                'country_name' => 'Indonesia',
                'nationality' => 'Indonesian',
            ],
            [
                'country_name' => 'Philippines',
                'nationality' => 'Filipino',
            ],
            [
                'country_name' => 'Bangladesh',
                'nationality' => 'Bangladeshi',
            ],
            [
                'country_name' => 'India',
                'nationality' => 'Indian',
            ],
            [
                'country_name' => 'Pakistan',
                'nationality' => 'Pakistani',
            ],
            [
                'country_name' => 'Sri Lanka',
                'nationality' => 'Sri Lankan',
            ],
            [
                'country_name' => 'Nepal',
                'nationality' => 'Nepalese',
            ],
            [
                'country_name' => 'Vietnam',
                'nationality' => 'Vietnamese',
            ],
            [
                'country_name' => 'Thailand',
                'nationality' => 'Thai',
            ],
        ];

        foreach ($nationalities as $item) {
            Nationality::create($item);
        }
    }
}
