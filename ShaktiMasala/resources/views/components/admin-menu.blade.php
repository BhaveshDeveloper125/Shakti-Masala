<nav class="h-screen sticky top-0">
    <ul id="nav" class="h-screen bg-[#113F67] w-20 hover:w-64 transition-all duration-300 ease-in-out flex flex-col shadow-xl group sticky top-0 md:relative">
        <!-- Logo/Hamburger Section -->
        <li class="p-4 flex items-center justify-between border-b border-[#34699A] sticky top-0 bg-[#113F67] z-10">
            <div class="flex items-center gap-4">
                <button onclick="ToggleMenu()" class="h-10 w-10 flex flex-col justify-center items-center cursor-pointer group-hover:rotate-180 transition-transform duration-300">
                    <div class="h-[2px] w-6 bg-white mb-1.5 transition-all duration-300 group-hover:rotate-45 group-hover:mb-0 group-hover:translate-y-1"></div>
                    <div class="h-[2px] w-6 bg-white mb-1.5 transition-all duration-300 group-hover:opacity-0"></div>
                    <div class="h-[2px] w-6 bg-white transition-all duration-300 group-hover:-rotate-45 group-hover:-translate-y-1"></div>
                </button>
                <span class="text-white font-bold text-xl hidden group-hover:block transition-opacity duration-200">Menu</span>
            </div>
        </li>

        <!-- Navigation Items -->
        <div class="flex-1 overflow-y-auto overflow-x-hidden py-4 custom-scrollbar">
            @if (!auth()->check())
            <li class="hover:bg-[#154D71] transition-colors duration-200 mx-2 rounded-lg">
                <a href="/registration" class="p-4 flex gap-4 items-center text-white">
                    <div class="min-w-[40px] h-10 rounded-lg bg-[#3B38A0] flex items-center justify-center">
                        <i class="fas fa-user-plus text-white"></i>
                    </div>
                    <span class="nav_text opacity-0 group-hover:opacity-100 transition-opacity duration-200 text-white font-medium">Registration</span>
                </a>
            </li>
            <li class="hover:bg-[#154D71] transition-colors duration-200 mx-2 rounded-lg">
                <a href="/login_page" class="p-4 flex gap-4 items-center text-white">
                    <div class="min-w-[40px] h-10 rounded-lg bg-[#3B38A0] flex items-center justify-center">
                        <i class="fas fa-sign-in-alt text-white"></i>
                    </div>
                    <span class="nav_text opacity-0 group-hover:opacity-100 transition-opacity duration-200 text-white font-medium">Login</span>
                </a>
            </li>
            @endif

            @if (auth()->check())
            <li class="hover:bg-[#154D71] transition-colors duration-200 mx-2 rounded-lg">
                <a href="/" class="p-4 flex gap-4 items-center text-white">
                    <div class="min-w-[40px] h-10 rounded-full bg-[#1A2A80] flex items-center justify-center">
                        <i class="fas fa-user text-white"></i>
                    </div>
                    <div class="flex flex-col">
                        <span class="nav_text opacity-0 group-hover:opacity-100 transition-opacity duration-200 text-white font-medium">{{ auth()->user()->name }}</span>
                        <span class="nav_text opacity-0 group-hover:opacity-100 transition-opacity duration-200 text-xs text-gray-300">Dashboard</span>
                    </div>
                </a>
            </li>
            <li class="hover:bg-[#154D71] transition-colors duration-200 mx-2 rounded-lg">
                <a href="/sales" class="p-4 flex gap-4 items-center text-white">
                    <div class="min-w-[40px] h-10 rounded-lg bg-[#3B38A0] flex items-center justify-center">
                        <i class="fas fa-cash-register text-white"></i>
                    </div>
                    <span class="nav_text opacity-0 group-hover:opacity-100 transition-opacity duration-200 text-white font-medium">Sales</span>
                </a>
            </li>
            <li class="hover:bg-[#154D71] transition-colors duration-200 mx-2 rounded-lg">
                <a href="/salesmanage" class="p-4 flex gap-4 items-center text-white">
                    <div class="min-w-[40px] h-10 rounded-lg bg-[#3B38A0] flex items-center justify-center">
                        <i class="fas fa-chart-line text-white"></i>
                    </div>
                    <span class="nav_text opacity-0 group-hover:opacity-100 transition-opacity duration-200 text-white font-medium">Sales Management</span>
                </a>
            </li>
            <li class="hover:bg-[#154D71] transition-colors duration-200 mx-2 rounded-lg">
                <a href="/saleshistory" class="p-4 flex gap-4 items-center text-white">
                    <div class="min-w-[40px] h-10 rounded-lg bg-[#3B38A0] flex items-center justify-center">
                        <i class="fas fa-receipt text-white"></i>
                    </div>
                    <span class="nav_text opacity-0 group-hover:opacity-100 transition-opacity duration-200 text-white font-medium">Sales History</span>
                </a>
            </li>
            <li class="hover:bg-[#154D71] transition-colors duration-200 mx-2 rounded-lg">
                <a href="/production" class="p-4 flex gap-4 items-center text-white">
                    <div class="min-w-[40px] h-10 rounded-lg bg-[#3B38A0] flex items-center justify-center">
                        <i class="fas fa-industry text-white"></i>
                    </div>
                    <span class="nav_text opacity-0 group-hover:opacity-100 transition-opacity duration-200 text-white font-medium">Production</span>
                </a>
            </li>
            <li class="hover:bg-[#154D71] transition-colors duration-200 mx-2 rounded-lg">
                <a href="/inventory" class="p-4 flex gap-4 items-center text-white">
                    <div class="min-w-[40px] h-10 rounded-lg bg-[#3B38A0] flex items-center justify-center">
                        <i class="fas fa-boxes text-white"></i>
                    </div>
                    <span class="nav_text opacity-0 group-hover:opacity-100 transition-opacity duration-200 text-white font-medium">Inventry</span>
                </a>
            </li>
            <li class="hover:bg-[#154D71] transition-colors duration-200 mx-2 rounded-lg">
                <a href="/customer_details" class="p-4 flex gap-4 items-center text-white">
                    <div class="min-w-[40px] h-10 rounded-lg bg-[#3B38A0] flex items-center justify-center">
                        <i class="fas fa-users text-white"></i>
                    </div>
                    <span class="nav_text opacity-0 group-hover:opacity-100 transition-opacity duration-200 text-white font-medium">Customer Details</span>
                </a>
            </li>
            <!-- <li class="hover:bg-[#154D71] transition-colors duration-200 mx-2 rounded-lg">
                <a href="/product_consting" class="p-4 flex gap-4 items-center text-white">
                    <div class="min-w-[40px] h-10 rounded-lg bg-[#3B38A0] flex items-center justify-center">
                        <i class="fas fa-calculator text-white"></i>
                    </div>
                    <span class="nav_text opacity-0 group-hover:opacity-100 transition-opacity duration-200 text-white font-medium">Product costing</span>
                </a>
            </li> -->
            <li class="hover:bg-[#154D71] transition-colors duration-200 mx-2 rounded-lg">
                <a href="/expenses" class="p-4 flex gap-4 items-center text-white">
                    <div class="min-w-[40px] h-10 rounded-lg bg-[#3B38A0] flex items-center justify-center">
                        <i class="fas fa-money-bill-wave text-white"></i>
                    </div>
                    <span class="nav_text opacity-0 group-hover:opacity-100 transition-opacity duration-200 text-white font-medium">Expenses</span>
                </a>
            </li>
            <li class="hover:bg-[#154D71] transition-colors duration-200 mx-2 rounded-lg">
                <a href="/product_costing" class="p-4 flex gap-4 items-center text-white">
                    <div class="min-w-[40px] h-10 rounded-lg bg-[#3B38A0] flex items-center justify-center">
                        <i class="fas fa-chart-bar text-white"></i>
                    </div>
                    <span class="nav_text opacity-0 group-hover:opacity-100 transition-opacity duration-200 text-white font-medium">Product Costing</span>
                </a>
            </li>
            </li>
            <li class="hover:bg-[#154D71] transition-colors duration-200 mx-2 rounded-lg">
                <a href="/set_product_type" class="p-4 flex gap-4 items-center text-white">
                    <div class="min-w-[40px] h-10 rounded-lg bg-[#3B38A0] flex items-center justify-center">
                        <i class="fas fa-th-large text-white"></i> <!-- Changed icon -->
                    </div>
                    <span class="nav_text opacity-0 group-hover:opacity-100 transition-opacity duration-200 text-white font-medium">Product Type</span>
                </a>
            </li>
            @endif
        </div>

        <!-- Logout Section -->
        @if (auth()->check())
        <div class="mt-auto border-t border-[#34699A] sticky bottom-0 bg-[#113F67]">
            <form action="/logout" method="post">
                @csrf
                <button type="submit" class="w-full p-4 flex gap-4 items-center text-white hover:bg-[#154D71] transition-colors duration-200">
                    <div class="min-w-[40px] h-10 rounded-lg bg-[#001BB7] flex items-center justify-center">
                        <i class="fas fa-sign-out-alt text-white"></i>
                    </div>
                    <span class="nav_text opacity-0 group-hover:opacity-100 transition-opacity duration-200 text-white font-medium">Logout</span>
                </button>
            </form>
        </div>
        @endif
    </ul>
</nav>

<style>
    /* Custom scrollbar styling */
    .custom-scrollbar::-webkit-scrollbar {
        width: 4px;
    }

    .custom-scrollbar::-webkit-scrollbar-track {
        background: transparent;
    }

    .custom-scrollbar::-webkit-scrollbar-thumb {
        background: #34699A;
        border-radius: 4px;
    }

    .custom-scrollbar::-webkit-scrollbar-thumb:hover {
        background: #3B38A0;
    }

    /* Mobile responsiveness */
    @media (max-width: 768px) {
        #nav {
            width: 64px !important;
            position: fixed;
            z-index: 1000;
        }

        #nav:hover {
            width: 250px !important;
        }

        .nav_text {
            display: none !important;
        }

        #nav:hover .nav_text {
            display: block !important;
            opacity: 1 !important;
        }
    }
</style>

<script>
    function ToggleMenu() {
        const nav = document.querySelector('#nav');
        const isMobile = window.innerWidth <= 768;

        if (isMobile) {
            nav.classList.toggle('w-64');
            nav.classList.toggle('mobile-expanded');

            // Toggle text visibility immediately on mobile
            document.querySelectorAll('.nav_text').forEach(el => {
                if (nav.classList.contains('mobile-expanded')) {
                    el.classList.remove('opacity-0');
                    el.style.display = 'block';
                } else {
                    el.classList.add('opacity-0');
                    el.style.display = 'none';
                }
            });
        } else {
            nav.classList.toggle('w-64');
            nav.classList.toggle('w-20');
        }
    }

    // Close menu when clicking outside on mobile
    document.addEventListener('click', function(event) {
        const nav = document.querySelector('#nav');
        const isMobile = window.innerWidth <= 768;

        if (isMobile && nav.classList.contains('mobile-expanded') &&
            !nav.contains(event.target) &&
            !event.target.closest('[onclick="ToggleMenu()"]')) {
            nav.classList.remove('mobile-expanded');
            nav.classList.remove('w-64');
            document.querySelectorAll('.nav_text').forEach(el => {
                el.classList.add('opacity-0');
                el.style.display = 'none';
            });
        }
    });
</script>

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
