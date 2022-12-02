<?php

namespace App\Http\Controllers\Api\V1\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreClientRequest;
use App\Http\Resources\V1\ClientResource;
use App\Interfaces\Admin\ClientRepositoryInterface;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    private ClientRepositoryInterface $repository;

    public function __construct(ClientRepositoryInterface $clientRepository)
    {
        $this->repository = $clientRepository;
    }

    public function show($id) 
    {
        $client = $this->repository->getById($id);
        return new ClientResource($client);
    }

    public function store(StoreClientRequest $request) 
    {
        $model = $this->repository->create($request->all());

        return new ClientResource($model);
    }
/*
    public function destroy($id) 
    {
        $this->repository->delete($id);
        return redirect()->route('clients.index');          
    }

    public function edit($url) 
    {
        $client = $this->repository->getByUrl($url);

        return view('admin.pages.clients.edit',[
            'client' => $client
        ]);
    }

    public function update(StoreUpdateClientRequest $request, int $id) 
    {
        $this->repository->update($id, $request->except(['_token','_method']));

        return redirect()->route('clients.index');
    }*/
}
