@extends('layout')
@section('title','Online Bangla Media | Bangla News, Jobs, Scholarships & Bangladesh Directory')
@section('description','Discover Bangla newspapers, universities, government services, job and scholarship resources and Bengali communities worldwide.')
@section('robots',request()->getQueryString()?'noindex,follow':'index,follow')
@section('body')
<div class="obm45-home">
<section class="obm45-hero">
 <div class="obm45-hero-art" aria-hidden="true"><svg viewBox="0 0 900 300" preserveAspectRatio="xMidYMax slice"><circle cx="725" cy="98" r="65" fill="#e83b4c" opacity=".85"/><path d="M0 230 Q180 130 330 235 T670 212 T900 178 V300 H0Z" fill="#80b99b" opacity=".24"/><path d="M0 265 Q180 195 360 255 T720 240 T900 225 V300 H0Z" fill="#b7d8b4" opacity=".24"/><path d="M680 280 L752 104 L824 280 M704 280 L752 154 L800 280 M728 280 L752 204 L776 280" fill="none" stroke="#e0eee6" stroke-width="7" opacity=".4"/></svg></div>
 <div class="obm45-hero-copy"><span class="obm45-eyebrow" lang="bn">বিশ্বজুড়ে বাঙালির তথ্যসঙ্গী</span><h1>Everything Bangla &amp; Bangladesh<br> in one place</h1><p>News, education, careers, scholarships, public services and Bengali communities worldwide.</p>
 <form action="/opportunities/directory" method="get" class="obm45-search"><label class="obm45-sr" for="home-query">Search the directory</label><input id="home-query" name="q" placeholder="Search newspapers, universities, services… / বাংলায় খুঁজুন"><button>Search</button></form>
 <div class="obm45-popular"><span>Popular:</span>
 @foreach(['news-media'=>'Newspapers','education'=>'Universities','government'=>'Government services','jobs'=>'Job resources','scholarship-providers'=>'Scholarships','bangladesh-abroad'=>'Probashi'] as $slug=>$label)
 @if($availableCategories->has($slug))
 <a href="/categories/{{ $slug }}">{{ $label }}</a>
 @endif
 @endforeach
 </div></div>
</section>
@include('ad-slot',['slot'=>'home_top'])
@php($icons=['news-media'=>'📰','government'=>'🏛️','education'=>'🎓','health'=>'✚','business'=>'▥','travel'=>'✈','jobs'=>'💼','scholarship-providers'=>'📚','bangladesh-abroad'=>'🌐','community-resources'=>'🤝','resources'=>'🔎'])
<section class="obm45-section"><div class="obm45-heading"><h2>Explore the directory</h2><a href="/categories">All categories →</a></div><div class="obm45-categories">
@foreach($categories as $c)
<a class="obm45-category" href="/categories/{{ $c->slug }}"><span class="obm45-icon" aria-hidden="true">{{ $icons[$c->slug]??'◆' }}</span><strong>{{ $c->name }}</strong><small lang="bn">{{ $c->name_bn }}</small></a>
@endforeach
</div></section>
<section class="obm45-section obm46-intro"><div class="obm45-heading"><h2>Trusted resources for Bengali communities at home and abroad</h2></div><p>Find Bangla newspapers, television, universities, hospitals, public services, jobs, scholarships and community resources across Bangladesh, India and the world. Visit the original providers directly for current information.</p></section>
<div class="obm45-editorial" id="media-sources">
@if($availableCategories->has('news-media'))
<section class="obm45-section"><div class="obm45-heading"><h2>Bangladesh &amp; international news sources</h2><a href="/categories/news-media">View all →</a></div>
<nav class="obm46-tabs" aria-label="Media groups">
@foreach($mediaTabs as $key=>$label)
<a href="/?media={{ $key }}#media-sources" @if($selectedMedia===$key) aria-current="true" @endif>{{ $label }}</a>
@endforeach
</nav><div class="obm45-papers obm46-news-grid">
@forelse($papers as $e)
@include('home-resource',['e'=>$e,'style'=>'paper'])
@empty
<p class="obm45-sub">No publishers in this group yet. <a href="/submit">Suggest a media source →</a></p>
@endforelse
</div></section>
@endif
<section class="obm45-section obm45-side"><div class="obm45-heading"><h2>Popular newspapers</h2></div><div class="obm46-popular-papers">
@foreach($popularPapers as $e)
@include('home-resource',['e'=>$e,'style'=>'paper'])
@endforeach
</div><a href="/categories/news-media">More newspapers →</a></section>
</div>
<section class="obm45-section"><div class="obm45-heading"><h2>Opportunities &amp; updates</h2></div><div class="obm45-panels">
@foreach($groups as $type=>$items)
<section class="obm45-panel obm45-panel-{{ $type }}"><div class="obm45-panel-head"><h3>{{ config('obm.types')[$type] }}</h3><a href="/opportunities/{{ $type }}">View all →</a></div><div class="obm45-panel-body">
@forelse($items as $e)
<a class="obm45-list-link" href="/entry/{{ $e->slug }}">{{ $e->title }}</a>
@empty
<p class="obm45-sub">{{ ['job'=>'Explore recruitment websites','scholarship'=>'Explore official funding providers','event'=>'Explore community resources','news'=>'Browse original publishers'][$type] }}</p>
@foreach($fallbacks[$type]??[] as $e)
@include('home-resource',['e'=>$e,'style'=>'list'])
@endforeach
@if($type==='news' && $availableCategories->has('news-media'))
<a class="obm45-list-link" href="/categories/news-media">Newspapers and media directory →</a>
@endif
@if($type==='event')
<a class="obm45-list-link" href="/submit">Suggest a community event →</a>
@endif
@endforelse
</div></section>
@endforeach
</div></section>
<section class="obm45-section"><div class="obm45-heading"><h2>Overseas jobs &amp; career resources</h2><a href="/opportunities/job">Live jobs →</a></div><div class="obm45-papers">
@foreach($overseasJobs->take(4) as $e)
@include('home-resource',['e'=>$e,'style'=>'paper'])
@endforeach
</div></section>
<section class="obm45-section"><div class="obm45-heading"><h2>Explore popular categories</h2><a href="/categories">View all →</a></div><div class="obm45-categories obm46-more-categories">
@foreach($availableCategories as $c)
<a class="obm45-category" href="/categories/{{ $c->slug }}"><span class="obm45-icon" aria-hidden="true">{{ $icons[$c->slug]??'◆' }}</span><strong>{{ $c->name }}</strong><small lang="bn">{{ $c->name_bn }}</small></a>
@endforeach
</div></section>
<div class="obm45-features">
@foreach([['news-media','Featured TV & Radio',$broadcast],['education','Featured universities',$universities],['government','Useful government links',$government]] as [$slug,$heading,$items])
@if($availableCategories->has($slug) && $items->isNotEmpty())
<section class="obm45-section"><div class="obm45-heading"><h2>{{ $heading }}</h2><a href="/categories/{{ $slug }}">View all →</a></div><div class="obm45-feature-list">
@foreach($items as $e)
@include('home-resource',['e'=>$e,'style'=>'list'])
@endforeach
</div></section>
@endif
@endforeach
</div>
<section class="obm46-shortcuts obm45-section">
<a href="/opportunities/directory"><strong>Bangladesh Directory</strong><span>Find organisations and official websites</span><b>Find a listing →</b></a>
<a href="/emergency.html"><strong>Emergency &amp; Helplines</strong><span>Important national support resources</span><b>Open helplines →</b></a>
@if($availableCategories->has('bangladesh-abroad'))
<a href="/categories/bangladesh-abroad"><strong>Bangladesh Abroad</strong><span>Embassies and resources worldwide</span><b>Explore resources →</b></a>
@endif
</section>
<section class="obm45-section"><div class="obm45-heading"><h2>Find useful organisations</h2><a href="/opportunities/directory">Full directory →</a></div><div class="obm45-papers">
@foreach(($featured->isNotEmpty()?$featured:$directoryPreview) as $e)
@include('home-resource',['e'=>$e,'style'=>'paper'])
@endforeach
</div></section>
<section class="obm46-emergency"><div><small>IMPORTANT INFORMATION</small><h2>Emergency &amp; national helplines</h2><p>Find emergency contacts and public support resources in Bangladesh.</p></div><a href="/emergency.html">View all helplines →</a></section>
<section class="obm45-section"><div class="obm45-heading"><h2>Popular services &amp; everyday resources</h2><a href="/categories">Browse everything →</a></div><div class="obm46-services">
@foreach(['government'=>['🛂','Passport, NID & civil records'],'health'=>['🏥','Hospitals & diagnostics'],'education'=>['🎓','Universities & admission'],'jobs'=>['💼','Jobs in Bangladesh'],'scholarship-providers'=>['📚','Study abroad & scholarships'],'business'=>['🏦','Banks & finance'],'travel'=>['🚆','Travel & transport'],'community-resources'=>['🤝','Community resources']] as $slug=>$service)
@if($availableCategories->has($slug))
<a href="/categories/{{ $slug }}"><span aria-hidden="true">{{ $service[0] }}</span><strong>{{ $service[1] }}</strong></a>
@endif
@endforeach
</div></section>
@if($availableCategories->has('bangladesh-abroad'))
<section class="obm45-abroad"><div><span lang="bn">প্রবাসী বাংলাদেশ</span><h2>Bangladesh Abroad</h2><p>Embassies, consular services and useful resources for Bengali communities worldwide.</p><div class="obm46-abroad-links">
@foreach($abroadResources as $e)
<a href="/entry/{{ $e->slug }}">{{ $e->title }}</a>
@endforeach
</div></div><a href="/categories/bangladesh-abroad">Explore Probashi resources →</a></section>
@endif
<section class="obm46-campaign"><div><h2>A Greener, Smarter, Stronger Bangladesh.</h2><p>People · Progress · Possibilities</p></div><a href="/categories">Explore more →</a></section>
@include('promotion')
@include('ad-slot',['slot'=>'home_bottom'])
<section class="obm45-contribute"><div><h2>Help improve OBM</h2><p>Suggest a useful resource, report an outdated link or share a community event.</p></div><a class="action" href="/submit">Submit a listing →</a></section>
</div>
@endsection
