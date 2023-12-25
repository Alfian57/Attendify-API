<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\StoreSubjectRequest;
use App\Http\Requests\V1\UpdateSubjectRequest;
use App\Http\Resources\V1\SubjectDetailResource;
use App\Http\Resources\V1\SubjectListResource;
use App\Models\Subject;
use Spatie\QueryBuilder\QueryBuilder;

class SubjectController extends Controller
{
    public function index()
    {
        $subjects = QueryBuilder::for(Subject::class)
            ->allowedFilters('name')
            ->defaultSort('name')
            ->allowedSorts('name')
            ->latest()
            ->jsonPaginate();

        return SubjectListResource::collection($subjects)->additional([
            'message' => 'Success to get all subjects',
        ]);
    }

    public function store(StoreSubjectRequest $request)
    {
        $subject = Subject::create($request->validated());

        return (new SubjectDetailResource($subject))
            ->additional([
                'message' => 'Success to create subject',
            ])
            ->response()
            ->setStatusCode(201);
    }

    public function show(Subject $subject)
    {
        return (new SubjectDetailResource($subject))
            ->additional([
                'message' => 'Success to get subject',
            ])
            ->response()
            ->setStatusCode(200);
    }

    public function update(UpdateSubjectRequest $request, Subject $subject)
    {
        $subject->update($request->validated());

        return (new SubjectDetailResource($subject))
            ->additional([
                'message' => 'Success to update subject',
            ])
            ->response()
            ->setStatusCode(200);
    }

    public function destroy(Subject $subject)
    {
        $subject->delete();

        return (new SubjectDetailResource($subject))
            ->additional([
                'message' => 'Success to delete subject',
            ])
            ->response()
            ->setStatusCode(200);
    }
}
