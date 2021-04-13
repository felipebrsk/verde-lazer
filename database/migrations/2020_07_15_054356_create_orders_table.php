<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('order_number')->unique();
            $table->float('sub_total');
            $table->float('coupon')->nullable();
            $table->float('total_amount');
            $table->integer('quantity');
            $table->enum('payment_method', ['cod', 'paypal'])->default('cod');
            $table->enum('payment_status', ['Pago', 'Nao pago'])->default('Nao pago');
            $table->enum('status', ['Em aberto', 'Em processamento', 'Coletado pela transportadora', 'À caminho', 'Em rota de entrega', 'Locado', 'Cancelado'])->default('Em aberto');
            $table->string('first_name');
            $table->string('last_name');
            $table->string('email');
            $table->string('phone');
            $table->string('country');
            $table->string('post_code')->nullable();
            $table->text('address1');
            $table->text('address2')->nullable();
            $table->date('location_date')->nullable();

            $table->unsignedBigInteger('user_id')->nullable();
            $table->unsignedBigInteger('shipping_id')->nullable();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('SET NULL');
            $table->foreign('shipping_id')->references('id')->on('shippings')->onDelete('SET NULL');

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
        Schema::dropIfExists('orders');
    }
}
