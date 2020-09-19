<?php

namespace App;

use App\Models\Curator;
use App\Models\Student;
use App\Models\Subject;
use App\Models\Teacher;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Group extends Model
{
    use SoftDeletes;

    protected $guarded = ['id'];

    //relations
    public function students()
    {
        return $this->belongsToMany(Student::class, 'student_profiles', 'group_id', 'student_id');
    }

    public function curator()
    {
        return $this->belongsTo(Curator::class, 'curator_id', 'id');
    }

    public function teachers()
    {
        return $this->belongsToMany(Teacher::class, 'group_subject', 'group_id', 'teacher_id');
    }

    public function subjects()
    {
        return $this->belongsToMany(Subject::class, 'group_subject', 'group_id', 'subject_id')
            ->withPivot(['group_id', 'subject_id', 'teacher_id']);
    }
}
