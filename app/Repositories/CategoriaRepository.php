<?php

namespace App\Repositories;

use App\Models\Categoria;
use Illuminate\Support\Collection;

class CategoriaRepository
{
    public function listByUser(int $user): Collection
    {
        return Categoria::where('user_id', $user)->get();
    }

    public function find($id): Categoria
    {
        return Categoria::find($id);
    }

    public function create($data): Categoria
    {
        return Categoria::create($data);
    }

    public function update($id, $data): bool
    {
        return $this->find($id)->update($data);
    }

    public function delete($id): bool
    {
        return $this->find($id)->delete();
    }
}