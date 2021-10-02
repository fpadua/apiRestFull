<?php

namespace App\Http\Resources\Api;

use Illuminate\Http\Resources\Json\JsonResource;

class EmpresaResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $response = [
            'id' => $this->id,
            'razao_social' => $this->razao_social,
            'cpf_cnpj' => $this->cpf_cnpj,
            'endereco' => [
                'logradouro' => $this->logradouro
            ]
        ];

        if($request->method() == 'POST') {
            $response = array_merge($response, [
                'alerts' => [
                    $request->message
                ]
            ]);
        }

        return $response;
    }
}
