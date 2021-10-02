<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableEmpresa extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('empresa', function (Blueprint $table) {
            $table->id();
            $table->string('razao_social', 150);
            $table->string('nome_fantasia', 150)->nullable();
            $table->string('tipo_pessoa', 1)->default('J');
            $table->string('tipo_contribuinte', 50);
            $table->string('tipo_cadastro', 50);

            $table->string('cpf_cnpj', 18);
            $table->string('inscricao_estadual')->nullable();
            $table->string('inscricao_municipal')->nullable();


            $table->string('pais', 100);
            $table->string('estado', 100);
            $table->string('cidade', 100);
            $table->string('cep', 10);
            $table->string('logradouro', 150);
            $table->string('numero', 50);
            $table->string('complemento')->nullable();
            $table->string('bairro', 150);

            $table->string('fone_principal', 15)->nullable();
            $table->string('fone_secundario', 15)->nullable();
            $table->string('email', 100)->nullable();

            $table->string('observacao')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('empresa');
    }

}
