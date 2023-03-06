<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Veiculo extends Model
{
    use HasFactory;

    protected $table = 'veiculos';

    protected $fillable = [
        'especie',
        'tipo',
        'marca',
        'modelo',
        'cor',
        'potencia',
        'ano',
        'fotos',
        'opcionais'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'veiculo_user');
    }


    protected $casts = [
        'opcionais' => 'array',
        'fotos' => 'array'
    ];
}
