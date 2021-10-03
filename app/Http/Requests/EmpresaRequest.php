<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EmpresaRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth('api')->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {

        /* Regras de validacao */
        if ($this->isNotFilled('numero')) {
            $this->merge(['numero' => 'SN']);
        }

        if ($this->tipo_pessoa === 'F' and $this->inscricao_estadual) {
            $this->request->remove('inscricao_estadual');
        }

        if ($this->estado == 'Goiás' and $this->tipo_cadastro == 'Variante') {
            $this->merge([
                'message' => [
                    'Mandar equipe de campo'
                ]
            ]);
        }


        if ($this->estado == 'São Paulo' and
            $this->tipo_cadastro == 'Variante' and
            $this->tipo_pessoa == 'F'
        ) {
            $this->merge(['message' => ['Reavaliar em 2 meses']]);
        }

        if ($this->estado == 'Ceará' and
            $this->tipo_cadastro == 'Variante' and
            $this->tipo_pessoa == 'F' and
            $this->filled('observacao')) {
            $this->merge(['message' => ['Possível violação do tratado Beta']]);
        }

        if ($this->estado == 'Tocantins' and
            $this->tipo_cadastro == 'Variante' and
            $this->tipo_pessoa == 'F' and
            $this->filled('observacao')) {
            $this->merge(['message' => ['Possível violação do tratado Celta']]);
        }

        if ($this->estado == 'Amazonas' and
            $this->tipo_cadastro == 'Variante' and
            $this->tipo_pessoa == 'F' and
            $this->filled('observacao')
        ) {
            $this->merge(['message' => ['Possível violação do tratado Alpha']]);
        }

        return [
            'tipo_pessoa' => 'required',
            'tipo_contribuinte' => 'required',
            'tipo_cadastro' => 'required',
            'estado' => 'required',
            'cidade' => 'required',
            'pais' => 'required',

            'cpf_cnpj' => 'required',
            'razao_social' => 'required',
            'email' => 'email',

            'cep' => 'required',
            'logradouro' => 'required',
            'bairro' => 'required',

            'nome_fantasia' => 'required_if:tipo_pessoa,==,J',
            'inscricao_estadual' => 'required_if:tipo_contribuinte,==,1',
            'fone_principal' => 'required_without:fone_secundario',
            'fone_secundario' => 'required_without:fone_principal',
            'numero' => '',
        ];

    }
}
