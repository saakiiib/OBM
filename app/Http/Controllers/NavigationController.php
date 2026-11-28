<?php namespace App\Http\Controllers;
use App\Models\{Category,MenuItem,Entry};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use App\Services\AdminActivity;
class NavigationController {
 public static function destinations(): array {
  $d=['/'=>'Home','/categories'=>'All categories','/submit'=>'Submit listing','/bangla.html'=>'বাংলা','/privacy.html'=>'Privacy','/emergency.html'=>'Emergency','/scholarship-sources'=>'Scholarship providers'];
  foreach(config('obm.types') as $k=>$v)$d['/opportunities/'.$k]=$v;
  foreach(Category::orderBy('sort_order')->get() as $c)$d['/categories/'.$c->slug]='Category: '.$c->name.($c->enabled?'':' (disabled)');
  return $d;
 }
 public function categories(){return view('admin.categories',['categories'=>Category::orderBy('sort_order')->orderBy('name')->get(),'counts'=>Entry::where('type','directory')->selectRaw('category, count(*) as total')->groupBy('category')->pluck('total','category')]);}
 public function category(Request $r,?Category $category=null){$v=$r->validate(['name'=>['required','string','max:100',Rule::unique('categories','name')->ignore($category?->id)],'slug'=>['required','regex:/^[a-z0-9]+(?:-[a-z0-9]+)*$/','max:120',Rule::unique('categories','slug')->ignore($category?->id)],'name_bn'=>'nullable|string|max:150','description'=>'nullable|string|max:2000','sort_order'=>'required|integer|min:0|max:10000']);$v['enabled']=$r->boolean('enabled');$v['featured']=$r->boolean('featured');
  DB::transaction(function()use($category,$v){if($category){$old=$category->name;$slug=$category->slug; // preserve public URLs once created
  $v['slug']=$slug; $category->update($v);if($old!==$v['name'])Entry::where('type','directory')->where('category',$old)->update(['category'=>$v['name']]);}else $category=Category::create($v);AdminActivity::record('save','category',$category->id,['enabled'=>$category->enabled]);});return back()->with('success','Category saved. Existing directory assignments preserved.');}
 public function menus(){return view('admin.menus',['items'=>MenuItem::orderBy('sort_order')->orderBy('id')->get(),'destinations'=>self::destinations()]);}
 public function menu(Request $r,?MenuItem $menu=null){$v=$r->validate(['label'=>'required|string|max:100','label_bn'=>'nullable|string|max:150','destination'=>['required',Rule::in(array_keys(self::destinations()))],'sort_order'=>'required|integer|min:0|max:10000']);$v['enabled']=$r->boolean('enabled');DB::transaction(function()use($menu,$v){if($menu)$menu->update($v);else $menu=MenuItem::create($v);AdminActivity::record('save','menu',$menu->id,['enabled'=>$menu->enabled]);});return back()->with('success','Menu saved.');}
 public function remove(MenuItem $menu){DB::transaction(function()use($menu){AdminActivity::record('remove','menu',$menu->id);$menu->delete();});return back()->with('success','Menu item removed.');}
}
