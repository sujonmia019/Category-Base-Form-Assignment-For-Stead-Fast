<?php

namespace App\Http\Requests;

use App\Http\Requests\FormRequest;

class FormDataRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $rules = [
            'category_id' => ['required','integer'],
            'title'       => ['required','string','max:190','unique:forms,title'],
            'description' => ['required','string'],
            'status'      => ['required','in:1,2']
        ];

        if(request()->update_id){
            $rules['title'][3] = 'unique:forms,title,'.request()->update_id;
        }

        return $rules;
    }
}
