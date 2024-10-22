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
use Illuminate\Support\Str;


class FuncionarioController extends Controller
{
    public function index()
    {
        $funcionario = Funcionario::query()->paginate(5);

        return response()->json(FuncionarioResource::collection($funcionario)->response()->getData(true), 200);
    }

    public function store(StoreFuncionarioRequest $request)
    {

        $data = $request->validated();

        // Verifica se o CPF já existe
        if (Funcionario::where('cpf', $data['cpf'])->exists()) {
            return response()->json(['message' => 'CPF já está cadastrado.'], 400);
        }

        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $filename = Str::uuid() . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('public/fotos', $filename);
            $data['file'] = $filename;
        }

        $funcionario = Funcionario::create($data);

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
