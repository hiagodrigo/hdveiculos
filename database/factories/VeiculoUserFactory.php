<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Veiculo;
use App\Models\VeiculoUser;
use Illuminate\Database\Eloquent\Factories\Factory;
/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\VeiculoUser>
 */
class VeiculoUserFactory extends Factory
{
    protected $model = VeiculoUser::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::all()->random()->id,
            'veiculo_id' => Veiculo::all()->random()->id
        ];
    }
}
