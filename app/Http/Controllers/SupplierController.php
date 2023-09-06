<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Supplier;
use Illuminate\Http\Request;
use App\Http\Resources\DataResource;
use Spatie\QueryBuilder\QueryBuilder;
use Spatie\QueryBuilder\AllowedFilter;
use App\Http\Controllers\ParentController;
use App\Http\Requests\Suppliers\CreateSupplierRequest;
use App\Http\Requests\Suppliers\UpdateSupplierRequest;

class SupplierController extends ParentController
{

    public function index()
    {

        return Inertia::render('Suppliers/index');
    }


    public function store(CreateSupplierRequest $request)
    {

        return Supplier::create($request->validated());
    }


    public function all()
    {
        $query = Supplier::query();

        $payload = QueryBuilder::for($query)
            ->allowedSorts(['code'])
            ->allowedFilters(
                AllowedFilter::callback('search', function ($query, $value) {
                    $query->where('email', 'like', "%{$value}%");
                    $query->orWhere('name', 'like', "%{$value}%");
                })
            )
            ->paginate(request('per_page', config('basic.pagination_per_page')));
        return DataResource::collection($payload);
    }

    public function allDropdown()
    {
        $suppliers = Supplier::all();
        return DataResource::collection($suppliers);
    }


    public function delete(int $id)
    {
        return Supplier::destroy($id);
    }


    public function edit(int $id)
    {

        $response['supplier'] = Supplier::find($id);
        return Inertia::render('Suppliers/edit', $response);
    }


    public function get(int $id)
    {
        $payload = Supplier::find($id);
        return new DataResource($payload);
    }


    public function update(UpdateSupplierRequest $request, int $id)
    {
        $supplier = Supplier::find($id);
        $supplier->update($request->validated());
    }
}
