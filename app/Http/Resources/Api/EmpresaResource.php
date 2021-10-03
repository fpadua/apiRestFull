<?php

namespace App\Http\Resources\Api;

use \Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class EmpresaResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'razao_social' => $this->razao_social,
            $this->mergeWhen($request->isMethod('post'), [
                'cpf_cnpj' => $this->cpf_cnpj,
            ]),
            'tipo_pessoa' => $this->tipo_pessoa === 'F' ? 'Física' : 'Jurídica',
            'tipo_contribuinte' => boolval($this->tipo_contribuinte),
            'tipo_cadastro' => $this->tipo_cadastro,
            'endereco' => [
                'logradouro' => $this->logradouro,
                'cidade' => $this->cidade,
                'estado' => $this->estado,
            ],
            $this->mergeWhen($request->isMethod('post'), [
                'alertas' => [
                    $request->message
                ]
            ])
        ];
    }
}
