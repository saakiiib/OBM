@extends('admin.layout')
@section('body')
<h1>Categories</h1><p>Manage public directory categories. Disabling a category hides its directory entries; it does not delete data. Existing slugs stay permanent.</p><section class="panel"><h2>Add category</h2><form class="editor" method="post" action="/admin/categories">@include('admin.category-form',['category'=>null])</form></section>
@foreach($categories as $category)
<details class="panel"><summary><strong>{{ $category->name }}</strong> · {{ $counts[$category->name]??0 }} entries · {{ $category->enabled?'Enabled':'Disabled' }}</summary><form class="editor" method="post" action="/admin/categories/{{ $category->id }}">@include('admin.category-form',['category'=>$category])</form></details>
@endforeach
@endsection
