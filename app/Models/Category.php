<?php namespace App\Models;
class Category extends \Illuminate\Database\Eloquent\Model {protected $guarded=['id'];protected $casts=['enabled'=>'boolean','featured'=>'boolean'];}
