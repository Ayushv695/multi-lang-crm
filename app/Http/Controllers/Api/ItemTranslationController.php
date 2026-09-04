<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\IndexItemTranslationRequest;
use App\Http\Requests\StoreItemTranslationRequest;
use App\Http\Requests\UpdateItemTranslationRequest;
use App\Repositories\Contracts\ItemTranslationsRepositoryInterface;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

class ItemTranslationController extends Controller
{
    public function __construct(private ItemTranslationsRepositoryInterface $repository) {}

    public function index(IndexItemTranslationRequest $request)
    {
        $items = $this->repository->list($request->validated());
        return new ItemCollection($items);
    }

    public function store(StoreItemTranslationRequest $request)
    {
        try{
            $item = $this->repository->create($request, $request->validated());

            return successResponse(
                data: new ItemResource($item),
                message: 'Item added successfully.'
            );
        }catch(\Exception $e){
            return errorResponse(
                message: $e->getMessage(),
                status: 500
            );
        }
    }

    public function update(UpdateItemTranslationRequest $request, int $id) {
        try{
            $language = $this->repository->update($id, $request, $request->validated());

            return successResponse(
                data: new ItemResource($language),
                message: 'Item updated successfully.'
            );

        }catch(ModelNotFoundException $e){
            return errorResponse(
                message: "Item not found.",
                status: 404
            );
        }catch(\Exception $e){
            return errorResponse(
                message: $e->getMessage(),
                status: 500
            );
        }
    }

    public function destroy(int $itemId, int $languageId)
    {
        try{
            $this->repository->delete($itemId,$languageId);
            return successResponse(
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
                status: 500
            );
        }
    }
}
