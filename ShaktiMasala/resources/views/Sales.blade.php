<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="meta" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sales Management</title>
    <x-cdnlinks />
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#1A2A80',
                        secondary: '#3B38A0',
                        accent: '#113F67',
                        highlight: '#34699A',
                        darkblue: '#154D71',
                        brightblue: '#001BB7',
                    }
                }
            }
        }
    </script>
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }

        .card-shadow {
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
        }

        .form-input {
            transition: all 0.3s;
        }

        .form-input:focus {
            box-shadow: 0 0 0 3px rgba(58, 130, 202, 0.3);
        }

        .status-badge {
            padding: 0.25rem 0.75rem;
            border-radius: 9999px;
            font-size: 0.75rem;
            font-weight: 600;
        }

        .paid {
            background-color: #ECFDF5;
            color: #047857;
        }

        .pending {
            background-color: #FEF3C7;
            color: #B45309;
        }

        .partially-paid {
            background-color: #E0E7FF;
            color: #3730A3;
        }

        .customer-badge {
            padding: 0.25rem 0.75rem;
            border-radius: 9999px;
            font-size: 0.75rem;
            font-weight: 600;
        }

        .wholesale {
            background-color: #DBEAFE;
            color: #1E40AF;
        }

        .retailer {
            background-color: #FCE7F3;
            color: #BE185D;
        }

        .scrollbar-hide::-webkit-scrollbar {
            display: none;
        }

        .scrollbar-hide {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }
    </style>
</head>

<body class="min-h-screen bg-gray-50 flex">
    <x-admin-menu />
    <div class="flex-1 overflow-auto p-6">
        <div class="max-w-7xl mx-auto">
            <!-- Header -->
            <div class="flex justify-between items-center mb-8">
                <h1 class="text-2xl font-bold text-primary">Sales Management</h1>
                <div class="text-sm text-gray-500">
                    <i class="far fa-calendar-alt mr-2"></i>
                    <span id="current-date"></span>
                </div>
            </div>

            <script>
                document.getElementById('current-date').textContent = new Date().toLocaleDateString('en-US', {
                    weekday: 'long',
                    year: 'numeric',
                    month: 'long',
                    day: 'numeric'
                });
            </script>

            <!-- Stats Cards -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                <div class="bg-white rounded-xl p-5 card-shadow border-l-4 border-primary">
                    <div class="flex justify-between items-start">
                        <div>
                            <p class="text-sm font-medium text-gray-500">Today's Sales</p>
                            <h3 id="todays_sale" class="text-2xl font-bold text-gray-900"></h3>
                        </div>
                        <div class="bg-primary rounded-lg p-3">
                            <i class="fas fa-shopping-cart text-white"></i>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-xl p-5 card-shadow border-l-4 border-secondary">
                    <div class="flex justify-between items-start">
                        <div>
                            <p class="text-sm font-medium text-gray-500">Total Orders</p>
                            <h3 id="total_order" class="text-2xl font-bold text-gray-900"></h3>
                        </div>
                        <div class="bg-secondary rounded-lg p-3">
                            <i class="fas fa-receipt text-white"></i>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-xl p-5 card-shadow border-l-4 border-accent">
                    <div class="flex justify-between items-start">
                        <div>
                            <p class="text-sm font-medium text-gray-500">Total Carton Sold today</p>
                            <h3 id="total_carton" class="text-2xl font-bold text-gray-900"></h3>
                        </div>
                        <div class="bg-accent rounded-lg p-3">
                            <i class="fas fa-clock text-white"></i>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-xl p-5 card-shadow border-l-4 border-highlight">
                    <div class="flex justify-between items-start">
                        <div>
                            <p class="text-sm font-medium text-gray-500">Todays Larget Order</p>
                            <h3 id="todays_largest_order" class="text-2xl font-bold text-gray-900"></h3>
                        </div>
                        <div class="bg-highlight rounded-lg p-3">
                            <i class="fas fa-users text-white"></i>
                        </div>
                    </div>
                </div>
            </div>

            <div class="flex flex-col lg:flex-row gap-6">
                <!-- Sales Form -->
                <div class="w-full lg:w-2/5">
                    <div class="bg-white rounded-xl p-6 card-shadow mb-6">
                        <h2 class="text-xl font-bold text-primary mb-6 flex items-center">
                            <i class="fas fa-plus-circle mr-2"></i> New Sale Entry
                        </h2>

                        <form action="" id="sales_form" method="post">
                            @csrf

                            <div class="mb-6">
                                <h3 class="text-lg font-semibold text-darkblue mb-4 flex items-center">
                                    <i class="fas fa-user-circle mr-2"></i> Customer Details
                                </h3>

                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Customer Name</label>
                                        <input type="text" name="customer_name" value="{{ old('customer_name') }}" id="customer_name"
                                            class="w-full form-input px-4 py-2 rounded-lg border border-gray-300 focus:outline-none focus:border-primary"
                                            placeholder="Customer Name" required>
                                    </div>

                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Customer Type</label>
                                        <select name="customer_type" id="customer_type"
                                            class="w-full form-input px-4 py-2 rounded-lg border border-gray-300 focus:outline-none focus:border-primary">
                                            <option value="" disabled selected>Select the customer type</option>
                                            <option value="wholesale">Wholesale</option>
                                            <option value="retailer">Retailer</option>
                                        </select>
                                    </div>

                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Date</label>
                                        <input type="date" name="date" value="{{ old('date') }}" id="date"
                                            class="w-full form-input px-4 py-2 rounded-lg border border-gray-300 focus:outline-none focus:border-primary" required>
                                    </div>

                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Payment Mode</label>
                                        <select name="payment_mode" id="payment_mode"
                                            class="w-full form-input px-4 py-2 rounded-lg border border-gray-300 focus:outline-none focus:border-primary">
                                            <option value="" disabled selected></option>
                                            <option value="cash">Cash</option>
                                            <option value="card">Credit/Debit Card</option>
                                            <option value="upi">UPI</option>
                                            <option value="cheque">Cheque</option>
                                        </select>
                                    </div>

                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Payment Status</label>
                                        <select name="payment_status" id="payment_status"
                                            class="w-full form-input px-4 py-2 rounded-lg border border-gray-300 focus:outline-none focus:border-primary">
                                            <option value="paid">Paid</option>
                                            <option value="pending">Pending</option>
                                            <option value="partially paid">Partially Paid</option>
                                        </select>
                                    </div>

                                    <div id="partial_amount_container" class="hidden">
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Partial Amount</label>
                                        <input type="number" name="partial_amount" value="{{ old('partial_amount') }}" id="partial_amount" min="0"
                                            class="w-full form-input px-4 py-2 rounded-lg border border-gray-300 focus:outline-none focus:border-primary"
                                            placeholder="Partial Amount">
                                    </div>

                                    <div class="md:col-span-2">
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Extra Charges</label>
                                        <input type="number" name="extra_charges" value="{{ old('extra_charges') }}" id="extra_charges"
                                            class="w-full form-input px-4 py-2 rounded-lg border border-gray-300 focus:outline-none focus:border-primary"
                                            placeholder="Extra Charges">
                                    </div>
                                </div>
                            </div>

                            <div class="mb-6">
                                <div class="flex justify-between items-center mb-4">
                                    <h3 class="text-lg font-semibold text-darkblue flex items-center">
                                        <i class="fas fa-boxes mr-2"></i> Product Details
                                    </h3>
                                    <button type="button" onclick="AddProduct()"
                                        class="flex items-center px-4 py-2 bg-primary text-white rounded-lg hover:bg-brightblue transition-colors">
                                        <i class="fas fa-plus mr-2"></i> Add Product
                                    </button>
                                </div>

                                <div id="product_section" class="space-y-4"></div>
                            </div>

                            <div class="flex justify-end">
                                <button type="submit" id="sales"
                                    class="px-6 py-3 bg-primary text-white rounded-lg font-medium hover:bg-brightblue transition-colors flex items-center">
                                    <i class="fas fa-check-circle mr-2"></i> Submit Sale
                                </button>
                            </div>

                            @if ($errors->any())
                            <div class="mt-4 p-4 bg-red-50 text-red-700 rounded-lg">
                                @foreach ($errors->all() as $i)
                                <p class="text-sm">{{ $i }}</p>
                                @endforeach
                            </div>
                            @endif
                        </form>
                    </div>
                </div>

                <!-- Sales Table -->
                <div class="w-full lg:w-3/5">
                    <div class="bg-white rounded-xl p-6 card-shadow">
                        <div class="flex justify-between items-center mb-6">
                            <h2 class="text-xl font-bold text-primary flex items-center">
                                <i class="fas fa-history mr-2"></i> Today's Sales
                            </h2>

                        </div>

                        <div class="overflow-x-auto scrollbar-hide">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead>
                                    <tr>
                                        <th class="px-4 py-3 bg-gray-50 text-left text-xs font-medium text-primary uppercase tracking-wider">Invoice</th>
                                        <th class="px-4 py-3 bg-gray-50 text-left text-xs font-medium text-primary uppercase tracking-wider">Customer</th>
                                        <th class="px-4 py-3 bg-gray-50 text-left text-xs font-medium text-primary uppercase tracking-wider">Date</th>
                                        <th class="px-4 py-3 bg-gray-50 text-left text-xs font-medium text-primary uppercase tracking-wider">Status</th>
                                        <th class="px-4 py-3 bg-gray-50 text-left text-xs font-medium text-primary uppercase tracking-wider">Amount</th>
                                        <th class="px-4 py-3 bg-gray-50 text-left text-xs font-medium text-primary uppercase tracking-wider">Actions</th>
                                    </tr>
                                </thead>
                                <tbody id="sales_body" class="bg-white divide-y divide-gray-200">
                                    <!-- Sales data will be populated here -->
                                    <tr>
                                        <td colspan="6" class="px-4 py-8 text-center text-gray-500">
                                            <i class="fas fa-receipt text-4xl mb-2 text-gray-300"></i>
                                            <p>No sales recorded today</p>
                                            <p class="text-sm">New sales will appear here</p>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>


                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Add Products in the Form -->
    <script>
        let ProductIndex = 0;

        function AddProduct() {
            let div = document.createElement('div');
            div.className = 'bg-gray-50 p-4 rounded-lg border border-gray-200';
            div.innerHTML = ` 
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="md:col-span-2 flex justify-between items-center mb-2">
                        <h4 class="font-medium text-accent">Product #${ProductIndex + 1}</h4>
                        <button type="button" onclick="this.parentElement.parentElement.parentElement.remove()" 
                            class="text-red-500 hover:text-red-700">
                            <i class="fas fa-times-circle"></i>
                        </button>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Product Name</label>
                        <input type="text" name="product[${ProductIndex}][name]" class="w-full form-input px-3 py-2 rounded-lg border border-gray-300 focus:outline-none focus:border-primary" placeholder="Product Name" required>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Brand Name</label>
                        <input type="text" name="product[${ProductIndex}][brand]" class="w-full form-input px-3 py-2 rounded-lg border border-gray-300 focus:outline-none focus:border-primary" placeholder="Brand Name" required>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">MRP</label>
                        <input type="number" name="product[${ProductIndex}][mrp]" min="0" class="w-full form-input px-3 py-2 rounded-lg border border-gray-300 focus:outline-none focus:border-primary" placeholder="MRP" required>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Total Carton</label>
                        <input type="number" name="product[${ProductIndex}][total_packet]" min="0" class="w-full form-input px-3 py-2 rounded-lg border border-gray-300 focus:outline-none focus:border-primary" placeholder="Total Carton" required>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Price Per Carot</label>
                        <input type="number" name="product[${ProductIndex}][price_per_carot]" min="0" class="w-full form-input px-3 py-2 rounded-lg border border-gray-300 focus:outline-none focus:border-primary" placeholder="Price Per Carot" required>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Packaging Type</label>
                        <select name="product[${ProductIndex}][packaging_type]" class="w-full form-input px-3 py-2 rounded-lg border border-gray-300 focus:outline-none focus:border-primary" required>
                            <option value="packet">Packet</option>
                            <option value="pouch">Pouch</option>
                            <option value="jar">Jar</option>
                        </select>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Net Weight Per Carot</label>
                        <input type="number" name="product[${ProductIndex}][net_weight]" min="0" class="w-full form-input px-3 py-2 rounded-lg border border-gray-300 focus:outline-none focus:border-primary" placeholder="Net Weight Per Carot" required>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Net Per Unit</label>
                        <input type="number" name="product[${ProductIndex}][net_per_unit]" min="0" class="w-full form-input px-3 py-2 rounded-lg border border-gray-300 focus:outline-none focus:border-primary" placeholder="Net Per Unit" required>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Units Per Carton</label>
                        <input type="number" name="product[${ProductIndex}][units_per_carton]" min="0" class="w-full form-input px-3 py-2 rounded-lg border border-gray-300 focus:outline-none focus:border-primary" placeholder="Units Per Carton" required>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Batch Number</label>
                        <input type="text" name="product[${ProductIndex}][batch]" class="w-full form-input px-3 py-2 rounded-lg border border-gray-300 focus:outline-none focus:border-primary" placeholder="Batch Number" required>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">MFG Date</label>
                        <input type="date" name="product[${ProductIndex}][mfg_date]" class="w-full form-input px-3 py-2 rounded-lg border border-gray-300 focus:outline-none focus:border-primary">
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">EXP Date</label>
                        <input type="date" name="product[${ProductIndex}][exp_date]" class="w-full form-input px-3 py-2 rounded-lg border border-gray-300 focus:outline-none focus:border-primary">
                    </div>
                </div>
            `;
            document.querySelector('#product_section').appendChild(div);
            ProductIndex++;
        }
    </script>

    <!-- Add Sales -->
    <script>
        document.querySelector('#sales_form').addEventListener('submit', async (e) => {
            try {
                e.preventDefault();
                let form = document.querySelector('#sales_form');
                const formData = new FormData(form);
                const response = await fetch(`${window.location.origin}/add_sales`, {
                    method: "POST",
                    body: formData
                });

                const result = await response.json();

                if (response.ok) {
                    toastr.success(result.success);
                    form.reset();
                    document.querySelector('#product_section').innerHTML = '';
                    ProductIndex = 0;
                    // Refresh the sales data after adding a new sale
                    fetchTodaysSales();
                } else {
                    toastr.error(result.error);
                }
            } catch (error) {
                toastr.error(error);
            }
        });
    </script>

    <!-- Show/hide partial amount field based on payment status -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const paymentStatus = document.getElementById('payment_status');
            const partialAmountContainer = document.getElementById('partial_amount_container');

            paymentStatus.addEventListener('change', function() {
                if (this.value === 'partially paid') {
                    partialAmountContainer.classList.remove('hidden');
                } else {
                    partialAmountContainer.classList.add('hidden');
                }
            });

            // Initialize today's sales data
            fetchTodaysSales();
        });
    </script>

    <!-- Fetch Todays Sales Data -->
    <script>
        async function fetchTodaysSales() {
            try {
                const response = await fetch(`${window.location.origin}/todays_sales`);
                const result = await response.json();
                if (response.ok) {
                    console.log('success', result.success);

                    const salesBody = document.querySelector('#sales_body');
                    salesBody.innerHTML = '';

                    if (result.success.length === 0) {
                        salesBody.innerHTML = `
                            <tr>
                                <td colspan="6" class="px-4 py-8 text-center text-gray-500">
                                    <i class="fas fa-receipt text-4xl mb-2 text-gray-300"></i>
                                    <p>No sales recorded today</p>
                                    <p class="text-sm">New sales will appear here</p>
                                </td>
                            </tr>
                        `;
                        return;
                    }


                    result.success.forEach(i => {
                        if (!i.customers) {
                            console.warn('Missing customer data:', i);
                            return;
                        }
                        const tr = document.createElement('tr');
                        tr.className = 'hover:bg-gray-50';

                        // Format date
                        const saleDate = new Date(i.customers.date);
                        const formattedDate = saleDate.toLocaleDateString('en-US', {
                            month: 'short',
                            day: 'numeric',
                            year: 'numeric'
                        });

                        // Determine status badge class
                        let statusClass = '';
                        if (i.customers.payment_status === 'paid') statusClass = 'paid';
                        else if (i.customers.payment_status === 'pending') statusClass = 'pending';
                        else if (i.customers.payment_status === 'partially paid') statusClass = 'partially-paid';

                        // Determine customer type badge class
                        let customerTypeClass = '';
                        if (i.customers.customer_type === 'wholesale') customerTypeClass = 'wholesale';
                        else if (i.customers.customer_type === 'retailer') customerTypeClass = 'retailer';

                        tr.innerHTML = `
                            <td class="px-4 py-4 whitespace-nowrap text-sm font-medium text-primary">${i.customers.invoice || 'N/A'}</td>
                            <td class="px-4 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900">${i.customers.customer_name || 'N/A'}</div>
                                <div class="text-sm text-gray-500"><span class="customer-badge ${customerTypeClass}">${i.customers.customer_type || 'N/A'}</span></div>
                            </td>
                            <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-500">${formattedDate}</td>
                            <td class="px-4 py-4 whitespace-nowrap">
                                <span class="status-badge ${statusClass}">${i.customers.payment_status || 'N/A'}</span>
                            </td>
                            <td class="px-4 py-4 whitespace-nowrap text-sm font-medium text-gray-900">₹${i.payable_amount || '0'}</td>
                            <td class="px-4 py-4 whitespace-nowrap text-sm font-medium">
                                <button class="text-primary hover:text-brightblue mr-3">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button class="text-red-500 hover:text-red-700">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </td>
                        `;
                        salesBody.appendChild(tr);
                    });

                    // Title Card assigning
                    document.querySelector('#todays_largest_order').textContent = `₹${result.HighestToday.payable_amount}`;
                    document.querySelector('#total_carton').textContent = result.TotalCarton;
                    document.querySelector('#total_order').textContent = result.TodaysOrder;
                    let totalPayableAmount = 0;
                    result.success.forEach(i => {
                        totalPayableAmount += parseFloat(i.payable_amount) || 0;
                    });

                    document.querySelector('#todays_sale').textContent = `₹${totalPayableAmount}`;
                } else {
                    toastr.error(result.error);
                }
            } catch (error) {
                toastr.error(error);
            }
        }
    </script>

    <!-- Toastr Notification (simplified version) -->
    <script>
        const toastr = {
            success: function(msg) {
                this.show(msg, 'green');
            },
            error: function(msg) {
                this.show(msg, 'red');
            },
            show: function(msg, color) {
                const toast = document.createElement('div');
                toast.className = `fixed top-4 right-4 px-4 py-2 rounded-lg shadow-lg text-white font-medium transition-opacity duration-300 ${color === 'green' ? 'bg-green-500' : 'bg-red-500'}`;
                toast.textContent = msg;
                document.body.appendChild(toast);

                setTimeout(() => {
                    toast.remove();
                }, 3000);
            }
        };
    </script>

</body>

</html>