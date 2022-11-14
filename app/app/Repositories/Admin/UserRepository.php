<?php

namespace App\Repositories\Admin;

use App\Interfaces\Admin\UserRepositoryInterface;
use App\Models\User;
use App\Repositories\BaseRepository;
use Illuminate\Support\Facades\Hash;

class UserRepository extends BaseRepository implements UserRepositoryInterface
{
    public function __construct()
    {
        $this->modelName = User::class;
    }

    public function search(string $filter = null, int $qtty = 15) 
    {
        return $this->modelName::latest()
                    ->tenantId()
                    ->where('name','LIKE', "%{$filter}%")
                    ->paginate($qtty);
    }

    public function getAll(array $order = null, array $with = null) 
    {
        $modelName = $this->modelName::tenantId();
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
        return $this->modelName::latest()->tenantId()->paginate($qtty);
    }

    public function getById(int $id) 
    {
        return $this->modelName::tenantId()->findOrFail($id);
    }

    public function delete(int $id) 
    {
        $this->modelName::tenantId()->destroy($id);
    }

    public function create(array $details) 
    {
        $authUser = auth()->user();
        if(isset($authUser)) {
            $details['tenant_id'] = $authUser->tenant_id;
        }
        $details['password'] = Hash::make($details['password']);
        return parent::create($details);
    }

    public function update(int $id, array $newDetails) 
    {
        if(isset($newDetails['password'])) {
            $newDetails['password'] = Hash::make($newDetails['password']);
        }

        return $this->modelName::tenantId()->update($id, $newDetails);
    }
}