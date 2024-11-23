<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - DigiLib</title>
    @vite('resources/css/app.css')
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
</head>
<body class="bg-gradient-to-br from-amber-50 to-amber-100 flex justify-center items-center min-h-screen p-4 font-inter">
    <div class="w-full max-w-md">
        <div class="bg-white p-8 rounded-2xl shadow-xl">
            <div class="flex justify-center mb-6">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                     stroke="currentColor" class="w-12 h-12 text-amber-600">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="M12 21v-8.25M15.75 21v-8.25M8.25 21v-8.25M3 9l9-6 9 6m-1.5 12V10.332A48.36 48.36 0 0012 9.75c-2.551 0-5.056.2-7.5.582V21M3 21h18M12 6.75h.008v.008H12V6.75z"/>
                </svg>
            </div>
            <h2 class="text-3xl font-bold text-center text-gray-800 mb-6">Welcome Back</h2>

            <form method="POST" action="{{ route('login') }}" class="space-y-4">
                @csrf

                @if ($errors->any())
                    <div class="bg-red-50 text-red-500 p-3 rounded-lg text-sm mb-6">
                        {{ $errors->first() }}
                    </div>
                @endif

                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                    <input type="email" id="email" name="email"
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-amber-500"
                           required autofocus>  
                </div>

                <div class="relative">
                    <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                    <input type="password" id="password" name="password"
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-amber-500"
                           required>
                    <button type="button" id="togglePassword"
                            class="absolute right-3 top-8   text-gray-600 hover:text-gray-800 focus:outline-none">
                        S
                    </button>
                </div>

                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <input type="checkbox" id="remember" name="remember"
                               class="h-4 w-4 text-amber-600 focus:ring-amber-500 border-gray-300 rounded">
                        <label for="remember" class="ml-2 block text-sm text-gray-700">Remember me</label>
                    </div>
                    <div class="text-sm">
                        <a href="#" class="font-medium text-amber-600 hover:text-amber-500">
                            Forgot your password?
                        </a>
                    </div>
                </div>
                <button type="submit"
                        class="w-full bg-amber-600 hover:bg-amber-700 text-white font-semibold py-2 px-4 rounded-md transition duration-300 ease-in-out transform hover:-translate-y-1 hover:shadow-lg">
                    Sign In
                </button>
            </form>

            <p class="text-center mt-6 text-sm text-gray-600">
                Don't have an account?
                <a href="{{ route('register') }}" class="text-amber-600 hover:text-amber-800 font-medium">
                    Register now
                </a>
            </p>
        </div>
    </div>

    <script>

        function togglePasswordVisibility() {
            const passwordInput = document.getElementById('password');
            const toggleButton = document.getElementById('togglePassword');

            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                toggleButton.textContent = 'H';
            } else {
                passwordInput.type = 'password';
                toggleButton.textContent = 'S';
            }
        }

        document.getElementById('togglePassword').addEventListener('click', togglePasswordVisibility);
    </script>
</body>
</html>
