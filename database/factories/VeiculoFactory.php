<?php

namespace Database\Factories;

use App\Models\Team;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use Faker\Generator as Faker;
use Laravel\Jetstream\Features;


/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Veiculo>
 */
class VeiculoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $faker = app(Faker::class);

        return [
            'especie' => $faker->randomElement(['carro', 'moto']),
            'tipo' => $faker->word(),
            'marca' => $faker->word(),
            'modelo' => $faker->word(),
            'cor' => $faker->colorName(),
            'potencia' => $faker->randomFloat(2, 50, 500),
            'ano' => $faker->numberBetween(1900, date('Y')),
            'opcionais' => $faker->randomElements(['Direção Hidráulica', 'Câmbio Automático', 'Teto Solar', 'Ar Condicionado', 'Roda de Liga Leve'], $faker->numberBetween(0, 3)),
            'fotos' => json_encode([$faker->imageUrl($width = 640, $height = 480, 'transport'), $faker->imageUrl($width = 640, $height = 480, 'car')]),
            'user_id' => User::all()->random()->id
        ];
    }
}
