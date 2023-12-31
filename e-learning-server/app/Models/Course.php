<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'teacher_id',
        'capacity',
    ];

    public function teacher()
    {
        return $this->belongsTo(User::class, 'teacher_id');
    }

    public function users() {
        return $this->belongsToMany(User::class);
    }

    public function enrollments()
    {
        return $this->hasMany(Enrollment::class, 'course_id');
    }

    public function enrollmentsAvgGrade()
{
    return $this->enrollments()
        ->selectRaw('course_id, AVG(grade) as avg_grade')
        ->groupBy('course_id');
}

    public function AttendanceByStudent()
    {
        return $this->hasMany(Attendance::class, 'course_id'); //->where('student_id',$student_id);
    }

    public function materials()
    {
        return $this->hasMany(Material::class, 'course_id');
    }

    public function assignmentsQuizzes()
    {
        return $this->hasMany(AssignmentQuiz::class, 'course_id');
    }

    public function scopeMaterialsIsAnnouncement($query)
    {
        return $query->where("is_announcement", 1);
    }

    // public function StudentAssignment(){
    //     return $this->hasMany(assignmentsQuizzes::class, 'submissions', 'student_id', 'course_id');//->where('grade', '=', 80);
    // }
}
