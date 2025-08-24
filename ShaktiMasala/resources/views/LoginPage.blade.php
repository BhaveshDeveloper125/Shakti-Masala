<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <x-cdnlinks />
</head>

<body class="h-screen w-screen flex bg-gray-50">
    <x-admin-menu />

    <div class="flex-1 flex items-center justify-center p-6">
        <div class="w-full max-w-md">
            <!-- Login Card -->
            <div class="bg-white rounded-xl shadow-2xl overflow-hidden">
                <!-- Card Header -->
                <div class="bg-gradient-to-r from-[#113F67] to-[#1A2A80] p-8 text-center">
                    <h1 class="text-3xl font-bold text-white">Welcome Back</h1>
                    <p class="text-[#34699A] mt-2">Sign in to your account</p>
                </div>

                <!-- Login Form -->
                <form id="login-form" action="/login" method="post" class="p-8 space-y-6">
                    @csrf

                    <!-- Email Field -->
                    <div class="space-y-2">
                        <label for="email" class="block text-sm font-medium text-[#154D71]">Email Address</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-envelope text-[#3B38A0]"></i>
                            </div>
                            <input type="email" name="email" id="email" required
                                class="pl-10 w-full rounded-lg border-[#34699A] border-2 p-3 focus:ring-2 focus:ring-[#3B38A0] focus:border-transparent"
                                placeholder="your@email.com">
                        </div>
                    </div>

                    <!-- Password Field -->
                    <div class="space-y-2">
                        <label for="password" class="block text-sm font-medium text-[#154D71]">Password</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-lock text-[#3B38A0]"></i>
                            </div>
                            <input type="password" name="password" id="password" required
                                class="pl-10 w-full rounded-lg border-[#34699A] border-2 p-3 focus:ring-2 focus:ring-[#3B38A0] focus:border-transparent"
                                placeholder="••••••••">
                        </div>
                        <div class="flex justify-end">
                            <a href="/forgot-password" class="text-sm text-[#3B38A0] hover:text-[#001BB7]">Forgot password?</a>
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <button type="submit"
                        class="w-full bg-gradient-to-r from-[#1A2A80] to-[#3B38A0] text-white py-3 px-4 rounded-lg font-semibold hover:from-[#001BB7] hover:to-[#154D71] transition-all duration-300 shadow-lg transform hover:scale-[1.01]">
                        Login
                    </button>

                    <!-- Error Messages -->
                    @if ($errors->any())
                    <div class="mt-4 space-y-2">
                        @foreach ($errors->all() as $error)
                        <p class="text-red-500 text-sm flex items-center">
                            <i class="fas fa-exclamation-circle mr-2"></i> {{ $error }}
                        </p>
                        @endforeach
                    </div>
                    @endif
                </form>

                <!-- Card Footer -->
                <div class="bg-gray-50 px-8 py-6 text-center border-t border-gray-200">
                    <p class="text-sm text-gray-600">
                        Don't have an account?
                        <a href="/registration" class="font-medium text-[#3B38A0] hover:text-[#1A2A80]">Sign up</a>
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- Toast Notifications -->
    @if (session('success'))
    <script>
        toastr.success("{{ session('success') }}");
    </script>
    @endif

    @if (session('error'))
    <script>
        toastr.error("{{ session('error') }}");
    </script>
    @endif
</body>

</html>