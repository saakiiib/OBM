@extends('admin.layout')
@section('body')
<h1>Activity log</h1><p>Records entry edits, publication decisions, editorial verification navigation changes, source configuration and submission review decisions made in V4.4.</p><div class="panel tablewrap"><table><thead><tr><th>When</th><th>Administrator</th><th>Action</th><th>Record</th><th>Changes</th></tr></thead><tbody>
@forelse($activity as $row)
<tr><td>{{ $row->created_at }}</td><td>{{ $row->administrator??'Unknown' }}</td><td>{{ $row->action }}</td><td>{{ $row->subject_type }} #{{ $row->subject_id }}</td><td>{{ $row->changes }}</td></tr>
@empty
<tr><td colspan="5">No recorded changes yet.</td></tr>
@endforelse
</tbody></table></div>{{ $activity->links('admin.pagination') }}
@endsection
