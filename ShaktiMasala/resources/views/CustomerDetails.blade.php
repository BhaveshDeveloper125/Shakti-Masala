<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Details</title>
    <x-cdnlinks />
    <style>
        .gradient-bg {
            background: linear-gradient(135deg, #1A2A80 0%, #3B38A0 100%);
        }

        .card-gradient {
            background: linear-gradient(135deg, #113F67 0%, #154D71 100%);
        }

        .hover-gradient:hover {
            background: linear-gradient(135deg, #34699A 0%, #001BB7 100%);
        }

        .table-row-hover:hover {
            background-color: rgba(52, 105, 154, 0.1);
        }
    </style>
</head>

<body class="bg-gray-50 min-h-screen flex">
    <x-admin-menu />

    <!-- Main Content -->
    <div class="flex-1 p-8 overflow-auto">
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-800 mb-2">Customer Details</h1>
            <p class="text-gray-600">View and manage all customer transactions and information</p>
        </div>

        <!-- Filters and Search - Simplified -->
        <div class="bg-white rounded-xl p-6 hidden shadow-lg border border-gray-100 mb-6">
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
                <div class="text-gray-500">
                    <i class="fas fa-filter mr-2"></i>
                    Use column headers to sort data
                </div>

                <button id="exportBtn" class="gradient-bg text-white px-6 py-2 rounded-lg font-medium hover:opacity-90 transition-opacity w-full md:w-auto flex items-center justify-center">
                    <i class="fas fa-download mr-2"></i>
                    Export Data
                </button>
            </div>
        </div>

        <!-- Customer Table -->
        <div class="bg-white rounded-xl shadow-lg border border-gray-100 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="bg-gray-50 text-gray-700 text-sm">
                            <th class="py-4 px-6 text-left font-medium cursor-pointer sortable" data-sort="invoice">
                                Invoice <i class="fas fa-sort ml-1"></i>
                            </th>
                            <th class="py-4 px-6 text-left font-medium cursor-pointer sortable" data-sort="customer_name">
                                Customer Name <i class="fas fa-sort ml-1"></i>
                            </th>
                            <th class="py-4 px-6 text-left font-medium cursor-pointer sortable" data-sort="customer_type">
                                Customer Type <i class="fas fa-sort ml-1"></i>
                            </th>
                            <th class="py-4 px-6 text-left font-medium cursor-pointer sortable" data-sort="date">
                                Date <i class="fas fa-sort ml-1"></i>
                            </th>
                            <th class="py-4 px-6 text-left font-medium">Payment Mode</th>
                            <th class="py-4 px-6 text-left font-medium cursor-pointer sortable" data-sort="payment_status">
                                Payment Status <i class="fas fa-sort ml-1"></i>
                            </th>
                            <th class="py-4 px-6 text-left font-medium cursor-pointer sortable" data-sort="partial_amount">
                                Partial Amount <i class="fas fa-sort ml-1"></i>
                            </th>
                            <th class="py-4 px-6 text-left font-medium">Extra Charges</th>
                            <th class="py-4 px-6 text-left font-medium cursor-pointer sortable" data-sort="total_price">
                                Total Prices <i class="fas fa-sort ml-1"></i>
                            </th>
                            <th class="py-4 px-6 text-left font-medium cursor-pointer sortable" data-sort="created_at">
                                Entry Date <i class="fas fa-sort ml-1"></i>
                            </th>
                        </tr>
                    </thead>
                    <tbody id="customer_details" class="divide-y divide-gray-100">
                        <!-- Data will be populated here -->
                    </tbody>
                </table>
            </div>

            <!-- Loading State -->
            <div id="loading" class="p-8 text-center">
                <div class="inline-block animate-spin rounded-full h-8 w-8 border-t-2 border-b-2 border-[#1A2A80]"></div>
                <p class="mt-2 text-gray-500">Loading customer data...</p>
            </div>

            <!-- Empty State -->
            <div id="emptyState" class="hidden p-8 text-center">
                <i class="fas fa-inbox text-4xl text-gray-300 mb-4"></i>
                <h3 class="text-lg font-medium text-gray-700 mb-2">No customers found</h3>
                <p class="text-gray-500">No customer data available</p>
            </div>

            <!-- Error State -->
            <div id="errorState" class="hidden p-8 text-center">
                <i class="fas fa-exclamation-triangle text-4xl text-red-400 mb-4"></i>
                <h3 class="text-lg font-medium text-gray-700 mb-2">Failed to load data</h3>
                <p class="text-gray-500 mb-4" id="errorMessage">There was an error fetching customer data</p>
                <button id="retryBtn" class="gradient-bg text-white px-4 py-2 rounded-lg font-medium hover:opacity-90 transition-opacity">
                    <i class="fas fa-redo mr-2"></i>Try Again
                </button>
            </div>
        </div>

        <!-- Pagination -->
        <div id="pagination" class="mt-6 flex justify-center items-center space-x-2">
            <!-- Pagination buttons will be populated here -->
        </div>
    </div>
    <script>
        let BaseUrl = `${window.location.origin}/customer_data`;
        let currentSort = 'created_at';
        let currentOrder = 'desc';

        // DOM Elements
        const exportBtn = document.getElementById('exportBtn');
        const retryBtn = document.getElementById('retryBtn');
        const sortableHeaders = document.querySelectorAll('.sortable');

        // Event Listeners
        exportBtn.addEventListener('click', exportData);
        retryBtn.addEventListener('click', GetCustomerData);

        sortableHeaders.forEach(header => {
            header.addEventListener('click', () => {
                const sortField = header.dataset.sort;
                if (currentSort === sortField) {
                    currentOrder = currentOrder === 'asc' ? 'desc' : 'asc';
                } else {
                    currentSort = sortField;
                    currentOrder = 'asc';
                }
                refreshData();
            });
        });

        // Utility Functions
        function buildUrl(baseUrl = BaseUrl) {
            let url = baseUrl;
            const params = new URLSearchParams();

            // Only append sort parameters if we're not using a pagination URL
            if (!url.includes('?')) {
                if (currentSort) params.append('sort', currentSort);
                if (currentOrder) params.append('order', currentOrder);
            } else {
                // If we have a pagination URL with existing params, update them
                const urlObj = new URL(url, window.location.origin);
                const existingParams = new URLSearchParams(urlObj.search);

                if (currentSort) existingParams.set('sort', currentSort);
                else existingParams.delete('sort');

                if (currentOrder) existingParams.set('order', currentOrder);
                else existingParams.delete('order');

                urlObj.search = existingParams.toString();
                return urlObj.toString();
            }

            return params.toString() ? `${url}?${params.toString()}` : url;
        }

        function refreshData() {
            GetCustomerData();
        }

        async function GetCustomerData() {
            const tbody = document.querySelector('#customer_details');
            const paginationContainer = document.querySelector('#pagination');
            const loading = document.querySelector('#loading');
            const emptyState = document.querySelector('#emptyState');
            const errorState = document.querySelector('#errorState');

            // Show loading, hide other states
            loading.classList.remove('hidden');
            emptyState.classList.add('hidden');
            errorState.classList.add('hidden');
            tbody.innerHTML = '';

            try {
                const url = buildUrl();
                console.log('Fetching from:', url); // Debug log

                const response = await fetch(url, {
                    headers: {
                        'Accept': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                });

                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }

                const result = await response.json();
                console.log('API Response:', result); // Debug log

                // Print paginated data to console
                console.log('=== PAGINATED DATA ===');
                console.log('Current Page:', result.customers.current_page);
                console.log('Total Pages:', result.customers.last_page);
                console.log('Per Page:', result.customers.per_page);
                console.log('Total Records:', result.customers.total);
                console.log('Data:', result.customers.data);
                console.log('=====================');

                // Hide loading indicator
                loading.classList.add('hidden');

                // Handle empty data
                if (!result.customers || !result.customers.data || result.customers.data.length === 0) {
                    emptyState.classList.remove('hidden');
                    paginationContainer.innerHTML = '';
                    return;
                }

                // Update stats cards if available
                if (result.stats) {
                    updateStatsCards(result.stats);
                }

                // Clear previous content
                tbody.innerHTML = '';
                paginationContainer.innerHTML = '';

                // Create pagination buttons
                if (result.customers.links && result.customers.links.length > 0) {
                    result.customers.links.forEach((link) => {
                        if (link.url === null) return;

                        let button = document.createElement('button');
                        button.innerHTML = link.label.replace('&laquo;', '«').replace('&raquo;', '»');
                        button.className = `px-4 py-2 rounded-lg border transition-colors ${
                        link.active 
                            ? 'bg-[#1A2A80] text-white border-[#1A2A80]' 
                            : 'border-gray-300 text-gray-700 hover:bg-gray-50'
                    } ${link.url === null ? 'opacity-50 cursor-not-allowed' : ''}`;

                        if (link.url !== null) {
                            button.addEventListener('click', () => {
                                console.log('Pagination clicked:', link.url); // Debug log
                                // Set BaseUrl to the pagination URL
                                BaseUrl = link.url;
                                GetCustomerData();
                            });
                        }

                        paginationContainer.appendChild(button);
                    });
                }

                // Populate table with customer data
                result.customers.data.forEach(i => {
                    let tr = document.createElement('tr');
                    tr.className = 'table-row-hover transition-colors';

                    // Determine status badge class
                    let statusClass = '';
                    if (i.payment_status === 'Paid') {
                        statusClass = 'bg-green-100 text-green-800';
                    } else if (i.payment_status === 'Pending') {
                        statusClass = 'bg-yellow-100 text-yellow-800';
                    } else {
                        statusClass = 'bg-red-100 text-red-800';
                    }

                    tr.innerHTML = `
                <td class="py-4 px-6 font-medium text-gray-900">${i.invoice || '-'}</td>
                <td class="py-4 px-6">
                    <div class="flex items-center">
                        <div class="w-8 h-8 rounded-full bg-[#1A2A80] flex items-center justify-center text-white text-sm font-medium mr-3">
                            ${(i.customer_name || '?').charAt(0).toUpperCase()}
                        </div>
                        <span>${i.customer_name || 'Unknown'}</span>
                    </div>
                </td>
                <td class="py-4 px-6">
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium ${getCustomerTypeClass(i.customer_type)}">
                        ${i.customer_type || 'Regular'}
                    </span>
                </td>
                <td class="py-4 px-6 text-gray-500">${formatDate(i.date) || '-'}</td>
                <td class="py-4 px-6">
                    <div class="flex items-center">
                        <i class="${getPaymentModeIcon(i.payment_mode)} mr-2 text-gray-500"></i>
                        <span>${i.payment_mode || '-'}</span>
                    </div>
                </td>
                <td class="py-4 px-6">
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium ${statusClass}">
                        ${i.payment_status || 'Unknown'}
                    </span>
                </td>
                <td class="py-4 px-6 font-medium text-gray-900">${formatCurrency(i.partial_amount) || '₹0.00'}</td>
                <td class="py-4 px-6 text-gray-500">${formatCurrency(i.extra_charges) || '₹0.00'}</td>
                <td class="py-4 px-6 font-bold text-gray-900">${formatCurrency(i.total_price) || '₹0.00'}</td>
                <td class="py-4 px-6 text-gray-500">${formatDate(i.created_at) || '-'}</td>
            `;
                    tbody.append(tr);
                });

            } catch (error) {
                console.error('Error fetching customer data:', error);
                loading.classList.add('hidden');
                errorState.classList.remove('hidden');
                document.getElementById('errorMessage').textContent = error.message;
            }
        }

        function getCustomerTypeClass(type) {
            switch (type) {
                case 'VIP':
                    return 'bg-purple-100 text-purple-800';
                case 'Wholesale':
                    return 'bg-blue-100 text-blue-800';
                default:
                    return 'bg-gray-100 text-gray-800';
            }
        }

        function getPaymentModeIcon(mode) {
            switch (mode) {
                case 'Credit Card':
                    return 'fas fa-credit-card';
                case 'PayPal':
                    return 'fab fa-paypal';
                case 'Bank Transfer':
                    return 'fas fa-university';
                default:
                    return 'fas fa-money-bill';
            }
        }

        function formatDate(dateString) {
            if (!dateString) return '-';
            try {
                const date = new Date(dateString);
                return date.toLocaleDateString();
            } catch (e) {
                return '-';
            }
        }

        function formatCurrency(amount) {
            if (!amount) return '₹0.00';
            if (typeof amount === 'string' && amount.startsWith('₹')) return amount;
            if (typeof amount === 'string' && amount.startsWith('$')) {
                // Convert dollar to rupee if needed (assuming 1$ = 83₹ for display purposes)
                const numericValue = parseFloat(amount.replace('$', ''));
                return `₹${(numericValue * 83).toFixed(2)}`;
            }
            try {
                return `₹${parseFloat(amount).toFixed(2)}`;
            } catch (e) {
                return '₹0.00';
            }
        }

        function updateStatsCards(stats) {
            if (stats.total_customers) document.getElementById('totalCustomers').textContent = stats.total_customers;
            if (stats.pending_payments) document.getElementById('pendingPayments').textContent = formatCurrency(stats.pending_payments);
            if (stats.completed_orders) document.getElementById('completedOrders').textContent = stats.completed_orders;
            if (stats.avg_order_value) document.getElementById('avgOrderValue').textContent = formatCurrency(stats.avg_order_value);
        }

        function exportData() {
            // Implement export functionality
            alert('Export functionality would be implemented here');
        }

        document.addEventListener('DOMContentLoaded', GetCustomerData);
    </script>
</body>

</html>