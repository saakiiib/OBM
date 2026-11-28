<section class="obm-promo container" aria-label="Products from Mento Software"><p class="obm-ad-label">House advertisement · Our products</p><h2>Tools for everyday life and business</h2><div class="obm-promo-grid">@foreach(config('advertising.products') as $product)
@if(filter_var($product['url'],FILTER_VALIDATE_URL) && parse_url($product['url'],PHP_URL_SCHEME)==='https')<article class="obm-promo-card">
@if(!empty($product['logo']) && is_file(public_path($product['logo'])))
<img class="obm-product-logo" src="{{ asset($product['logo']) }}" alt="{{ $product['name'] }} logo" width="64" height="64" loading="lazy">
@else
<span class="obm-promo-icon" aria-hidden="true">{{ $product['initials'] }}</span>
@endif
<div><small>{{ $product['label'] }}</small><h3>{{ $product['name'] }}</h3><p>{{ $product['description'] }}</p><a href="{{ $product['url'] }}" target="_blank" rel="noopener noreferrer sponsored">Explore {{ $product['name'] }} →</a></div></article>@endif @endforeach</div></section>
