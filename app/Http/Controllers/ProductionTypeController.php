<?php

namespace App\Http\Controllers;

use App\Models\ProductionType;
use App\Http\Requests\StoreProductionTypeRequest;
use App\Http\Requests\UpdateProductionTypeRequest;

class ProductionTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return ProductionType::all();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreProductionTypeRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreProductionTypeRequest $request)
    {
        $type = ProductionType::create($request->only('name'));

        return $type;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ProductionType  $productionType
     * @return \Illuminate\Http\Response
     */
    public function show(ProductionType $productionType)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateProductionTypeRequest  $request
     * @param  \App\Models\ProductionType  $productionType
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateProductionTypeRequest $request, ProductionType $productionType)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ProductionType  $productionType
     * @return \Illuminate\Http\Response
     */
    public function destroy(ProductionType $productionType)
    {
        //
    }
}
