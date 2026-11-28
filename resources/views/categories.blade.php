@extends('layout')
@section('title','Browse Bengali resource categories | Online Bangla Media')
@section('body')
<h1>Explore all categories</h1><p>Find useful organisations and official resources for Bengali communities worldwide.</p><div class="portal-grid">
@foreach($categories as $c)
<a class="portal-tile" href="/categories/{{ $c->slug }}"><strong>{{ $c->name }}</strong><span lang="bn">{{ $c->name_bn }}</span><p>{{ $c->description }}</p><span>{{ $counts[$c->name]??0 }} published resources →</span></a>
@endforeach
</div>
@endsection
