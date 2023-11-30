<?php

namespace App\Repositories;

use App\Models\Lancamento;
use Illuminate\Support\Collection;

class LancamentoRepository
{
    public function listByUser(int $user): Collection
    {
        return Lancamento::where('user_id', $user)->get();
    }

    public function find($id): ?Lancamento
    {
        return Lancamento::find($id);
    }

    public function create($data): ?Lancamento
    {
        return Lancamento::create($data);
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
