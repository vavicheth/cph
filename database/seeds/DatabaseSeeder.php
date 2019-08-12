<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        
        $this->call(PatientSeed::class);
        $this->call(InvoiceSeed::class);
        $this->call(RoleSeed::class);
        $this->call(UserSeed::class);

    }
}
