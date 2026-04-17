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
        Schema::table('pangkats', function (Blueprint $table) {
            $table->enum('jenis_asn', ['PNS', 'PPPK', 'Keduanya'])->default('PNS')->after('golongan');
        });

        // Seed data untuk golongan PPPK
        $golongans = ['V', 'VI', 'VII', 'VIII', 'IX', 'X', 'XI', 'XII', 'XIII'];
        $data = [];
        foreach ($golongans as $g) {
            $data[] = [
                'nama' => 'Golongan ' . $g,
                'golongan' => $g,
                'jenis_asn' => 'PPPK',
                'aktif' => 'Y',
                'created_at' => now(),
                'updated_at' => now()
            ];
        }
        \Illuminate\Support\Facades\DB::table('pangkats')->insert($data);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        \Illuminate\Support\Facades\DB::table('pangkats')->where('jenis_asn', 'PPPK')->delete();
        Schema::table('pangkats', function (Blueprint $table) {
            $table->dropColumn('jenis_asn');
        });
    }
};
