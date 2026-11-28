@extends('admin.layout')
@section('robots','noindex,nofollow')
@section('body')
<h1>Edit entry</h1><p class="small">Saving as published makes the entry public if it has not expired. Marking reviewed records editorial verification only; it does not change publication status.</p><a href="/admin/content/{{ $entry->type }}">Back to admin</a><form class="panel editor" method="post" action="/admin/entries/{{ $entry->id }}">@include('entryform')</form>
@if($entry->type==='directory')<article><p>Link check: {{ $entry->link_status??'Not checked' }} · {{ $entry->link_checked_at??'' }}</p><p>Editorial review: {{ $entry->verified_at??'Not reviewed' }}</p><form class="panel editor" method="post" action="/admin/entries/{{ $entry->id }}/verify">@csrf<button>Mark reviewed after checking official source</button></form></article>@endif
<section class="panel"><h2>Quick publication action</h2><p>Only publish after checking the original source. Directory editorial verification is a separate action.</p><form method="post" action="/admin/entries/{{ $entry->id }}/status" class="editor">@csrf
<label>Publication status<select name="status"><option value="pending" @selected($entry->status==='pending')>Pending / unpublish</option><option value="published" @selected($entry->status==='published')>Approve and publish</option><option value="rejected" @selected($entry->status==='rejected')>Reject / unpublish</option></select></label><button>Apply publication status</button></form></section>
@endsection
