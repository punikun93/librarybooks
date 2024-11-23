<!-- resources/views/components/layout/sidebar-profile.blade.php -->
@props(['name', 'email', 'image'])

<div class="sticky inset-x-0 bottom-0 border-t border-gray-100">
    <div class="flex items-center gap-2 bg-white p-4">
        <img alt="Profile" src="{{ $image }}" class="h-10 w-10 rounded-full object-cover" />
        <div>
            <p class="text-xs">
                <strong class="block font-medium">{{ $name }}</strong>
                <span>{{ $email }}</span>
            </p>
        </div>
    </div>
</div>