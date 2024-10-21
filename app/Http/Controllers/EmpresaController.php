<?php

namespace App\Http\Controllers;

use App\Models\Empresa;
use App\Http\Resources\EmpresaResource;
use App\Http\Requests\StoreEmpresaRequest;
use App\Http\Requests\UpdateEmpresaRequest;
use App\Http\Resources\EmpresaFuncionarioResource;
use Illuminate\Http\JsonResponse;


class EmpresaController extends Controller
{ 
   public function index()
    {
        $empresa = Empresa::with('funcionarios')->paginate(5);

        return response()->json(EmpresaFuncionarioResource::collection($empresa)->response()->getData(true), 200);
    }

    public function store(StoreEmpresaRequest $request)
    {
        $empresa = Empresa::create($request->validated()); 

        return response()->json(EmpresaResource::make($empresa), 201); 
    }

    public function show(int $id): JsonResponse
{
    $empresa = Empresa::findOrFail($id);

    return response()->json(EmpresaResource::make($empresa), 200); // EmpresaResource::make($empresa) traz a formatação do elemento pelo service
}

    public function update(int $id, UpdateEmpresaRequest $request): JsonResponse
    {
        $empresa = Empresa::findOrFail($id);
        $isUpdated = $empresa->update($request->validated()); // instanciei em outra variavel pois o metodo update é static 

        return response()->json(EmpresaResource::make($empresa), 200);
    }

    public function destroy(int $id): JsonResponse
    {
        $empresa = Empresa::findOrFail($id);
        $isDeleted = $empresa->delete(); // instanciei em outra variavel pois o metodo ""  ""  é static 

        return response()->json($isDeleted, 200); 
    }
}
