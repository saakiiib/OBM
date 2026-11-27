@extends('layout')
@section('robots','noindex,nofollow')
@section('body')
<h1>Edit entry</h1><a href="/admin">Back to admin</a><form method="post" action="/admin/entries/{{ $entry->id }}">@include('entryform')</form>
@if($entry->type==='directory')<article><p>Link check: {{ $entry->link_status??'Not checked' }} · {{ $entry->link_checked_at??'' }}</p><p>Editorial review: {{ $entry->verified_at??'Not reviewed' }}</p><form method="post" action="/admin/entries/{{ $entry->id }}/verify">@csrf<button>Mark reviewed after checking official source</button></form></article>@endif
@endsection
