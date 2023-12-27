<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\StoreScheduleRequest;
use App\Http\Requests\V1\UpdateScheduleRequest;
use App\Http\Resources\V1\ScheduleDetailResource;
use App\Http\Resources\V1\ScheduleListResource;
use App\Models\Schedule;
use Illuminate\Http\Request;
use Spatie\QueryBuilder\QueryBuilder;

class ScheduleController extends Controller
{
    public function index()
    {
        $schedules = QueryBuilder::for(Schedule::class)
            ->latest()
            ->with('teacher', "subject", "classroom")
            ->jsonPaginate();

        return ScheduleListResource::collection($schedules)->additional([
            'message' => 'Success to get all schedules',
        ]);
    }

    public function store(StoreScheduleRequest $request)
    {
        $schedules = Schedule::create($request->validated());

        return (new ScheduleDetailResource($schedules))
            ->additional([
                'message' => 'Success to create schedules',
            ])
            ->response()
            ->setStatusCode(201);
    }

    public function show(Schedule $schedule)
    {
        return (new ScheduleDetailResource($schedule))
            ->additional([
                'message' => 'Success to get schedule',
            ])
            ->response()
            ->setStatusCode(200);
    }

    public function update(UpdateScheduleRequest $request, Schedule $schedule)
    {
        $schedule->update($request->validated());

        return (new ScheduleDetailResource($schedule))
            ->additional([
                'message' => 'Success to update schedule',
            ])
            ->response()
            ->setStatusCode(200);
    }

    public function destroy(Schedule $schedule)
    {
        $schedule->delete();

        return (new ScheduleDetailResource($schedule))
            ->additional([
                'message' => 'Success to delete schedule',
            ])
            ->response()
            ->setStatusCode(200);
    }

    public function mySchedule(Request $request)
    {
        $teacher = $request->user();

        return ScheduleListResource::collection($teacher->schedules)->additional([
            'message' => 'Success to get all schedules',
        ]);
    }
}
