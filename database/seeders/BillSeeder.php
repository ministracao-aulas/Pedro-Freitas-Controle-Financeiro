<?php

namespace Database\Seeders;

use App\Models\Bill;
use App\Models\Creditor;
use Illuminate\Database\Seeder;

class BillSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $creditors = Creditor::factory(10)->create();

        foreach ($creditors as $creditor) {
            Bill::factory()->createOne([
                'creditor_id' => $creditor->id,
            ]);
        }
    }
}
