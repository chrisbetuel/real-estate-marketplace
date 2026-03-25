<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::delete("DELETE FROM migrations WHERE migration = '2026_03_19_081119_add_is_available_to_products_table'");
    }

    public function down(): void
    {
        //
    }
};
?>

