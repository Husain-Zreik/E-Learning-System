<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\User;
use Illuminate\Http\Request;

class AdminCourseController extends Controller
{
    function createCourse(Request $request) {

        $validatedData = $request->validate([
            "teacher_id" => 'required|exists:users,id',
            "name" => 'required|string|max:255',
            "capacity" => 'required|integer'
        ]);

        $course = Course::create($validatedData);

        return response()->json(["message" => "course created successfully", "course" => $course]);
    }

    function updateCourse(Request $request, $courseId) {

        $course = Course::find($courseId);

        $course->name = $request->name;
        $course->capacity = $request->capacity;
        $course->teacher_id = $request->teacher_id;

        // $validatedData = $request->validate([
        //     "teacher_id" => 'required|exists:users,id',
        //     "name" => 'required|string|max:255',
        //     "capacity" => 'required|integer'
        // ]);

        // $course->update($validatedData);

        return response()->json(["message" => "course updated successfully", "course" => $course]);
    }

    function courseReport($courseReport) {

        $course = Course::find($courseReport);

        $totalEnrollments = $course->enrollments->count();
        $completedEnrollments = $course->enrollments->where("is_completed", true)->count();

        return response()->json([
            "course" => $course,
            "total_enrollments" => $totalEnrollments,
            "completed_enrollments" => $completedEnrollments,
        ]);
    }

    function teacherReport($teacherId) {

        $teacher = User::find($teacherId);
        $teacher_courses = Course::where('teacher_id', $teacherId)->get();

        return response()->json($teacher_courses);
    }

    function studentReport($studentId) {

        $student = User::find($studentId);
        $enrolled_courses = $student->enrolledCourses;

        // return response()->json($enrolled_courses);

        $content = [];

        foreach($enrolled_courses as $enrolledCourse) {
            $enrollments = $enrolledCourse->enrollments;

            foreach($enrollments as $enrollment) {
                $avg_grade = $enrollment->submission->avg("grade");
                return response()->json($avg_grade);
            }


            $content[] = [
                "course" => $enrolledCourse,
                // "grade" => $avg_grade
            ];
        }

        return response()->json([
            'message' => 'success',
            'data' => $content
        ]);
    }
}
