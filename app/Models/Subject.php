<?php

namespace App\Models;

use App\Models\Themes\Theme;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Subject extends Model
{
    use SoftDeletes;

    protected $guarded = ['id'];

    //mutators
    public function getImageAttribute($val)
    {
        if(strpos($val, '://') === false) {
            return config('app.url').$val;
        }
    }

    //relations
    public function sections()
    {
        return $this->hasMany(Section::class);
    }

    public function themes()
    {
        return $this->hasManyThrough(Theme::class, Section::class);
    }

    public function tasks()
    {
        return $this->hasMany(Task::class);
    }

    public function teachers()
    {
        return $this->belongsToMany(Teacher::class, 'subject_teacher', 'subject_id', 'teacher_id');
    }

    public function archived()
    {
        return $this->hasMany(ArchivedContent::class);
    }

    public function isArchived()
    {
        return $this->archived->whereNull('section_id')->isNotEmpty();
    }

    public function getSuccessRate(Student $student)
    {
        $successRates = [
            'themes' => [],
            'total' => 0
        ];
        $this->themes->each(function(Theme $theme) use($student, &$successRates){

            $successRates['themes'][$theme->id] = $theme->getSuccessRate($student);

        });

        if(!empty($successRates['themes'])) {
            $successRates['total'] = array_sum($successRates)/count($successRates);
        }

        return $successRates;
    }
}
