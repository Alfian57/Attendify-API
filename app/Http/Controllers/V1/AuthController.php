<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\LoginAdminRequest;
use App\Http\Requests\V1\LoginStudentRequest;
use App\Http\Requests\V1\LoginTeacherRequest;
use App\Http\Resources\V1\AdminDetailResource;
use App\Http\Resources\V1\StudentDetailResource;
use App\Http\Resources\V1\TeacherDetailResource;
use App\Models\Admin;
use App\Models\Student;
use App\Models\Teacher;
use Hash;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function loginAdmin(LoginAdminRequest $request)
    {
        $admin = Admin::where('email', $request->email)->first();

        if ($admin && Hash::check($request->password, $admin->password)) {
            $token = $admin->createToken('auth-admin-token', ['admin'])->plainTextToken;

            return response()->json([
                'token' => $token,
                'admin' => new AdminDetailResource($admin),
            ]);
        }

        return response()->json(['message' => 'invalid credentials'], 403);
    }

    public function loginTeacher(LoginTeacherRequest $request)
    {
        $teacher = Teacher::where('email', $request->email)->first();

        if ($teacher && Hash::check($request->password, $teacher->password)) {
            $token = $teacher->createToken('auth-teacher-token', ['teacher'])->plainTextToken;

            return response()->json([
                'token' => $token,
                'teacher' => new TeacherDetailResource($teacher),
            ]);
        }

        return response()->json(['message' => 'invalid credentials'], 403);
    }

    public function loginStudent(LoginStudentRequest $request)
    {
        $student = Student::where('nisn', $request->nisn)->first();

        if ($student && Hash::check($request->password, $student->password)) {
            $token = $student->createToken('auth-student-token', ['student'])->plainTextToken;

            return response()->json([
                'token' => $token,
                'student' => new StudentDetailResource($student),
            ]);
        }

        return response()->json(['message' => 'invalid credentials'], 403);
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'message' => 'success to logout',
        ]);
    }
}
