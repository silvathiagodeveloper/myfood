<?php

namespace App\Repositories\Admin;

use App\Interfaces\Admin\ClientRepositoryInterface;
use App\Models\Admin\Client;
use App\Repositories\BaseRepository;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Support\Facades\Hash;

class ClientRepository extends BaseRepository implements ClientRepositoryInterface
{
    public function __construct()
    {
        $this->modelName = Client::class;
    }

    public function search(string $filter = null, int $qty = 15) 
    {
        return $this->modelName::latest()
                    ->where('name','LIKE', "%{$filter}%")
                    ->orWhere('description','LIKE', "%{$filter}%")
                    ->paginate($qty);
    }

    public function create(array $details) 
    {
        $details['password'] = Hash::make($details['password']);
        return parent::create($details);
    }

    public function auth(string $email = null, string $password, string $deviceName) 
    {
        $client = $this->modelName::where('email', "{$email}")
                               ->first();
        if(!$client || !Hash::check($password, $client->password)) {
            throw new AuthenticationException();
        } else {
            $token = $client->createToken($deviceName)->plainTextToken;
            return $token;
        }
    }
}