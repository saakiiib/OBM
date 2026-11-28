@php
$enabledSlugs = \App\Models\Category::where('enabled', true)->pluck('slug')->all();
$menus = \App\Models\MenuItem::where('enabled', true)->orderBy('sort_order')->orderBy('id')->get()->filter(fn($m) => !str_starts_with($m->destination, '/categories/') || in_array(substr($m->destination, 12), $enabledSlugs, true))->values();
$primary = $menus->take(7);
$remaining = $menus->slice(7);
@endphp
<details class="obm47-menu"><summary>☰ Menu</summary><div class="obm47-mobile-links">
@foreach($menus as $menu)
<a href="{{ $menu->destination }}" @if(request()->getPathInfo() === $menu->destination) aria-current="page" @endif>{{ $menu->label }}</a>
@endforeach
</div></details>
<nav class="obm47-nav" aria-label="Main navigation">
@foreach($primary as $menu)
<a href="{{ $menu->destination }}" @if(request()->getPathInfo() === $menu->destination) aria-current="page" @endif>{{ $menu->label }}</a>
@endforeach
@if($remaining->isNotEmpty())
<details class="obm47-more"><summary>More <span aria-hidden="true">⌄</span></summary><div class="obm47-dropdown">
@foreach($remaining as $menu)
<a href="{{ $menu->destination }}" @if(request()->getPathInfo() === $menu->destination) aria-current="page" @endif>{{ $menu->label }}</a>
@endforeach
</div></details>
@endif
<a class="obm47-search-link" href="/opportunities/directory" aria-label="Search directory"><svg width="19" height="19" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" aria-hidden="true"><circle cx="10" cy="10" r="6"/><path d="m15 15 6 6"/></svg></a>
</nav>
