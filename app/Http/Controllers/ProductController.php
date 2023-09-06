<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Resources\DataResource;
use Spatie\QueryBuilder\QueryBuilder;
use Spatie\QueryBuilder\AllowedFilter;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\ParentController;
use App\Http\Requests\Products\CreateProductRequest;
use App\Http\Requests\Products\UpdateProductRequest;

class ProductController extends ParentController
{
    public function index()
    {
        return Inertia::render('Products/index');
    }


    public function store(CreateProductRequest $request)
    {
        $data = $request->validated();

        $file = $request->file('photo');
        $name = time() . '_' . $file->getClientOriginalName();
        Storage::putFileAs('public', $file, $name);

        $data['image'] = $name;

        return Product::create($data);
    }


    public function all()
    {
        $query = Product::query();

        $payload = QueryBuilder::for($query)
            ->allowedSorts(['code'])
            ->allowedFilters(
                AllowedFilter::callback('search', function ($query, $value) {
                    $query->where('code', 'like', "%{$value}%");
                    $query->orWhere('name', 'like', "%{$value}%");
                })
            )
            ->paginate(request('per_page', config('basic.pagination_per_page')));
        return DataResource::collection($payload);
    }


    public function delete(int $id)
    {
        return Product::destroy($id);
    }


    public function edit(int $id)
    {

        $response['product'] = Product::find($id);
        return Inertia::render('Suppliers/edit', $response);
    }


    public function get(int $id)
    {
        $payload = Product::find($id);
        return new DataResource($payload);
    }


    public function update(UpdateProductRequest $request, int $id)
    {
        $data = $request->validated();

        $file = $request->file('photo');
        if($file){
            $name = time() . '_' . $file->getClientOriginalName();
            Storage::putFileAs('public', $file, $name);

            $data['image'] = $name;
        }


        $product = Product::find($id);
        $product->update($data);
    }
}
