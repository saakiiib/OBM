@extends('admin.layout')
@section('body')
<div class="heading"><div><p class="eyebrow">CONTENT MANAGEMENT</p><h1>{{ config('obm.types')[$type]??'All entries' }}</h1><p>Review original sources before publishing. Pending and rejected entries are hidden.</p></div><a class="button" href="#new">Add entry</a></div><form class="panel filters" method="get"><label>Search<input name="q" value="{{ request('q') }}" placeholder="English or Bengali title"></label><label>Status<select name="status"><option value="">All statuses</option>
@foreach(['pending','published','rejected'] as $state)
<option @selected(request('status')===$state)>{{ $state }}</option>
@endforeach
</select></label><label>Category<select name="category"><option value="">All categories</option>
@foreach($categories as $c)
<option value="{{ $c->name }}" @selected(request('category')===$c->name)>{{ $c->name }}</option>
@endforeach
</select></label><button>Filter</button></form><div class="panel tablewrap"><table><thead><tr><th>Entry</th><th>Status</th><th>Review / Link</th><th>Actions</th></tr></thead><tbody>
@forelse($entries as $entry)
<tr><td><strong>{{ $entry->title }}</strong><small>{{ $entry->type }} · {{ $entry->category }}</small></td><td><span class="state {{ $entry->status }}">{{ $entry->status }}</span></td><td>{{ $entry->verified_at?'Reviewed':'Not reviewed' }}<small>{{ $entry->link_status??'Unchecked' }}</small></td><td><a href="/admin/entries/{{ $entry->id }}">Edit / review</a>
@if($entry->status==='published')
<small><a href="/entry/{{ $entry->slug }}" target="_blank" rel="noopener">Public page ↗</a></small>
@endif
</td></tr>
@empty
<tr><td colspan="4">No matching entries.</td></tr>
@endforelse
</tbody></table></div>{{ $entries->links('admin.pagination') }}<section class="panel" id="new"><h2>Add entry</h2><form method="post" action="/admin/entries" class="editor">@include('entryform',['defaultType'=>$type==='all'?'directory':$type])</form></section>
@endsection
