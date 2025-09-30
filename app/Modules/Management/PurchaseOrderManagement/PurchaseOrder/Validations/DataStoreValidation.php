<?php

namespace App\Modules\Management\PurchaseOrderManagement\PurchaseOrder\Validations;

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
            'title' => 'required | sometimes',
            'reference' => 'required | sometimes',
            'suppliyer_id' => 'required | sometimes',
            'date' => 'required | sometimes',
            'currency_id' => 'required | sometimes',
            'currency_exchange_rate' => 'required | sometimes',
            'expected_time_of_delivery' => 'required | sometimes',
            'subtotal' => 'required | sometimes',
            'discount' => 'required | sometimes',
            'total' => 'required | sometimes',
            'total_in_bdt' => 'required | sometimes',
            'paid' => ' sometimes',
            'due' => ' sometimes',
            'status' => ['sometimes', Rule::in(['active', 'inactive'])],
        ];
    }
}
