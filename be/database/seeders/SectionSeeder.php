<?php

namespace Database\Seeders;

use App\Models\Section;
use Illuminate\Database\Seeder;

class SectionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            [
                'year_level' => 'I',
                'section' => 'Section I'
            ],
            [
                'year_level' => 'I',
                'section' => 'Section II'
            ],
            [
                'year_level' => 'I',
                'section' => 'Section III'
            ],
            [
                'year_level' => 'I',
                'section' => 'Section IV'
            ],
            [
                'year_level' => 'I',
                'section' => 'Section V'
            ],
            [
                'year_level' => 'II',
                'section' => 'Section I'
            ],
            [
                'year_level' => 'II',
                'section' => 'Section II'
            ],
            [
                'year_level' => 'II',
                'section' => 'Section III'
            ],
            [
                'year_level' => 'II',
                'section' => 'Section IV'
            ],
            [
                'year_level' => 'II',
                'section' => 'Section V'
            ],
            [
                'year_level' => 'III',
                'section' => 'Section I'
            ],
            [
                'year_level' => 'III',
                'section' => 'Section II'
            ],
            [
                'year_level' => 'III',
                'section' => 'Section III'
            ],
            [
                'year_level' => 'III',
                'section' => 'Section IV'
            ],
            [
                'year_level' => 'III',
                'section' => 'Section V'
            ],
            [
                'year_level' => 'IV',
                'section' => 'Section I'
            ],
            [
                'year_level' => 'IV',
                'section' => 'Section II'
            ],
            [
                'year_level' => 'IV',
                'section' => 'Section III'
            ],
            [
                'year_level' => 'IV',
                'section' => 'Section IV'
            ],
            [
                'year_level' => 'IV',
                'section' => 'Section V'
            ],
        ];

        foreach($data as $section) {
            Section::create($section);
        }
    }
}
