<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('route')->unique();
            $table->timestamps();
        });

        DB::table('categories')->insert([
            ['name' => 'Textiles écologiques', 'route' => 'textiles-ecologiques'],
            ['name' => 'Petites fournitures éco-responsables', 'route' => 'petites-fournitures-eco-responsables'],
            ['name' => 'Produits d\'entretien naturels', 'route' => 'produits-entretien-naturels'],
            ['name' => 'Cosmétiques bio', 'route' => 'cosmetiques-bio'],
            ['name' => 'Produits animaliers écologiques', 'route' => 'produits-animaliers-ecologiques'],
            ['name' => 'Produits ménagers naturels', 'route' => 'produits-menagers-naturels'],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('categories');
    }
};
