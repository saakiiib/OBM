<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\{Schema,DB};
use Illuminate\Support\Str;
return new class extends Migration {
 public function up(): void {
  Schema::create('categories',function(Blueprint $t){$t->id();$t->string('name',100)->unique();$t->string('slug',120)->unique();$t->string('name_bn',150)->nullable();$t->text('description')->nullable();$t->unsignedInteger('sort_order')->default(100);$t->boolean('enabled')->default(true);$t->boolean('featured')->default(false);$t->timestamps();});
  Schema::create('menu_items',function(Blueprint $t){$t->id();$t->string('label',100);$t->string('label_bn',150)->nullable();$t->string('destination',200);$t->unsignedInteger('sort_order')->default(100);$t->boolean('enabled')->default(true);$t->timestamps();});
  $defaults=['News & Media'=>'সংবাদ ও গণমাধ্যম','Government'=>'সরকারি সেবা','Education'=>'শিক্ষা','Health'=>'স্বাস্থ্য','Business'=>'ব্যবসা','Travel'=>'ভ্রমণ','Jobs'=>'চাকরি','Resources'=>'তথ্যসূত্র','Scholarship providers'=>'বৃত্তি প্রদানকারী প্রতিষ্ঠান','Bangladesh Abroad'=>'প্রবাসী বাংলাদেশ','Community resources'=>'কমিউনিটি','More'=>'আরও','General'=>'সাধারণ'];
  DB::table('entries')->where('type','directory')->where(fn($q)=>$q->whereNull('category')->orWhere('category',''))->update(['category'=>'General']);
  $names=array_unique(array_merge(array_keys($defaults),DB::table('entries')->where('type','directory')->whereNotNull('category')->distinct()->pluck('category')->all()));
  foreach($names as $i=>$name){if(!trim($name))continue;$slug=Str::slug($name)?:'category';if(DB::table('categories')->where('slug',$slug)->exists())$slug.='-'.substr(sha1($name),0,8);DB::table('categories')->insert(['name'=>$name,'slug'=>$slug,'name_bn'=>$defaults[$name]??null,'sort_order'=>($i+1)*10,'enabled'=>true,'featured'=>$i<6,'created_at'=>now(),'updated_at'=>now()]);}
  $i=0;foreach(['Home'=>'/','News & Media'=>'/categories/news-media','Education'=>'/categories/education','Health'=>'/categories/health','Government'=>'/categories/government','Jobs'=>'/opportunities/job','Scholarships'=>'/opportunities/scholarship','Events'=>'/opportunities/event','Directory'=>'/opportunities/directory','Probashi'=>'/categories/bangladesh-abroad','All categories'=>'/categories','বাংলা'=>'/bangla.html'] as $label=>$destination){DB::table('menu_items')->insert(['label'=>$label,'destination'=>$destination,'sort_order'=>++$i*10,'enabled'=>true,'created_at'=>now(),'updated_at'=>now()]);}
  DB::table('entries')->where('title','Sample Software Engineer Job')->where('type','job')->update(['status'=>'rejected']);
 }
 public function down():void {Schema::dropIfExists('menu_items');Schema::dropIfExists('categories');}
};
