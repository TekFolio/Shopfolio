<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Shopfolio\Traits\Database;

class CreateProductsTable extends Migration
{
    use Database\Migration;

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->getTableName('products'), function (Blueprint $table) {
            $this->addCommonFields($table, true);

            $table->string('name');
            $table->string('slug')->unique()->nullable();
            $table->string('sku')->unique()->nullable();
            $table->string('barcode')->unique()->nullable();
            $table->longText('description')->nullable();
            $table->integer('security_stock')->default(0);
            $table->boolean('featured')->default(false);
            $table->boolean('is_visible')->default(false);
            $table->integer('old_price_amount')->nullable();
            $table->integer('price_amount')->nullable();
            $table->integer('cost_amount')->nullable();
            $table->enum('type', ['deliverable', 'downloadable'])->nullable();
            $table->boolean('backorder')->default(false);
            $table->boolean('requires_shipping')->default(false);
            $table->dateTimeTz('published_at')->default(now())->nullable();

            $this->addSeoFields($table);
            $this->addShippingFields($table);

            $this->addForeignKey($table, 'parent_id', $this->getTableName('products'));
            $this->addForeignKey($table, 'brand_id', $this->getTableName('brands'));
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists($this->getTableName('products'));
    }
}
