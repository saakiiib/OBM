@extends('layout')
@section('title','International scholarship providers | Online Bangla Media')
@section('body')
<h1>International scholarship providers</h1><p>Explore official funding programmes. These are provider links, not confirmed open applications. Check deadlines, eligibility and funding directly.</p><p><a href="/opportunities/scholarship">Browse reviewed scholarship opportunities →</a></p>
@foreach($sources as $source)<article><h2>{{ $source->title }}</h2>@if($source->title_bn)<p lang="bn">{{ $source->title_bn }}</p>@endif<a href="{{ $source->url }}" rel="noopener noreferrer" target="_blank">Visit official programme →</a></article>@endforeach
@endsection
