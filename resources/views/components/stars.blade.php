@props(['rating' => 0, 'count' => null])

@php $rating = (float) $rating; @endphp

<div {{ $attributes->merge(['class' => 'inline-flex items-center gap-1']) }}>
    <div class="flex">
        @for($i = 1; $i <= 5; $i++)
            <svg class="h-4 w-4 {{ $i <= round($rating) ? 'text-amber-400' : 'text-gray-300' }}" fill="currentColor" viewBox="0 0 20 20">
                <path d="M9.05 2.93c.3-.92 1.6-.92 1.9 0l1.35 4.15a1 1 0 0 0 .95.69h4.36c.97 0 1.37 1.24.59 1.81l-3.53 2.56a1 1 0 0 0-.36 1.12l1.35 4.15c.3.92-.76 1.69-1.54 1.12l-3.53-2.56a1 1 0 0 0-1.18 0l-3.53 2.56c-.78.57-1.84-.2-1.54-1.12l1.35-4.15a1 1 0 0 0-.36-1.12L1.2 9.58c-.78-.57-.38-1.81.59-1.81h4.36a1 1 0 0 0 .95-.69l1.35-4.15Z"/>
            </svg>
        @endfor
    </div>
    @if($count !== null)
        <span class="text-xs text-gray-500">{{ $rating > 0 ? number_format($rating, 1) : '—' }} ({{ $count }})</span>
    @endif
</div>
