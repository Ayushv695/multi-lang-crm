<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreItemTranslationRequest;
use App\Http\Requests\UpdateItemTranslationRequest;
use App\Http\Resources\ItemTranslationCollection;
use App\Repositories\Contracts\ItemTranslationsRepositoryInterface;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

class ItemTranslationController extends Controller
{
    public function __construct(private ItemTranslationsRepositoryInterface $repository) {}

    public function index(int $id)
    {
        try{
            $result = $this->repository->list($id);

            return successResponse(
                // data: new ItemTranslationCollection($translations),
                data:[
                    'translations' => new ItemTranslationCollection($result['translations']),
                    'languages_available_for_mapping' => $result['languages_available_for_mapping'],
                ],
                message: 'Item translations retrieved successfully.'
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
