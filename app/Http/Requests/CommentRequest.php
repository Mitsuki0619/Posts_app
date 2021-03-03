<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CommentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'comment' => 'required_without:file|max:140',
            'user_id' => 'required|numeric',
            'post_id' => 'required|numeric',
            'file' => [
                'file',
                'image',
                'mimes:jpeg,png',
            ]
        ];
    }
}
