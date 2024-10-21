<?php

namespace App\Http\Controllers;

use App\Models\Funcionario;
use App\Http\Requests\StoreFuncionarioRequest;
use App\Http\Requests\UpdateFuncionarioRequest;
use App\Http\Resources\EmpresaResource;
use App\Http\Resources\FuncionarioResource;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class FuncionarioController extends Controller
{ 
    public function index()
    {
        $funcionario = Funcionario::query()->paginate(5);
        
        return response()->json(FuncionarioResource::collection($funcionario)->response()->getData(true), 200);
    }

    public function store(StoreFuncionarioRequest $request)
    {
        $funcionario = Funcionario::create($request->validated());
        return response()->json(FuncionarioResource::make($funcionario), 201);  
    }

    public function show(int $id): JsonResponse 
{
    $funcionario = Funcionario::findOrFail($id);

    return response()->json(FuncionarioResource::make($funcionario), 200); 
}
    /*
    public function search(StoreFuncionarioRequest $request): JsonResponse
    {
        $query = $request->input('query');
        $funcionario = Funcionario::where('nome', 'LIKE', '%query%')->o rwhere('id', $query);

        if ($funcionario){
            return response()->json(FuncionarioResource::make($funcionario), 200);
        }

        return response()->json(['message' => 'Encontramos não dog'], 404);
    }*/

    public function update(UpdateFuncionarioRequest $request, int $id)
    {
        $funcionario = Funcionario::findOrFail($id);
        $isUpdated = $funcionario->update($request->validated());
        return response()->json(FuncionarioResource::make($funcionario), 200); 
    }

    public function destroy(int $id): JsonResponse
    {
        $funcionario = Funcionario::findOrFail($id);
        $isDeleted = $funcionario->delete();
        return response()->json($isDeleted, 200); 
    }
}
