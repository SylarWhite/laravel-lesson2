<?php

namespace App\Http\Requests;

class ReplyRequest extends Request
{
    public function rules()
    {
        switch($this->method())
        {
            case 'POST':
            case 'PUT':
            case 'PATCH':
            case 'GET':
            case 'DELETE':
            default:
            {
                return [
                    'content'   =>  'required|min:2'
                ];
            }
        }
    }

    public function messages()
    {
        return [
        ];
    }
}
