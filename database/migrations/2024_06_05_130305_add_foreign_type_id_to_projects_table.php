<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('projects', function (Blueprint $table) {
            // 1. Aggiungo la colonna 
            $table->unsignedBigInteger('type_id')->nullable()->after('id');
            // 2. Definisco il vincolo di relazione tra le colonne delle tabelle
            $table->foreign('type_id')->references('id')->on('types')->onDelete('set null');


            // In alternativa si può scrivere 
            // $table->foreignId('type_id')->constrained();



        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('projects', function (Blueprint $table) {
            // 2. rimuovere il vincolo di relazione
            $table->dropForeign('posts_type_id_foreign');
            // 2. In alternativa 
            // $table->dropForeign('[type_id]');


            // 1. rimuovere la colonna type_id
            $table->dropColumn('type_id');
        });
    }
};
