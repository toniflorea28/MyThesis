@props(['url'])
<tr>
<td class="header">
<a href="{{ $url }}" style="display: inline-block;">
@if (trim($slot) === 'Laravel')
<img src="../../../../js/src/assets/logo/logo.png" class="logo" alt="Workbook Logo">
@else
{{ $slot }}
@endif
</a>
</td>
</tr>
