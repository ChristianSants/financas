<?php

namespace Database\Factories;

use App\Models\Categoria;
use App\Models\Lancamento;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class LancamentoFactory extends Factory
{
    protected $model = Lancamento::class;

    public function definition(): array
    {
        return [
            'data' => $this->faker->date(),
            'identificador' => $this->faker->uuid,
            'valor' => $this->faker->randomFloat(2, 0, 1000),
            'tipo' => $this->faker->randomElement(['C', 'D']),
            'descricao' => $this->faker->text,
            'status' => $this->faker->randomElement([0, 1]),
            'categoria_id' => Categoria::factory(),
            'user_id' => User::factory(),
        ];
    }
}
