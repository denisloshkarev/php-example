<?php

namespace App;

use App\Models\Curator;
use App\Models\Student;
use Illuminate\Database\Eloquent\Model;

class StudentProfile extends Model
{

    protected $with = ['curator'];

    //relations
    public function curator()
    {
        return $this->belongsTo(Curator::class);
    }

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function group()
    {
        return $this->belongsTo(Group::class);
    }
}
