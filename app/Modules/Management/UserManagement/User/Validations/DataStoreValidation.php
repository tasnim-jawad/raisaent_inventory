<?php

namespace App\Modules\Management\UserManagement\User\Validations;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rule;

class DataStoreValidation extends FormRequest
{
    /**
     * Determine if the  is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }
    /**
     * validateError to make this request.
     */
    public function validateError($data)
    {
        $errorPayload =  $data->getMessages();
        return response(['status' => 'validation_error', 'errors' => $errorPayload], 422);
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException($this->validateError($validator->errors()));
        if ($this->wantsJson() || $this->ajax()) {
            throw new HttpResponseException($this->validateError($validator->errors()));
        }
        parent::failedValidation($validator);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required | sometimes',
            'email' => 'required | sometimes | unique:users,email,' . $this->id,
            'password_in_text' => 'required | sometimes |min:8',
            'image' => 'required | sometimes',
            'role_id' => 'required | sometimes',
            'address' => 'required | sometimes',
            'phone_number' => 'required | sometimes',
            'join_date' => 'required | sometimes',
            'salery' => 'required | sometimes',
            'can_login' => 'required | sometimes',
            'present_address' => ' sometimes',
            'permanent_address' => ' sometimes',
            'designation' => ' sometimes',
            'nid' => ' sometimes',
            'comment' => ' sometimes',
            'status' => ['sometimes', Rule::in(['active', 'inactive'])],
        ];
    }
    public function messages(): array
    {
        return [
            'password_in_text.required' => 'The password field is required.',
        ];
    }
}
