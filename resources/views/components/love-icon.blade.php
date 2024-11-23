@props(['filled' => false, 'size' => 'w-6 h-6', 'color' => 'text-pink-600'])

<svg xmlns="http://www.w3.org/2000/svg" 
    class="{{ $size }} {{ $color }}" 
    viewBox="0 0 24 24" 
    fill="{{ $filled ? 'currentColor' : 'none' }}" 
    stroke="currentColor" 
    stroke-width="2" 
    stroke-linecap="round" 
    stroke-linejoin="round">
    <path d="M12 21C12 21 7 17.24 4 12.72 1.85 9.42 3 5.5 7.17 5.5 9.57 5.5 11.08 7.08 12 8.06 12.92 7.08 14.43 5.5 16.83 5.5 21 5.5 22.15 9.42 20 12.72 17 17.24 12 21 12 21z" />
</svg>
