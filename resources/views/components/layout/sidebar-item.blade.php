<!-- resources/views/components/sidebar-item.blade.php -->
@props(['route', 'label'])

<li>
    <a href="{{ $route }}" class="block rounded-lg px-4 py-2 text-sm font-medium text-gray-500 hover:bg-gray-100 hover:text-gray-700">
        {{ $label }}
    </a>
</li>
