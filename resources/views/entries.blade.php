@extends('layout')
@section('title',($category?->name??config('obm.types')[$type]).' | Online Bangla Media')
@section('description',$category?->description??'Find resources and opportunities from Online Bangla Media. Confirm details with the original provider.')
@section('robots',request()->getQueryString()||$entries->isEmpty()?'noindex,follow':'index,follow')
@section('body')
<p class="small"><a href="/">Home</a> / <a href="/categories">Categories</a></p><h1>{{ $category?->name??config('obm.types')[$type] }}</h1>
@if($category?->name_bn)
<p lang="bn">{{ $category->name_bn }}</p>
@endif
<p>{{ $category?->description??'Explore published resources and opportunities. Always confirm information with the original provider.' }}</p><form class="filters" method="get"><input name="q" aria-label="Search" placeholder="Search English or Bangla" value="{{ request('q') }}"><select name="country" aria-label="Country"><option value="">All countries</option>
@foreach($countries as $c)
<option @selected(request('country')===$c)>{{ $c }}</option>
@endforeach
</select>
@if($type==='directory' && !$category)
<select name="category" aria-label="Category"><option value="">All categories</option>
@foreach($directoryCategories as $c)
<option value="{{ $c->slug }}" @selected(request('category')===$c->slug)>{{ $c->name }}</option>
@endforeach
</select>
@endif
<button>Search</button></form><div class="portal-grid listing-grid">
@forelse($entries as $e)
<article class="portal-tile"><h2><a href="/entry/{{ $e->slug }}">{{ $e->title }}</a></h2>
@if($e->title_bn)
<p lang="bn">{{ $e->title_bn }}</p>
@endif
<p class="small">{{ $e->country }} {{ $e->city }} · {{ $e->category }}</p><p>{{ \Illuminate\Support\Str::limit((string)$e->summary,220) }}</p>
@if($e->deadline)
<p>Deadline: {{ $e->deadline->format('d M Y') }}</p>
@endif
@if($e->type==='directory')
<p class="small">{{ $e->verified_at?'Editorially reviewed':'Editorial review pending' }}</p>
@endif
<a href="/entry/{{ $e->slug }}">View details →</a>
@if(filter_var($e->url,FILTER_VALIDATE_URL) && in_array(parse_url($e->url,PHP_URL_SCHEME),['http','https'],true))
<a href="{{ $e->url }}" target="_blank" rel="noopener noreferrer nofollow">Original website ↗</a>
@endif
</article>
@empty
<p>No published entries available yet. <a href="/submit">Suggest a resource</a>.</p>
@endforelse
</div>{{ $entries->links('admin.pagination') }}
@if($type==='directory' && !$category)
@include('promotion')
@include('ad-slot',['slot'=>'directory_bottom'])
@endif
@if($category)
@include('ad-slot',['slot'=>'category_bottom'])
@endif
@if($type==='scholarship')
<p><a href="/scholarship-sources">Official scholarship providers</a></p>
@endif
@endsection
