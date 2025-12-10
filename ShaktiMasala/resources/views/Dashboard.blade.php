<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Analytics</title>
    <x-cdnlinks />
    <style>
        :root {
            --primary-dark: #1A2A80;
            --primary: #3B38A0;
            --secondary-dark: #113F67;
            --secondary: #34699A;
            --accent-dark: #154D71;
            --accent: #001BB7;
        }

        body {
            background: linear-gradient(135deg, #f5f7fa 0%, #e4edf5 100%);
        }

        .glass-card {
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            box-shadow: 0 8px 32px rgba(31, 38, 135, 0.1);
        }

        .gradient-bg {
            background: linear-gradient(135deg, var(--primary) 0%, var(--accent) 100%);
        }

        .stat-card {
            transition: all 0.3s ease;
            border-left: 4px solid transparent;
        }

        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 40px rgba(31, 38, 135, 0.2);
        }

        .stat-card:nth-child(1) {
            border-left-color: #1A2A80;
        }

        .stat-card:nth-child(2) {
            border-left-color: #3B38A0;
        }

        .stat-card:nth-child(3) {
            border-left-color: #113F67;
        }

        .stat-card:nth-child(4) {
            border-left-color: #34699A;
        }

        .stat-card:nth-child(5) {
            border-left-color: #154D71;
        }

        .stat-card:nth-child(6) {
            border-left-color: #001BB7;
        }

        .btn-primary {
            background: linear-gradient(135deg, var(--primary) 0%, var(--accent) 100%);
            color: white;
            transition: all 0.3s ease;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(26, 42, 128, 0.3);
        }

        .chart-container {
            position: relative;
            height: 300px;
            background: white;
            border-radius: 12px;
            padding: 20px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
        }

        .table-container {
            background: white;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
        }

        .table-header {
            background: linear-gradient(135deg, var(--secondary-dark) 0%, var(--secondary) 100%);
            color: white;
        }

        .pulse {
            animation: pulse 2s infinite;
        }

        @keyframes pulse {
            0% {
                box-shadow: 0 0 0 0 rgba(26, 42, 128, 0.4);
            }

            70% {
                box-shadow: 0 0 0 10px rgba(26, 42, 128, 0);
            }

            100% {
                box-shadow: 0 0 0 0 rgba(26, 42, 128, 0);
            }
        }

        .fade-in {
            animation: fadeIn 0.8s ease-out;
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

        /* Rupee Symbol */
        .rupee:before {
            content: "₹";
            margin-right: 2px;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .grid-cols-1 {
                grid-template-columns: 1fr !important;
            }

            .grid-cols-2 {
                grid-template-columns: 1fr !important;
            }

            .grid-cols-3 {
                grid-template-columns: 1fr !important;
            }

            .grid-cols-4 {
                grid-template-columns: 1fr !important;
            }

            .chart-container {
                height: 250px;
                padding: 15px;
            }

            .table-container {
                overflow-x: auto;
            }

            .table-container table {
                min-width: 600px;
            }

            .flex-col-mobile {
                flex-direction: column;
            }

            .space-x-4 {
                gap: 1rem;
            }

            .p-6 {
                padding: 1rem;
            }

            .text-3xl {
                font-size: 1.5rem;
            }

            .text-2xl {
                font-size: 1.25rem;
            }
        }

        @media (max-width: 480px) {
            .p-6 {
                padding: 0.75rem;
            }

            .text-3xl {
                font-size: 1.25rem;
            }

            .text-2xl {
                font-size: 1.125rem;
            }

            .chart-container {
                height: 200px;
                padding: 10px;
            }
        }
    </style>
</head>

<body class="h-screen w-screen flex bg-gray-50">
    <x-admin-menu />

    <div class="flex-1 overflow-y-auto p-4 md:p-6">
        <!-- Header -->
        <div class="mb-6 md:mb-8 fade-in">
            <h1 class="text-2xl md:text-3xl font-bold text-gray-800 mb-2">Dashboard Overview</h1>
            <p class="text-gray-600">Real-time analytics and business insights</p>
        </div>

        <!-- Stats Cards Grid -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 md:gap-6 mb-6 md:mb-8">
            <!-- Total Sales Card -->
            <div class="stat-card glass-card rounded-xl p-4 md:p-6 fade-in animate__animated animate__fadeInUp"
                style="animation-delay: 0.1s">
                <div class="flex items-center justify-between mb-3 md:mb-4">
                    <div class="p-2 md:p-3 rounded-lg gradient-bg">
                        <svg class="w-5 h-5 md:w-6 md:h-6 text-white" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z">
                            </path>
                        </svg>
                    </div>
                </div>
                <h3 class="text-sm font-medium text-gray-500 mb-1 md:mb-2">Total Sales</h3>
                <h1 class="text-2xl md:text-3xl font-bold text-gray-800 rupee" id="Total_Sales">0.00</h1>
            </div>

            <!-- Payment Status Card -->
            <div class="stat-card glass-card rounded-xl p-4 md:p-6 fade-in animate__animated animate__fadeInUp"
                style="animation-delay: 0.2s">
                <div class="flex items-center justify-between mb-3 md:mb-4">
                    <div class="p-2 md:p-3 rounded-lg"
                        style="background: linear-gradient(135deg, #3B38A0 0%, #1A2A80 100%)">
                        <svg class="w-5 h-5 md:w-6 md:h-6 text-white" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                </div>
                <div class="space-y-2 md:space-y-3">
                    <div>
                        <h3 class="text-xs md:text-sm font-medium text-gray-500">Partially Pending</h3>
                        <p class="text-lg md:text-xl font-semibold text-red-600" id="TotalPartiallyPending">0</p>
                    </div>
                    <div>
                        <h3 class="text-xs md:text-sm font-medium text-gray-500">Partially Paid</h3>
                        <p class="text-lg md:text-xl font-semibold text-green-600" id="TotalPartiallyPaid">0</p>
                    </div>
                </div>
            </div>

            <!-- Stock Status Card -->
            <div class="stat-card glass-card rounded-xl p-4 md:p-6 fade-in animate__animated animate__fadeInUp"
                style="animation-delay: 0.3s">
                <div class="flex items-center justify-between mb-3 md:mb-4">
                    <div class="p-2 md:p-3 rounded-lg"
                        style="background: linear-gradient(135deg, #113F67 0%, #34699A 100%)">
                        <svg class="w-5 h-5 md:w-6 md:h-6 text-white" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                        </svg>
                    </div>
                </div>
                <div class="grid grid-cols-2 gap-3 md:gap-4">
                    <div>
                        <h3 class="text-xs md:text-sm font-medium text-gray-500">Total Products</h3>
                        <p class="text-lg md:text-xl font-semibold text-gray-800" id="TotalProductsUnits">0</p>
                    </div>
                    <div>
                        <h3 class="text-xs md:text-sm font-medium text-gray-500">Expires Soon</h3>
                        <p class="text-lg md:text-xl font-semibold text-yellow-600" id="TotalExpiresSoon">0</p>
                    </div>
                </div>
            </div>

            <!-- Expenses Card -->
            <div class="stat-card glass-card rounded-xl p-4 md:p-6 fade-in animate__animated animate__fadeInUp"
                style="animation-delay: 0.4s">
                <div class="flex items-center justify-between mb-3 md:mb-4">
                    <div class="p-2 md:p-3 rounded-lg"
                        style="background: linear-gradient(135deg, #154D71 0%, #001BB7 100%)">
                        <svg class="w-5 h-5 md:w-6 md:h-6 text-white" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z">
                            </path>
                        </svg>
                    </div>
                </div>
                <h3 class="text-xs md:text-sm font-medium text-gray-500 mb-1 md:mb-2">Monthly Expenses</h3>
                <h1 class="text-2xl md:text-3xl font-bold text-gray-800 rupee" id="ExpensesThisMonth">0.00</h1>
            </div>
        </div>

        <!-- Sales Filter Section -->
        <div class="mb-6 md:mb-8 fade-in animate__animated animate__fadeInUp">
            <div class="glass-card rounded-xl p-4 md:p-6">
                <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-4 md:mb-6">
                    <div class="mb-4 md:mb-0">
                        <h2 class="text-xl md:text-2xl font-bold text-gray-800">Sales Analysis</h2>
                        <p class="text-gray-600">Filter and analyze sales data by date range</p>
                    </div>
                    <form action="/total_sales" method="post" id="TotalSalesForm"
                        class="flex flex-col sm:flex-row items-start sm:items-center space-y-2 sm:space-y-0 sm:space-x-2 md:space-x-4 w-full md:w-auto">
                        @csrf
                        <div class="flex space-x-2">
                            <input type="date" name="from"
                                class="text-sm px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 w-full">
                            <input type="date" name="to"
                                class="text-sm px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 w-full">
                        </div>
                        <button type="submit" onclick="TotalSales(event)"
                            class="btn-primary text-sm px-4 py-2 rounded-lg w-full sm:w-auto">Get Sales Data</button>
                    </form>
                </div>
                <div class="text-center p-4 bg-blue-50 rounded-lg">
                    <p class="text-gray-600">Current Sales Displayed: <span class="font-semibold rupee"
                            id="CurrentSalesDisplay">0.00</span></p>
                </div>
            </div>
        </div>

        <!-- Charts Section -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-4 md:gap-6 mb-6 md:mb-8">
            <!-- Sales Chart -->
            <div class="fade-in animate__animated animate__fadeInLeft">
                <div class="chart-container">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4">Sales Overview</h3>
                    <canvas id="salesChart"></canvas>
                </div>
            </div>

            <!-- Product Performance Chart -->
            <div class="fade-in animate__animated animate__fadeInRight">
                <div class="chart-container">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4">Product Performance</h3>
                    <canvas id="productChart"></canvas>
                </div>
            </div>
        </div>

        <!-- Stock Status Cards -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 md:gap-6 mb-6 md:mb-8">
            <div class="stat-card glass-card rounded-xl p-4 md:p-6 fade-in animate__animated animate__fadeInUp">
                <div class="flex items-center space-x-3 md:space-x-4">
                    <div class="p-2 md:p-3 rounded-lg bg-red-100">
                        <svg class="w-6 h-6 md:w-8 md:h-8 text-red-600" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L4.732 16.5c-.77.833.192 2.5 1.732 2.5z">
                            </path>
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-xs md:text-sm font-medium text-gray-500">Expired Products</h3>
                        <p class="text-xl md:text-2xl font-bold text-red-600" id="TotalExpired">0</p>
                    </div>
                </div>
            </div>

            <div class="stat-card glass-card rounded-xl p-4 md:p-6 fade-in animate__animated animate__fadeInUp">
                <div class="flex items-center space-x-3 md:space-x-4">
                    <div class="p-2 md:p-3 rounded-lg bg-green-100">
                        <svg class="w-6 h-6 md:w-8 md:h-8 text-green-600" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M5 11l7-7 7 7M5 19l7-7 7 7"></path>
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-xs md:text-sm font-medium text-gray-500">Highest Stock</h3>
                        <p class="text-base md:text-lg font-semibold text-gray-800 truncate" id="HighestStock">-</p>
                        <p class="text-xs md:text-sm text-gray-600" id="HighestStockUnits">0 units</p>
                    </div>
                </div>
            </div>

            <div class="stat-card glass-card rounded-xl p-4 md:p-6 fade-in animate__animated animate__fadeInUp">
                <div class="flex items-center space-x-3 md:space-x-4">
                    <div class="p-2 md:p-3 rounded-lg bg-yellow-100">
                        <svg class="w-6 h-6 md:w-8 md:h-8 text-yellow-600" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-xs md:text-sm font-medium text-gray-500">Lowest Stock</h3>
                        <p class="text-base md:text-lg font-semibold text-gray-800 truncate" id="LowestStock">-</p>
                        <p class="text-xs md:text-sm text-gray-600" id="LowestStockUnits">0 units</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Highest Selling Products -->
        <div class="mb-6 md:mb-8 fade-in animate__animated animate__fadeInUp">
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-4 md:mb-6">
                <div class="mb-4 md:mb-0">
                    <h2 class="text-xl md:text-2xl font-bold text-gray-800">Top Selling Products</h2>
                    <p class="text-gray-600">Performance over selected period</p>
                </div>
                <form action="/highest_selling_products" method="post" id="HighestSellingProductsForm"
                    class="flex flex-col sm:flex-row items-start sm:items-center space-y-2 sm:space-y-0 sm:space-x-2 md:space-x-4 w-full md:w-auto">
                    @csrf
                    <div class="flex space-x-2">
                        <input type="date" name="from"
                            class="text-sm px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 w-full">
                        <input type="date" name="to"
                            class="text-sm px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 w-full">
                    </div>
                    <button type="submit" onclick="HighestSellingProducts(event)"
                        class="btn-primary text-sm px-4 py-2 rounded-lg w-full sm:w-auto">Filter</button>
                </form>
            </div>
            <div class="table-container">
                <div class="overflow-x-auto">
                    <table class="w-full min-w-[600px]">
                        <thead class="table-header">
                            <tr>
                                <th class="py-3 md:py-4 px-4 md:px-6 text-left text-xs md:text-sm font-semibold">#</th>
                                <th class="py-3 md:py-4 px-4 md:px-6 text-left text-xs md:text-sm font-semibold">
                                    Product Name</th>
                                <th class="py-3 md:py-4 px-4 md:px-6 text-left text-xs md:text-sm font-semibold">Total
                                    Sales</th>
                                <th class="py-3 md:py-4 px-4 md:px-6 text-left text-xs md:text-sm font-semibold">
                                    Performance</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200" id="Highest_Selling_Products">
                            <tr>
                                <td colspan="4" class="py-6 md:py-8 text-center text-gray-500">No data available
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Payment Status Section -->
        <div class="mb-6 md:mb-8 fade-in animate__animated animate__fadeInUp">
            <h2 class="text-xl md:text-2xl font-bold text-gray-800 mb-4 md:mb-6">Payment Status</h2>

            <!-- Pending Payments -->
            <div class="mb-6 md:mb-8">
                <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between mb-3 md:mb-4">
                    <h3 class="text-lg md:text-xl font-semibold text-gray-700 mb-2 sm:mb-0">Pending Payments</h3>
                    <span
                        class="px-3 py-1 md:px-4 md:py-2 bg-red-100 text-red-700 rounded-full text-sm md:text-base font-medium"
                        id="TotalPendingCustomers">0</span>
                </div>
                <div class="table-container">
                    <div class="overflow-x-auto">
                        <table class="w-full min-w-[600px]">
                            <thead class="table-header">
                                <tr>
                                    <th class="py-3 md:py-4 px-4 md:px-6 text-left text-xs md:text-sm">#</th>
                                    <th class="py-3 md:py-4 px-4 md:px-6 text-left text-xs md:text-sm">Customer Name
                                    </th>
                                    <th class="py-3 md:py-4 px-4 md:px-6 text-left text-xs md:text-sm">Payment Status
                                    </th>
                                    <th class="py-3 md:py-4 px-4 md:px-6 text-left text-xs md:text-sm">Pending Amount
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200" id="PartiallyPayment"></tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Partially Paid -->
            <div>
                <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between mb-3 md:mb-4">
                    <h3 class="text-lg md:text-xl font-semibold text-gray-700 mb-2 sm:mb-0">Partially Paid</h3>
                    <span
                        class="px-3 py-1 md:px-4 md:py-2 bg-yellow-100 text-yellow-700 rounded-full text-sm md:text-base font-medium"
                        id="TotalPartiallyCustomers">0</span>
                </div>
                <div class="table-container">
                    <div class="overflow-x-auto">
                        <table class="w-full min-w-[800px]">
                            <thead class="table-header">
                                <tr>
                                    <th class="py-3 md:py-4 px-4 md:px-6 text-left text-xs md:text-sm">#</th>
                                    <th class="py-3 md:py-4 px-4 md:px-6 text-left text-xs md:text-sm">Customer Name
                                    </th>
                                    <th class="py-3 md:py-4 px-4 md:px-6 text-left text-xs md:text-sm">Status</th>
                                    <th class="py-3 md:py-4 px-4 md:px-6 text-left text-xs md:text-sm">Paid Amount</th>
                                    <th class="py-3 md:py-4 px-4 md:px-6 text-left text-xs md:text-sm">Due Amount</th>
                                    <th class="py-3 md:py-4 px-4 md:px-6 text-left text-xs md:text-sm">Total Amount
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200" id="PendingPayment"></tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Expenses Section -->
        <div class="fade-in animate__animated animate__fadeInUp">
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-4 md:mb-6">
                <div class="mb-4 md:mb-0">
                    <h2 class="text-xl md:text-2xl font-bold text-gray-800">Expenses Tracker</h2>
                    <p class="text-gray-600">Track and analyze business expenses</p>
                </div>
                <form id="ExpensesForm" action="/total_expenses" method="post"
                    class="flex flex-col sm:flex-row items-start sm:items-center space-y-2 sm:space-y-0 sm:space-x-2 md:space-x-4 w-full md:w-auto">
                    @csrf
                    <div class="flex space-x-2">
                        <input type="date" name="from" id="from"
                            class="text-sm px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 w-full">
                        <input type="date" name="to" id="to"
                            class="text-sm px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 w-full">
                    </div>
                    <button type="submit" class="btn-primary text-sm px-4 py-2 rounded-lg w-full sm:w-auto">Filter
                        Expenses</button>
                </form>
            </div>
            <div class="table-container">
                <div class="overflow-x-auto">
                    <table class="w-full min-w-[800px]">
                        <thead class="table-header">
                            <tr>
                                <th class="py-3 md:py-4 px-4 md:px-6 text-left text-xs md:text-sm">#</th>
                                <th class="py-3 md:py-4 px-4 md:px-6 text-left text-xs md:text-sm">Expense Name</th>
                                <th class="py-3 md:py-4 px-4 md:px-6 text-left text-xs md:text-sm">Amount</th>
                                <th class="py-3 md:py-4 px-4 md:px-6 text-left text-xs md:text-sm">Date</th>
                                <th class="py-3 md:py-4 px-4 md:px-6 text-left text-xs md:text-sm">Description</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200" id="ExpensesTable"></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Initialize Charts -->
    <script>
        // Sales Chart
        const salesCtx = document.getElementById('salesChart').getContext('2d');
        const salesChart = new Chart(salesCtx, {
            type: 'line',
            data: {
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
                datasets: [{
                    label: 'Sales',
                    data: [12000, 19000, 15000, 25000, 22000, 30000],
                    borderColor: '#1A2A80',
                    backgroundColor: 'rgba(26, 42, 128, 0.1)',
                    borderWidth: 3,
                    fill: true,
                    tension: 0.4
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: true,
                        position: 'top',
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: {
                            color: 'rgba(0,0,0,0.05)'
                        },
                        ticks: {
                            callback: function(value) {
                                return '₹' + value.toLocaleString();
                            }
                        }
                    },
                    x: {
                        grid: {
                            color: 'rgba(0,0,0,0.05)'
                        }
                    }
                }
            }
        });

        // Product Performance Chart
        const productCtx = document.getElementById('productChart').getContext('2d');
        const productChart = new Chart(productCtx, {
            type: 'bar',
            data: {
                labels: ['Product A', 'Product B', 'Product C', 'Product D', 'Product E'],
                datasets: [{
                    label: 'Sales Volume',
                    data: [65, 59, 80, 81, 56],
                    backgroundColor: [
                        'rgba(26, 42, 128, 0.8)',
                        'rgba(59, 56, 160, 0.8)',
                        'rgba(17, 63, 103, 0.8)',
                        'rgba(52, 105, 154, 0.8)',
                        'rgba(21, 77, 113, 0.8)'
                    ],
                    borderColor: [
                        '#1A2A80',
                        '#3B38A0',
                        '#113F67',
                        '#34699A',
                        '#154D71'
                    ],
                    borderWidth: 1,
                    borderRadius: 6
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: {
                            color: 'rgba(0,0,0,0.05)'
                        }
                    },
                    x: {
                        grid: {
                            display: false
                        }
                    }
                }
            }
        });

        // Update charts with real data
        function updateCharts(salesData, productData) {
            salesChart.data.labels = salesData.labels || [];
            salesChart.data.datasets[0].data = salesData.data || [];
            salesChart.update();

            productChart.data.labels = productData.labels || [];
            productChart.data.datasets[0].data = productData.data || [];
            const backgroundPalette = (productData.colors && productData.colors.length ? productData.colors : productChart
                .data.datasets[0].backgroundColor);
            productChart.data.datasets[0].backgroundColor = productChart.data.labels.map((_, idx) => backgroundPalette[idx %
                backgroundPalette.length]);
            productChart.update();
        }
    </script>

    <!-- Your existing JavaScript functions with modifications -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            PartialDaat();
            fetchInitialSales();
            HighestSellingProducts({
                preventDefault: () => {}
            });
            PaymentStatus();
            DashboardOverview();
            fetchExpenses();
        });

        // Fetch initial sales data
        async function fetchInitialSales() {
            try {
                const formData = new FormData();
                const today = new Date();
                const firstDay = new Date(today.getFullYear(), today.getMonth(), 1);

                const fromInput = document.querySelector('#TotalSalesForm input[name="from"]');
                const toInput = document.querySelector('#TotalSalesForm input[name="to"]');
                if (fromInput && !fromInput.value) {
                    fromInput.value = firstDay.toISOString().split('T')[0];
                }
                if (toInput && !toInput.value) {
                    toInput.value = today.toISOString().split('T')[0];
                }

                formData.append('from', firstDay.toISOString().split('T')[0]);
                formData.append('to', today.toISOString().split('T')[0]);
                formData.append('_token', document.querySelector('input[name="_token"]').value);

                const response = await fetch('/total_sales', {
                    method: 'POST',
                    body: formData
                });

                const responseData = await response.json();
                if (response.ok) {
                    updateSalesDisplay(responseData.success);
                    await loadSalesCharts();
                }
            } catch (e) {
                console.error('Error fetching initial sales:', e);
            }
        }

        async function PartialDaat() {
            try {
                const response = await fetch('/partial_payment_data');
                const responseData = await response.json();

                if (response.ok) {
                    document.querySelector('#TotalPartiallyPaid').innerHTML = responseData.partially;
                    document.querySelector('#TotalPartiallyPending').innerHTML = responseData.partially;
                } else {
                    toastr.error(responseData);
                }
            } catch (e) {
                toastr.error(`API EXCEPTION : ${e}`);
            }
        }

        async function TotalSales(e) {
            e.preventDefault();
            const form = document.querySelector('#TotalSalesForm');
            const formData = new FormData(form);

            try {
                const response = await fetch('/total_sales', {
                    method: 'POST',
                    body: formData
                });

                const responseData = await response.json();
                if (response.ok) {
                    updateSalesDisplay(responseData.success);
                    await loadSalesCharts();
                } else {
                    toastr.error(responseData.error);
                }
            } catch (e) {
                toastr.error('API Exception Error ', e);
            }
        }

        function updateSalesDisplay(amount) {
            const salesElement = document.querySelector('#Total_Sales');
            const currentSalesElement = document.querySelector('#CurrentSalesDisplay');

            const formattedAmount = parseFloat(amount).toLocaleString('en-IN', {
                minimumFractionDigits: 2,
                maximumFractionDigits: 2
            });

            salesElement.textContent = formattedAmount;
            currentSalesElement.textContent = formattedAmount;

            salesElement.classList.add('animate__animated', 'animate__pulse');
            currentSalesElement.classList.add('animate__animated', 'animate__pulse');

            setTimeout(() => {
                salesElement.classList.remove('animate__animated', 'animate__pulse');
                currentSalesElement.classList.remove('animate__animated', 'animate__pulse');
            }, 1000);
        }

        async function loadSalesCharts() {
            const form = document.querySelector('#TotalSalesForm');
            const formData = new FormData(form);

            try {
                const response = await fetch('/sales_chart_data', {
                    method: 'POST',
                    body: formData
                });

                const responseData = await response.json();
                if (response.ok) {
                    const palette = [
                        'rgba(26, 42, 128, 0.8)',
                        'rgba(59, 56, 160, 0.8)',
                        'rgba(17, 63, 103, 0.8)',
                        'rgba(52, 105, 154, 0.8)',
                        'rgba(21, 77, 113, 0.8)',
                        'rgba(15, 99, 128, 0.8)',
                        'rgba(32, 86, 179, 0.8)',
                        'rgba(14, 66, 120, 0.8)'
                    ];

                    const productColors = (responseData.products && responseData.products.data ? responseData.products
                        .data : []).map((_, idx) => palette[idx % palette.length]);

                    updateCharts(
                        responseData.sales || {
                            labels: [],
                            data: []
                        }, {
                            labels: responseData.products ? responseData.products.labels : [],
                            data: responseData.products ? responseData.products.data : [],
                            colors: productColors
                        }
                    );
                } else {
                    toastr.error(responseData.error || 'Failed to load sales charts');
                }
            } catch (e) {
                console.error('Error fetching chart data:', e);
            }
        }

        async function HighestSellingProducts(e) {
            e.preventDefault();
            const form = document.querySelector('#HighestSellingProductsForm');
            const formData = new FormData(form);

            try {
                const response = await fetch('/highest_selling_products', {
                    method: 'POST',
                    body: formData
                });

                const responseData = await response.json();
                if (response.ok) {
                    const container = document.querySelector('#Highest_Selling_Products');
                    container.innerHTML = '';

                    if (responseData.success.length === 0) {
                        container.innerHTML = `
                            <tr>
                                <td colspan="4" class="py-8 text-center text-gray-500">No products found</td>
                            </tr>
                        `;
                        return;
                    }

                    responseData.success.forEach((product, index) => {
                        const performance = product.total_sales > 1000 ? 'Excellent' :
                            product.total_sales > 500 ? 'Good' : 'Average';
                        const bgColor = performance === 'Excellent' ? 'bg-green-100 text-green-800' :
                            performance === 'Good' ? 'bg-yellow-100 text-yellow-800' :
                            'bg-gray-100 text-gray-800';

                        const formattedSales = parseFloat(product.total_sales).toLocaleString('en-IN', {
                            minimumFractionDigits: 2,
                            maximumFractionDigits: 2
                        });

                        container.innerHTML += `
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="py-4 px-6">${index + 1}</td>
                                <td class="py-4 px-6 font-medium">${product.name}</td>
                                <td class="py-4 px-6 font-semibold rupee">${formattedSales}</td>
                                <td class="py-4 px-6">
                                    <span class="px-3 py-1 rounded-full text-sm font-medium ${bgColor}">
                                        ${performance}
                                    </span>
                                </td>
                            </tr>
                        `;
                    });
                } else {
                    toastr.error(responseData.error);
                }
            } catch (e) {
                toastr.error('API Exception Error ', e);
            }
        }

        async function PaymentStatus() {
            try {
                const response = await fetch('/unpaid_cus');
                const responseData = await response.json();

                if (response.ok) {
                    // Update pending payments
                    const pendingContainer = document.querySelector('#PartiallyPayment');
                    pendingContainer.innerHTML = '';

                    if (responseData.pending && responseData.pending.length > 0) {
                        responseData.pending.forEach((customer, index) => {
                            const formattedAmount = parseFloat(customer.total_price).toLocaleString('en-IN', {
                                minimumFractionDigits: 2,
                                maximumFractionDigits: 2
                            });

                            pendingContainer.innerHTML += `
                                <tr class="hover:bg-red-50 transition-colors">
                                    <td class="py-4 px-6">${index + 1}</td>
                                    <td class="py-4 px-6 font-medium">${customer.customer_name}</td>
                                    <td class="py-4 px-6">
                                        <span class="px-3 py-1 bg-red-100 text-red-700 rounded-full text-sm">
                                            ${customer.payment_mode}
                                        </span>
                                    </td>
                                    <td class="py-4 px-6 font-semibold text-red-600 rupee">
                                        ${formattedAmount}
                                    </td>
                                </tr>
                            `;
                        });
                    }

                    // Update partially paid
                    const partiallyContainer = document.querySelector('#PendingPayment');
                    partiallyContainer.innerHTML = '';

                    if (responseData.partially && responseData.partially.length > 0) {
                        responseData.partially.forEach((customer, index) => {
                            const dueAmount = customer.total_price - customer.partial_amount;
                            const formattedPartial = parseFloat(customer.partial_amount).toLocaleString(
                                'en-IN', {
                                    minimumFractionDigits: 2,
                                    maximumFractionDigits: 2
                                });
                            const formattedDue = parseFloat(dueAmount).toLocaleString('en-IN', {
                                minimumFractionDigits: 2,
                                maximumFractionDigits: 2
                            });
                            const formattedTotal = parseFloat(customer.total_price).toLocaleString('en-IN', {
                                minimumFractionDigits: 2,
                                maximumFractionDigits: 2
                            });

                            partiallyContainer.innerHTML += `
                                <tr class="hover:bg-yellow-50 transition-colors">
                                    <td class="py-4 px-6">${index + 1}</td>
                                    <td class="py-4 px-6 font-medium">${customer.customer_name}</td>
                                    <td class="py-4 px-6">
                                        <span class="px-3 py-1 bg-yellow-100 text-yellow-700 rounded-full text-sm">
                                            ${customer.payment_status}
                                        </span>
                                    </td>
                                    <td class="py-4 px-6 text-green-600 font-medium rupee">
                                        ${formattedPartial}
                                    </td>
                                    <td class="py-4 px-6 text-red-600 font-medium rupee">
                                        ${formattedDue}
                                    </td>
                                    <td class="py-4 px-6 font-semibold rupee">
                                        ${formattedTotal}
                                    </td>
                                </tr>
                            `;
                        });
                    }

                    // Update counters
                    document.querySelector('#TotalPendingCustomers').textContent =
                        responseData.pending ? responseData.pending.length : 0;
                    document.querySelector('#TotalPartiallyCustomers').textContent =
                        responseData.partially ? responseData.partially.length : 0;
                }
            } catch (e) {
                toastr.error('API Exception Error ', e);
            }
        }

        async function DashboardOverview() {
            try {
                const response = await fetch('/overview');
                const responseData = await response.json();

                if (response.ok) {
                    // Update stock information
                    const elements = [{
                            id: 'TotalExpired',
                            value: responseData.expiry?.length || 0
                        },
                        {
                            id: 'TotalExpiresSoon',
                            value: responseData.expires?.length || 0
                        },
                        {
                            id: 'TotalProductsUnits',
                            value: responseData.totalProducts || 0
                        },
                        {
                            id: 'HighestStock',
                            value: responseData.highestStock?.name || '-'
                        },
                        {
                            id: 'HighestStockUnits',
                            value: responseData.highestStock?.units_per_carton || 0
                        },
                        {
                            id: 'LowestStock',
                            value: responseData.lowestStock?.name || '-'
                        },
                        {
                            id: 'LowestStockUnits',
                            value: responseData.lowestStock?.units_per_carton || 0
                        }
                    ];

                    elements.forEach(el => {
                        const element = document.getElementById(el.id);
                        if (element) {
                            element.textContent = el.value;
                            element.classList.add('animate__animated', 'animate__fadeIn');
                            setTimeout(() => element.classList.remove('animate__animated', 'animate__fadeIn'),
                                500);
                        }
                    });

                    // Show notifications
                    if (responseData.expires?.length > 0) {
                        toastr.warning(`${responseData.expires.length} products expiring soon`);
                    }
                    if (responseData.expiry?.length > 0) {
                        toastr.error(`${responseData.expiry.length} products expired`);
                    }
                }
            } catch (e) {
                toastr.error('API Exception Error ', e);
            }
        }

        async function fetchExpenses() {
            const form = document.getElementById('ExpensesForm');
            const tbody = document.getElementById('ExpensesTable');
            const formData = new FormData(form);

            try {
                const response = await fetch('/total_expenses', {
                    method: 'POST',
                    body: formData
                });

                const data = await response.json();

                // Update monthly expenses
                const expensesElement = document.getElementById('ExpensesThisMonth');
                if (expensesElement && data.ExpensesCount) {
                    const formattedAmount = parseFloat(data.ExpensesCount).toLocaleString('en-IN', {
                        minimumFractionDigits: 2,
                        maximumFractionDigits: 2
                    });
                    expensesElement.textContent = formattedAmount;
                    expensesElement.classList.add('animate__animated', 'animate__pulse');
                    setTimeout(() => expensesElement.classList.remove('animate__animated', 'animate__pulse'), 1000);
                }

                // Update expenses table
                tbody.innerHTML = '';

                if (!data.expenses || data.expenses.length === 0) {
                    tbody.innerHTML = `
                        <tr>
                            <td colspan="5" class="py-8 text-center text-gray-500">
                                No expenses found for the selected period
                            </td>
                        </tr>
                    `;
                    return;
                }

                data.expenses.forEach((exp, i) => {
                    const formattedAmount = parseFloat(exp.expense).toLocaleString('en-IN', {
                        minimumFractionDigits: 2,
                        maximumFractionDigits: 2
                    });

                    tbody.innerHTML += `
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="py-4 px-6">${i + 1}</td>
                            <td class="py-4 px-6 font-medium">${exp.expense_name}</td>
                            <td class="py-4 px-6 font-semibold text-red-600 rupee">
                                ${formattedAmount}
                            </td>
                            <td class="py-4 px-6">${exp.date || '-'}</td>
                            <td class="py-4 px-6 text-gray-600">${exp.description || '-'}</td>
                        </tr>
                    `;
                });

            } catch (err) {
                toastr.error('API Error: ' + err.message);
            }
        }
    </script>
</body>

</html>
