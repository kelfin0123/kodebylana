<?php
// database/migrations/xxxx_xx_xx_xxxxxx_create_contact_messages_table.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('contact_messages', function (Blueprint $t) {
            $t->id();
            $t->string('name');
            $t->string('email');
            $t->string('subject')->nullable();
            $t->text('message');
            $t->boolean('consent')->default(false);
            $t->boolean('is_read')->default(false)->index();
            $t->timestamp('replied_at')->nullable()->index();
            $t->json('meta')->nullable(); // ip, user_agent, referrer
            $t->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists('contact_messages'); }
};
