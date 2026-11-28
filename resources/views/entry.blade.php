@extends('layout')
@section('title', $entry->title . ' | Online Bangla Media')
@section('description', \Illuminate\Support\Str::limit((string) $entry->summary, 150))
@section('robots', $entry->type === 'directory' && !$entry->verified_at ? 'noindex,follow' : 'index,follow')
@push('structured')
<script type="application/ld+json">{!! json_encode(['@context'=>'https://schema.org','@type'=>'BreadcrumbList','itemListElement'=>[['@type'=>'ListItem','position'=>1,'name'=>'Home','item'=>url('/')],['@type'=>'ListItem','position'=>2,'name'=>config('obm.types')[$entry->type],'item'=>url('/opportunities/'.$entry->type)],['@type'=>'ListItem','position'=>3,'name'=>$entry->title,'item'=>url('/entry/'.$entry->slug)]]],JSON_HEX_TAG|JSON_HEX_AMP|JSON_HEX_APOS|JSON_HEX_QUOT|JSON_UNESCAPED_SLASHES) !!}</script>
@endpush
@section('body')
<p class="small"><a href="/opportunities/{{ $entry->type }}">{{ config('obm.types')[$entry->type] }}</a> / {{ $entry->title }}</p>
<article class="obm-entry-detail">
<h1>{{ $entry->title }}</h1>
@if($entry->title_bn)
<h2 lang="bn">{{ $entry->title_bn }}</h2>
@endif
<p>{{ $entry->country }} {{ $entry->city }} · {{ $entry->category }}</p>
<p style="white-space:pre-wrap">{{ $entry->summary }}</p>
@if($entry->deadline)
<p>Deadline: {{ $entry->deadline->format('d M Y H:i T') }}</p>
@endif
@if($entry->event_start)
<p>Event: {{ $entry->event_start->format('d M Y H:i T') }}</p>
@endif
@if($entry->type === 'directory')
@if($entry->verified_at)
@foreach(['subcategory'=>'Category','address'=>'Address','phone'=>'Telephone','contact_email'=>'Email'] as $field=>$label)
@if(!empty($entry->details[$field]))
<p><strong>{{ $label }}:</strong> {{ $entry->details[$field] }}</p>
@endif
@endforeach
@endif
<p class="small">Editorial review: {{ $entry->verified_at ?? 'Pending' }}. Link availability: {{ $entry->link_status ?? 'Not checked' }}.</p>
@endif
<p>Confirm eligibility, dates and information directly with the provider. OBM is not the organiser or employer.</p>
@if(filter_var($entry->url, FILTER_VALIDATE_URL) && in_array(parse_url($entry->url, PHP_URL_SCHEME), ['http','https'], true))
<a class="action" href="{{ $entry->url }}" rel="noopener noreferrer nofollow" target="_blank">Original source / apply ↗</a>
@endif
<p><a href="/submit?listing={{ urlencode($entry->title) }}">Report incorrect information</a></p>
</article>
@endsection
