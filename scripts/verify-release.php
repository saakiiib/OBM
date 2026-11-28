<?php
// Run only on a staging instance with a separate database and APP_ENV=staging/local.
require __DIR__.'/../vendor/autoload.php';
$app=require __DIR__.'/../bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();
if(!app()->environment(['local','staging'])){fwrite(STDERR,"Use staging/local only.\n");exit(2);}
$errors=0;
foreach(new RecursiveIteratorIterator(new RecursiveDirectoryIterator(resource_path('views'))) as $file){
 if(!$file->isFile()||!str_ends_with($file->getFilename(),'.blade.php'))continue;
 try{ $compiled=app('blade.compiler')->compileString(file_get_contents($file->getPathname()));$tmp=tempnam(sys_get_temp_dir(),'obm-blade-');file_put_contents($tmp,$compiled);exec(escapeshellarg(PHP_BINARY).' -l '.escapeshellarg($tmp).' 2>&1',$out,$code);unlink($tmp);if($code!==0){echo "FAIL Blade {$file->getPathname()}: ".implode("\n",$out)."\n";$errors++;}else echo "OK Blade {$file->getFilename()}\n";$out=[]; }catch(Throwable $e){echo "FAIL Blade {$file->getFilename()}: {$e->getMessage()}\n";$errors++;}
}
$kernel=$app->make(Illuminate\Contracts\Http\Kernel::class);
$base=rtrim(config('app.url'),'/');
$checks=['/'=>200,'/categories'=>200,'/categories/government'=>200,'/government.html'=>301,'/opportunities/directory'=>200,'/opportunities/job'=>200,'/opportunities/scholarship'=>200,'/opportunities/event'=>200,'/opportunities/news'=>200,'/submit'=>200,'/sitemap.xml'=>200,'/robots.txt'=>200,'/admin/login'=>200,'/admin'=>302,'/categories/nonexistent-obm-check'=>404];
$entry=App\Http\Controllers\PortalController::active()->where('type','directory')->first();if($entry)$checks['/entry/'.$entry->slug]=200;
foreach($checks as $path=>$expected){try{$req=Illuminate\Http\Request::create($base.$path,'GET');$res=$kernel->handle($req);$actual=$res->getStatusCode();$kernel->terminate($req,$res);echo ($actual===$expected?'OK':'FAIL')." HTTP $path $actual (expected $expected)\n";if($actual!==$expected)$errors++;}catch(Throwable $e){echo "FAIL HTTP $path: {$e->getMessage()}\n";$errors++;}}
exit($errors?1:0);
