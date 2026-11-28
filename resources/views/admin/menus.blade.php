@extends('admin.layout')
@section('body')
<h1>Navigation menus</h1><p>Manage the main public navigation. Lower sort numbers appear first. Only supported internal destinations can be selected.</p><section class="panel"><h2>Add menu item</h2><form class="editor" method="post" action="/admin/menus">@include('admin.menu-form',['item'=>null])</form></section>
@foreach($items as $item)
<details class="panel"><summary>{{ $item->sort_order }} · {{ $item->label }} · {{ $item->enabled?'Enabled':'Disabled' }}</summary><form class="editor" method="post" action="/admin/menus/{{ $item->id }}">@include('admin.menu-form')</form><form method="post" action="/admin/menus/{{ $item->id }}">@csrf
@method('DELETE')
<button class="danger">Remove menu item</button></form></details>
@endforeach
@endsection
