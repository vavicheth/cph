<?php

use Illuminate\Database\Seeder;

class RoleSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $items = [
            
            ['id' => 1, 'title' => 'Administrators',],
            ['id' => 2, 'title' => 'Super Users',],
            ['id' => 3, 'title' => 'Modarators',],
            ['id' => 4, 'title' => 'Creators',],
            ['id' => 5, 'title' => 'Editors',],
            ['id' => 6, 'title' => 'Viewers',],
            ['id' => 7, 'title' => 'Users',],

        ];

        foreach ($items as $item) {
            \App\Role::create($item);
        }
    }
}
