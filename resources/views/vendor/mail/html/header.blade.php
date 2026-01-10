@props(['url'])
@php
    $logo = \App\Models\SaasSetting::where('key', 'app_logo')->value('value');
    if ($logo) {
        $logoUrl = asset('storage/' . $logo);
    } else {
        $logoUrl = null;
    }
@endphp

<tr>
<td class="header">
<a href="{{ $url }}" style="display: inline-block;">
@if ($logoUrl)
    <img src="{{ $logoUrl }}" class="logo" alt="{{ config('app.name') }}" style="max-height: 75px; width: auto; border: 0;">
@else
    {{ config('app.name') }}
@endif
</a>
</td>
</tr>
