<?php

namespace App\Repositories;

use App\Interfaces\BaseRepositoryInterface;
use Illuminate\Database\Eloquent\Model;

abstract class BaseRepository implements BaseRepositoryInterface
{
    protected string $modelName;
    public function __construct()
    {
        $this->modelName = Model::class;
    }
    public function first(array $order = null, array $with = null) 
    {
        $modelName = $this->modelName;
        $result = new $modelName();
        if(isset($order)) {
            $result = $result->orderBy(implode(',',$order));
        } 

        if(isset($with)) {
            foreach($with as $item) {
                $result = $result->with($item);
            }
        } 

        return $result->firstOrFail();
    }

    public function getAll(array $order = null, array $with = null) 
    {
        $modelName = $this->modelName;
        $result = new $modelName();
        if(isset($order)) {
            $result = $result->orderBy(implode(',',$order));
        } 

        if(isset($with)) {
            foreach($with as $item) {
                $result = $result->with($item);
            }
        } 

        return $result->get();
    }

    public function getAllPaginate(int $qtty = 15)
    {
        return $this->modelName::latest()->paginate($qtty);
    }

    public function getById(int $id) 
    {
        return $this->modelName::findOrFail($id);
    }

    public function delete(int $id) 
    {
        $this->modelName::destroy($id);
    }

    public function create(array $details) 
    {
        return $this->modelName::create($details);
    }

    public function update(int $id, array $newDetails) 
    {
        return $this->modelName::findOrFail($id)->update($newDetails);
    }
}