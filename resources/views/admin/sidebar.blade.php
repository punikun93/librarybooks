<div class="flex h-screen flex-col justify-between border-e bg-white">
    <div class="px-4 py-6">
        <span
            class="items-center space-x-2 h-10 w-32 place-content-center rounded-lg bg-gray-100 text-xs text-gray-600 flex">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                stroke="currentColor" class="w-6 h-6 text-amber-600">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M12 21v-8.25M15.75 21v-8.25M8.25 21v-8.25M3 9l9-6 9 6m-1.5 12V10.332A48.36 48.36 0 0012 9.75c-2.551 0-5.056.2-7.5.582V21M3 21h18M12 6.75h.008v.008H12V6.75z" />
            </svg>
            <h2 class="font-bold text-md">Library</h2>
        </span>

        <ul class="mt-6 space-y-1">
            @php
                $label = Auth::user()->Role == 'administrator' ? 'Activity Log' : 'Dashboard';
            @endphp

            <x-layout.sidebar-item route="{{ route('admin.dashboard') }}" label="{{ $label }}" />

            @if (Auth::user()->Role == 'administrator')
                <x-layout.sidebar-group label="Users" :items="[
                    ['route' => route('users.confirmed'), 'label' => 'Confirm Users'],
                    ['route' => route('users.data'), 'label' => 'Data Users'],
                ]" />
            @endif

            <x-layout.sidebar-group label="Books" :items="[
                ['route' => route('books.category'), 'label' => 'Category Books'],
                ['route' => route('books.data'), 'label' => 'Data Books'],
            ]" />

            @if (Auth::user()->Role == 'petugas')
                <x-layout.sidebar-group label="Borrowing" :items="[
                    ['route' => route('borrow.confirmed'), 'label' => 'Confirm Borrows'],
                    ['route' => route('borrow'), 'label' => 'Data Borrows'],
                    ['route' => route('borrow.return'), 'label' => 'Confirm Return'],
                    ['route' => route('borrow.history'), 'label' => 'History'],
                ]" />
            @endif

            <x-layout.sidebar-group label="Report" :items="[
                ['route' => route('report.borrow'), 'label' => 'Borrowed'],
                ['route' => route('report.review'), 'label' => 'Review Books'],
            ]" />
            @include('components.layout.sidebar-item-logout')

            {{-- <x-layout.sidebar-group label="Account" :items="[
                ['route' => '#', 'label' => 'Details'],
                ['route' => '#', 'label' => 'Security'],
                ['route' => '#', 'label' => 'Logout'],
            ]" /> --}}
        </ul>
    </div>

    <x-layout.sidebar-profile name="{{ Auth::user()->NamaLengkap }}" email="{{ Auth::user()->email }}"
        image="https://images.unsplash.com/photo-1600486913747-55e5470d6f40?ixlib=rb-1.2.1&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1770&q=80" />
</div>
