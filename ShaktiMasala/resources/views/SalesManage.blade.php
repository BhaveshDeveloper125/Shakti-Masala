<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="meta" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sales Data Dashboard</title>
    <x-cdnlinks />
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        body {
            font-family: 'Poppins', sans-serif;
        }

        .gradient-bg {
            background: linear-gradient(135deg, #1A2A80 0%, #3B38A0 100%);
        }

        .card-gradient {
            background: linear-gradient(135deg, #113F67 0%, #34699A 100%);
        }

        .status-badge {
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 500;
        }

        .status-pending {
            background-color: rgba(255, 193, 7, 0.2);
            color: #ffc107;
        }

        .status-partial {
            background-color: rgba(0, 123, 255, 0.2);
            color: #007bff;
        }

        .table-row-hover:hover {
            background-color: rgba(52, 105, 154, 0.05);
            transition: all 0.2s ease;
        }

        .scrollbar-thin {
            scrollbar-width: thin;
            scrollbar-color: #cbd5e0 #f7fafc;
        }

        .scrollbar-thin::-webkit-scrollbar {
            width: 6px;
        }

        .scrollbar-thin::-webkit-scrollbar-track {
            background: #f7fafc;
            border-radius: 3px;
        }

        .scrollbar-thin::-webkit-scrollbar-thumb {
            background-color: #cbd5e0;
            border-radius: 3px;
        }
    </style>
</head>

<body class="h-screen w-screen flex bg-gray-50">
    <x-admin-menu />

    <div class="flex-1 flex flex-col overflow-hidden">
        <!-- Header -->
        <header class="gradient-bg text-white py-4 px-6 shadow-lg">
            <div class="flex justify-between items-center">
                <h1 class="text-2xl font-bold">Sales Dashboard</h1>
                <div class="flex items-center space-x-4">
                    <!-- <div class="relative">
                        <input type="text" placeholder="Search invoices..." class="bg-white/20 text-white placeholder-white/70 rounded-lg pl-10 pr-4 py-2 focus:outline-none focus:ring-2 focus:ring-white/50">
                        <svg class="w-5 h-5 absolute left-3 top-2.5 text-white/70" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </div> -->
                    <div class="flex items-center space-x-2 bg-white/10 rounded-lg px-3 py-1.5">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <span id="current-date" class="text-white font-medium"></span>
                    </div>
                </div>
            </div>
        </header>

        <!-- Main Content -->
        <main class="flex-1 overflow-auto p-6">
            <!-- Summary Cards -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                <div class="card-gradient rounded-xl shadow-lg text-white p-6">
                    <div class="flex justify-between items-start">
                        <div>
                            <p class="text-white/80 text-sm font-medium">Pending Payments</p>
                            <h2 class="text-3xl font-bold mt-2" id="pending-count">0</h2>
                            <p class="text-white/70 text-xs mt-1">Customers awaiting payment</p>
                        </div>
                        <!-- <div class="bg-white/20 p-3 rounded-full">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                            </svg>
                        </div> -->
                    </div>
                </div>

                <div class="bg-white rounded-xl shadow-lg p-6 border-l-4 border-[#3B38A0]">
                    <div class="flex justify-between items-start">
                        <div>
                            <p class="text-gray-500 text-sm font-medium">Partially Paid</p>
                            <h2 class="text-3xl font-bold mt-2 text-gray-800" id="partial-count">0</h2>
                            <p class="text-gray-500 text-xs mt-1">Customers with partial payments</p>
                        </div>
                        <div class="bg-[#3B38A0]/10 p-3 rounded-full">
                            <svg class="w-6 h-6 text-[#3B38A0]" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                            </svg>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-xl shadow-lg p-6 border-l-4 border-[#154D71]">
                    <div class="flex justify-between items-start">
                        <div>
                            <p class="text-gray-500 text-sm font-medium">Total Due Amount(pending + partially due Amount)</p>
                            <h2 class="text-3xl font-bold mt-2 text-gray-800" id="total-due">₹0</h2>
                            <p class="text-gray-500 text-xs mt-1">Combined outstanding balance</p>
                        </div>
                        <div class="bg-[#154D71]/10 p-3 rounded-full">
                            <svg class="w-6 h-6 text-[#154D71]" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tabs for Pending and Partially Paid -->
            <div class="bg-white rounded-xl shadow-lg overflow-hidden mb-8">
                <div class="border-b border-gray-200">
                    <nav class="flex -mb-px">
                        <button id="pending-tab" class="py-4 px-6 text-center border-b-2 border-[#1A2A80] font-medium text-[#1A2A80] flex-1">
                            Pending Payments
                        </button>
                        <button id="partial-tab" class="py-4 px-6 text-center border-b-2 border-transparent font-medium text-gray-500 hover:text-gray-700 flex-1">
                            Partially Paid
                        </button>
                    </nav>
                </div>

                <!-- Pending Payments Table -->
                <div id="pending-section" class="p-0">
                    <!-- <div class="p-6 pb-4 flex justify-between items-center">
                        <h2 class="text-lg font-semibold text-gray-800">Pending Payment Customers</h2>
                        <div class="flex space-x-2">
                            <button class="bg-gray-100 hover:bg-gray-200 text-gray-700 px-3 py-1.5 rounded-lg text-sm font-medium flex items-center">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path>
                                </svg>
                                Filter
                            </button>
                            <button class="bg-gray-100 hover:bg-gray-200 text-gray-700 px-3 py-1.5 rounded-lg text-sm font-medium flex items-center">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M3 14h18m-9-4v8m-7 0h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"></path>
                                </svg>
                                Export
                            </button>
                        </div>
                    </div> -->

                    <div class="overflow-x-auto scrollbar-thin">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Invoice</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Customer</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Payment Mode</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Due Amount</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total Amount</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                                </tr>
                            </thead>
                            <tbody id="pending_data" class="bg-white divide-y divide-gray-200"></tbody>
                        </table>
                    </div>
                </div>

                <!-- Partially Paid Table (Hidden by default) -->
                <div id="partial-section" class="hidden p-0">
                    <!-- <div class="p-6 pb-4 flex justify-between items-center">
                        <h2 class="text-lg font-semibold text-gray-800">Partially Paid Customers</h2>
                        <div class="flex space-x-2">
                            <button class="bg-gray-100 hover:bg-gray-200 text-gray-700 px-3 py-1.5 rounded-lg text-sm font-medium flex items-center">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path>
                                </svg>
                                Filter
                            </button>
                            <button class="bg-gray-100 hover:bg-gray-200 text-gray-700 px-3 py-1.5 rounded-lg text-sm font-medium flex items-center">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M3 14h18m-9-4v8m-7 0h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"></path>
                                </svg>
                                Export
                            </button>
                        </div>
                    </div> -->

                    <div class="overflow-x-auto scrollbar-thin">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Invoice</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Customer</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Payment Mode</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Paid Amount</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Due Amount</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total Amount</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                                </tr>
                            </thead>
                            <tbody id="partially_data" class="bg-white divide-y divide-gray-200"></tbody>
                        </table>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <!-- Getching the Pending and Partially Paid Customer Details -->
    <script>
        // Set current date
        document.getElementById('current-date').textContent = new Date().toLocaleDateString('en-US', {
            weekday: 'long',
            year: 'numeric',
            month: 'long',
            day: 'numeric'
        });

        // Tab functionality
        document.getElementById('pending-tab').addEventListener('click', function() {
            document.getElementById('pending-section').classList.remove('hidden');
            document.getElementById('partial-section').classList.add('hidden');
            document.getElementById('pending-tab').classList.add('border-[#1A2A80]', 'text-[#1A2A80]');
            document.getElementById('pending-tab').classList.remove('border-transparent', 'text-gray-500');
            document.getElementById('partial-tab').classList.add('border-transparent', 'text-gray-500');
            document.getElementById('partial-tab').classList.remove('border-[#1A2A80]', 'text-[#1A2A80]');
        });

        document.getElementById('partial-tab').addEventListener('click', function() {
            document.getElementById('partial-section').classList.remove('hidden');
            document.getElementById('pending-section').classList.add('hidden');
            document.getElementById('partial-tab').classList.add('border-[#1A2A80]', 'text-[#1A2A80]');
            document.getElementById('partial-tab').classList.remove('border-transparent', 'text-gray-500');
            document.getElementById('pending-tab').classList.add('border-transparent', 'text-gray-500');
            document.getElementById('pending-tab').classList.remove('border-[#1A2A80]', 'text-[#1A2A80]');
        });

        async function UnpaidCustomerData() {
            try {
                const response = await fetch(`${window.location.origin}/unpaid_cus`);
                const result = await response.json();

                if (response.ok) {
                    // Update summary cards
                    document.getElementById('pending-count').textContent = result.pending.length;
                    document.getElementById('partial-count').textContent = result.partially.length;

                    // Calculate total due amount
                    let totalDue = 0;
                    result.pending.forEach(i => totalDue += (i.total_price - i.partial_amount));
                    result.partially.forEach(i => totalDue += (i.total_price - i.partial_amount));
                    document.getElementById('total-due').textContent = `₹${totalDue.toLocaleString()}`;

                    // Display Partially Paid Data
                    let partials = document.querySelector('#partially_data');
                    partials.innerHTML = '';
                    result.partially.forEach(i => {
                        let tr = document.createElement('tr');
                        tr.className = 'table-row-hover';

                        tr.innerHTML = `
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="ml-4">
                                        <div class="text-sm font-medium text-gray-900">${i.invoice}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">${i.customer_name}</div>
                                <div class="text-sm text-gray-500">${i.customer_type}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">${i.date}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">${i.payment_mode}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">₹${i.partial_amount.toLocaleString()}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-amber-600">₹${(i.total_price - i.partial_amount).toLocaleString()}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">₹${i.total_price.toLocaleString()}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <a href="partial_emi/${i.invoice}" class="text-[#1A2A80] hover:text-[#3B38A0] font-medium flex items-center">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                    </svg>
                                    Add EMI
                                </a>
                            </td>
                        `;
                        partials.appendChild(tr);
                    });

                    // Display Pending Data
                    let Pending = document.querySelector('#pending_data');
                    Pending.innerHTML = '';
                    result.pending.forEach(i => {
                        let tr = document.createElement('tr');
                        tr.className = 'table-row-hover';

                        tr.innerHTML = `
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="ml-4">
                                        <div class="text-sm font-medium text-gray-900">${i.invoice}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">${i.customer_name}</div>
                                <div class="text-sm text-gray-500">${i.customer_type}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">${i.date}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">${i.payment_mode}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-amber-600">₹${(i.total_price - i.partial_amount).toLocaleString()}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">₹${i.total_price.toLocaleString()}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <a href="partial_emi/${i.invoice}" class="text-[#1A2A80] hover:text-[#3B38A0] font-medium flex items-center">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                    </svg>
                                    Add EMI
                                </a>
                            </td>
                        `;
                        Pending.appendChild(tr);
                    });
                } else {
                    toastr.error(result.error);
                }

            } catch (error) {
                toastr.error(error);
            }
        }

        document.addEventListener('DOMContentLoaded', UnpaidCustomerData);
    </script>

</body>

</html>