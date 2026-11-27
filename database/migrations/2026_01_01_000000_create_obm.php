<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration {
 public function up(): void {
 Schema::create('users',function(Blueprint $t){$t->id();$t->string('name');$t->string('email')->unique();$t->string('password');$t->boolean('is_admin')->default(false);$t->rememberToken();$t->timestamps();});
 Schema::create('sources',function(Blueprint $t){$t->id();$t->string('name');$t->string('driver');$t->string('type');$t->string('url',2048);$t->string('country')->nullable();$t->boolean('enabled')->default(false);$t->unsignedInteger('interval_minutes')->default(360);$t->timestamp('last_attempt')->nullable();$t->timestamp('last_success')->nullable();$t->timestamps();});
 Schema::create('entries',function(Blueprint $t){$t->id();$t->foreignId('source_id')->nullable()->constrained()->nullOnDelete();$t->string('fingerprint',64)->unique();$t->string('type')->index();$t->string('slug')->unique();$t->string('title');$t->string('title_bn')->nullable();$t->text('summary')->nullable();$t->string('country')->nullable();$t->string('category')->nullable();$t->string('city')->nullable();$t->string('url',2048);$t->string('status')->default('pending')->index();$t->timestamp('deadline')->nullable();$t->timestamp('event_start')->nullable();$t->timestamp('expires_at')->nullable();$t->timestamp('last_seen')->nullable();$t->json('details')->nullable();$t->timestamps();$t->index(['type','status','country']);});
 Schema::create('submissions',function(Blueprint $t){$t->id();$t->string('reference')->unique();$t->string('name');$t->string('email');$t->string('type');$t->string('listing');$t->string('category')->nullable();$t->string('region')->nullable();$t->string('website',2048)->nullable();$t->text('message');$t->string('status')->default('pending');$t->timestamp('consented_at');$t->timestamp('emailed_at')->nullable();$t->timestamps();});
 Schema::create('import_runs',function(Blueprint $t){$t->id();$t->foreignId('source_id')->constrained()->cascadeOnDelete();$t->string('status');$t->unsignedInteger('count')->default(0);$t->string('error')->nullable();$t->timestamps();});
 }
 public function down(): void {foreach(['import_runs','submissions','entries','sources','users'] as $table) Schema::dropIfExists($table);}
};
