<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('identitas_legals', function (Blueprint $table) {
            if (!Schema::hasColumn('identitas_legals', 'pegawai_id')) {
                $table->char('pegawai_id', 18)->index();
            }
            if (!Schema::hasColumn('identitas_legals', 'nama_pegawai')) {
                $table->string('nama_pegawai', 255)->nullable();
            }
            if (!Schema::hasColumn('identitas_legals', 'no_ktp')) {
                $table->string('no_ktp', 50)->nullable();
            }
            if (!Schema::hasColumn('identitas_legals', 'no_npwp')) {
                $table->string('no_npwp', 50)->nullable();
            }
            if (!Schema::hasColumn('identitas_legals', 'no_bpjs')) {
                $table->string('no_bpjs', 50)->nullable();
            }
            if (!Schema::hasColumn('identitas_legals', 'dok_ktp')) {
                $table->string('dok_ktp', 255)->nullable();
            }
            if (!Schema::hasColumn('identitas_legals', 'dok_npwp')) {
                $table->string('dok_npwp', 255)->nullable();
            }
            if (!Schema::hasColumn('identitas_legals', 'dok_bpjs')) {
                $table->string('dok_bpjs', 255)->nullable();
            }
            if (!Schema::hasColumn('identitas_legals', 'dok_kk')) {
                $table->string('dok_kk', 255)->nullable();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('identitas_legals', function (Blueprint $table) {
            $dropColumns = [];
            foreach (['pegawai_id', 'nama_pegawai', 'no_ktp', 'no_npwp', 'no_bpjs', 'dok_ktp', 'dok_npwp', 'dok_bpjs', 'dok_kk'] as $column) {
                if (Schema::hasColumn('identitas_legals', $column)) {
                    $dropColumns[] = $column;
                }
            }

            if (!empty($dropColumns)) {
                $table->dropColumn($dropColumns);
            }
        });
    }
};
