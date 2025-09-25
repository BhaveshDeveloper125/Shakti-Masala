<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Partially Paid Entries</title>
    <x-cdnlinks />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#1A2A80',
                        secondary: '#3B38A0',
                        accent1: '#113F67',
                        accent2: '#34699A',
                        accent3: '#154D71',
                        accent4: '#001BB7',
                    }
                }
            }
        }
    </script>
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

        .form-input {
            transition: all 0.3s ease;
        }

        .form-input:focus {
            box-shadow: 0 0 0 3px rgba(26, 42, 128, 0.1);
        }
    </style>
</head>

<body class="h-screen w-screen flex bg-gray-50">
    <x-admin-menu />

    <div class="flex-1 flex flex-col overflow-hidden">
        <!-- Header -->
        <header class="gradient-bg text-white py-4 px-6 shadow-lg">
            <div class="flex justify-between items-center">
                <h1 class="text-2xl font-bold"></h1>
                <div class="flex items-center space-x-4">
                    <div class="relative">
                        <!-- <input type="text" placeholder="Search..." class="bg-white/20 text-white placeholder-white/70 rounded-lg pl-10 pr-4 py-2 focus:outline-none focus:ring-2 focus:ring-white/50"> -->
                        <!-- <i class="fas fa-search absolute left-3 top-2.5 text-white/70"></i> -->
                    </div>
                    <div class="flex items-center space-x-2 bg-white/10 rounded-lg px-3 py-1.5">
                        <i class="fas fa-calendar-alt text-white"></i>
                        <span id="current-date" class="text-white font-medium">{{ date('F d, Y') }}</span>
                    </div>
                </div>
            </div>
        </header>

        <!-- Main Content -->
        <main class="flex-1 overflow-auto p-6">
            <!-- Customer Summary Card -->
            <div class="bg-white rounded-xl shadow-lg p-6 mb-6 border-l-4 border-primary">
                <div class="flex justify-between items-center mb-4">
                    <h2 class="text-xl font-bold text-gray-800">Customer Summary</h2>
                    <div class="flex space-x-2">
                        <span class="status-badge bg-yellow-100 text-yellow-800">{{ $customer->payment_status }}</span>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-4">
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <p class="text-sm text-gray-500">Invoice</p>
                        <p class="font-semibold text-gray-800">{{ $customer->invoice }}</p>
                    </div>
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <p class="text-sm text-gray-500">Customer Name</p>
                        <p class="font-semibold text-gray-800">{{ $customer->customer_name }}</p>
                    </div>
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <p class="text-sm text-gray-500">Customer Type</p>
                        <p class="font-semibold text-gray-800">{{ $customer->customer_type }}</p>
                    </div>
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <p class="text-sm text-gray-500">Due Amount</p>
                        <p class="font-semibold text-red-600">₹{{ number_format($customer->total_price - $customer->partial_amount, 2) }}</p>
                    </div>
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <p class="text-sm text-gray-500">Total Amount</p>
                        <p class="font-semibold text-gray-800">₹{{ number_format($customer->total_price, 2) }}</p>
                    </div>
                </div>
            </div>

            <!-- Payment Form -->
            <div class="bg-white rounded-xl shadow-lg p-6 mb-6">
                <h2 class="text-xl font-bold text-gray-800 mb-4">Record Payment</h2>
                <form action="/update_unpaid" method="post" id="payment_form" class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="id" id="partially_id" value="{{ $customer->id }}" required>

                    <div>
                        <label for="invoice" class="block text-sm font-medium text-gray-700 mb-1">Invoice Number</label>
                        <input type="number" name="invoice" min="0" id="invoice" value="{{ $customer->invoice }}" required
                            class="w-full form-input rounded-lg border-gray-300 focus:border-primary focus:ring-primary">
                    </div>

                    <div>
                        <label for="partial_amount" class="block text-sm font-medium text-gray-700 mb-1">Payment Amount (₹)</label>
                        <input type="number" name="partial_amount" min="0" id="partial_amount" required
                            class="w-full form-input rounded-lg border-gray-300 focus:border-primary focus:ring-primary"
                            placeholder="Enter Amount">
                    </div>

                    <div class="flex items-end">
                        <button type="submit" id="pay_form" class="w-full bg-primary hover:bg-accent4 text-white font-medium py-2.5 px-4 rounded-lg transition duration-300 flex items-center justify-center">
                            <i class="fas fa-credit-card mr-2"></i> Process Payment
                        </button>
                    </div>
                </form>
            </div>

            <!-- Customer Details Table -->
            <div class="bg-white rounded-xl shadow-lg overflow-hidden mb-6">
                <div class="p-6 pb-4 flex justify-between items-center">
                    <h2 class="text-xl font-bold text-gray-800">Customer Details</h2>
                </div>

                <div class="overflow-x-auto scrollbar-thin">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Invoice</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Customer Name</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Customer Type</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Payment Mode</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Payment Status</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Extra Charges</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Partial Paid Amount</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total Due Amount</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total Payable Amount</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            <tr class="table-row-hover">
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $customer->invoice }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $customer->customer_name }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $customer->customer_type }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $customer->date }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $customer->payment_mode }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="status-badge bg-yellow-100 text-yellow-800">{{ $customer->payment_status }}</span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">₹{{ number_format($customer->extra_charges, 2) }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">₹{{ number_format($customer->partial_amount, 2) }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-red-600">₹{{ number_format($customer->total_price - $customer->partial_amount, 2) }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">₹{{ number_format($customer->total_price, 2) }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Products/Services Table -->
            <div class="bg-white rounded-xl shadow-lg overflow-hidden">
                <div class="p-6 pb-4 flex justify-between items-center">
                    <h2 class="text-xl font-bold text-gray-800">Purchased Items</h2>
                    <div class="flex space-x-2">
                        <button class="bg-gray-100 hover:bg-gray-200 text-gray-700 px-3 py-1.5 rounded-lg text-sm font-medium flex items-center">
                            <i class="fas fa-download mr-1"></i> Export
                        </button>
                    </div>
                </div>

                <div class="overflow-x-auto scrollbar-thin">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Brand</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">MRP</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total Packet</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Price Per Carat</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Packaging Type</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Net Weight</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Net Per Unit</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Units Per Carton</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Batch</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Payable Amount</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">MFG Date</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">EXP Date</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse($customer->sale as $i)
                            <tr class="table-row-hover">
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $i->name }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $i->brand }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">₹{{ number_format($i->mrp, 2) }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $i->total_packet }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">₹{{ number_format($i->price_per_carot, 2) }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $i->packaging_type }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $i->net_weight }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $i->net_per_unit }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $i->units_per_carton }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $i->batch }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">₹{{ number_format($i->payable_amount, 2) }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $i->mfg_date }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $i->exp_date }}</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="13" class="px-6 py-4 text-center text-sm text-gray-500">No items found</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </main>
    </div>

    <script>
        // Set current date
        document.getElementById('current-date').textContent = new Date().toLocaleDateString('en-US', {
            weekday: 'long',
            year: 'numeric',
            month: 'long',
            day: 'numeric'
        });
    </script>
    <script>
        document.querySelector('#pay_form').addEventListener('click', async (e) => {
            try {
                e.preventDefault();
                let form = document.querySelector('#payment_form');
                const formData = new FormData(form);
                const response = await fetch(`${window.location.origin}/update_unpaid`, {
                    method: "POST",
                    body: formData
                });

                const result = await response.json();

                if (response.ok) {
                    toastr.success(result.success);
                    form.reset();
                    setTimeout(() => {
                        window.location.reload();
                    }, 3000);
                } else {
                    toastr.error(result.error);
                }
            } catch (error) {
                toastr.error(error);
            }
        });
    </script>
</body>

</html>