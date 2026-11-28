<!doctype html>
<html lang="en"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1"><meta name="robots" content="noindex,nofollow"><title>@yield('title','OBM Administration')</title><link rel="icon" href="/favicon.ico"><link rel="stylesheet" href="/admin-v44.css"></head><body>
<div class="workspace"><aside class="sidebar"><a class="identity" href="/admin"><img src="/assets/logo-header.webp" alt="OBM" width="42" height="42"><span>OBM <small>Administration</small></span></a><nav aria-label="Administration"><span class="navlabel">WORKSPACE</span><a href="/admin" @if(request()->is('admin')) aria-current="page" @endif>Overview</a><span class="navlabel">CONTENT</span>
@foreach(config('obm.types') as $key=>$label)
<a href="/admin/content/{{ $key }}" @if(request()->is('admin/content/'.$key)) aria-current="page" @endif>{{ $label }}</a>
@endforeach
<a href="/admin/content/all">All entries</a><span class="navlabel">WEBSITE</span><a href="/admin/categories">Categories</a><a href="/admin/menus">Navigation menus</a><span class="navlabel">OPERATIONS</span><a href="/admin/submissions">Submissions</a><a href="/admin/sources">Import sources</a><a href="/admin/imports">Import history</a><a href="/admin/activity">Activity log</a></nav></aside><div class="workspace-body"><header class="top"><a href="/" target="_blank" rel="noopener">View website ↗</a><span>{{ auth()->user()->name ?? 'Administrator' }}</span><form method="post" action="/admin/logout">@csrf
<button class="secondary">Sign out</button></form></header><main>
@if(session('success'))
<p class="notice" role="status">{{ session('success') }}</p>
@endif
@if($errors->any())
<div class="errors" role="alert">
@foreach($errors->all() as $error)
<p>{{ $error }}</p>
@endforeach
</div>
@endif
@yield('body')</main><footer>Online Bangla Media · Administration V4.4</footer></div></div></body></html>
