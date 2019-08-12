<?php

use Illuminate\Database\Seeder;

class InvoiceSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $items = [
            
            ['id' => 1, 'date' => '28-03-2019', 'patient_id' => 1, 'invstate_id' => 2, 'total' => null, 'description' => null,],

        ];

        foreach ($items as $item) {
            \App\Invoice::create($item);
        }
    }
}
