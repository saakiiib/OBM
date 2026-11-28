@extends('admin.layout')
@section('body')
<h2 id="runs">Recent imports</h2>@foreach($runs as $run)<article class="panel">Source {{ $run->source_id }} · {{ $run->status }} · {{ $run->count }} processed · {{ $run->created_at }}<p>{{ $run->error }}</p></article>@endforeach
{{ $runs->links('admin.pagination') }}
@endsection
