<?php namespace App\Models;
class User extends \Illuminate\Foundation\Auth\User { protected $guarded=['id']; protected $hidden=['password','remember_token']; }
