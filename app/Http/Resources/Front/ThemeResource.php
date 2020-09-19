<?php

namespace App\Http\Resources\Front;

use Illuminate\Http\Resources\Json\JsonResource;

class ThemeResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $practice = null;
        if($this->practice->active) {
            $practice = [
                'id' => $this->practice->id,
                'tasks' => TaskResource::collection($this->practice->tasks)
            ];
        }

        $control = null;
        if($this->control->active) {
            $control = [
                'id' => $this->control->id,
                'tasks' => TaskResource::collection($this->control->tasks)
            ];
        }

        return [
            'id' => $this->id,
            'title' => $this->title,
            'section_id' => $this->section_id,
            'subject_id' => $this->subject_id,
            'sort' => $this->sort,
            'theory_id' => $this->theory->active ? $this->theory->id : null,
            'practice' => $practice,
            'control' => $control,
            'tags' => $this->tags->pluck('name', 'id')
        ];
    }
}
