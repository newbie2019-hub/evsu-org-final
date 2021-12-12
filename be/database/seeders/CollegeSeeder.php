<?php

namespace Database\Seeders;

use App\Models\College;
use Illuminate\Database\Seeder;

class CollegeSeeder extends Seeder
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
                'college' => 'College of Architecture and Allied Discipline',
                'abbreviation' => 'CAAD',
                'mission' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nulla pretium leo sit amet nulla viverra ultricies. Maecenas aliquet malesuada sodales. Nunc semper suscipit libero luctus ullamcorper.',
                'vision' => 'Vivamus eu tristique ipsum, vitae blandit leo. Nulla at posuere leo. Nullam in lectus et neque facilisis convallis a sed quam.'
            ],
            [
                'college' => 'College of Arts and Sciences',
                'abbreviation' => 'CAS',
                'mission' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nulla pretium leo sit amet nulla viverra ultricies. Maecenas aliquet malesuada sodales. Nunc semper suscipit libero luctus ullamcorper.',
                'vision' => 'Vivamus eu tristique ipsum, vitae blandit leo. Nulla at posuere leo. Nullam in lectus et neque facilisis convallis a sed quam.'
            ],
            [
                'college' => 'College of Business and Entrepreneurship',
                'abbreviation' => 'COBE',
                'mission' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nulla pretium leo sit amet nulla viverra ultricies. Maecenas aliquet malesuada sodales. Nunc semper suscipit libero luctus ullamcorper.',
                'vision' => 'Vivamus eu tristique ipsum, vitae blandit leo. Nulla at posuere leo. Nullam in lectus et neque facilisis convallis a sed quam.'
            ],
            [
                'college' => 'College of Education',
                'abbreviation' => 'COEd',
                'mission' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nulla pretium leo sit amet nulla viverra ultricies. Maecenas aliquet malesuada sodales. Nunc semper suscipit libero luctus ullamcorper.',
                'vision' => 'Vivamus eu tristique ipsum, vitae blandit leo. Nulla at posuere leo. Nullam in lectus et neque facilisis convallis a sed quam.'
            ],
            [
                'college' => 'College of Engineering',
                'abbreviation' => 'COE',
                'mission' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nulla pretium leo sit amet nulla viverra ultricies. Maecenas aliquet malesuada sodales. Nunc semper suscipit libero luctus ullamcorper.',
                'vision' => 'Vivamus eu tristique ipsum, vitae blandit leo. Nulla at posuere leo. Nullam in lectus et neque facilisis convallis a sed quam.'
            ],
            [
                'college' => 'College of Technology',
                'abbreviation' => 'COT',
                'mission' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nulla pretium leo sit amet nulla viverra ultricies. Maecenas aliquet malesuada sodales. Nunc semper suscipit libero luctus ullamcorper.',
                'vision' => 'Vivamus eu tristique ipsum, vitae blandit leo. Nulla at posuere leo. Nullam in lectus et neque facilisis convallis a sed quam.'
            ],
        ];

        foreach($data as $college){
            College::create($college);
        }
    }
}
