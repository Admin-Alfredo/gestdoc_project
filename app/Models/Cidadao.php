<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cidadao extends Model
{
    protected $table = "cidadao";
    protected $primaryKey = 'n_codicentr';
    protected $fillable = [
        'id',
        'n_bi',
        'nome',
        'data_nascimento',
        'nacionalidade',
        'nome_pai',
        'nome_mae',
        'data_bi_validade',
        'data_bi_emissao',
        'estado_civil',
        'created_at',
        'updated_at',
        'residencia',
        'sexo',
        'provincia',
        'residencia',
        'altura'
    ];
    use HasFactory;
}
