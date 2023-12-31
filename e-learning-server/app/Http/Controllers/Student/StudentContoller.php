<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\AssignmentQuiz;
use App\Models\Enrollment;
use App\Models\Submission;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class StudentContoller extends Controller
{
    function IsSubmitted()
    {
        $auth_user = Auth::user();

        if ($auth_user->user_type_id == 3) {
            $student = User::child($auth_user->id)->first();
        } else {
            $student = $auth_user;
        }

        $assignments = Submission::where("student_id", $student->id)->with("assignmentQuiz.course");

        if ($assignments->exists()) {
            $assignments_data = $assignments->get();
            $data = [];
            foreach ($assignments_data as $submission) {
            $data[] = [
            "course_name" => $submission->assignmentQuiz->course->name,
            "submission_data" => $submission
        ];
    }
        } else {
            return response()->json([
                "status" => "success",
                "message" => "No assignments submitted"
            ]);
        }

        return response()->json([
            "status" => "success",
            "data" => $data
        ]);
    }


    function IsCompleted()
    {
        $auth_user = Auth::user();

        if ($auth_user->user_type_id == 3) {
            $student = User::child($auth_user->id)->first();
        } else {
            $student = $auth_user;
        }

        if ($student) {
            $student_id = $student->id;
            $student_courses = Enrollment::Completed()->with('course')->where("student_id", $student_id)->get();

            if ($student_courses->isNotEmpty()) {
                return response()->json([
                    "status" => "success",
                    "data" => $student_courses
                ]);
            } else {
                return response()->json([
                    "status" => "success",
                    "message" => "Not compeleted courses"
                ]);
            }
        } else {
            return response()->json([
                "status" => "error",
                "message" => "User not found"
            ]);
        }
    }

    public function uploadSubmission(Request $request)
    {
        $request->validate([
            'file' => 'required|file',
        ]);

        $auth_user = Auth::user();
        $assignment = AssignmentQuiz::findOrFail($request->assignment_id);

        if ($request->hasFile('file')) {
        $file = $request->file('file');
        $fileName = time() . '_' . $file->getClientOriginalName();
        $file->move(public_path('uploads/Studentfiles'), $fileName);
        }


        $submission = new Submission([
            'student_id' => $auth_user->id,
            'assignment_id' => $assignment->id,
            'grade' => null,
            'feedback' => null,
            'file_url' => $fileName,
        ]);

        $submission->save();

        return response()->json([
            'message' => 'Submission created successfully',
            'submission' => $submission,
        ], 201);
    }
}
