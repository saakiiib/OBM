@extends('layout')
@section('title','Online Bangla Media | Bengali News, Jobs, Scholarships & Directory')
@section('body')
<section class="portal-hero"><p lang="bn">বিশ্বজুড়ে বাঙালির তথ্যসঙ্গী</p><h1>Connecting Bengalis worldwide</h1><p>Discover news sources, education, government services, careers and community opportunities in one place.</p><form action="/opportunities/directory" method="get" class="portal-search"><input name="q" aria-label="Search directory" placeholder="Search organisations in English or বাংলা"><button>Search directory</button></form></section>
@include('ad-slot',['slot'=>'home_top'])
<h2>Explore the directory</h2><div class="portal-grid">
@foreach($categories as $c)
<a class="portal-tile" href="/categories/{{ $c->slug }}"><strong>{{ $c->name }}</strong><span lang="bn">{{ $c->name_bn }}</span><span>Explore resources →</span></a>
@endforeach
</div><p><a href="/categories">View all categories →</a> · <a href="/emergency.html">Emergency information</a> · <a href="/categories/bangladesh-abroad">Probashi resources</a></p>
<div class="portal-grid opportunities-grid">
@foreach($groups as $type=>$items)
<section class="portal-tile"><h2>{{ config('obm.types')[$type] }}</h2>
@forelse($items as $item)
<p><a href="/entry/{{ $item->slug }}">{{ $item->title }}</a></p>
@empty
<p>No published updates yet.</p>
@endforelse
<a href="/opportunities/{{ $type }}">Explore {{ strtolower(config('obm.types')[$type]) }} →</a>
@if($type==='scholarship')
<p><a href="/scholarship-sources">Official funding providers</a></p>
@endif
</section>
@endforeach
</div>
@if($featured->isNotEmpty())
<h2>Editorially reviewed resources</h2><div class="portal-grid">
@foreach($featured as $e)
<a class="portal-tile" href="/entry/{{ $e->slug }}"><strong>{{ $e->title }}</strong><span>{{ $e->category }}</span></a>
@endforeach
</div>
@endif
@include('promotion')
@include('ad-slot',['slot'=>'home_bottom'])
<section class="portal-callout"><h2>Help improve OBM</h2><p>Suggest a new resource, community event or correction.</p><a class="action" href="/submit">Submit a listing</a></section>
@endsection
