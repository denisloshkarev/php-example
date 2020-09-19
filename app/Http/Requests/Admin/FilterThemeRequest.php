<?php

namespace App\Http\Requests\Admin;

use App\Http\Requests\ApiRequest;

class FilterThemeRequest extends ApiRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'section_id' => 'exists:sections,id',
            'subject_id' => 'exists:subjects,id',
            'activity' => 'in:all,active,archive',
        ];
    }
}
