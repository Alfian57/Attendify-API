<?php

namespace App\Observers;

use App\Enums\AttendanceStatus;
use App\Models\Attendance;
use App\Models\Student;

class StudentObserver
{
    public function created(Student $student): void
    {
        Attendance::create([
            'student_id' => $student->id,
            'status' => AttendanceStatus::ALPHA->value,
        ]);
    }
}
