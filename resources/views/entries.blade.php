@extends('layout')
@section('title',config('obm.types')[$type].' | Online Bangla Media')
@section('robots',request()->getQueryString()||$entries->isEmpty()?'noindex,follow':'index,follow')
@section('body')
<h1>{{ config('obm.types')[$type] }}</h1><p>Explore reviewed resources and opportunities. Always confirm details with the original provider.</p><form class="filters" method="get"><input name="q" aria-label="Search" placeholder="Search English or Bangla" value="{{ request('q') }}"><select name="country" aria-label="Country"><option value="">All countries</option>@foreach($countries as $c)<option @selected(request('country')===$c)>{{ $c }}</option>@endforeach</select><button>Search</button></form>
@forelse($entries as $e)<article><h2><a href="/entry/{{ $e->slug }}">{{ $e->title }}</a></h2>@if($e->title_bn)<p lang="bn">{{ $e->title_bn }}</p>@endif<p>{{ $e->country }} {{ $e->city }} · {{ $e->category }}</p><p>{{ \Illuminate\Support\Str::limit($e->summary,220) }}</p>@if($e->deadline)<p>Deadline: {{ $e->deadline->format('d M Y') }}</p>@endif<a href="/entry/{{ $e->slug }}">View details →</a></article>@empty<p>No approved entries available yet. <a href="/submit">Suggest an opportunity</a>.</p>@endforelse
{{ $entries->links() }}
@if($type==='directory')@include('promotion')@include('ad-slot',['slot'=>'directory_bottom'])@endif
@if($type==='scholarship')<p><a href="/scholarship-sources">Official scholarship providers</a></p>@endif
@endsection
