<?php

namespace App\Http\Controllers\V1;

use App\Enums\AttendanceStatus;
use App\Enums\Config as EnumsConfig;
use App\Http\Controllers\Controller;
use App\Http\Requests\V1\AttendanceInRequest;
use App\Http\Requests\V1\UpdateAttendanceRequest;
use App\Http\Resources\V1\RecapAttendanceResource;
use App\Http\Resources\V1\TodayAttendanceResource;
use App\Models\Attendance;
use App\Models\Config;
use App\Models\Student;
use Spatie\QueryBuilder\QueryBuilder;

class AttendanceController extends Controller
{
    public function todayAttendance()
    {
        $attendances = QueryBuilder::for(Attendance::class)
            ->with('student')
            ->whereDate('attendances.created_at', now())
            ->latest()
            ->jsonPaginate();

        return TodayAttendanceResource::collection($attendances)->additional([
            'message' => 'Success to get all today attendances',
        ]);
    }

    public function studentRecap(Student $student)
    {
        $attendances = QueryBuilder::for(Attendance::class)
            ->where('student_id', $student->id)
            ->when(request('month'), function ($query) {
                $query->whereMonth('created_at', request('month'));
            })
            ->when(! request('month'), function ($query) {
                $query->whereMonth('created_at', date('m'));
            })
            ->when(request('year'), function ($query) {
                $query->whereYear('created_at', request('year'));
            })
            ->when(! request('year'), function ($query) {
                $query->whereYear('created_at', date('Y'));
            })
            ->latest()
            ->jsonPaginate();

        return RecapAttendanceResource::collection($attendances)->additional([
            'message' => 'Success to get all student recap',
        ]);
    }

    public function updateAttendance(UpdateAttendanceRequest $request, Attendance $attendance)
    {
        $attendance->update($request->validated());

        return response()->json([
            'message' => 'Success to update attendance',
        ]);
    }

    public function attendanceIn(AttendanceInRequest $request)
    {
        $student = $request->user();
        $config = Config::where('name', EnumsConfig::QR_CODE->value)->firstOrFail();

        if ($request->qr_code != $config->value) {
            return response()->json([
                'message' => 'Qr code invalid',
            ], 400);
        }

        $attendance = Attendance::query()
            ->where('student_id', $student->id)
            ->whereDate('created_at', now())
            ->firstOrFail();

        if ($attendance->status == AttendanceStatus::PRESENT->value) {
            return response()->json([
                'message' => 'already done a presence',
            ], 400);
        }

        $attendance->update(['status' => AttendanceStatus::PRESENT->value]);

        return response()->json([
            'message' => 'Success for attendance',
        ]);
    }
}
