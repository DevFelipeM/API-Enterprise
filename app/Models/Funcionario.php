<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Funcionario extends Model
{
    use HasFactory, SoftDeletes;


    protected $fillable = [
        'nome',
        'cpf',
        'empresa_id',
        'cargo',
        'file',
        'dataDeNascimento'
    ];

    public function empresa()
    {
        return $this->belongsTo(Empresa::class)->withTrashed();
    }
}
