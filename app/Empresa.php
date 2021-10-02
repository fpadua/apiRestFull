<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Empresa extends Model
{
    protected $primaryKey = 'id';
    protected $table = 'empresa';

    protected $fillable = [
        'tipo_pessoa',
        'tipo_contribuinte',
        'tipo_cadastro',
        'estado',
        'cidade',
        'pais',

        'cpf_cnpj',
        'inscricao_estadual',
        'inscricao_municipal',
        'razao_social',
        'nome_fantasia',
        'fone_principal',
        'fone_secundario',
        'email',

        'cep',
        'logradouro',
        'numero',
        'complemento',
        'bairro',
        'observacao'
    ];

    protected $hidden = [
        'cpf_cnpj'
    ];
}
