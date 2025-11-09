<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Costing Management</title>
    <x-cdnlinks />
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap');

        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f8fafc;
            overflow-x: hidden;
        }

        .card-gradient {
            background: linear-gradient(135deg, #34699A 0%, #154D71 100%);
        }

        .btn-primary {
            background: linear-gradient(135deg, #001BB7 0%, #1A2A80 100%);
        }

        .btn-primary:hover {
            background: linear-gradient(135deg, #1A2A80 0%, #001BB7 100%);
        }

        .form-input {
            transition: all 0.3s ease;
        }

        .form-input:focus {
            box-shadow: 0 0 0 3px rgba(26, 42, 128, 0.2);
        }

        .table-row {
            transition: all 0.3s ease;
        }

        .table-row:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
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

        .pulse-animation {
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

        .shadow-custom {
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1),
                0 10px 10px -5px rgba(0, 0, 0, 0.04);
        }

        .shadow-custom-lg {
            box-shadow: 0 20px 50px -12px rgba(0, 0, 0, 0.15);
        }

        /* --- Mobile Responsive Styles --- */
        @media (max-width: 1024px) {
            .grid {
                grid-template-columns: 1fr !important;
            }

            .p-8 {
                padding: 1.5rem !important;
            }

            h1 {
                font-size: 1.75rem;
            }

            .text-2xl {
                font-size: 1.25rem;
            }

            .text-xl {
                font-size: 1.1rem;
            }

            .card-gradient h2 {
                font-size: 1rem;
            }
        }

        @media (max-width: 768px) {
            body {
                padding: 0;
            }

            .max-w-7xl {
                max-width: 100%;
                padding: 0 1rem;
            }

            .flex.justify-between {
                flex-direction: column;
                align-items: flex-start;
                gap: 0.75rem;
            }

            .grid-cols-3 {
                grid-template-columns: repeat(1, 1fr) !important;
            }

            .table-wrapper {
                overflow-x: auto;
                -webkit-overflow-scrolling: touch;
            }

            table {
                min-width: 700px;
            }

            .btn-primary {
                font-size: 0.9rem;
                padding: 0.75rem 1rem;
            }
        }

        @media (max-width: 480px) {
            .text-3xl {
                font-size: 1.5rem;
            }

            .p-6 {
                padding: 1rem !important;
            }

            input,
            select {
                font-size: 0.9rem;
                padding: 0.6rem 0.8rem;
            }

            .btn-primary {
                padding: 0.75rem;
                font-size: 0.9rem;
            }
        }
    </style>
</head>

<body class="min-h-screen">
    <div class="flex flex-col md:flex-row">
        <x-admin-menu />

        <!-- Main Content -->
        <div class="flex-1 p-4 md:p-8 fade-in">
            <div class="max-w-7xl mx-auto">
                <!-- Header -->
                <div class="flex justify-between items-center mb-6 md:mb-8">
                    <div>
                        <h1 class="text-2xl md:text-3xl font-bold text-gray-800">Product Costing Management</h1>
                        <p class="text-gray-600 mt-2 text-sm md:text-base">
                            Manage and track your product costing efficiently
                        </p>
                    </div>
                </div>

                <!-- Stats Cards -->
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 md:gap-6 mb-8">

                    <div
                        class="bg-white rounded-xl shadow-custom p-6 flex items-center justify-between hover:scale-105 transition-transform">
                        <div class="rounded-full bg-green-100 p-4 mr-4">
                            <i class="fas fa-cubes text-green-600 text-xl"></i>
                        </div>
                        <div>
                            <p class="text-gray-500 text-sm md:text-base">Total Raw Material Cost</p>
                            <h3 class="text-xl md:text-2xl font-bold text-gray-800">₹{{ $TotalRawMaterials }}</h3>
                        </div>
                    </div>

                    <div
                        class="bg-white rounded-xl shadow-custom p-6 flex items-center justify-between hover:scale-105 transition-transform">
                        <div class="rounded-full bg-blue-100 p-4 mr-4">
                            <i class="fas fa-hard-hat text-[#1A2A80] text-xl"></i>
                        </div>
                        <div>
                            <p class="text-gray-500 text-sm md:text-base">Total Labour Cost</p>
                            <h3 class="text-xl md:text-2xl font-bold text-gray-800">{{ $TotalLabour }}</h3>
                        </div>
                    </div>

                    <div
                        class="bg-white rounded-xl shadow-custom p-6 flex items-center justify-between hover:scale-105 transition-transform">
                        <div class="rounded-full bg-purple-100 p-4 mr-4">
                            <i class="fas fa-money-bill-wave text-purple-600 text-xl"></i>
                        </div>
                        <div>
                            <p class="text-gray-500 text-sm md:text-base">Total Other Expense</p>
                            <h3 class="text-xl md:text-2xl font-bold text-gray-800">{{ $TotalOtherExpenses }}</h3>
                        </div>
                    </div>

                </div>

                <!-- Grid Section -->
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                    <!-- Add Costing Form -->
                    <div class="lg:col-span-1">
                        <div class="bg-white rounded-xl shadow-custom-lg overflow-hidden">
                            <div class="card-gradient px-6 py-4">
                                <h2 class="text-lg md:text-xl font-bold text-white flex items-center">
                                    <i class="fas fa-plus-circle mr-2"></i> Add Product Costing
                                </h2>
                            </div>

                            <form action="/add_costing" id="product_costing_form" method="post" class="p-6 space-y-6">
                                @csrf
                                <input type="hidden" name="product_id" value="{{ $id }}">

                                <div>
                                    <label class="block text-gray-700 mb-2 font-medium" for="raw_material">
                                        <i class="fas fa-cube mr-2 text-[#1A2A80]"></i> Raw Material Cost
                                    </label>
                                    <div class="relative">
                                        <div
                                            class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                            <span class="text-gray-500">₹</span>
                                        </div>
                                        <input type="number" name="raw_material" id="raw_material"
                                            class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-lg form-input focus:border-[#1A2A80]"
                                            placeholder="Enter Raw Material Amount">
                                    </div>
                                </div>

                                <div>
                                    <label class="block text-gray-700 mb-2 font-medium" for="labour">
                                        <i class="fas fa-user-tie mr-2 text-[#1A2A80]"></i> Labour Cost
                                    </label>
                                    <div class="relative">
                                        <div
                                            class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                            <span class="text-gray-500">₹</span>
                                        </div>
                                        <input type="number" name="labour" id="labour"
                                            class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-lg form-input focus:border-[#1A2A80]"
                                            placeholder="Enter Labour Amount">
                                    </div>
                                </div>

                                <div>
                                    <label class="block text-gray-700 mb-2 font-medium" for="other_expense">
                                        <i class="fas fa-receipt mr-2 text-[#1A2A80]"></i> Other Expenses
                                    </label>
                                    <div class="relative">
                                        <div
                                            class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                            <span class="text-gray-500">₹</span>
                                        </div>
                                        <input type="number" name="other_expense" id="other_expense"
                                            class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-lg form-input focus:border-[#1A2A80]"
                                            placeholder="Enter Other Expenses Amount">
                                    </div>
                                </div>

                                <div>
                                    <label class="block text-gray-700 mb-2 font-medium" for="total_unit_produced">
                                        <i class="fas fa-boxes mr-2 text-[#1A2A80]"></i> Total Units Produced
                                    </label>
                                    <input type="number" name="total_unit_produced" id="total_unit_produced"
                                        class="w-full px-4 py-3 border border-gray-300 rounded-lg form-input focus:border-[#1A2A80]"
                                        placeholder="Enter Number of Products Produced">
                                </div>

                                <div>
                                    <label class="block text-gray-700 mb-2 font-medium" for="product_type">
                                        <i class="fas fa-tag mr-2 text-[#1A2A80]"></i> Product Type
                                    </label>
                                    <select name="product_type" id="product_type"
                                        class="w-full px-4 py-3 border border-gray-300 rounded-lg form-input focus:border-[#1A2A80]">
                                        <option selected disabled>Select Product Type</option>
                                        @foreach ($ProductType as $i)
                                            <option value="{{ $i->name }}">{{ $i->name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <button type="submit" id="add_costing"
                                    class="w-full btn-primary text-white font-bold py-3 px-4 rounded-lg transition-all transform hover:scale-105 pulse-animation flex items-center justify-center">
                                    <i class="fas fa-plus-circle mr-2"></i> Add Costing
                                </button>
                            </form>
                        </div>
                    </div>

                    <!-- Costing Data Table -->
                    <div class="lg:col-span-2">
                        <div class="bg-white rounded-xl shadow-custom-lg overflow-hidden">
                            <div class="card-gradient px-6 py-4">
                                <h2 class="text-lg md:text-xl font-bold text-white flex items-center">
                                    <i class="fas fa-table mr-2"></i> Costing Data
                                </h2>
                            </div>

                            <div class="table-wrapper">
                                <table class="w-full text-sm md:text-base">
                                    <thead class="bg-gray-100">
                                        <tr>
                                            <th class="py-3 px-4 text-left text-gray-700 font-semibold">#</th>
                                            <th class="py-3 px-4 text-left text-gray-700 font-semibold">Product</th>
                                            <th class="py-3 px-4 text-left text-gray-700 font-semibold">Raw Material
                                            </th>
                                            <th class="py-3 px-4 text-left text-gray-700 font-semibold">Labour</th>
                                            <th class="py-3 px-4 text-left text-gray-700 font-semibold">Other</th>
                                            <th class="py-3 px-4 text-left text-gray-700 font-semibold">Units</th>
                                            <th class="py-3 px-4 text-left text-gray-700 font-semibold">Per Unit</th>
                                            <th class="py-3 px-4 text-left text-gray-700 font-semibold">Product Type
                                            </th>
                                            <th class="py-3 px-4 text-left text-gray-700 font-semibold">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-gray-200">
                                        @foreach ($CostingData as $i)
                                            <tr class="table-row hover:bg-blue-50">
                                                <td class="py-3 px-4">{{ $loop->iteration }}</td>
                                                <td class="py-3 px-4 font-medium text-gray-800">{{ $i->product->name }}
                                                </td>
                                                <td class="py-3 px-4">₹{{ $i->raw_material }}</td>
                                                <td class="py-3 px-4">₹{{ $i->labour }}</td>
                                                <td class="py-3 px-4">₹{{ $i->other_expense }}</td>
                                                <td class="py-3 px-4">{{ $i->total_unit_produced }}</td>
                                                <td class="py-3 px-4 font-bold text-[#1A2A80]">
                                                    ₹{{ $i->price_per_unit }}</td>
                                                <td class="py-3 px-4">
                                                    {{ $i->product_type }}</td>
                                                <td
                                                    class="px-6 py-4 whitespace-nowrap text-sm font-medium text-center">
                                                    <a href="/edit_costing/{{ $i->product_id }}"
                                                        class="text-info hover:text-blue-700 mr-3"><i
                                                            class="fas fa-edit"></i></a>
                                                    <button id="${i.id}"
                                                        class="DeleteProduct text-red-500 hover:text-red-700 cursor-pointer"><i
                                                            class="fas fa-trash-alt"></i></button>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Add Product Costing
        document.querySelector('#add_costing').addEventListener('click', async (e) => {
            e.preventDefault();
            const form = document.querySelector('#product_costing_form');
            const formData = new FormData(form);

            try {
                const response = await fetch('/add_costing', {
                    method: 'POST',
                    body: formData,
                });

                const result = await response.json();

                if (response.ok) {
                    toastr.success(result.success);
                    form.reset();
                } else {
                    toastr.error(result.error);
                }
            } catch (e) {
                toastr.error('API Exception');
            }
        });

        // Form animations
        document.addEventListener('DOMContentLoaded', function() {
            const inputs = document.querySelectorAll('.form-input');
            inputs.forEach(input => {
                input.addEventListener('focus', function() {
                    this.parentElement.classList.add('transform', 'scale-105');
                });
                input.addEventListener('blur', function() {
                    this.parentElement.classList.remove('transform', 'scale-105');
                });
            });
        });
    </script>
</body>

</html>
