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
            'opcionais' => $faker->randomElements(['ar_condicionado', 'direcao_hidraulica', 'vidros_eletricos'], $faker->numberBetween(0, 3)),
            'fotos' => json_encode([$faker->image(public_path('img/veiculos'), 640, 480, null, false)]),
            'user_id' => User::all()->random()->id
        ];
    }
}
