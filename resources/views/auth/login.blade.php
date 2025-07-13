<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap');

        * {
            font-family: 'Inter', sans-serif;
        }

        .hero-image {
            background: linear-gradient(rgba(0, 0, 0, 0.4), rgba(0, 0, 0, 0.6)),
                url('https://masjidalikhwan.com/storage/masjid.jpg');
            background-size: cover;
            background-position: center;
            animation: zoomInOut 20s infinite;
        }

        @keyframes zoomInOut {

            0%,
            100% {
                transform: scale(1);
            }

            50% {
                transform: scale(1.05);
            }
        }

        .form-container {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
        }

        .input-field {
            transition: all 0.3s ease;
        }

        .input-field:focus {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
        }

        .login-button {
            background: linear-gradient(135deg, #38b000 0%, #008000 100%);
            transition: all 0.3s ease;
        }

        .login-button:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(56, 176, 0, 0.4);
        }

        .floating-label {
            transition: all 0.3s ease;
        }

        .input-field:focus+.floating-label,
        .input-field:not(:placeholder-shown)+.floating-label {
            transform: translateY(-1.5rem) scale(0.8);
            color: #667eea;
        }

        .pulse-ring {
            animation: pulse-ring 2s infinite;
        }

        @keyframes pulse-ring {
            0% {
                transform: scale(0.8);
                opacity: 1;
            }

            100% {
                transform: scale(2.4);
                opacity: 0;
            }
        }

        .fade-in {
            animation: fadeIn 0.8s ease-in-out;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .slide-in-right {
            animation: slideInRight 0.8s ease-in-out;
        }

        @keyframes slideInRight {
            from {
                opacity: 0;
                transform: translateX(50px);
            }

            to {
                opacity: 1;
                transform: translateX(0);
            }
        }
    </style>
</head>

<body class="h-screen overflow-hidden">
    <!-- Session Status -->
    @if (session('status'))
    <div class="fixed top-4 right-4 z-50 bg-green-500 text-white px-6 py-3 rounded-lg shadow-lg fade-in">
        {{ session('status') }}
    </div>
    @endif

    <div class="flex h-full">
        <!-- Left Side - Hero Image -->
        <div class="hidden lg:flex lg:w-1/2 hero-image relative">
            <div class="absolute inset-0 bg-gradient-to-br from-green-900/20 to-blue-900/20"></div>
            <div class="relative z-10 flex flex-col justify-center items-center text-white p-12">
                <div class="text-center fade-in">
                    <div class="relative mb-8">
                        <div class="absolute inset-0 bg-white/20 rounded-full pulse-ring"></div>
                        <div class="relative bg-white/10 backdrop-blur-sm rounded-full p-6">
                            <svg class="w-16 h-16 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                            </svg>
                        </div>
                    </div>
                    <h1 class="text-5xl font-bold mb-4 leading-tight">Welcome Back</h1>
                    <p class="text-xl text-gray-200 max-w-md mx-auto leading-relaxed">
                        Assalamualaikum Admin, Welcome Back
                    </p>
                </div>
            </div>
        </div>

        <!-- Right Side - Login Form -->
        <div class="w-full lg:w-1/2 flex items-center justify-center p-8 bg-gray-50">
            <div class="form-container rounded-2xl shadow-2xl p-8 w-full max-w-md slide-in-right">
                <div class="text-center mb-8">
                    <h2 class="text-3xl font-bold text-gray-800 mb-2">Sign In</h2>
                    <p class="text-gray-600">Enter your credentials to access your account</p>
                </div>

                <form method="POST" action="{{ route('login') }}" class="space-y-6">
                    @csrf

                    <!-- Email Address -->
                    <div class="relative">
                        <input
                            id="email"
                            class="input-field w-full px-4 py-4 bg-white border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent placeholder-transparent"
                            type="email"
                            name="email"
                            value="{{ old('email') }}"
                            required
                            autofocus
                            autocomplete="username"
                            placeholder="Email Address" />
                        <label for="email" class="floating-label absolute left-4 top-4 text-gray-600 pointer-events-none">
                            Email Address
                        </label>
                        @error('email')
                        <p class="text-red-500 text-sm mt-2 ml-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Password -->
                    <div class="relative">
                        <input
                            id="password"
                            class="input-field w-full px-4 py-4 bg-white border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent placeholder-transparent"
                            type="password"
                            name="password"
                            required
                            autocomplete="current-password"
                            placeholder="Password" />
                        <label for="password" class="floating-label absolute left-4 top-4 text-gray-600 pointer-events-none">
                            Password
                        </label>
                        @error('password')
                        <p class="text-red-500 text-sm mt-2 ml-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Remember Me -->
                    <div class="flex items-center justify-between">
                        <label for="remember_me" class="flex items-center cursor-pointer">
                            <input
                                id="remember_me"
                                type="checkbox"
                                class="w-4 h-4 text-green-600 border-gray-300 rounded focus:ring-green-500 focus:ring-2"
                                name="remember" />
                            <span class="ml-2 text-sm text-gray-600">Remember me</span>
                        </label>

                        @if (Route::has('password.request'))
                        <a class="text-sm text-green-600 hover:text-green-800 transition-colors duration-200" href="{{ route('password.request') }}">
                            Forgot password?
                        </a>
                        @endif
                    </div>

                    <!-- Submit Button -->
                    <button
                        type="submit"
                        class="login-button w-full py-4 text-white font-semibold rounded-xl focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2">
                        Sign In
                    </button>
                </form>
            </div>
        </div>
    </div>
</body>

</html>