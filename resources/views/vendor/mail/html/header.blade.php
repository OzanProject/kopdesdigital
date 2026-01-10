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
    <img src="{{ $logoUrl }}" class="logo" alt="{{ config('app.name') }} Logo" style="max-height: 75px; width: auto;">
@elseif (trim($slot) === 'Laravel')
    {{ config('app.name') }}
@else
    {!! $slot !!}
@endif
</a>
</td>
</tr>
