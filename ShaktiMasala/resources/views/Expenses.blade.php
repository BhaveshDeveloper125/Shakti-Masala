<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Expense Management</title>
    <x-cdnlinks />
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap');

        body {
            font-family: 'Inter', sans-serif;
        }

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

        .input-focus:focus {
            border-color: #1A2A80;
            box-shadow: 0 0 0 3px rgba(26, 42, 128, 0.1);
        }
    </style>
</head>

<body class="bg-gray-50 min-h-screen flex">
    <x-admin-menu />

    <!-- Main Content -->
    <div class="flex-1 p-8 overflow-auto">
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-800 mb-2">Expense Management</h1>
            <p class="text-gray-600">Track and manage all your expenses in one place</p>
        </div>

        <!-- Add Expense Card -->
        <div class="bg-white rounded-xl shadow-lg border border-gray-100 p-6 mb-8">
            <h2 class="text-xl font-semibold text-gray-800 mb-6 flex items-center">
                <i class="fas fa-plus-circle mr-3 text-[#1A2A80]"></i>
                Add New Expense
            </h2>

            <form method="post" id="ExpenseForm" class="space-y-6">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            <i class="fas fa-tag mr-2 text-[#34699A]"></i>
                            Expense Name
                        </label>
                        <input type="text" name="expense_name" placeholder="Enter expense name"
                            class="w-full px-4 py-3 rounded-lg border border-gray-300 input-focus transition-colors focus:outline-none"
                            required>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            <i class="fas fa-indian-rupee-sign mr-2 text-[#34699A]"></i>
                            Amount
                        </label>
                        <input type="number" name="expense" min="0" placeholder="Enter amount"
                            class="w-full px-4 py-3 rounded-lg border border-gray-300 input-focus transition-colors focus:outline-none"
                            required>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            <i class="fas fa-calendar mr-2 text-[#34699A]"></i>
                            Date
                        </label>
                        <input type="date" name="date"
                            class="w-full px-4 py-3 rounded-lg border border-gray-300 input-focus transition-colors focus:outline-none"
                            required>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            <i class="fas fa-align-left mr-2 text-[#34699A]"></i>
                            Description (Optional)
                        </label>
                        <textarea name="description" placeholder="Enter description"
                            class="w-full px-4 py-3 rounded-lg border border-gray-300 input-focus transition-colors focus:outline-none resize-none"
                            rows="1"></textarea>
                    </div>
                </div>

                <div class="flex justify-end">
                    <button type="submit" id="expense_button"
                        class="gradient-bg text-white px-8 py-3 rounded-lg font-semibold hover:opacity-90 transition-all duration-300 transform hover:scale-105 flex items-center">
                        <i class="fas fa-plus mr-2"></i>
                        Add Expense
                    </button>
                </div>
            </form>
        </div>

        <!-- Expense List Card -->
        <div class="bg-white rounded-xl shadow-lg border border-gray-100 overflow-hidden">
            <div class="p-6 border-b border-gray-200">
                <h2 class="text-xl font-semibold text-gray-800 flex items-center">
                    <i class="fas fa-receipt mr-3 text-[#1A2A80]"></i>
                    Expense History
                </h2>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="bg-gray-50 text-gray-700 text-sm">
                            <th class="py-4 px-6 text-left font-medium uppercase tracking-wider">
                                <i class="fas fa-tag mr-2"></i>Name
                            </th>
                            <th class="py-4 px-6 text-left font-medium uppercase tracking-wider">
                                <i class="fas fa-indian-rupee-sign mr-2"></i>Amount
                            </th>
                            <th class="py-4 px-6 text-left font-medium uppercase tracking-wider">
                                <i class="fas fa-calendar mr-2"></i>Date
                            </th>
                            <th class="py-4 px-6 text-left font-medium uppercase tracking-wider">
                                <i class="fas fa-align-left mr-2"></i>Description
                            </th>
                            <th class="py-4 px-6 text-left font-medium uppercase tracking-wider">
                                <i class="fas fa-clock mr-2"></i>Entry Date
                            </th>
                        </tr>
                    </thead>
                    <tbody id="expense_body" class="divide-y divide-gray-100">
                        <!-- Data will be populated here -->
                    </tbody>
                </table>
            </div>

            <!-- Loading State -->
            <div id="loading" class="p-8 text-center">
                <div class="inline-block animate-spin rounded-full h-8 w-8 border-t-2 border-b-2 border-[#1A2A80]"></div>
                <p class="mt-2 text-gray-500">Loading expenses...</p>
            </div>

            <!-- Empty State -->
            <div id="emptyState" class="hidden p-8 text-center">
                <i class="fas fa-receipt text-4xl text-gray-300 mb-4"></i>
                <h3 class="text-lg font-medium text-gray-700 mb-2">No expenses found</h3>
                <p class="text-gray-500">Start by adding your first expense above</p>
            </div>
        </div>

        <!-- Pagination -->
        <div id="pagination" class="mt-6 flex justify-center items-center space-x-2">
            <!-- Pagination buttons will be populated here -->
        </div>
    </div>

    <script>
        // Add Expense
        document.querySelector('#expense_button').addEventListener('click', async (e) => {
            e.preventDefault();
            const button = document.querySelector('#expense_button');
            const originalText = button.innerHTML;

            // Show loading state
            button.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Adding...';
            button.disabled = true;

            const formData = new FormData(document.querySelector('#ExpenseForm'));

            try {
                const response = await fetch('/add_expense', {
                    method: 'POST',
                    body: formData
                });
                const data = await response.json();

                if (response.ok) {
                    toastr.success(data.success);
                    document.querySelector('#ExpenseForm').reset();
                    // Refresh the expense list
                    GetCustomerData();
                } else {
                    toastr.error(data.error);
                }
            } catch (e) {
                toastr.error('API Exception Error');
            } finally {
                // Restore button state
                button.innerHTML = originalText;
                button.disabled = false;
            }
        });

        // Fetch Expenses
        let BaseUrl = `${window.location.origin}/expense`;

        async function GetCustomerData() {
            const tbody = document.querySelector('#expense_body');
            const paginationContainer = document.querySelector('#pagination');
            const loading = document.querySelector('#loading');
            const emptyState = document.querySelector('#emptyState');

            // Show loading, hide empty state
            loading.classList.remove('hidden');
            emptyState.classList.add('hidden');
            tbody.innerHTML = '';

            try {
                const response = await fetch(BaseUrl);
                const result = await response.json();

                // Hide loading indicator
                loading.classList.add('hidden');

                paginationContainer.innerHTML = '';

                // Create pagination buttons
                if (result.expenses && result.expenses.links) {
                    result.expenses.links.forEach((link, index) => {
                        if (index === 0) return;

                        let button = document.createElement('button');
                        button.innerText = link.label;
                        button.className = `px-4 py-2 rounded-lg border transition-colors ${
                            link.active 
                                ? 'bg-[#1A2A80] text-white border-[#1A2A80]' 
                                : 'border-gray-300 text-gray-700 hover:bg-gray-50'
                        }`;

                        button.addEventListener('click', () => {
                            BaseUrl = link.url;
                            tbody.innerHTML = '';
                            GetCustomerData();
                        });

                        paginationContainer.appendChild(button);
                    });
                }

                // Handle empty data
                if (!result.expenses || !result.expenses.data || result.expenses.data.length === 0) {
                    emptyState.classList.remove('hidden');
                    return;
                }

                // Populate table with expense data
                result.expenses.data.forEach(i => {
                    let tr = document.createElement('tr');
                    tr.className = 'table-row-hover transition-colors';

                    tr.innerHTML = `
                        <td class="py-4 px-6">
                            <div class="flex items-center">
                                <div class="w-10 h-10 rounded-lg bg-[#1A2A80] bg-opacity-10 flex items-center justify-center mr-3">
                                    <i class="fas fa-receipt text-[#1A2A80]"></i>
                                </div>
                                <span class="font-medium text-gray-900">${i.expense_name}</span>
                            </div>
                        </td>
                        <td class="py-4 px-6">
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold bg-red-100 text-red-800">
                                <i class="fas fa-indian-rupee-sign mr-1"></i>${i.expense}
                            </span>
                        </td>
                        <td class="py-4 px-6 text-gray-600">${new Date(i.date).toLocaleDateString()}</td>
                        <td class="py-4 px-6 text-gray-600">${i.description || '-'}</td>
                        <td class="py-4 px-6 text-gray-500 text-sm">${new Date(i.created_at).toLocaleDateString()}</td>
                    `;
                    tbody.append(tr);
                });

            } catch (error) {
                console.error('Error fetching expenses:', error);
                loading.classList.add('hidden');
                toastr.error('Failed to load expenses');
            }
        }

        document.addEventListener('DOMContentLoaded', GetCustomerData);
    </script>
</body>

</html>