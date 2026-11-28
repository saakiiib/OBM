<?php namespace App\Services;
use Illuminate\Support\Facades\DB;
class AdminActivity {public static function record(string $action, string $type,int $id,array $changes=[]):void {DB::table('admin_activity')->insert(['user_id'=>auth()->id(),'action'=>$action,'subject_type'=>$type,'subject_id'=>$id,'changes'=>json_encode($changes,JSON_THROW_ON_ERROR),'created_at'=>now(),'updated_at'=>now()]);}}
