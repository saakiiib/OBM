<?php
namespace App\Models;
class Entry extends \Illuminate\Database\Eloquent\Model { protected $casts = ["details"=>"array","deadline"=>"datetime","event_start"=>"datetime","expires_at"=>"datetime"]; protected $guarded = ["id"]; }
