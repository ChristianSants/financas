<?php

namespace App\Http\Controllers;

use App\Http\Requests\Categoria\StoreRequest;
use App\Http\Requests\Categoria\UpdateRequest;
use App\Services\CategoriaService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CategoriaController extends Controller
{
    public function __construct(
        protected CategoriaService $categoriaService
    ) {
        //
    }

    public function index(): JsonResponse
    {
        return response()->json([
            'categorias' => $this->categoriaService->list()
        ], 200);
    }

    public function store(Request $request): JsonResponse
    {
        return response()->json([
            'categoria' => $this->categoriaService->create($request)
        ], 201);
    }

    public function show(int $categoria): JsonResponse
    {
        try {
            $categoria = $this->categoriaService->find($categoria);
            return response()->json(['categoria' => $categoria], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 404);
        }
    }

    public function update(Request $request, int $categoria): JsonResponse
    {
        $result = $this->categoriaService->update($categoria, $request);
        if ($result) {
            return response()->json(['message' => 'Categoria atualizada com sucesso.'], 200);
        } else {
            return response()->json(['error' => 'Algum erro ocorreu.'], 500);
        }
    }

    public function destroy(int $categoria): JsonResponse
    {
        $result = $this->categoriaService->delete($categoria);
        if ($result) {
            return response()->json(['message' => 'Categoria excluída com sucesso.'], 200);
        } else {
            return response()->json(['error' => 'Algum erro ocorreu.'], 500);
        }
    }
}
