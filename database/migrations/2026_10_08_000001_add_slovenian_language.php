<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        if (DB::table('languages')->where('code', 'sl')->exists()) {
            return;
        }

        DB::table('languages')->insert([
            'code'        => 'sl',
            'native_name' => 'Slovenščina',
            'flag_ext'    => 'png',
            'is_visible'  => true,
            'sort_order'  => (int) DB::table('languages')->max('sort_order') + 1,
            'created_at'  => now(),
            'updated_at'  => now(),
        ]);
    }

    public function down(): void
    {
        DB::table('languages')->where('code', 'sl')->delete();
    }
};
