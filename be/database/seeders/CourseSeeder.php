<?php

namespace Database\Seeders;

use App\Models\Course;
use Illuminate\Database\Seeder;

class CourseSeeder extends Seeder
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
                'college_id' => rand(1, 6),
                'course' => 'Course 1 Sample',
                'abbreviation' => 'C1S',
            ],
            [
                'college_id' => rand(1, 6),
                'course' => 'Course 2 Sample',
                'abbreviation' => 'C2S',
            ],
            [
                'college_id' => rand(1, 6),
                'course' => 'Course 3 Sample',
                'abbreviation' => 'C3S',
            ],
            [
                'college_id' => rand(1, 6),
                'course' => 'Course 4 Sample',
                'abbreviation' => 'C4S',
            ],
            [
                'college_id' => rand(1, 6),
                'course' => 'Course 5 Sample',
                'abbreviation' => 'C5S',
            ],
            [
                'college_id' => rand(1, 6),
                'course' => 'Course 6 Sample',
                'abbreviation' => 'C6S',
            ],
            [
                'college_id' => rand(1, 6),
                'course' => 'Course 7 Sample',
                'abbreviation' => 'C7S',
            ],
            [
                'college_id' => rand(1, 6),
                'course' => 'Course 8 Sample',
                'abbreviation' => 'C8S',
            ],
            [
                'college_id' => rand(1, 6),
                'course' => 'Course 9 Sample',
                'abbreviation' => 'C9S',
            ],
            [
                'college_id' => rand(1, 6),
                'course' => 'Course 10 Sample',
                'abbreviation' => 'C10S',
            ],
            [
                'college_id' => rand(1, 6),
                'course' => 'Course 11 Sample',
                'abbreviation' => 'C11S',
            ],
        ];

        foreach($data as $course) {
            Course::create($course);
        }
    }
}
