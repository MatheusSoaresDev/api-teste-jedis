<?php

namespace Database\Factories;

use App\Models\Produto;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProdutoFactory extends Factory
{
    protected $model = Produto::class;

    public function definition(): array
    {
        return [
            'nome' => $this->faker->sentence(3),
            'descricao' => $this->faker->paragraph(3),
            'preco' => $this->faker->randomFloat(2, 10, 1000),
            'quantidade' => $this->faker->numberBetween(1, 100),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
