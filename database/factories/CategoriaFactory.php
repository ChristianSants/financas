<?php

namespace Database\Factories;

use App\Models\Categoria;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class CategoriaFactory extends Factory
{
    protected $model = Categoria::class;

    public function definition(): array
    {
        return [
            'nome' => $this->faker->name,
            'descricao' => $this->faker->text,
            'status' => $this->faker->randomElement([0, 1]),
            'user_id' => User::factory(),
        ];
    }
}
