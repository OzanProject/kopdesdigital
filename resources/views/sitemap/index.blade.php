{!! $xmlHeader !!}
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
    @foreach($pages as $page)
    <url>
        <loc>{{ $page['url'] }}</loc>
        <lastmod>{{ $lastMod }}</lastmod>
        <changefreq>{{ $page['changefreq'] }}</changefreq>
        <priority>{{ $page['priority'] }}</priority>
    </url>
    @endforeach
</urlset>
