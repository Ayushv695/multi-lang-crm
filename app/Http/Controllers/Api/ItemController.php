<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\IndexItemRequest;
use App\Http\Requests\StoreItemRequest;
use App\Http\Requests\UpdateItemRequest;
use App\Http\Resources\ItemCollection;
use App\Http\Resources\ItemResource;
use App\Repositories\Contracts\ItemRepositoryInterface;
use App\Traits\ApiResponse;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class ItemController extends Controller
{
    use ApiResponse;

    public function __construct(private ItemRepositoryInterface $repository) {}

    public function index(IndexItemRequest $request)
    {
        $items = $this->repository->list($request->validated());
        return new ItemCollection($items);
    }

    public function store(StoreItemRequest $request)
    {
        try{
            $item = $this->repository->create($request->validated());

            return $this->successResponse(
                data: new ItemResource($item),
                message: 'Item added successfully.'
            );
        }catch(\Exception $e){
            return errorResponse(
                message: $e->getMessage(),
                status: 401
            );
        }
    }

    public function update(UpdateItemRequest $request, $id) {
        try{
            $language = $this->repository->update($id, $request->validated());

            return $this->successResponse(
                data: new ItemResource($language),
                message: 'Item updated successfully.'
            );

        }catch(ModelNotFoundException $e){
            return errorResponse(
                message: "Item not found.",
                status: 401
            );
        }catch(\Exception $e){
            return errorResponse(
                message: $e->getMessage(),
                status: 404
            );
        }
    }

    public function destroy($id)
    {
        try{
            $this->repository->delete($id);
            return $this->successResponse(
                message: 'Item deleted successfully.'
            );

        }catch(ModelNotFoundException $e){
            return errorResponse(
                message: "Item not found.",
                status: 404
            );
        }catch(\Exception $e){
            return errorResponse(
                message: $e->getMessage(),
                status: 401
            );
        }
    }
}
