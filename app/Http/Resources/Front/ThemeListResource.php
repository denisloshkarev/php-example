<?php

namespace App\Http\Resources\Front;

use Illuminate\Http\Resources\Json\JsonResource;

class ThemeListResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'section_id' => $this->section_id,
            'subject_id' => $this->subject_id,
            'sort' => $this->sort,
            'theory_id' => $this->theory->active ? $this->theory->id : null,
            'practice_id' => $this->practice->active ? $this->practice->id : null,
            'control_id' => $this->control->active ? $this->control->id : null,
            'tags' => $this->tags->pluck('name', 'id')
        ];
    }
}
