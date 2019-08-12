<?php

use Illuminate\Database\Seeder;

class PatientSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $items = [
            
            ['id' => 1, 'name' => 'Test Patient', 'gender' => '1', 'age' => 30, 'oranization_id' => null, 'diagnostic' => null, 'address' => null, 'contact' => null, 'description' => null,],

        ];

        foreach ($items as $item) {
            \App\Patient::create($item);
        }
    }
}
