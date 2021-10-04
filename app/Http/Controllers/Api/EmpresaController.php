<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\EmpresaRequest;
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
     * Lista ou filtra todos as empresas
     *
     * @param  Request  $request
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index(Request $request)
    {
        $empresas = Empresa::search($request);
        return EmpresaResource::collection($empresas);
    }

    /**
     * Cria uma nova empresa
     *
     * @param  EmpresaRequest  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(EmpresaRequest $request)
    {
        $validacao = Validator::make($request->all(), $request->rules());

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
     * Atualiza uma empresa especifica
     * @param EmpresaRequest $request
     * @param  Empresa  $empresa
     * @return \Illuminate\Http\Response
     */
    public function update(EmpresaRequest $request, Empresa $empresa)
    {
        $validacao = Validator::make($request->all(), $request->rules());

        if ($validacao->fails()) {
            return response()->json($validacao->errors());
        }

        $empresa->update($request->request->all());

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
