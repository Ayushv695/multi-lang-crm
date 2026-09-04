<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\IndexLanguageRequest;
use App\Http\Requests\StoreLanguageRequest;
use App\Http\Requests\UpdateLanguageRequest;
use App\Http\Resources\LanguageCollection;
use App\Http\Resources\LanguageResource;
use App\Repositories\Contracts\LanguageRepositoryInterface;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class LanguageController extends Controller
{
    public function __construct(private LanguageRepositoryInterface $repository) {}

    public function index(IndexLanguageRequest $request)
    {
        $languages = $this->repository->list($request->validated());
        return new LanguageCollection($languages);
    }

    public function store(StoreLanguageRequest $request)
    {
        try{
            $language = $this->repository->create($request->validated());
            return successResponse(
                data: new LanguageResource($language),
                message: 'Language added successfully.'
            );
        }catch(\Exception $e){
            return errorResponse(
                message: $e->getMessage(),
                status: 401
            );
        }
    }

    public function update(UpdateLanguageRequest $request, $id) {
        
        try{
            $language = $this->repository->update($id, $request->validated());

            return successResponse(
                data: new LanguageResource($language),
                message: 'Language updated successfully.'
            );

        }catch(ModelNotFoundException $e){
            return errorResponse(
                message: "Language not found.",
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
            return successResponse(
                message: 'Language deleted successfully.'
            );

        }catch(ModelNotFoundException $e){
            return errorResponse(
                message: "Language not found.",
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
