<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        $next = (int) DB::table('languages')->max('sort_order');

        foreach ([
            ['code' => 'sk', 'native_name' => 'Slovenčina'],
            ['code' => 'mt', 'native_name' => 'Malti'],
        ] as $lang) {
            if (DB::table('languages')->where('code', $lang['code'])->exists()) {
                continue;
            }

            DB::table('languages')->insert([
                'code'        => $lang['code'],
                'native_name' => $lang['native_name'],
                'flag_ext'    => 'png',
                'is_visible'  => true,
                'sort_order'  => ++$next,
                'created_at'  => now(),
                'updated_at'  => now(),
            ]);
        }
    }

    public function down(): void
    {
        DB::table('languages')->whereIn('code', ['sk', 'mt'])->delete();
    }
};
