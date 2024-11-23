<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - DigiLib</title>
    @vite('resources/css/app.css')
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
</head>
<body class="bg-gradient-to-br from-amber-50 to-amber-100 flex justify-center items-center min-h-screen p-4 font-inter">
    <div class="w-full max-w-4xl">
        <div class="bg-white p-8 rounded-2xl shadow-xl ">
            <div class="flex justify-center mb-6 space-x-2">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-12 h-12 text-amber-600">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 21v-8.25M15.75 21v-8.25M8.25 21v-8.25M3 9l9-6 9 6m-1.5 12V10.332A48.36 48.36 0 0012 9.75c-2.551 0-5.056.2-7.5.582V21M3 21h18M12 6.75h.008v.008H12V6.75z" />
                </svg>
                <h2 class="text-3xl font-bold text-center text-gray-800 mt-2">Welcome to DigiLib</h2>
            </div>

            <form method="POST" action="{{ route('register') }}" class="grid grid-cols-2 gap-4">
                @csrf

                @if($errors->any())
                    <div class="col-span-2 bg-red-50 text-red-500 p-3 rounded-lg text-sm mb-6">
                        {{ $errors->first() }}
                    </div>
                @endif

                <div>
                    <label for="Username" class="block text-sm font-medium text-gray-700 mb-1">Username</label>
                    <input type="text" id="Username" name="Username" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-amber-500" required>
                </div>

                <div>
                    <label for="NamaLengkap" class="block text-sm font-medium text-gray-700 mb-1">Full Name</label>
                    <input type="text" id="NamaLengkap" name="NamaLengkap" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-amber-500" required>
                </div>

                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                    <input type="email" id="email" name="email" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-amber-500" required>
                </div>

                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                    <input type="password" id="password" name="password" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-amber-500" required>
                </div>

                <div class="col-span-2">
                    <label for="Alamat" class="block text-sm font-medium text-gray-700 mb-1">Address</label>
                    <textarea id="Alamat" name="Alamat" rows="3" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-amber-500" required></textarea>
                </div>

                <div class="col-span-2">
                    <button type="submit" class="w-full bg-amber-600 hover:bg-amber-700 text-white font-semibold py-2 px-4 rounded-md transition duration-300 ease-in-out transform hover:-translate-y-1 hover:shadow-lg">
                        Create Account
                    </button>
                </div>
            </form>

            <p class="text-center mt-6 text-sm text-gray-600 col-span-2">
                Already have an account? 
                <a href="{{ route('login') }}" class="text-amber-600 hover:text-amber-800 font-medium">
                    Log in
                </a>
            </p>
        </div>
    </div>


</body>
</html>
