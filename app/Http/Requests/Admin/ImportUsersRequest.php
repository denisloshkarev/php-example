<?php

namespace App\Http\Requests\Admin;

use App\Http\Requests\ApiRequest;

class ImportUsersRequest extends ApiRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'type' => 'required|in:moderator,teacher,student',
            'file' => 'required|file|mimes:xlsx,xls'
        ];
    }
}
