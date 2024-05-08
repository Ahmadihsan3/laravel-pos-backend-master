<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddParentAndQuantityToUnitsTable extends Migration
{
    public function up(): void
    {
        Schema::table('units', function (Blueprint $table) {
            // Tambahkan kolom parent_id hanya jika belum ada
            if (!Schema::hasColumn('units', 'parent_id')) {
                $table->unsignedBigInteger('parent_id')->nullable();
                $table->foreign('parent_id')->references('id')->on('units')->onDelete('set null');
            }
            // Tambahkan kolom quantity hanya jika belum ada
            if (!Schema::hasColumn('units', 'quantity')) {
                $table->integer('quantity')->default(0);
            }
        });
    }

    public function down(): void
    {
        Schema::table('units', function (Blueprint $table) {
            // Hapus kolom parent_id hanya jika ada
            if (Schema::hasColumn('units', 'parent_id')) {
                $table->dropForeign(['parent_id']);
                $table->dropColumn('parent_id');
            }
            // Hapus kolom quantity hanya jika ada
            if (Schema::hasColumn('units', 'quantity')) {
                $table->dropColumn('quantity');
            }
        });
    }
}
