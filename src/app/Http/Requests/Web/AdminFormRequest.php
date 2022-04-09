<?php

namespace App\Http\Requests\Web;

use Illuminate\Foundation\Http\FormRequest;

class AdminFormRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        //implementar as permissões aqui

        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
  /*  public function rules()
    {
        return [
           'name' => 'required|string|max:60',
           'email' => 'required|email',
           'password' => 'required|string|min:6',
            'cpf' => 'required|string|min:11',
            'telefone' => 'required|string|max:255',
        ];
    }

      public function messages()
    {
        return  [
                'required' => 'O campo :attribute é obrigatório',
                'password.min' => 'O campo senha não pode conter menos de 6 caracteres',

        ];
    }*/

    /**
     * Configure the validator instance.
     *
     * @param  \Illuminate\Validation\Validator  $validator
     * @return void
     */
    public function withValidator($validator)
    {

        //return $validator->fails();

       /* $validator->after(function ($validator) {
            if ($this->somethingElseIsInvalid()) {
                $validator->errors()->add('field', 'Something is wrong with this field!');
            }
        });*/
    }
}
