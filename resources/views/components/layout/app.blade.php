<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>DigiLib - Your Modern Digital Library</title>
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])


</head>

<body class="">
    <header class="bg-amber-900 text-white">
        <div class="container mx-auto px-4 py-6 flex items-center justify-between">
            <a href="{{ route('landingPage') }}" class="flex items-center space-x-2">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor" class="w-8 h-8">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25" />
                </svg>
                <span class="text-2xl font-bold">DigiLib</span>
            </a>
            <nav class="hidden md:flex space-x-2">
                @auth
                    <a href="{{ route('books.data') }}" 
                       class="hover:text-amber-200 transition duration-300 ease-in-out py-2 px-4 rounded-md {{ request()->routeIs('books.data') ? 'text-amber-400 bg-amber-700' : 'text-white' }}">
                        Library
                    </a>
                    
                    @if (Auth::user()->Role == 'peminjam')
                        <a href="{{ route('collections') }}" 
                           class="hover:text-amber-200 transition duration-300 ease-in-out py-2 px-4 rounded-md {{ request()->routeIs('collections') ? 'text-amber-400 bg-amber-700' : 'text-white' }}">
                            Collections
                        </a>
                        <a href="{{ route('ulasan') }}" 
                           class="hover:text-amber-200 transition duration-300 ease-in-out py-2 px-4 rounded-md {{ request()->routeIs('ulasan') ? 'text-amber-400 bg-amber-700' : 'text-white' }}">
                            History
                        </a>
                    @endif
                    
                    <form action="{{ route('logout') }}" method="POST" class="cursor-pointer">
                        @csrf
                        <button type="submit" 
                                class="hover:text-amber-200 transition duration-300 ease-in-out py-2 px-4 rounded-md {{ request()->routeIs('logout') ? 'text-amber-400 bg-amber-700' : 'text-white' }}">
                            Logout
                        </button>
                    </form>
                @else
                    <a href="{{ route('register') }}" 
                       class="hover:text-amber-200 transition duration-300 ease-in-out py-2 px-4 rounded-md {{ request()->routeIs('register') ? 'text-amber-400 bg-amber-700' : 'text-white' }}">
                        Register
                    </a>
                    <a href="{{ route('login') }}" 
                       class="hover:text-amber-200 transition duration-300 ease-in-out py-2 px-4 rounded-md {{ request()->routeIs('login') ? 'text-amber-400 bg-amber-700' : 'text-white' }}">
                        Login
                    </a>
                @endauth
            </nav>
            <button class="md:hidden">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor" class="w-6 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
                </svg>
            </button>
        </div>
    </header>
    

    <main class="overflow-y-auto">
        {{ $slot }}
    </main>

    <footer class="bg-amber-900 text-white py-10" id="contact">
        <div class="container mx-auto px-4">
            <div class="grid md:grid-cols-4 gap-8">
                <div>
                    <h3 class="text-lg font-semibold mb-4">About DigiLib</h3>
                    <p class="text-amber-200">Empowering readers with access to a world of knowledge and
                        imagination.</p>
                </div>
                <div>
                    <h3 class="text-lg font-semibold mb-4">Quick Links</h3>
                    <ul class="space-y-2">
                        <li><a href="#" class="hover:text-amber-200 transition">Home</a></li>
                        <li><a href="#" class="hover:text-amber-200 transition">About Us</a></li>
                        <li><a href="#" class="hover:text-amber-200 transition">FAQ</a></li>
                        <li><a href="#" class="hover:text-amber-200 transition">Contact</a></li>
                    </ul>
                </div>
                <div>
                    <h3 class="text-lg font-semibold mb-4">Legal</h3>
                    <ul class="space-y-2">

                        <li><a href="#" class="hover:text-amber-200 transition">Terms of Service</a></li>
                        <li><a href="#" class="hover:text-amber-200 transition">Privacy Policy</a></li>
                        <li><a href="#" class="hover:text-amber-200 transition">Cookie Policy</a></li>
                    </ul>
                </div>
                <div>
                    <h3 class="text-lg font-semibold mb-4">Connect With Us</h3>
                    <div class="flex space-x-4">
                        <a href="#"
                            class="bg-amber-800 hover:bg-amber-700 text-white p-2 rounded-full transition"><svg
                                class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path fill-rule="evenodd"
                                    d="M22 12c0-5.523-4.477-10-10-10S2 6.477 2 12c0 4.991 3.657 9.128 8.438 9.878v-6.987h-2.54V12h2.54V9.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562V12h2.773l-.443 2.89h-2.33v6.988C18.343 21.128 22 16.991 22 12z"
                                    clip-rule="evenodd"></path>
                            </svg></a>
                        <a href="#"
                            class="bg-amber-800 hover:bg-amber-700 text-white p-2 rounded-full transition"><svg
                                class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path
                                    d="M8.29 20.251c7.547 0 11.675-6.253 11.675-11.675 0-.178 0-.355-.012-.53A8.348 8.348 0 0022 5.92a8.19 8.19 0 01-2.357.646 4.118 4.118 0 001.804-2.27 8.224 8.224 0 01-2.605.996 4.107 4.107 0 00-6.993 3.743 11.65 11.65 0 01-8.457-4.287 4.106 4.106 0 001.27 5.477A4.072 4.072 0 012.8 9.713v.052a4.105 4.105 0 003.292 4.022 4.095 4.095 0 01-1.853.07 4.108 4.108 0 003.834 2.85A8.233 8.233 0 012 18.407a11.616 11.616 0 006.29 1.84">
                                </path>
                            </svg></a>
                        <a href="#"
                            class="bg-amber-800 hover:bg-amber-700 text-white p-2 rounded-full transition"><svg
                                class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path fill-rule="evenodd"
                                    d="M12.315 2c2.43 0 2.784.013 3.808.06 1.064.049 1.791.218 2.427.465a4.902 4.902 0 011.772 1.153 4.902 4.902 0 011.153 1.772c.247.636.416 1.363.465 2.427.048 1.067.06 1.407.06 4.123v.08c0 2.643-.012 2.987-.06 4.043-.049 1.064-.218 1.791-.465 2.427a4.902 4.902 0 01-1.153 1.772 4.902 4.902 0 01-1.772 1.153c-.636.247-1.363.416-2.427.465-1.067.048-1.407.06-4.123.06h-.08c-2.643 0-2.987-.012-4.043-.06-1.064-.049-1.791-.218-2.427-.465a4.902 4.902 0 01-1.772-1.153 4.902 4.902 0 01-1.153-1.772c-.247-.636-.416-1.363-.465-2.427-.047-1.024-.06-1.379-.06-3.808v-.63c0-2.43.013-2.784.06-3.808.049-1.064.218-1.791.465-2.427a4.902 4.902 0 011.153-1.772A4.902 4.902 0 015.45 2.525c.636-.247 1.363-.416 2.427-.465C8.901 2.013 9.256 2 11.685 2h.63zm-.081 1.802h-.468c-2.456 0-2.784.011-3.807.058-.975.045-1.504.207-1.857.344-.467.182-.8.398-1.15.748-.35.35-.566.683-.748 1.15-.137.353-.3.882-.344 1.857-.047 1.023-.058 1.351-.058 3.807v.468c0 2.456.011 2.784.058 3.807.045.975.207 1.504.344 1.857.182.466.399.8.748 1.15.35.35.683.566 1.15.748.353.137.882.3 1.857.344 1.054.048 1.37.058 4.041.058h.08c2.597 0 2.917-.01 3.96-.058.976-.045 1.505-.207 1.858-.344.466-.182.8-.398 1.15-.748.35-.35.566-.683.748-1.15.137-.353.3-.882.344-1.857.048-1.055.058-1.37.058-4.041v-.08c0-2.597-.01-2.917-.058-3.96-.045-.976-.207-1.505-.344-1.858a3.097 3.097 0 00-.748-1.15 3.098 3.098 0 00-1.15-.748c-.353-.137-.882-.3-1.857-.344-1.023-.047-1.351-.058-3.807-.058zM12 6.865a5.135 5.135 0 110 10.27 5.135 5.135 0 010-10.27zm0 1.802a3.333 3.333 0 100 6.666 3.333 3.333 0 000-6.666zm5.338-3.205a1.2 1.2 0 110 2.4 1.2 1.2 0 010-2.4z"
                                    clip-rule="evenodd"></path>
                            </svg></a>
                    </div>
                </div>
            </div>
            <div class="mt-8 pt-8 border-t border-amber-800 text-center">
                <p>&copy; 2024 DigiLib. All rights reserved.</p>
            </div>
        </div>
    </footer>
    @stack('scripts')
</body>

</html>