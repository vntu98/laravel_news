<?php
namespace App\Repositories\Contracts;

interface CategoryRepositoryInterface
{
    public function all();
    public function find($id);
    public function create($request);
    public function update($request, $id);
    public function delete($id);
}