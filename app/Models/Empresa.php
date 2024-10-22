<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Empresa extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'nome',
        'cnpj',
    ];

    public function funcionarios()
    {
        return $this->hasMany(Funcionario::class, 'empresa_id', 'id');
    }

    protected static function boot()
    {
        parent::boot();
        static::deleting(function ($empresa) {

            foreach ($empresa->funcionarios as $funcionario) {
                $funcionario->empresa_id = null; 
                $funcionario->save(); 
                
            }
        });
    }
}
