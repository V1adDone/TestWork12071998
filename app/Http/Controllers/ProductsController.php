<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Faker\Generator;
use Illuminate\Support\Facades\Validator;
use App\Models\Product;

class ProductsController extends Controller
{
    /**
     * Get all products
     *
     * @return Response
     */
    public function index()
    {
        $data = Product::all();
        return response($data->jsonSerialize(), Response::HTTP_OK);
    }

    /**
     * Create random product
     *
     * @return Response
     */
    public function create(Generator $faker)
    {
        $product = new Product([
            'title' => $faker->lexify('????????'),
            'price' => $faker->numerify('####.##')
        ]);

        $product->save();

        return response($product->jsonSerialize(), Response::HTTP_CREATED);
    }

    /**
     * Update product
     *
     * @return Response
     */
    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        Validator::make($request->all(), [
            'title' => ['required', 'max:20'],
            'price' => ['required', 'numeric', 'max:100000000'],
        ])->validate();

        $product->update($request->all());
        return response($product->jsonSerialize(), Response::HTTP_OK);
    }

    /**
     * Delete product
     *
     * @return Response
     */
    public function destroy($id)
    {
        Product::destroy($id);
        return response(null, Response::HTTP_OK);
    }
}
