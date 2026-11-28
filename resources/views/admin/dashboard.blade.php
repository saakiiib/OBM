@extends('admin.layout')
@section('body')
<div class="heading"><div><p class="eyebrow">MANAGEMENT OVERVIEW</p><h1>Dashboard</h1><p>Manage content, navigation and automated sources from one workspace.</p></div><a class="button" href="/admin/content/all">Manage content</a></div><div class="metrics">
@foreach($counts as $label=>$count)
<section class="metric"><span>{{ $label }}</span><strong>{{ number_format($count) }}</strong></section>
@endforeach
</div><h2>Content modules</h2><div class="modules">
@foreach(config('obm.types') as $key=>$label)
<a class="panel module" href="/admin/content/{{ $key }}"><strong>{{ $label }}</strong><span>{{ $types[$key]??0 }} records · Manage →</span></a>
@endforeach
</div><h2>Recent imports</h2><div class="panel tablewrap"><table><thead><tr><th>Source</th><th>Status</th><th>Processed</th><th>Date</th></tr></thead><tbody>
@forelse($runs as $run)
<tr><td>{{ $run->source_id }}</td><td>{{ $run->status }}</td><td>{{ $run->count }}</td><td>{{ $run->created_at }}</td></tr>
@empty
<tr><td colspan="4">No imports recorded yet.</td></tr>
@endforelse
</tbody></table></div><p><a href="/admin/imports">Full import history →</a></p>
@endsection
