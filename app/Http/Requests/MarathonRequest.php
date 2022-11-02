<?php
namespace App\Http\Requests;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;
class MarathonRequest extends FormRequest
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
            'first_name' => 'required',
            'last_name' => 'required',
            'phonecode' => 'required',
            'phone' => 'required|regex:/^([0-9\s\-\+\(\)]*)$/|min:10',
            'event' => 'required|numeric',
        ];
    }
    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json($validator->errors()));
    }
    public function messages()
    {
        return [
            'first_name.required' => 'First name is required!',
            'last_name.required' => 'Last name is required!',
            'phone.required' => 'Phone number is require min digits 10!',
            'phonecode.required' => 'Country is required!',
            'email.required' => 'Email is required!',
            'address.required' => 'Address is required!',
            'gender.required' => 'Gender is required!',
            'age.required' => 'Age is required!',
            'event.required' => 'Marathon Event is required!',
        ];
    }
    public function getValidatorInstance()
    {
        $this->cleanPhoneNumber();
        $this->cleanFirstName();
        $this->cleanLastName();
        $this->cleanAddress();
        $this->cleanGender();
        $this->cleanTShirtSize();
        return parent::getValidatorInstance();
    }
    protected function cleanPhoneNumber()
    {
        if ($this->request->has('phone')) {
            $this->merge([
                'phone' => phone_number_format($this->request->get('phonecode'), $this->request->get('phone'))
            ]);
        }
    }
    protected function cleanFirstName()
    {
        if ($this->request->has('first_name')) {
            $this->merge([
                'first_name' => ucwords(strtolower($this->request->get('first_name')))
            ]);
        }
    }
    protected function cleanLastName()
    {
        if ($this->request->has('last_name')) {
            $this->merge([
                'last_name' => ucwords(strtolower($this->request->get('last_name')))
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
    protected function cleanGender()
    {
        if ($this->request->has('gender')) {
            $this->merge([
                'gender' => strtoupper(strtolower($this->request->get('gender')))
            ]);
        }
    }
    protected function cleanTShirtSize()
    {
        if ($this->request->has('t_shirt_size')) {
            $this->merge([
                't_shirt_size' => strtoupper(strtolower($this->request->get('t_shirt_size')))
            ]);
        }
    }
}
