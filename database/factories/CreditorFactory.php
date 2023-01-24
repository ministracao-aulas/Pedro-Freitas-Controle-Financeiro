<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Creditor>
 */
class CreditorFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'name' => \fake()->company(),
            'active' => fn () => (bool) (\rand() % 2),
            'doc_type' => fn () => \Arr::random([
                'CNPJ',
                'CPF',
                'CNH',
            ]),
            'doc' => \fake()->numerify('###.###.###-##'),
            'note' => \null,
        ];
    }
}
