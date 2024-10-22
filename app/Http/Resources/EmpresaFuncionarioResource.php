<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class EmpresaFuncionarioResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'nome' => $this->nome,
            'cnpj' => $this->cnpj,
            'funcionario' => $this->funcionarios()->get()->map(function($funcionario){   //get retornando collection
                return [
                    'id' => $funcionario->id,
                    'nome' => $funcionario->nome,
                    'cargo' => $funcionario->cargo,
                    'dataDeNascimento' => $funcionario->dataDeNascimento,
                    'file' => $funcionario->file,
                ];
            }),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
