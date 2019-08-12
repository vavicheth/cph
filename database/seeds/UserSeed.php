<?php

use Illuminate\Database\Seeder;

class UserSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $items = [
            
            ['id' => 1, 'name_kh' => 'Administrator', 'name' => 'Admin', 'email' => 'admin@calmette.org', 'password' => '$2y$10$0DXlpuaTyVm3is11L4Z38.5zsOwH46.h82VF5fH66U2//F8nrpJZi', 'role_id' => 1, 'remember_token' => '',],

        ];

        foreach ($items as $item) {
            \App\User::create($item);
        }
    }
}
