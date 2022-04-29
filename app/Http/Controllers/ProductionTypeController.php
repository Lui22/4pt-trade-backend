<?php

namespace App\Http\Controllers;

use App\Models\ProductionType;
use App\Http\Requests\StoreProductionTypeRequest;
use App\Http\Requests\UpdateProductionTypeRequest;
use Illuminate\Http\Response;

class ProductionTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index(): Response
    {
        return ProductionType::all();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreProductionTypeRequest $request
     * @return Response
     */
    public function store(StoreProductionTypeRequest $request): Response
    {
        return ProductionType::create($request->only('name'));
    }

    /**
     * Display the specified resource.
     *
     * @param ProductionType $productionType
     * @return void
     */
    public function show(ProductionType $productionType): void
    {
        return;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateProductionTypeRequest $request
     * @param ProductionType $productionType
     * @return void
     */
    public function update(UpdateProductionTypeRequest $request, ProductionType $productionType): void
    {
        return;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param ProductionType $productionType
     * @return void
     */
    public function destroy(ProductionType $productionType): void
    {
        return;
    }
}
