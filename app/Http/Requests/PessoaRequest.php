<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PessoaRequest extends FormRequest
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
            'tipo_pessoa' => 'required',
            'tipo_contribuinte' => 'required',

            'nome_fantasia' => 'required_if:tipo_pessoa,==,J',
            'tipo_cadastro' => 'required',
            'inscricao_estadual' => 'required_if:tipo_contribuinte,==,1',
            'estado' => 'required',
//            'fone_principal' => 'required_without:fone_secundario',
//            'fone_secundario' => 'required_without:fone_principal',
//            'cidade' => 'required',
//            'pais' => 'required',

//            'cpf_cnpj' => 'required',
//            'razao_social' => 'required',

//            'cep' => 'required',
//            'logradouro' => 'required',
//            'complemento' => 'required',
//            'bairro' => 'required',
            'numero' => '',

//            'inscricao_estadual' => '',
//            'inscricao_municipal' => '',
//            'email' => 'email',
//            'observacao' => ''
        ];
    }
}
