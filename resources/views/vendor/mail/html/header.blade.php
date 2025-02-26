@props(['url'])
<tr>
<td class="header">
<a href="{{ $url }}" style="display: inline-block;">
@if (trim($slot) === 'Bodypoint')
<img src="{{ asset('img/bp-logo-lg-new.png') }}" class="logo" alt="BodyPoint Logo">
@else
{{ $slot }}
@endif
</a>
</td>
</tr>
