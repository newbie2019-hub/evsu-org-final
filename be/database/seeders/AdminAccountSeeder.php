<?php

namespace Database\Seeders;

use App\Models\AdminAccount;
use App\Models\AdminAccountInfo;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminAccountSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $account_info = AdminAccountInfo::create([
            'first_name' => 'Mayven Claire',
            'middle_name' => 'Labastida',
            'last_name' => 'Garrido II',
            'gender' => 'Female',
            'contact_number' => '00000000000',
            'organization_id' => 1,
        ]);

        AdminAccount::create([
            'email' => 'groupcapstone12@gmail.com',
            'password' => Hash::make('123123'),
            // 'password' => Hash::make('porgarlib99'),
            'admin_account_info_id' => $account_info->id
        ]);
    }
}
