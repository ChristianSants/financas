<?php

namespace App\Services;

use App\Models\Categoria;
use App\Repositories\CategoriaRepository;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class CategoriaService
{
    public function __construct(
        protected CategoriaRepository $categoriaRepository
    ) {
        //
    }

    public function list(): Collection
    {
        return $this->categoriaRepository->listByUser(auth()->user()->id);
    }

    public function find(int $categoria): Categoria
    {
        if( ($categoria = $this->categoriaRepository->find($categoria))
            &&
            $categoria->user_id == auth()->user()->id 
        ){
            return $categoria;                  
        }

        throw new Exception("Categoria do usuário não encontrada!");
    }

    public function create(Request $request): Categoria
    {
        $request['user_id'] = auth()->user()->id;

        $data = $request->validate([
            'nome'      => ['required','string','max:255'],
            'descricao' => ['nullable','string'],
            'status'    => ['required','in:0,1'],
            'user_id'   => ['required','exists:users,id'],
        ]);

        return $this->categoriaRepository->create($data);
    }

    public function update(int $categoria, Request $request): bool
    {
        if($this->find($categoria)){
            $data = $request->validate([
                'nome'      => ['sometimes', 'string', 'max:255'],
                'descricao' => ['nullable', 'string'],
                'status'    => ['sometimes', 'in:0,1'],
            ]);
    
            return $this->categoriaRepository->update($categoria, $data);
        }

        return false;        
    }

    public function delete(int $categoria): bool
    {
        if($this->find($categoria)){
            return $this->categoriaRepository->delete($categoria);
        }

        return false;
    }
}