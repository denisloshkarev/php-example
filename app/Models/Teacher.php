<?php

namespace App\Models;

use App\Traits\HasParentModel;

class Teacher extends User
{
    use HasParentModel;

    public function subjects()
    {
        return $this->belongsToMany(Subject::class, 'subject_teacher', 'teacher_id', 'subject_id');
    }

    public function getSubjects()
    {
        return $this->subjects;
    }
}
