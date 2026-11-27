<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration {
 public function up():void {Schema::table('entries',function(Blueprint $t){$t->timestamp('link_checked_at')->nullable();$t->string('link_status',32)->nullable();$t->timestamp('verified_at')->nullable();});}
 public function down():void {Schema::table('entries',fn(Blueprint $t)=>$t->dropColumn(['link_checked_at','link_status','verified_at']));}
};
