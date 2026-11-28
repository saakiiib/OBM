@extends('admin.layout')
@section('body')
<h2 id="sources">Import sources</h2><details class="panel"><summary>Add source</summary><form method="post" action="/admin/sources">@include('sourceform',['source'=>null])</form></details>@foreach($sources as $source)<details class="panel"><summary>{{ $source->name }} — {{ $source->enabled?'Enabled':'Disabled' }} — {{ $source->last_success??'Never imported' }}</summary><form method="post" action="/admin/sources/{{ $source->id }}">@include('sourceform',['source'=>$source])</form></details>@endforeach{{ $sources->links('admin.pagination') }}
@endsection
