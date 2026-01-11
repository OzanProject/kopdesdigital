{!! $xmlHeader !!}
<urlset 
    xmlns="http://www.sitemaps.org/schemas/sitemap/0.9"
    xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
    xsi:schemaLocation="http://www.sitemaps.org/schemas/sitemap/0.9 http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd">
    
    @foreach($pages as $page)
    <url>
        <loc>{{ url($page['url']) }}</loc>
        <lastmod>{{ isset($page['lastmod']) ? $page['lastmod'] : $lastMod }}</lastmod>
        <changefreq>{{ $page['changefreq'] ?? 'monthly' }}</changefreq>
        <priority>{{ $page['priority'] ?? '0.5' }}</priority>
    </url>
    @endforeach
</urlset>