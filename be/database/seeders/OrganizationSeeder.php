<?php

namespace Database\Seeders;

use App\Models\Organization;
use Illuminate\Database\Seeder;

class OrganizationSeeder extends Seeder
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
                'organization_service_id' => 3,
                'college_id' => rand(1, 6),
                'organization' => 'MANAGEMENT',
                'abbreviation' => 'MGT',
            ],
            [
                'organization_service_id' => rand(1, 3),
                'college_id' => rand(1, 6),
                'organization' => 'Organization 1 Sample',
                'abbreviation' => 'ORG1S',
            ],
            [
                'organization_service_id' => rand(1, 3),
                'college_id' => rand(1, 6),
                'organization' => 'Organization 2 Sample',
                'abbreviation' => 'ORG2S',
            ],
            [
                'organization_service_id' => rand(1, 3),
                'college_id' => rand(1, 6),
                'organization' => 'Organization 3 Sample',
                'abbreviation' => 'ORG3S',
            ],
            [
                'organization_service_id' => rand(1, 3),
                'college_id' => rand(1, 6),
                'organization' => 'Organization 4 Sample',
                'abbreviation' => 'ORG4S',
            ],
            [
                'organization_service_id' => rand(1, 3),
                'college_id' => rand(1, 6),
                'organization' => 'Organization 5 Sample',
                'abbreviation' => 'ORG5S',
            ],
            [
                'organization_service_id' => rand(1, 3),
                'college_id' => rand(1, 6),
                'organization' => 'Organization 6 Sample',
                'abbreviation' => 'ORG6S',
            ],
            [
                'organization_service_id' => rand(1, 3),
                'college_id' => rand(1, 6),
                'organization' => 'Organization 7 Sample',
                'abbreviation' => 'ORG7S',
            ],
            [
                'organization_service_id' => rand(1, 3),
                'college_id' => rand(1, 6),
                'organization' => 'Organization 8 Sample',
                'abbreviation' => 'ORG8S',
            ],
            [
                'organization_service_id' => rand(1, 3),
                'college_id' => rand(1, 6),
                'organization' => 'Organization 9 Sample',
                'abbreviation' => 'ORG9S',
            ],
            [
                'organization_service_id' => rand(1, 3),
                'college_id' => rand(1, 6),
                'organization' => 'Organization 10 Sample',
                'abbreviation' => 'ORG10S',
            ],
            [
                'organization_service_id' => rand(1, 3),
                'college_id' => rand(1, 6),
                'organization' => 'Organization 11 Sample',
                'abbreviation' => 'ORG11S',
            ],
        ];

        foreach($data as $org) {
            Organization::create($org);
        }
    }
}
