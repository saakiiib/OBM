@php($enabledSlugs=\App\Models\Category::where('enabled',true)->pluck('slug')->all())
<nav class="portal-nav" aria-label="Main navigation"><div class="container portal-nav-inner">
@foreach(\App\Models\MenuItem::where('enabled',true)->orderBy('sort_order')->orderBy('id')->get() as $menu)
@if(!str_starts_with($menu->destination,'/categories/') || in_array(substr($menu->destination,12),$enabledSlugs,true))
<a href="{{ $menu->destination }}">{{ $menu->label }} @if($menu->label_bn)<span lang="bn">{{ $menu->label_bn }}</span> @endif</a>
@endif
@endforeach
</div></nav>
