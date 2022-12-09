<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreUpdateTableRequest;
use App\Interfaces\Admin\TableRepositoryInterface;
use Illuminate\Http\Request;

class TableController extends Controller
{
    private TableRepositoryInterface $repository;

    public function __construct(TableRepositoryInterface $tableRepository)
    {
        $this->repository = $tableRepository;
        $this->middleware("can:tables.show", ['only' => ['index','show','search']]);
        $this->middleware("can:tables.create", ['only' => ['create','store']]);
        $this->middleware("can:tables.edit", ['only' => ['edit','update']]);
        $this->middleware("can:tables.destroy", ['only' => ['destroy']]);
    }
    public function index()
    {
        $tables = $this->repository->getAllPaginate(config('constants.max_paginate'));

        return view('admin.pages.tables.index', [
            'tables' => $tables
        ]);
    }

    public function search(Request $request)
    {
        $tables = $this->repository->search($request->filter,config('constants.max_paginate'));
        $filters = $request->except('_token');
        return view('admin.pages.tables.index', [
            'tables' => $tables,
            'filters' => $filters
        ]);
    }

    public function create()
    {
        return view('admin.pages.tables.create');
    }

    public function store(StoreUpdateTableRequest $request) 
    {
        $model = $this->repository->create($request->all());

        return redirect()->route('tables.index');
    }

    public function show($url) 
    {
        $table = $this->repository->getByUrl($url);
        return view('admin.pages.tables.show',[
            'table' => $table
        ]);
    }

    public function qrcode($url) 
    {
        $table = $this->repository->getByUrl($url);
        $tenant = auth()->user()->tenant;
        $uri = env('URI_CLIENT') . "/{$tenant->uuid}/{$table->uuid}";
        return view('admin.pages.tables.qrcode',[
            'uri' => $uri
        ]);
    }

    public function destroy($id) 
    {
        $this->repository->delete($id);
        return redirect()->route('tables.index');          
    }

    public function edit($url) 
    {
        $table = $this->repository->getByUrl($url);

        return view('admin.pages.tables.edit',[
            'table' => $table
        ]);
    }

    public function update(StoreUpdateTableRequest $request, int $id) 
    {
        $this->repository->update($id, $request->except(['_token','_method']));

        return redirect()->route('tables.index');
    }
}
