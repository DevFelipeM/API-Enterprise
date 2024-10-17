<?php

namespace App\Http\Controllers;

use App\Models\Funcionario;
use App\Http\Requests\StoreFuncionarioRequest;
use App\Http\Requests\UpdateFuncionarioRequest;
use App\Http\Resources\FuncionarioResource;
use Symfony\Component\HttpFoundation\JsonResponse;

class FuncionarioController extends Controller
{ 
    public function index()
    {
        $funcionario = Funcionario::paginate(5);
        
        return response()->json($funcionario);
    }

    public function store(StoreFuncionarioRequest $request)
    {
        $funcionario = Funcionario::create($request->validated());
        return response()->json($funcionario, 201);  
    }

    public function show(int $id): JsonResponse 
{
    $funcionario = Funcionario::findOrFail($id);

    if (!$funcionario) {
        return response()->json(['message' => 'Empresa não encontrada'], 404);
    }

    return response()->json(FuncionarioResource::make($funcionario), 200); 
}
    /*
    public function search(StoreFuncionarioRequest $request): JsonResponse
    {
        $query = $request->input('query');
        $funcionario = Funcionario::where('nome', 'LIKE', '%query%')->orwhere('id', $query);

        if ($funcionario){
            return response()->json(FuncionarioResource::make($funcionario), 200);
        }

        return response()->json(['message' => 'Encontramos não dog'], 404);
    }*/

    public function update(UpdateFuncionarioRequest $request, Funcionario $funcionario)
    {
        $funcionario->update($request->validated());
        return response()->json($funcionario, 200); 
    }

    public function destroy(int $id): JsonResponse
    {
        $funcionario = Funcionario::findOrFail($id);
        $isDeleted = $funcionario->delete();
        return response()->json($isDeleted, 200); 
    }
}
