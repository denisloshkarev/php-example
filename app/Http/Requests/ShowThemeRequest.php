<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ShowThemeRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $theme = $this->route('theme');

        //check if user can access to theme
        $subjectId = $theme->subject ? $theme->subject->id : null;

        return $this->user()->resolveModel()->getSubjects()->where('id', $subjectId)->isNotEmpty();

    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            //
        ];
    }
}
