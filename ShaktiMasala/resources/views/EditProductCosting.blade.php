<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Update Product Costing</title>
    <x-cdnlinks />

    <style>
        body {
            background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
        }

        .gradient-bg {
            background: linear-gradient(135deg, #1A2A80 0%, #3B38A0 50%, #113F67 100%);
        }

        .card-gradient {
            background: linear-gradient(135deg, #34699A 0%, #154D71 100%);
        }

        .btn-primary {
            background: linear-gradient(135deg, #001BB7 0%, #1A2A80 100%);
        }

        .btn-primary:hover {
            background: linear-gradient(135deg, #1A2A80 0%, #001BB7 100%);
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(0, 27, 183, 0.3);
        }

        .form-input {
            transition: all 0.3s ease;
        }

        .form-input:focus {
            box-shadow: 0 0 0 3px rgba(26, 42, 128, 0.2);
            border-color: #1A2A80;
        }

        .fade-in {
            animation: fadeIn 0.6s ease-in-out;
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

        .slide-in {
            animation: slideIn 0.5s ease-out;
        }

        @keyframes slideIn {
            from {
                transform: translateX(-20px);
                opacity: 0;
            }

            to {
                transform: translateX(0);
                opacity: 1;
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

        .floating {
            animation: floating 3s ease-in-out infinite;
        }

        @keyframes floating {
            0% {
                transform: translateY(0px);
            }

            50% {
                transform: translateY(-10px);
            }

            100% {
                transform: translateY(0px);
            }
        }

        .glow {
            box-shadow: 0 0 20px rgba(26, 42, 128, 0.3);
        }

        .shadow-custom {
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        }

        .shadow-custom-lg {
            box-shadow: 0 20px 50px -12px rgba(0, 0, 0, 0.15);
        }

        .input-group {
            position: relative;
        }

        .input-icon {
            position: absolute;
            left: 12px;
            top: 50%;
            transform: translateY(-50%);
            color: #1A2A80;
            z-index: 10;
        }

        .currency-symbol {
            position: absolute;
            left: 40px;
            top: 50%;
            transform: translateY(-50%);
            color: #6B7280;
            z-index: 10;
        }
    </style>
</head>

<body class="min-h-screen">
    <div class="flex">
        <x-admin-menu />

        <!-- Main Content -->
        <div class="flex-1 p-4 lg:p-8 fade-in">
            <div class="max-w-4xl mx-auto">
                <!-- Header Section -->
                <div class="mb-8 text-center">
                    <div class="inline-block p-4 rounded-full bg-white shadow-custom-lg mb-4 floating">
                        <i class="fas fa-edit text-3xl text-[#1A2A80]"></i>
                    </div>
                    <h1 class="text-3xl lg:text-4xl font-bold text-gray-800 mb-2">Update Product Costing</h1>
                    <p class="text-gray-600 max-w-lg mx-auto">Modify the product costing details below. All fields are
                        required for accurate calculations.</p>
                </div>

                <!-- Stats Summary Cards -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-8">
                    <div
                        class="bg-white rounded-xl shadow-custom p-4 flex items-center transform transition-transform hover:scale-105">
                        <div class="rounded-full bg-blue-100 p-3 mr-4">
                            <i class="fas fa-cube text-[#1A2A80] text-lg"></i>
                        </div>
                        <div>
                            <p class="text-gray-500 text-sm">Current Raw Material</p>
                            <h3 class="text-xl font-bold text-gray-800">₹{{ $ProductCosting->raw_material }}</h3>
                        </div>
                    </div>

                    <div
                        class="bg-white rounded-xl shadow-custom p-4 flex items-center transform transition-transform hover:scale-105">
                        <div class="rounded-full bg-green-100 p-3 mr-4">
                            <i class="fas fa-user-tie text-green-600 text-lg"></i>
                        </div>
                        <div>
                            <p class="text-gray-500 text-sm">Current Labour</p>
                            <h3 class="text-xl font-bold text-gray-800">₹{{ $ProductCosting->labour }}</h3>
                        </div>
                    </div>

                    <div
                        class="bg-white rounded-xl shadow-custom p-4 flex items-center transform transition-transform hover:scale-105">
                        <div class="rounded-full bg-purple-100 p-3 mr-4">
                            <i class="fas fa-boxes text-purple-600 text-lg"></i>
                        </div>
                        <div>
                            <p class="text-gray-500 text-sm">Units Produced</p>
                            <h3 class="text-xl font-bold text-gray-800">{{ $ProductCosting->total_unit_produced }}</h3>
                        </div>
                    </div>
                </div>

                <!-- Update Form -->
                <div class="bg-white rounded-2xl shadow-custom-lg overflow-hidden">
                    <div class="card-gradient px-6 py-4">
                        <h2 class="text-xl font-bold text-white flex items-center">
                            <i class="fas fa-pencil-alt mr-3"></i>
                            Edit Costing Details
                        </h2>
                    </div>

                    <form action="/update_costing" method="post" id="product_costing_form" class="p-6 lg:p-8">
                        @csrf
                        @method('PUT')
                        <input type="hidden" value="{{ $ProductCosting->product_id }}" name="product_id">

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                            <!-- Raw Material Input -->
                            <div class="input-group">
                                <label class="block text-gray-700 mb-3 font-medium" for="raw_material">
                                    <i class="fas fa-cube mr-2 text-[#1A2A80]"></i>
                                    Raw Material Cost
                                </label>
                                <div class="relative">
                                    <div class="input-icon">
                                        <i class="fas fa-cube"></i>
                                    </div>
                                    <div class="currency-symbol">
                                        <span>₹</span>
                                    </div>
                                    <input type="number" value="{{ $ProductCosting->raw_material }}"
                                        name="raw_material" id="raw_material"
                                        class="w-full pl-16 pr-4 py-3 border border-gray-300 rounded-xl form-input focus:border-[#1A2A80]"
                                        placeholder="Enter Raw Material Cost" required>
                                </div>
                            </div>

                            <!-- Labour Input -->
                            <div class="input-group">
                                <label class="block text-gray-700 mb-3 font-medium" for="labour">
                                    <i class="fas fa-user-tie mr-2 text-[#1A2A80]"></i>
                                    Labour Cost
                                </label>
                                <div class="relative">
                                    <div class="input-icon">
                                        <i class="fas fa-user-tie"></i>
                                    </div>
                                    <div class="currency-symbol">
                                        <span>₹</span>
                                    </div>
                                    <input type="number" value="{{ $ProductCosting->labour }}" name="labour"
                                        id="labour"
                                        class="w-full pl-16 pr-4 py-3 border border-gray-300 rounded-xl form-input focus:border-[#1A2A80]"
                                        placeholder="Enter Labour Cost" required>
                                </div>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                            <!-- Other Expenses Input -->
                            <div class="input-group">
                                <label class="block text-gray-700 mb-3 font-medium" for="other_expense">
                                    <i class="fas fa-receipt mr-2 text-[#1A2A80]"></i>
                                    Other Expenses
                                </label>
                                <div class="relative">
                                    <div class="input-icon">
                                        <i class="fas fa-receipt"></i>
                                    </div>
                                    <div class="currency-symbol">
                                        <span>₹</span>
                                    </div>
                                    <input type="number" value="{{ $ProductCosting->other_expense }}"
                                        name="other_expense" id="other_expense"
                                        class="w-full pl-16 pr-4 py-3 border border-gray-300 rounded-xl form-input focus:border-[#1A2A80]"
                                        placeholder="Enter Other Expenses" required>
                                </div>
                            </div>

                            <!-- Total Units Produced Input -->
                            <div class="input-group">
                                <label class="block text-gray-700 mb-3 font-medium" for="total_unit_produced">
                                    <i class="fas fa-boxes mr-2 text-[#1A2A80]"></i>
                                    Total Units Produced
                                </label>
                                <div class="relative">
                                    <div class="input-icon">
                                        <i class="fas fa-boxes"></i>
                                    </div>
                                    <input type="number" value="{{ $ProductCosting->total_unit_produced }}"
                                        name="total_unit_produced" id="total_unit_produced"
                                        class="w-full pl-12 pr-4 py-3 border border-gray-300 rounded-xl form-input focus:border-[#1A2A80]"
                                        placeholder="Enter Total Units Produced" required>
                                </div>
                            </div>
                        </div>

                        <!-- Product Type Select -->
                        <div class="mb-8">
                            <label class="block text-gray-700 mb-3 font-medium" for="product_type">
                                <i class="fas fa-tag mr-2 text-[#1A2A80]"></i>
                                Product Type
                            </label>
                            <div class="relative">
                                <div class="input-icon">
                                    <i class="fas fa-tag"></i>
                                </div>
                                <select name="product_type" id="product_type"
                                    class="w-full pl-12 pr-4 py-3 border border-gray-300 rounded-xl form-input focus:border-[#1A2A80] appearance-none">
                                    <option selected disabled>Select Product Type</option>
                                    @foreach ($ProductType as $i)
                                        <option value="{{ $i->name }}"
                                            {{ $i->name == $ProductCosting->product_type ? 'selected' : '' }}>
                                            {{ $i->name }}</option>
                                    @endforeach
                                </select>
                                <div
                                    class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3 text-gray-700">
                                    <i class="fas fa-chevron-down"></i>
                                </div>
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="flex flex-col sm:flex-row gap-4 pt-4">
                            <button type="submit" id="update_costing"
                                class="flex-1 btn-primary text-white font-bold py-4 px-6 rounded-xl transition-all transform hover:scale-105 pulse-animation flex items-center justify-center">
                                <i class="fas fa-save mr-3"></i>
                                Update Costing
                            </button>

                            <a href="#"
                                class="flex-1 bg-gray-200 text-gray-800 font-bold py-4 px-6 rounded-xl transition-all transform hover:scale-105 flex items-center justify-center hover:bg-gray-300">
                                <i class="fas fa-times mr-3"></i>
                                Cancel
                            </a>
                        </div>
                    </form>
                </div>

                <!-- Info Section -->
                <div class="mt-8 bg-blue-50 border border-blue-200 rounded-2xl p-6 slide-in">
                    <div class="flex items-start">
                        <div class="flex-shrink-0">
                            <i class="fas fa-info-circle text-blue-500 text-xl mt-1"></i>
                        </div>
                        <div class="ml-4">
                            <h3 class="text-lg font-medium text-blue-800">Update Information</h3>
                            <div class="mt-2 text-blue-700">
                                <p class="text-sm">Updating product costing will recalculate the price per unit based
                                    on your inputs.</p>
                                <p class="text-sm mt-1">All changes will be reflected immediately in reports and
                                    analytics.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Update Costing Form Submission
            document.querySelector('#update_costing').addEventListener('click', async (e) => {
                e.preventDefault();
                const form = document.querySelector('#product_costing_form');
                const formData = new FormData(form);
                const submitBtn = document.getElementById('update_costing');

                // Add loading state
                submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-3"></i> Updating...';
                submitBtn.disabled = true;

                try {
                    const response = await fetch('/update_costing', {
                        method: 'POST',
                        body: formData,
                    });
                    const result = await response.json();

                    if (response.ok) {
                        toastr.success(result.success);
                        // Add success animation
                        submitBtn.innerHTML = '<i class="fas fa-check mr-3"></i> Updated Successfully!';
                        submitBtn.classList.remove('btn-primary', 'pulse-animation');
                        submitBtn.classList.add('bg-green-500');

                        setTimeout(() => {
                            submitBtn.innerHTML =
                                '<i class="fas fa-save mr-3"></i> Update Costing';
                            submitBtn.classList.add('btn-primary', 'pulse-animation');
                            submitBtn.classList.remove('bg-green-500');
                            submitBtn.disabled = false;
                        }, 2000);
                    } else {
                        toastr.error(result.error);
                        submitBtn.innerHTML = '<i class="fas fa-save mr-3"></i> Update Costing';
                        submitBtn.disabled = false;
                    }
                } catch (e) {
                    toastr.error('API Exception');
                    submitBtn.innerHTML = '<i class="fas fa-save mr-3"></i> Update Costing';
                    submitBtn.disabled = false;
                }
            });

            // Add focus animations to form inputs
            const inputs = document.querySelectorAll('.form-input');
            inputs.forEach(input => {
                input.addEventListener('focus', function() {
                    this.parentElement.parentElement.classList.add('transform', 'scale-105');
                });

                input.addEventListener('blur', function() {
                    this.parentElement.parentElement.classList.remove('transform', 'scale-105');
                });
            });

            // Add animation to select element
            const select = document.getElementById('product_type');
            select.addEventListener('focus', function() {
                this.parentElement.classList.add('transform', 'scale-105');
            });

            select.addEventListener('blur', function() {
                this.parentElement.classList.remove('transform', 'scale-105');
            });
        });
    </script>
</body>

</html>
