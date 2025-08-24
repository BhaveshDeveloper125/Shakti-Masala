<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration</title>
    <x-cdnlinks />
</head>

<body class="h-screen w-screen flex bg-gray-50">
    <x-admin-menu />

    <div class="flex-1 flex items-center justify-center p-4 overflow-auto">
        <div class="w-full max-w-md mx-auto">
            <div class="bg-white rounded-xl shadow-2xl overflow-hidden">
                <!-- Form Header -->
                <div class="bg-[#113F67] p-6 text-center">
                    <h1 class="text-3xl font-bold text-white">Create Account</h1>
                    <!-- <p class="text-[#34699A] mt-2">Join our community today</p> -->
                </div>

                <!-- Registration Form -->
                <form action="/register" method="post" class="p-6 space-y-6">
                    @csrf

                    <!-- Name Input -->
                    <div class="space-y-2">
                        <label for="name" class="block text-sm font-medium text-[#154D71]">Full Name</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-user text-[#3B38A0]"></i>
                            </div>
                            <input type="text" name="name" id="name" required
                                class="pl-10 w-full rounded-lg border-[#34699A] border-2 p-3 focus:ring-2 focus:ring-[#3B38A0] focus:border-transparent"
                                placeholder="John Doe">
                        </div>
                    </div>

                    <!-- Email Input -->
                    <div class="space-y-2">
                        <label for="email" class="block text-sm font-medium text-[#154D71]">Email Address</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-envelope text-[#3B38A0]"></i>
                            </div>
                            <input type="email" name="email" id="email" required
                                class="pl-10 w-full rounded-lg border-[#34699A] border-2 p-3 focus:ring-2 focus:ring-[#3B38A0] focus:border-transparent"
                                placeholder="john@example.com">
                        </div>
                    </div>

                    <!-- Password Input -->
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
                    </div>

                    <!-- Confirm Password Input -->
                    <div class="space-y-2">
                        <label for="password_confirmation" class="block text-sm font-medium text-[#154D71]">Confirm Password</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-lock text-[#3B38A0]"></i>
                            </div>
                            <input type="password" name="password_confirmation" id="password_confirmation" required
                                class="pl-10 w-full rounded-lg border-[#34699A] border-2 p-3 focus:ring-2 focus:ring-[#3B38A0] focus:border-transparent"
                                placeholder="••••••••">
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <button type="submit"
                        class="w-full bg-gradient-to-r from-[#1A2A80] to-[#3B38A0] text-white py-3 px-4 rounded-lg font-semibold hover:from-[#001BB7] hover:to-[#154D71] transition-all duration-300 shadow-lg">
                        Sign Up
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

                <!-- Footer -->
                <div class="bg-gray-50 px-6 py-4 text-center border-t border-gray-200">
                    <p class="text-sm text-gray-600">
                        Already have an account?
                        <a href="/login_page" class="font-medium text-[#3B38A0] hover:text-[#1A2A80]">Login</a>
                    </p>
                </div>
            </div>
        </div>
    </div>

    @if (session()->has('success'))
    <script>
        toastr.success("{{ session('success') }}")
    </script>
    @endif
    @if (session()->has('error'))
    <script>
        toastr.error("{{ session('error') }}")
    </script>
    @endif
    @if (session()->has('email'))
    <script>
        toastr.warning("{{ session('email') }}");
    </script>
    @endif
</body>

</html>