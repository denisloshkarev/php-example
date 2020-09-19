<?php

namespace App\Models;

use App\Models\Themes\Theme;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Traits\HasRoles;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    use Notifiable, HasRoles, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'last_name', 'second_name', 'email', 'phone', 'password', 'active'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    protected $roleClasses = [
        'student' => Student::class,
        'teacher' => Teacher::class,
        'curator' => Curator::class,
        'parent' => ParentOfStudent::class,
    ];

    public function setPasswordAttribute($password)
    {
        $this->attributes['password'] = Hash::make($password);
    }

    public function getSubjects()
    {
        if($userModel = $this->resolveModel()) {
            return $userModel->getSubjects();
        }
        return null;
    }

    public function getThemesQuery(): ?Builder
    {
        $subjects = $this->getSubjects();

        if(!is_null($subjects)) {
            $subjectIds = $subjects->pluck('id')->toArray();
            return Theme::whereHas('section', function($sectionQuery) use($subjectIds){
                $sectionQuery->whereHas('subject', function($subjectQuery) use ($subjectIds){
                    $subjectQuery->whereIn('id', $subjectIds);
                });
            });
        }
        return null;
    }

    public function resolveModel()
    {
        $userRoles = $this->roles()->pluck('name')->toArray();
        foreach($userRoles as $role) {
            if(isset($this->roleClasses[$role])) {
                return $this->roleClasses[$role]::find($this->id);
            }
        }
        return null;
    }

    public function isStudent()
    {
        return get_class($this->resolveModel()) === Student::class;
    }

    public function isTeacher()
    {
        return get_class($this->resolveModel()) === Teacher::class;
    }

    public function isCurator()
    {
        return get_class($this->resolveModel()) === Curator::class;
    }

    public function isParent()
    {
        return get_class($this->resolveModel()) === ParentOfStudent::class;
    }

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }
    public function getJWTCustomClaims()
    {
        return [];
    }
}
