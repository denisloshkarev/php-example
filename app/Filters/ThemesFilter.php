<?php


namespace App\Filters;

use Illuminate\Database\Eloquent\Builder;

class ThemesFilter extends BaseFilter
{

    public function filterSectionId($sectionId)
    {
        $this->query->where('section_id', $sectionId);
    }

    public function filterSubjectId($subjectId)
    {
        $this->query->whereHas('section', function(Builder $subQuery) use($subjectId){
            $subQuery->where('subject_id', $subjectId);
        });
    }

    public function filterActivity($activity)
    {
        switch($activity) {
            case 'all':
                //return all sections
                break;
            case 'archive':
                $this->query->where(function($query){
                    $query->whereHas('archived')
                        ->orWhereHas('subject', function($query){
                            $query->whereHas('archived', function($query){
                                $query->whereNull('section_id');
                            });
                        })
                        ->orWhereHas('section', function($query){
                            $query->whereHas('archived', function($query){
                                $query->whereNull('theme_id');
                            });
                        });
                });
                break;
            default:
                $this->query->whereDoesntHave('archived');
                $this->query->whereHas('subject', function($query){
                    $query->whereDoesntHave('archived', function($query){
                        $query->whereNull('section_id');
                    });
                });
                $this->query->whereHas('section', function($query){
                    $query->whereDoesntHave('archived', function($query){
                        $query->whereNull('theme_id');
                    });
                });
                break;
        }
    }

}
