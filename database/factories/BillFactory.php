<?php

namespace Database\Factories;

use App\Models\Bill;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Bill>
 */
class BillFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'title' => \fake()->words(rand(2, 5), true),
            'type' => fn () => \Arr::random([
                Bill::TYPE_FIXED,
                Bill::TYPE_VARIABLE,
                Bill::TYPE_SEPARATE,
                Bill::TYPE_OTHER,
            ]),
            'overdue_date' => fn () => \Arr::random([
                now()->addDays(rand(1, 30)),
                now()->subDays(rand(1, 15)),
                now(),
            ]),
            'value' => fn () => (float) fake()->numerify(str_repeat('#', rand(2, 6)) . '.##'),
            'status' => fn () => \Arr::random([
                Bill::STATUS_OPENED,
                Bill::STATUS_PAID,
                Bill::STATUS_POSTPONED,
                Bill::STATUS_OTHER,
            ]),
            'note' => \null,
            'creditor_id' => \null,
            'created_by' => \null,
        ];
    }
}
