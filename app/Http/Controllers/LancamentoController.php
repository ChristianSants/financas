<?php

namespace App\Http\Controllers;

use App\Services\LancamentoService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class LancamentoController extends Controller
{
    public function __construct(
        protected LancamentoService $lancamentoService
    ) {
        //
    }

    public function index(): JsonResponse
    {
        return response()->json([
            'lancamentos' => $this->lancamentoService->list()
        ], 200);
    }

    public function store(Request $request): JsonResponse
    {
        return response()->json([
            'lancamento' => $this->lancamentoService->create($request)
        ], 201);
    }

    public function show(int $lancamento): JsonResponse
    {
        try {
            $lancamento = $this->lancamentoService->find($lancamento);
            return response()->json(['lancamento' => $lancamento], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 404);
        }
    }

    public function update(Request $request, int $lancamento): JsonResponse
    {
        $result = $this->lancamentoService->update($lancamento, $request);
        if ($result) {
            return response()->json(['message' => 'Lançamento atualizada com sucesso.'], 200);
        } else {
            return response()->json(['error' => 'Algum erro ocorreu.'], 500);
        }
    }

    public function destroy(int $lancamento): JsonResponse
    {
        $result = $this->lancamentoService->delete($lancamento);
        if ($result) {
            return response()->json(['message' => 'Lançamento excluída com sucesso.'], 200);
        } else {
            return response()->json(['error' => 'Algum erro ocorreu.'], 500);
        }
    }
}
