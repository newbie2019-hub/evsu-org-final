<?php

namespace Database\Seeders;

use App\Models\OrganizationServices;
use Illuminate\Database\Seeder;

class OrganizationServicesSeeder extends Seeder
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
                'name' => 'Service Oriented'
            ],
            [
                'name' => 'Course Oriented'
            ],
            [
                'name' => 'Values Oriented'
            ]
        ];

        foreach($data as $course) {
            OrganizationServices::create($course);
        }
    }
}
