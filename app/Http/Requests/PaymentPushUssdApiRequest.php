<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class PaymentPushUssdApiRequest extends FormRequest
{

       
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    protected $payload = [];
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function setPayload(array $payload)
    {
        $this->payload = $payload;

        return $this;
    }
    public function rules()
    {
        return [
            'user_id' => 'required|max:255',
            'payment_number' => 'required',
            'service_type' => 'required',
            'service_id' => 'required',
        ];

    }
    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'success' => false,
            'message' => 'Validation errors',
            'data' => $validator->errors(),
        ]));
    }
}