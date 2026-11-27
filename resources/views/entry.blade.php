@extends('layout')
@section('title',$entry->title.' | Online Bangla Media')
@section('description',\Illuminate\Support\Str::limit($entry->summary,150))
@section('robots',$entry->type==='directory'&&!$entry->verified_at?'noindex,follow':'index,follow')
@section('body')
<p><a href="/opportunities/{{ $entry->type }}">{{ config('obm.types')[$entry->type] }}</a> / {{ $entry->title }}</p><h1>{{ $entry->title }}</h1>@if($entry->title_bn)<h2 lang="bn">{{ $entry->title_bn }}</h2>@endif<p>{{ $entry->country }} {{ $entry->city }} · {{ $entry->category }}</p><p style="white-space:pre-wrap">{{ $entry->summary }}</p>@if($entry->deadline)<p>Deadline: {{ $entry->deadline->format('d M Y H:i T') }}</p>@endif @if($entry->event_start)<p>Event: {{ $entry->event_start->format('d M Y H:i T') }}</p>@endif@if($entry->type==='directory')<p>Editorial review: {{ $entry->verified_at??'Pending' }}. Link availability: {{ $entry->link_status??'Not checked' }}.</p>@endif<p>Confirm eligibility, dates and information directly with the provider. OBM is not the organiser or employer.</p><a class="action" href="{{ $entry->url }}" rel="noopener noreferrer nofollow">Original source / apply</a><p><a href="/submit?listing={{ urlencode($entry->title) }}">Report incorrect information</a></p>
@endsection
