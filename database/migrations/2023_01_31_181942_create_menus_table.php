<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class() extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('menus', function (Blueprint $table) {
            $table->id();
            $table->string('identifier')->unique();
            $table->integer('type_enum')->nullable(); // App\Enums\MenuEnum
            $table->string('url')->nullable();
            $table->string('icon')->nullable();
            $table->string('class')->nullable();
            $table->string('label')->nullable();
            $table->json('can')->nullable();
            $table->json('custom_menu_rule')->nullable();
            $table->string('route')->nullable();
            $table->json('active_if_route_in')->nullable();
            $table->unsignedBigInteger('parent_id')->nullable();
            $table->integer('relative_position')->nullable()->default(0);
            $table->boolean('active')->nullable()->default(true);
            $table->unsignedBigInteger('show_only_to')->nullable(); // User
            $table->timestamps();

            $table->foreign('parent_id')->references('id')
                ->on('menus')->onDelete('cascade'); //cascade|set null

            $table->foreign('show_only_to')->references('id')
                ->on('users')->onDelete('cascade'); //cascade|set null

            $table->index('type_enum');
            $table->index('parent_id');
            $table->index('relative_position');
            $table->index('active');
            $table->index('show_only_to');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('menus');
    }
};
