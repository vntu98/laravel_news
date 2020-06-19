<?php
namespace App\Repositories\Eloquents;

use App\Models\CategoryModel as Category;
use App\Repositories\Contracts\CategoryRepositoryInterface;

class CategoryRepository implements CategoryRepositoryInterface
{
    public function all()
    {
        return Category::all();
    }

    public function find($id)
    {
        return Category::findOrFail($id);
    }

    public function create($request)
   {
        return Category::createOrFail($data);
   }

   public function update($request, $id)
   {
        $result = Category::findOrFail($id);
        if ($result) {
            $result->update($request);
            return $result;
        }

        return false;
   } 

   public function delete($id)
   {
        $result = Category::findOrFail($id);
        if ($result) {
            $result->delete($request);
            return true;
        }
        return false;
   }
}