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
        // 1. Add jenis_jabatan column
        Schema::table('jabatans', function (Blueprint $table) {
            $table->enum('jenis_jabatan', ['struktural', 'fungsional'])
                  ->after('id')
                  ->default('struktural');
        });

        // 2. Rename 'nama' to 'nama_jabatan'
        Schema::table('jabatans', function (Blueprint $tatble) {
            $table->renameColumn('nama', 'nama_jabatan');
        });

        // 3. Update eselon column: change enum values from II/a format to II.a format
        // MySQL requires raw SQL to alter ENUM values
        DB::statement("ALTER TABLE jabatans MODIFY COLUMN eselon ENUM('II.a','II.b','III.a','III.b','IV.a','IV.b') NULL");

        // 4. Convert old eselon values to new format
        DB::table('jabatans')->where('eselon', 'II/a')->update(['eselon' => 'II.a']);
        DB::table('jabatans')->where('eselon', 'II/b')->update(['eselon' => 'II.b']);
        DB::table('jabatans')->where('eselon', 'III/a')->update(['eselon' => 'III.a']);
        DB::table('jabatans')->where('eselon', 'III/b')->update(['eselon' => 'III.b']);
        DB::table('jabatans')->where('eselon', 'IV/a')->update(['eselon' => 'IV.a']);
        DB::table('jabatans')->where('eselon', 'IV/b')->update(['eselon' => 'IV.b']);

        // 5. Set jenis_jabatan = 'fungsional' for rows that had Fungsional/Non-Eselon/null
        DB::table('jabatans')->whereNull('eselon')->update(['jenis_jabatan' => 'fungsional']);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Revert eselon format
        DB::statement("ALTER TABLE jabatans MODIFY COLUMN eselon ENUM('II/a','II/b','III/a','III/b','IV/a','IV/b','Fungsional','Non-Eselon') NULL");

        DB::table('jabatans')->where('eselon', 'II.a')->update(['eselon' => 'II/a']);
        DB::table('jabatans')->where('eselon', 'II.b')->update(['eselon' => 'II/b']);
        DB::table('jabatans')->where('eselon', 'III.a')->update(['eselon' => 'III/a']);
        DB::table('jabatans')->where('eselon', 'III.b')->update(['eselon' => 'III/b']);
        DB::table('jabatans')->where('eselon', 'IV.a')->update(['eselon' => 'IV/a']);
        DB::table('jabatans')->where('eselon', 'IV.b')->update(['eselon' => 'IV/b']);

        Schema::table('jabatans', function (Blueprint $table) {
            $table->renameColumn('nama_jabatan', 'nama');
        });

        Schema::table('jabatans', function (Blueprint $table) {
            $table->dropColumn('jenis_jabatan');
        });
    }
};
