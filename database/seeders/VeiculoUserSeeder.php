<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\Veiculo;

class VeiculoUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        // Obter todos os usuários e veículos
        $users = User::all();
        $veiculos = Veiculo::all();
        
        // Percorrer todos os usuários e veículos e criar registros aleatórios na tabela veiculo_user
        foreach ($users as $user) {
            foreach ($veiculos as $veiculo) {
                if (rand(0, 1)) {
                    DB::table('veiculo_user')->insert([
                        'user_id' => $user->id,
                        'veiculo_id' => $veiculo->id,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }
            }
        }
    }
}
