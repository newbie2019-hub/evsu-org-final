<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            CollegeSeeder::class,
            CourseSeeder::class,
            OrganizationServicesSeeder::class,
            OrganizationSeeder::class,
            AdminAccountSeeder::class,
            SectionSeeder::class,
        ]);
    }
}
