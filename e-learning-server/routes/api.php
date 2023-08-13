<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Teacher\AssignmentController;
use App\Http\Controllers\Teacher\CourseController;
use App\Http\Controllers\Teacher\TeacherController;


Route::group(['prefix' => 'user', 'middleware' => 'auth:api'], function () {

    Route::group(['prefix' => 'student',  'middleware' => 'auth.student'], function () {
    });


    Route::group(['prefix' => 'teacher',  'middleware' => 'auth.teacher'], function () {

        Route::group(['prefix' => 'teacher'], function () {
            Route::get('{teacherId}/courses', [TeacherController::class, 'getCourses']);
            Route::post('record-attendance', [TeacherController::class, 'recordAttendance']);
            Route::post('update-submission', [TeacherController::class, 'updateSubmission']);
        });

        Route::group(['prefix' => 'course'], function () {
            Route::get('{courseId}/content', [CourseController::class, 'getCourseContent']);
            Route::post('{courseId}/create-assignment-quiz', [CourseController::class, 'createAssignmentQuiz']);
            Route::post('{courseId}/create-material', [CourseController::class, 'createMaterial']);
            Route::get('{courseId}/students', [CourseController::class, 'getEnrolledStudents']);
        });

        Route::group(['prefix' => 'assignment'], function () {
            Route::get('{assignmentId}', [AssignmentController::class, 'getAssignmentDetails']);
        });
    });

    Route::group(['prefix' => 'parent'], function () {
    });

    Route::group(['prefix' => 'admin'], function () {
    });

    Route::get("profile", [AuthController::class, "profile"]);
    Route::post("logout", [AuthController::class, "logout"]);
    Route::post("refresh", [AuthController::class, "refresh"]);
});


Route::group(['prefix' => 'guest'], function () {
    Route::get("unauthorized", [AuthController::class, "unauthorized"])->name("unauthorized");
    Route::post('/login', [AuthController::class, 'login']);
});
