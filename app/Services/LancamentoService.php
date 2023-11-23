<?php

namespace App\Services;

use App\Models\Lancamento;
use App\Repositories\LancamentoRepository;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class LancamentoService
{
    public function __construct(
        protected LancamentoRepository $lancamentoRepository
    ) {
        //
    }

    public function list(): Collection
    {
        return $this->lancamentoRepository->listByUser(auth()->user()->id);
    }

    public function find(int $lancamento): Lancamento
    {
        if( ($lancamento = $this->lancamentoRepository->find($lancamento))
            &&
            $lancamento->user_id == auth()->user()->id
        ){
            return $lancamento;
        }
  
        throw new Exception("Lançamento do usuário não encontrado!");
    }

    public function create(Request $request): Lancamento
    {
        $request['user_id'] = auth()->user()->id;

        $data = $request->validate([
            'data'          => ['required', 'date'],
            'identificador' => ['nullable', 'string', 'max:255'],
            'valor'         => ['required', 'numeric'],
            'tipo'          => ['required', 'in:C,D'],
            'descricao'     => ['nullable', 'string'],
            'status'        => ['sometimes', 'in:0,1'],
            'categoria_id'  => ['required', 'exists:categorias,id'],
            'user_id'    => ['required', 'exists:users,id'],
        ]);

        return $this->lancamentoRepository->create($data);
    }

    public function update(int $lancamento, Request $request): bool
    {
        if($this->find($lancamento))
        {
            $data = $request->validate([
                'data'          => ['required', 'date'],
                'identificador' => ['nullable', 'string', 'max:255'],
                'valor'         => ['required', 'numeric'],
                'tipo'          => ['required', 'in:C,D'],
                'descricao'     => ['nullable', 'string'],
                'status'        => ['required', 'in:0,1'],
                'categoria_id'  => ['required', 'exists:categorias,id'],
            ]);
    
            return $this->lancamentoRepository->update($lancamento, $data);
        }
        
        return false;
    }

    public function delete(int $lancamento): bool
    {
        if($this->find($lancamento)){
            return $this->lancamentoRepository->delete($lancamento);
        }

        return false;
    }
}
