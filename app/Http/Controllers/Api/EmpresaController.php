<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\PessoaRequest;
use App\Empresa;
use App\Http\Resources\Api\EmpresaResource;
use GuzzleHttp\Client;
use http\Env\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Validator;

class EmpresaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $empresas = Empresa::query()->paginate(10);
        return EmpresaResource::collection($empresas);
    }

    public function search(Request $request)
    {
        $empresas = Empresa::query();

//        dd($request->header('cpf_cnpj'));
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

        $empresas = $empresas->paginate(10);
        return EmpresaResource::collection($empresas);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $validacao = Validator::make($request->all(), [
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

        ]);

        if ($request->isNotFilled('numero')) {
            $request->merge(['numero' => 'SN']);
        }

        if ($request->tipo_pessoa === 'F' and $request->inscricao_estadual) {
            $request->request->remove('inscricao_estadual');
        }

        if ($request->estado == 'Goiás' and $request->tipo_cadastro == 'Variante') {
            $request->merge([
                'message' => [
                    'Mandar equipe de campo'
                ]
            ]);
        }

        if ($request->estado == 'São Paulo' and
            $request->tipo_cadastro == 'Variante' and
            $request->tipo_pessoa == 'F'
        ) {
            $request->merge(['message' => ['Reavaliar em 2 meses']]);
        }

        if ($request->estado == 'Ceará' and
            $request->tipo_cadastro == 'Variante' and
            $request->tipo_pessoa == 'F' and
            $request->filled('observacao')) {
            $request->merge(['message' => ['Possível violação do tratado Beta']]);
        }

        if ($request->estado == 'Tocantins' and
            $request->tipo_cadastro == 'Variante' and
            $request->tipo_pessoa == 'F' and
            $request->filled('observacao')) {
            $request->merge(['message' => ['Possível violação do tratado Celta']]);
        }

        if ($request->estado == 'Amazonas' and
            $request->tipo_cadastro == 'Variante' and
            $request->tipo_pessoa == 'F' and
            $request->filled('observacao')
        ) {
            $request->merge(['message' => ['Possível violação do tratado Alpha']]);
        }


        if ($validacao->fails()) {
            return response()->json($validacao->errors());
        }

        $empresa = Empresa::create($request->all());

        return EmpresaResource::collection([$empresa]);
    }

    public function edit(Request $request)
    {
        $empresa = Empresa::query();
        if ($request->query->get('id')) {
            $empresa->where('id', $request->query->get('id'));
        } else {
            $empresa->where('cpf_cnpj', $request->query->get('cpf_cnpj'));
        }

        return response()->json($empresa->get());
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  Empresa  $empresa
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Empresa $empresa)
    {
        $validacao = Validator::make($request->all(), [
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
        ]);

        if ($request->isNotFilled('numero')) {
            $request->merge(['numero' => 'SN']);
        }

        if ($request->tipo_pessoa === 'F' and $request->inscricao_estadual) {
            $request->request->remove('inscricao_estadual');
        }

        if ($request->estado == 'Goiás' and $request->tipo_cadastro == 'Variante') {
            $request->merge([
                'message' => [
                    'Mandar equipe de campo'
                ]
            ]);
        }

        if ($request->estado == 'São Paulo' and
            $request->tipo_cadastro == 'Variante' and
            $request->tipo_pessoa == 'F'
        ) {
            $request->merge(['message' => ['Reavaliar em 2 meses']]);
        }

        if ($request->estado == 'Ceará' and
            $request->tipo_cadastro == 'Variante' and
            $request->tipo_pessoa == 'F' and
            $request->filled('observacao')) {
            $request->merge(['message' => ['Possível violação do tratado Beta']]);
        }

        if ($request->estado == 'Tocantins' and
            $request->tipo_cadastro == 'Variante' and
            $request->tipo_pessoa == 'F' and
            $request->filled('observacao')) {
            $request->merge(['message' => ['Possível violação do tratado Celta']]);
        }

        if ($request->estado == 'Amazonas' and
            $request->tipo_cadastro == 'Variante' and
            $request->tipo_pessoa == 'F' and
            $request->filled('observacao')
        ) {
            $request->merge(['message' => ['Possível violação do tratado Alpha']]);
        }

        if ($request->has('cpf_cnpj')) {
            $request->request->remove('cpf_cnpj');
        }

        if ($validacao->fails()) {
            return response()->json($validacao->errors());
        }

        $empresa->update($request->all());

        return EmpresaResource::collection([$empresa]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $empresa = Empresa::query();
        if ($request->query->get('id')) {
            $empresa->where('id', $request->query->get('id'));
        } else {
            $empresa->where('cpf_cnpj', $request->query->get('cpf_cnpj'));
        }

        $empresa->delete();

        return response()->json('', 200);
    }

    public function verifyCnpj(Request $request)
    {
        $cnpj = str_replace(['.', '-', '/'], '', $request->query('cnpj'));

        $client = new Client();
        $url = 'https://www.receitaws.com.br/v1/';

        try {
            $response = $client->request('get', $url."cnpj/{$cnpj}", [
                'verify' => false
            ]);
        } catch (\Exception $error) {
            return response()->json(['message' => 'Erro na api receitaws'], 500);
        }

        $body = json_decode($response->getBody());

        return response()->json($body);
    }
}
