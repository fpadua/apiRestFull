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

    public static function search($request)
    {
        $empresas = Empresa::query();

        if ($request->exists('cpf_cnpj')) {
            $empresas->where('cpf_cnpj', $request->query('cpf_cnpj'));
        }

        if ($request->exists('razao_social')) {
            $empresas->where('razao_social', 'like', "%{$request->query('razao_social')}%");
        }

        if ($request->exists('nome_fantasia')) {
            $empresas->where('nome_fantasia', 'like', "%{$request->query('nome_fantasia')}%");
        }

        if ($request->exists('tipo_pessoa')) {
            $empresas->where('tipo_pessoa', $request->query('tipo_pessoa'));
        }

        if ($request->exists('tipo_contribuinte')) {
            $empresas->where('tipo_contribuinte', $request->query('tipo_contribuinte'));
        }

        if ($request->exists('tipo_cadastro')) {
            $empresas->where('tipo_cadastro', $request->query('tipo_cadastro'));
        }

        if ($request->exists('estado')) {
            $empresas->where('estado', $request->query('estado'));
        }

        if ($request->exists('cidade')) {
            $empresas->where('cidade', 'like', "%{$request->query('cidade')}%");
        }

        if ($request->exists('pais')) {
            $empresas->where('pais', $request->query('pais'));
        }

        return $empresas->paginate(10);
    }
}
