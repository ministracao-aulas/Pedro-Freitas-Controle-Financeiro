<?php

namespace Database\Seeders;

use App\Models\Creditor;
use Illuminate\Database\Seeder;

class CreditorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Creditor::factory(5)->create();
    }
}
