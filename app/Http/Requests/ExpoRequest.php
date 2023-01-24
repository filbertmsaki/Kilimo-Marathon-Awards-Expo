<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;

class ExpoRequest extends FormRequest
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
            'entry' => 'required',
            'company_name' => 'required|string',
            'service_name' => 'required|string',
            'contact_person_name' => 'required|string',
            'contact_person_phone' => 'required|regex:/^([0-9\s\-\+\(\)]*)$/|min:10',
            'company_details' => 'required',
        ];
    }
    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json($validator->errors()));
    }

    public function messages()
    {
        return [
            'company_name.required' => 'Company, business or service name is required!',
            'service_name.required' => 'Business service you offer is require!',
            'contact_person_name.required' => 'Contact person name is require!',
            'contact_person_phone.required' => 'Contact person phone is require!',
            'entry.required' => 'Entry Category is required!',
        ];
    }


    public function getValidatorInstance()
    {
        $this->cleanCompanyPhoneNumber();
        $this->cleanPhoneNumber();
        $this->cleanCompanyName();
        $this->cleanServiceName();
        $this->cleanAddress();
        $this->cleanCompanyDetails();
        return parent::getValidatorInstance();
    }

    protected function cleanCompanyPhoneNumber()
    {
        if ($this->request->has('company_phone')) {
            $this->merge([
                'company_phone' => phone_number_format('255', $this->request->get('company_phone'))
            ]);
        }
    }
    protected function cleanPhoneNumber()
    {
        if ($this->request->has('contact_person_phone')) {
            $this->merge([
                'contact_person_phone' => phone_number_format('255', $this->request->get('contact_person_phone'))
            ]);
        }
    }
    protected function cleanCompanyName()
    {
        if ($this->request->has('company_name')) {
            $this->merge([
                'company_name' => ucwords(strtolower($this->request->get('company_name')))
            ]);
        }
    }
    protected function cleanServiceName()
    {
        if ($this->request->has('service_name')) {
            $this->merge([
                'service_name' => ucwords(strtolower($this->request->get('service_name')))
            ]);
        }
    }
    protected function cleanAddress()
    {
        if ($this->request->has('address')) {
            $this->merge([
                'address' => ucwords(strtolower($this->request->get('address')))
            ]);
        }
    }
    protected function cleanCompanyDetails()
    {
        if ($this->request->has('company_details')) {
            $this->merge([
                'company_details' => ucwords(strtolower($this->request->get('company_details')))
            ]);
        }
    }
}
