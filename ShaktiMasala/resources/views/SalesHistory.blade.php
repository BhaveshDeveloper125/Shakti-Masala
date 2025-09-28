<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sales History</title>
    <x-cdnlinks />
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#1A2A80',
                        secondary: '#3B38A0',
                        accent: '#113F67',
                        info: '#34699A',
                        dark: '#154D71',
                        highlight: '#001BB7'
                    }
                }
            }
        }
    </script>
    <style>
        .table-row-hover:hover {
            background-color: rgba(26, 42, 128, 0.05);
            transform: translateY(-1px);
            transition: all 0.2s ease;
        }

        .status-paid {
            background-color: rgba(34, 197, 94, 0.1);
            color: #16a34a;
        }

        .status-pending {
            background-color: rgba(251, 191, 36, 0.1);
            color: #d97706;
        }

        .status-failed {
            background-color: rgba(239, 68, 68, 0.1);
            color: #dc2626;
        }

        .payment-mode {
            background-color: rgba(59, 56, 160, 0.1);
            color: #3B38A0;
        }

        .fade-in {
            animation: fadeIn 0.5s ease-in-out;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .stats-card {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .stats-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        }
    </style>
</head>

<body class="bg-gray-50 min-h-screen flex">
    <x-admin-menu />

    <div class="flex-1 p-6 overflow-x-auto">
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-dark mb-2">Sales History</h1>
            <p class="text-gray-600">View and manage all sales transactions</p>
        </div>

        <!-- Filters and Search -->
        <div class="bg-white rounded-xl shadow-sm p-4 mb-6">
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
                <div class="relative w-full md:w-64">
                    <input type="number" min="0" id="search-input" placeholder="Search by invoice or customer..." class="w-full pl-10 pr-4 py-2 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent">
                    <i class="fas fa-search absolute left-3 top-3 text-gray-400"></i>
                </div>

                <div class="flex flex-wrap gap-2">

                </div>
            </div>
        </div>
        <div class="bg-white item-center rounded-xl shadow-sm overflow-hidden fade-in hidden">
            <table id="search_table" class="min-w-full divide-y divide-gray-200 ">
                <thead class="bg-primary text-white">
                    <tr>
                        <th class="px-6 py-4 text-left text-xs font-medium uppercase tracking-wider">Invoice</th>
                        <th class="px-6 py-4 text-left text-xs font-medium uppercase tracking-wider">Customer</th>
                        <th class="px-6 py-4 text-left text-xs font-medium uppercase tracking-wider">Date</th>
                        <th class="px-6 py-4 text-left text-xs font-medium uppercase tracking-wider">Payment Mode</th>
                        <th class="px-6 py-4 text-left text-xs font-medium uppercase tracking-wider">Status</th>
                        <th class="px-6 py-4 text-left text-xs font-medium uppercase tracking-wider">Total Price</th>
                        <th class="px-6 py-4 text-left text-xs font-medium uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody id="search_table_body" class="bg-white divide-y divide-gray-200">
                </tbody>
            </table>
            <br><br><br><br>
        </div>


        <!-- Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6" id="stats-cards">
            <!-- Stats will be populated by JavaScript -->
        </div>

        <!-- Sales Table -->
        <div class="bg-white rounded-xl shadow-sm overflow-hidden fade-in">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-primary text-white">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-medium uppercase tracking-wider">Invoice</th>
                            <th class="px-6 py-4 text-left text-xs font-medium uppercase tracking-wider">Customer</th>
                            <th class="px-6 py-4 text-left text-xs font-medium uppercase tracking-wider">Date</th>
                            <th class="px-6 py-4 text-left text-xs font-medium uppercase tracking-wider">Payment Mode</th>
                            <th class="px-6 py-4 text-left text-xs font-medium uppercase tracking-wider">Status</th>
                            <th class="px-6 py-4 text-left text-xs font-medium uppercase tracking-wider">Total Price</th>
                            <th class="px-6 py-4 text-left text-xs font-medium uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody id="history_table_body" class="bg-white divide-y divide-gray-200">
                        <!-- Data will be populated here -->
                    </tbody>
                </table>
            </div>

            <!-- Loading State -->
            <div id="loading" class="p-8 text-center">
                <i class="fas fa-spinner fa-spin text-primary text-2xl mb-2"></i>
                <p class="text-gray-500">Loading sales data...</p>
            </div>

            <!-- Empty State -->
            <div id="empty-state" class="hidden p-8 text-center">
                <i class="fas fa-inbox text-gray-300 text-4xl mb-4"></i>
                <h3 class="text-lg font-medium text-gray-700">No sales history found</h3>
                <p class="text-gray-500 mt-1">Try adjusting your search or filter to find what you're looking for.</p>
            </div>

            <!-- Pagination -->
            <div id="pagination" class=" px-6 py-4 bg-gray-50 border-t border-gray-200 flex items-center justify-between">
                <div class="text-sm text-gray-700">
                    Showing <span id="start-range">1</span> to <span id="end-range">10</span> of <span id="total-items">0</span> results
                </div>
                <div class="flex space-x-2">
                    <button id="prev-page" class="px-3 py-1 rounded border border-gray-300 bg-white text-gray-700 hover:bg-gray-50 disabled:opacity-50 disabled:cursor-not-allowed">
                        <i class="fas fa-chevron-left"></i>
                    </button>
                    <div id="page-numbers" class="flex space-x-1">
                        <!-- Page numbers will be inserted here -->
                    </div>
                    <button id="next-page" class="px-3 py-1 rounded border border-gray-300 bg-white text-gray-700 hover:bg-gray-50 disabled:opacity-50 disabled:cursor-not-allowed">
                        <i class="fas fa-chevron-right"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Search Starts
        let inp = document.querySelector('#search-input');

        inp.addEventListener('keydown', async (e) => {
            if (e.key === 'Enter') {
                const response = await fetch(`${window.location.origin}/invoice/${inp.value}`);
                const result = await response.json();

                let search_table = document.querySelector('#search_table').parentElement;
                if (response.status == 404) {
                    search_table.classList.remove('hidden');
                    let div = document.createElement('div');
                    div.className = ' p-8 text-center';
                    div.innerHTML = `
                        <i class="fas fa-inbox text-gray-300 text-4xl mb-4"></i>
                        <h3 class="text-lg font-medium text-gray-700">No sales history found</h3>
                        <p class="text-gray-500 mt-1">Try adjusting your search or filter to find what you're looking for.</p>
                `;
                    search_table.appendChild(div);
                } else {
                    populateSearchTable(result.bill);
                }
                console.log();
            }
        });

        function populateSearchTable(data) {
            let search_table = document.querySelector('#search_table').parentElement;
            search_table.classList.remove('hidden');
            let body = document.querySelector('#search_table_body');
            body.innerHTML = '';

            const row = document.createElement('tr');
            row.className = 'table-row-hover fade-in';

            // Format date
            const date = new Date(data.date);
            const formattedDate = date.toLocaleDateString('en-US', {
                year: 'numeric',
                month: 'short',
                day: 'numeric'
            });

            // Determine status class
            let statusClass = '';
            if (data.payment_status === 'Paid') {
                statusClass = 'status-paid';
            } else if (data.payment_status === 'Pending') {
                statusClass = 'status-pending';
            } else {
                statusClass = 'status-failed';
            }

            row.innerHTML = `
        <td class="px-6 py-4 whitespace-nowrap">
            <div class="text-sm font-medium text-primary">${data.invoice}</div>
        </td>
        <td class="px-6 py-4 whitespace-nowrap">
            <div class="text-sm font-medium text-gray-900">${data.customer_name}</div>
            <div class="text-sm text-gray-500">${data.customer_type}</div>
        </td>
        <td class="px-6 py-4 whitespace-nowrap">
            <div class="text-sm text-gray-900">${formattedDate}</div>
        </td>
        <td class="px-6 py-4 whitespace-nowrap">
            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full payment-mode">
                ${data.payment_mode}
            </span>
        </td>
        <td class="px-6 py-4 whitespace-nowrap">
            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full ${statusClass}">
                ${data.payment_status}
            </span>
        </td>
        <td class="px-6 py-4 whitespace-nowrap">
            <div class="text-sm font-bold text-gray-900">₹${parseFloat(data.total_price).toFixed(2)}</div>
            ${data.extra_charges > 0 ? `<div class="text-xs text-gray-500">₹${parseFloat(data.extra_charges).toFixed(2)} charges</div>` : ''}
        </td>
        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
            <button class="text-primary hover:text-secondary mr-3 view-details" data-invoice="${data.invoice}">
                <a href="/bill/${data.id}" target="_blank">Bill</a>
            </button>
        </td>
    `;

            body.appendChild(row);
        }
        // Search ends

        // Global variables
        let currentPage = 1;
        let totalPages = 1;
        let currentFilters = {
            search: '',
            status: '',
            mode: '',
            date: ''
        };

        document.addEventListener('DOMContentLoaded', async () => {
            // Load initial data
            await loadSalesData();

            // Set up event listeners
            document.getElementById('search-input').addEventListener('keyup', function(e) {
                if (e.key === 'Enter') {}
            });

            // Add real-time search with debounce
            let searchTimeout;
            document.getElementById('search-input').addEventListener('input', function() {
                clearTimeout(searchTimeout);
                searchTimeout = setTimeout(() => {}, 500);
            });


        });

        // Function to load sales data from API
        async function loadSalesData(page = 1) {
            try {
                // Show loading state
                document.getElementById('loading').classList.remove('hidden');
                document.getElementById('empty-state').classList.add('hidden');
                document.getElementById('pagination').classList.add('hidden');

                // Build query parameters
                const params = new URLSearchParams({
                    page: page,
                    ...currentFilters
                });

                // Make API call
                const response = await fetch(`${window.location.origin}/history?${params}`);

                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }

                const result = await response.json();

                // Hide loading indicator
                document.getElementById('loading').classList.add('hidden');

                // If no data, show empty state
                if (!result.history || result.history.data.length === 0) {
                    document.getElementById('empty-state').classList.remove('hidden');
                    document.getElementById('history_table_body').innerHTML = '';
                    return;
                }

                // Update global pagination variables
                currentPage = result.history.current_page;
                totalPages = result.history.last_page;

                // Populate table with data
                populateTable(result.history.data);

                // Update stats cards
                updateStatsCards(result.history);

                // Setup pagination
                setupPagination(result.history);

            } catch (error) {
                console.error('Error fetching sales data:', error);
                document.getElementById('loading').classList.add('hidden');

                // Show error message
                document.getElementById('history_table_body').innerHTML = `
                    <tr>
                        <td colspan="7" class="px-6 py-4 text-center text-red-500">
                            <i class="fas fa-exclamation-triangle mr-2"></i>
                            Error loading sales data. Please try again.
                        </td>
                    </tr>
                `;
            }
        }


        // Function to reset filters
        function resetFilters() {
            document.getElementById('search-input').value = '';
            document.getElementById('status-filter').value = '';
            document.getElementById('mode-filter').value = '';
            document.getElementById('date-filter').value = '';

            currentFilters = {
                search: '',
                status: '',
                mode: '',
                date: ''
            };

            loadSalesData(1);
        }

        // Function to populate table with data
        function populateTable(data) {
            const tableBody = document.getElementById('history_table_body');
            tableBody.innerHTML = '';

            data.forEach(item => {
                const row = document.createElement('tr');
                row.className = 'table-row-hover fade-in';

                // Format date
                const date = new Date(item.date);
                const formattedDate = date.toLocaleDateString('en-US', {
                    year: 'numeric',
                    month: 'short',
                    day: 'numeric'
                });

                // Determine status class
                let statusClass = '';
                if (item.payment_status === 'Paid') {
                    statusClass = 'status-paid';
                } else if (item.payment_status === 'Pending') {
                    statusClass = 'status-pending';
                } else {
                    statusClass = 'status-failed';
                }

                row.innerHTML = `
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm font-medium text-primary">${item.invoice}</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm font-medium text-gray-900">${item.customer_name}</div>
                        <div class="text-sm text-gray-500">${item.customer_type}</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm text-gray-900">${formattedDate}</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full payment-mode">
                            ${item.payment_mode}
                        </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full ${statusClass}">
                            ${item.payment_status}
                        </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm font-bold text-gray-900">₹${parseFloat(item.total_price).toFixed(2)}</div>
                        ${item.extra_charges > 0 ? `<div class="text-xs text-gray-500">₹ ${parseFloat(item.extra_charges).toFixed(2)} charges</div>` : ''}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                        <button class="text-primary hover:text-secondary mr-3 view-details" data-invoice="${item.invoice}">
                            <a href="/bill/${item.id}" target="_blank">Bill</a>
                        </button>
                        
                    </td>
                `;

                tableBody.appendChild(row);
            });

            // Add event listeners to action buttons
            document.querySelectorAll('.view-details').forEach(button => {
                button.addEventListener('click', function() {
                    const invoice = this.getAttribute('data-invoice');
                    viewInvoiceDetails(invoice);
                });
            });

            document.querySelectorAll('.download-invoice').forEach(button => {
                button.addEventListener('click', function() {
                    const invoice = this.getAttribute('data-invoice');
                    downloadInvoice(invoice);
                });
            });
        }

        // Function to update stats cards
        function updateStatsCards(historyData) {
            const statsContainer = document.getElementById('stats-cards');

            // Calculate stats from the data
            const totalSales = historyData.data.reduce((sum, item) => sum + parseFloat(item.total_price), 0);
            const completedTransactions = historyData.data.filter(item => item.payment_status === 'Paid').length;
            const pendingPayments = historyData.data.filter(item => item.payment_status === 'Pending').length;
            const avgTransaction = historyData.data.length > 0 ? totalSales / historyData.data.length : 0;

            statsContainer.innerHTML = `
                <div class="bg-white rounded-xl shadow-sm p-4 border-l-4 border-primary stats-card">
                    <div class="flex justify-between items-center">
                        <div>
                            <p class="text-gray-500 text-sm">Total Sales</p>
                            <h3 class="text-2xl font-bold text-dark">₹${totalSales.toFixed(2)}</h3>
                        </div>
                        <div class="bg-primary bg-opacity-10 p-3 rounded-full">
                            <i class="fas fa-dollar-sign text-primary text-xl"></i>
                        </div>
                    </div>
                    <p class="text-green-500 text-sm mt-2"><i class="fas fa-chart-line mr-1"></i> Real-time data</p>
                </div>
                
                <div class="bg-white rounded-xl shadow-sm p-4 border-l-4 border-accent stats-card">
                    <div class="flex justify-between items-center">
                        <div>
                            <p class="text-gray-500 text-sm">Completed Transactions</p>
                            <h3 class="text-2xl font-bold text-dark">${completedTransactions}</h3>
                        </div>
                        <div class="bg-accent bg-opacity-10 p-3 rounded-full">
                            <i class="fas fa-check-circle text-accent text-xl"></i>
                        </div>
                    </div>
                    <p class="text-green-500 text-sm mt-2"><i class="fas fa-chart-line mr-1"></i> Real-time data</p>
                </div>
                
                <div class="bg-white rounded-xl shadow-sm p-4 border-l-4 border-info stats-card">
                    <div class="flex justify-between items-center">
                        <div>
                            <p class="text-gray-500 text-sm">Pending Payments</p>
                            <h3 class="text-2xl font-bold text-dark">${pendingPayments}</h3>
                        </div>
                        <div class="bg-info bg-opacity-10 p-3 rounded-full">
                            <i class="fas fa-clock text-info text-xl"></i>
                        </div>
                    </div>
                    <p class="text-red-500 text-sm mt-2"><i class="fas fa-chart-line mr-1"></i> Real-time data</p>
                </div>
                
                <div class="bg-white rounded-xl shadow-sm p-4 border-l-4 border-highlight stats-card">
                    <div class="flex justify-between items-center">
                        <div>
                            <p class="text-gray-500 text-sm">Avg. Transaction</p>
                            <h3 class="text-2xl font-bold text-dark">₹${avgTransaction.toFixed(2)}</h3>
                        </div>
                        <div class="bg-highlight bg-opacity-10 p-3 rounded-full">
                            <i class="fas fa-chart-bar text-highlight text-xl"></i>
                        </div>
                    </div>
                    <p class="text-green-500 text-sm mt-2"><i class="fas fa-chart-line mr-1"></i> Real-time data</p>
                </div>
            `;
        }

        // Function to setup pagination
        function setupPagination(historyData) {
            const paginationContainer = document.getElementById('pagination');
            paginationContainer.classList.remove('hidden');

            const startRange = document.getElementById('start-range');
            const endRange = document.getElementById('end-range');
            const totalItems = document.getElementById('total-items');
            const prevButton = document.getElementById('prev-page');
            const nextButton = document.getElementById('next-page');
            const pageNumbersContainer = document.getElementById('page-numbers');

            // Set initial values
            const itemsPerPage = historyData.per_page;
            const currentPage = historyData.current_page;
            const totalPages = historyData.last_page;

            startRange.textContent = ((currentPage - 1) * itemsPerPage) + 1;
            endRange.textContent = Math.min(currentPage * itemsPerPage, historyData.total);
            totalItems.textContent = historyData.total;

            // Disable/enable navigation buttons
            prevButton.disabled = currentPage === 1;
            nextButton.disabled = currentPage === totalPages;

            // Generate page numbers
            pageNumbersContainer.innerHTML = '';
            const maxVisiblePages = 5;
            let startPage = Math.max(1, currentPage - Math.floor(maxVisiblePages / 2));
            let endPage = Math.min(totalPages, startPage + maxVisiblePages - 1);

            // Adjust if we're at the end
            if (endPage - startPage + 1 < maxVisiblePages) {
                startPage = Math.max(1, endPage - maxVisiblePages + 1);
            }

            // Add page numbers
            for (let i = startPage; i <= endPage; i++) {
                const pageButton = document.createElement('button');
                pageButton.className = `px-3 py-1 rounded border ${i === currentPage ? 'bg-primary text-white border-primary' : 'border-gray-300 text-gray-700 hover:bg-gray-50'}`;
                pageButton.textContent = i;
                pageButton.addEventListener('click', () => {
                    loadSalesData(i);
                });
                pageNumbersContainer.appendChild(pageButton);
            }

            // Add event listeners for prev/next buttons
            prevButton.addEventListener('click', () => {
                if (currentPage > 1) {
                    loadSalesData(currentPage - 1);
                }
            });

            nextButton.addEventListener('click', () => {
                if (currentPage < totalPages) {
                    loadSalesData(currentPage + 1);
                }
            });
        }

        // Function to view invoice details (placeholder)
        function viewInvoiceDetails(invoice) {
            console.log('');
        }

        // Function to download invoice (placeholder)
        function downloadInvoice(invoice) {
            console.log('');
        }
    </script>
</body>

</html>