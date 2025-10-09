<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('contact_messages', function (Blueprint $table) {
            if (! Schema::hasColumn('contact_messages', 'ip')) {
                $table->string('ip', 45)->nullable()->after('consent');       // IPv4/IPv6
            }
            if (! Schema::hasColumn('contact_messages', 'user_agent')) {
                $table->text('user_agent')->nullable()->after('ip');
            }
        });
    }

    public function down(): void
    {
        Schema::table('contact_messages', function (Blueprint $table) {
            if (Schema::hasColumn('contact_messages', 'user_agent')) {
                $table->dropColumn('user_agent');
            }
            if (Schema::hasColumn('contact_messages', 'ip')) {
                $table->dropColumn('ip');
            }
        });
    }
};
