@php($external=filter_var($e->url,FILTER_VALIDATE_URL) && in_array(parse_url($e->url,PHP_URL_SCHEME),['http','https'],true))
<div class="obm45-resource obm45-resource-{{ $style }}">
<a class="obm45-resource-title" href="/entry/{{ $e->slug }}">
@if($style==='paper' && $e->title_bn)
<strong lang="bn">{{ $e->title_bn }}</strong><small>{{ $e->title }}</small>
@else
<strong>{{ $e->title }}</strong>
@endif
</a>
@if($external)
<a class="obm45-visit" href="{{ $e->url }}" target="_blank" rel="noopener noreferrer nofollow" aria-label="Visit {{ $e->title }} website">Website ↗</a>
@endif
</div>
