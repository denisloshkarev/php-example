<?php

namespace App\Models\Themes;

use App\Models\ArchivedContent;
use App\Models\Section;
use App\Models\Subject;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Theme extends Model
{
    use SoftDeletes;

    protected $with = ['section', 'theory', 'practice', 'control', 'tags'];
    protected $guarded = ['id'];

    public static function boot()
    {
        parent::boot();

        self::created(function($theme){
            $theme->theory()->create([]);
            $theme->practice()->create([]);
            $theme->control()->create([]);
        });

    }

    //relations
    public function section()
    {
        return $this->belongsTo(Section::class);
    }

    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }

    public function theory()
    {
        return $this->hasOne(Theory::class);
    }

    public function practice()
    {
        return $this->hasOne(Practice::class);
    }

    public function control()
    {
        return $this->hasOne(Control::class);
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }

}
