@extends('layout')
@section('title','Admin sign in | OBM')
@section('robots','noindex,nofollow')
@section('body')
<h1>Administrator sign in</h1><form method="post" action="/admin/login">@csrf<label>Email<input type="email" name="email" required autocomplete="username"></label><label>Password<input type="password" name="password" required autocomplete="current-password"></label><button>Sign in</button></form>
@endsection
