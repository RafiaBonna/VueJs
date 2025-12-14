<?php

// database/migrations/XXXX_XX_XX_XXXXXX_add_depo_id_to_users_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Depo বা Distributor ID-এর জন্য কলাম
            // nullable: কারণ Admin ইউজারের এই আইডি না-ও থাকতে পারে
            $table->foreignId('depo_id')
                  ->nullable()
                  ->after('email') 
                  ->constrained('depos') // 'depos' টেবিলকে রেফার করবে
                  ->onDelete('set null'); // ডিপো ডিলিট হলে ইউজারদের depo_id null হয়ে যাবে
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Drop করার সময় প্রথমে foreign key constraints সরাতে হবে
            $table->dropForeign(['depo_id']);
            $table->dropColumn('depo_id');
        });
    }
};