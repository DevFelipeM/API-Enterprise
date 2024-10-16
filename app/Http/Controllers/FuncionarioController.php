<?php

namespace App\Http\Controllers;

use App\Models\Funcionario;
use App\Http\Requests\StoreFuncionarioRequest;
use App\Http\Requests\UpdateFuncionarioRequest;
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

    return response()->json($funcionario, 200); 
}

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
