<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateClientesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('clientes', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('nome', 150);
            $table->string('cpf_cnpj', 24);
            $table->string('endereco', 100)->nullable();
            $table->string('num', 8)->nullable();
            $table->string('bairro', 50)->nullable();
            $table->string('cep', 10)->nullable();
            $table->string('cidade', 80)->nullable();
            $table->string('estado', 20)->nullable();
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
        Schema::dropIfExists('clientes');
    }
}
