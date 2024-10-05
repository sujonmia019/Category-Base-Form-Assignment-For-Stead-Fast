<?php

namespace App\Http\Requests;

use App\Http\Requests\FormRequest;

class FieldRequest extends FormRequest
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
        if (request()->form_name == 'text') {
            return [
                'form_id'     => ['required','integer'],
                'label'       => ['required','string','max:180'],
                'placeholder' => ['nullable','string','max:180'],
                'type'        => ['required','in:text,tel,email']
            ];
        }

        if (request()->form_name == 'field') {
            return [
                'form_id'     => ['required','integer'],
                'label'       => ['required','string','max:180'],
                'placeholder' => ['nullable','string','max:180'],
                'type'        => ['required','in:date,file']
            ];
        }

        if (request()->form_name == 'multi') {
            return [
                'form_id'     => ['required','integer'],
                'label'       => ['required','string','max:180'],
                'options'     => ['required','string'],
                'type'        => ['required','in:select,checkbox,radio']
            ];
        }
    }
}
