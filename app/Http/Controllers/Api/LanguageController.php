<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\IndexLanguageRequest;
use App\Http\Requests\StoreLanguageRequest;
use App\Http\Requests\UpdateLanguageRequest;
use App\Http\Resources\LanguageCollection;
use App\Http\Resources\LanguageResource;
use App\Models\Language;
use App\Repositories\Contracts\LanguageRepositoryInterface;
use App\Traits\ApiResponse;

class LanguageController extends Controller
{
    use ApiResponse;

    public function __construct(private LanguageRepositoryInterface $repository) {}

    public function index(IndexLanguageRequest $request)
    {
        $languages = $this->repository->list($request->validated());
        return new LanguageCollection($languages);
    }

    public function store(StoreLanguageRequest $request)
    {
        $language = $this->repository->create($request->validated());
        // return new LanguageResource($language);
        return $this->successResponse(
            data: new LanguageResource($language),
            message: 'Language added successfully.'
        );
    }

    public function update(UpdateLanguageRequest $request, Language $language) {
        $language = $this->repository->update($language, $request->validated());
        // return new LanguageResource($language);
        return $this->successResponse(
            data: new LanguageResource($language),
            message: 'Language updated successfully.'
        );
    }

    public function destroy(Language $language)
    {
        $this->repository->delete($language);
        return $this->successResponse(
            message: 'Language deleted successfully.'
        );
    }
}
