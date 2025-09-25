<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Product Data</title>
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
        body {
            font-family: 'Poppins', sans-serif;
        }

        .form-input {
            transition: all 0.3s ease;
        }

        .form-input:focus {
            transform: translateY(-2px);
            box-shadow: 0 4px 6px rgba(0, 27, 183, 0.2);
        }

        .btn-primary {
            transition: all 0.3s ease;
            background: linear-gradient(135deg, #1A2A80 0%, #3B38A0 100%);
        }

        .btn-primary:hover {
            transform: translateY(-3px);
            box-shadow: 0 6px 12px rgba(26, 42, 128, 0.4);
        }

        .btn-secondary {
            transition: all 0.3s ease;
            background: linear-gradient(135deg, #113F67 0%, #34699A 100%);
        }

        .btn-secondary:hover {
            transform: translateY(-3px);
            box-shadow: 0 6px 12px rgba(19, 63, 103, 0.4);
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

        .animate-fade-in {
            animation: fadeIn 0.5s ease-out forwards;
        }

        .card-hover {
            transition: all 0.3s ease;
        }

        .card-hover:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.1);
        }

        .image-preview {
            transition: all 0.3s ease;
        }

        .image-preview:hover {
            transform: scale(1.05);
        }
    </style>
</head>

<body class="bg-gray-50 min-h-screen flex">
    <!-- Simulated Sidebar -->
    <x-admin-menu />

    <div class="flex-1 overflow-auto p-6 md:p-10">
        <div class="max-w-4xl mx-auto animate-fade-in">
            <!-- Header -->
            <div class="flex justify-between items-center mb-8">
                <h1 class="text-3xl font-bold text-primary">Edit Product</h1>
                <div class="flex space-x-3">
                    <a href="{{ url()->previous() }}" class="btn-secondary text-white px-5 py-2 rounded-lg flex items-center">
                        <i class="fas fa-arrow-left mr-2"></i> Back
                    </a>
                    <a href="/production" class="btn-primary text-white px-5 py-2 rounded-lg flex items-center">
                        <i class="fas fa-industry text-white"></i>
                        Products
                    </a>
                </div>
            </div>

            @if (isset($product))
            <!-- Form Container -->
            <div class="bg-white rounded-xl shadow-lg overflow-hidden card-hover">
                <form action="/UpdateProduct" id="add_product_form" method="post" enctype="multipart/form-data" class="p-6 md:p-8">
                    @csrf
                    @method('PUT')

                    <input type="hidden" name="product_id" value="{{ $product->product_id }}">

                    <!-- Image Upload Section -->
                    <div class="mb-10">
                        <label class="block text-dark text-lg font-medium mb-3">Product Image</label>
                        <div class="flex flex-col md:flex-row items-center">
                            <div class="relative mb-4 md:mb-0 md:mr-6">
                                <div class="w-40 h-40 rounded-lg border-2 border-dashed border-info flex items-center justify-center image-preview bg-gray-100">
                                    <img src="{{ asset($product->image) }}" alt="image" class="h-full w-full object-cover">
                                    <div class="text-center">
                                        <!-- <i class="fas fa-camera text-info text-2xl mb-2"></i>
                                        <p class="text-gray-500 text-sm">Preview</p> -->
                                    </div>
                                </div>
                            </div>
                            <div class="flex-1">
                                <label for="image" class="cursor-pointer bg-gray-100 hover:bg-gray-200 text-dark py-3 px-6 rounded-lg flex items-center justify-center transition duration-300">
                                    <i class="fas fa-cloud-upload-alt mr-2"></i>
                                    <span>Select Product Image</span>
                                    <input type="file" name="image" id="image" class="hidden">
                                </label>
                            </div>
                        </div>
                    </div>

                    <!-- Product Details -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                        <div>
                            <label for="name" class="block text-dark font-medium mb-2">Product Name</label>
                            <input type="text" name="name" value="{{ $product->name }}" id="name" placeholder="Enter Product Name"
                                class="w-full form-input px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-highlight focus:border-transparent outline-none" required>
                        </div>

                        <div>
                            <label for="brand_name" class="block text-dark font-medium mb-2">Brand Name</label>
                            <input type="text" name="brand_name" value="{{ $product->brand_name }}" id="brand_name" placeholder="Enter Brand Name"
                                class="w-full form-input px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-highlight focus:border-transparent outline-none" required>
                        </div>
                    </div>

                    <!-- Pricing Information -->
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                        <div>
                            <label for="mrp" class="block text-dark font-medium mb-2">MRP per Unit (₹)</label>
                            <input type="number" name="mrp" value="{{ $product->mrp }}" id="mrp" min="0" placeholder="0.00"
                                class="w-full form-input px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-highlight focus:border-transparent outline-none" required>
                        </div>

                        <div>
                            <label for="total_packet" class="block text-dark font-medium mb-2">Total Packets</label>
                            <input type="number" name="total_packet" value="{{ $product->total_packet }}" id="total_packet" min="0" placeholder="0"
                                class="w-full form-input px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-highlight focus:border-transparent outline-none" required>
                        </div>

                        <div>
                            <label for="price_per_carot" class="block text-dark font-medium mb-2">Price Per Box (₹)</label>
                            <input type="number" name="price_per_carot" value="{{ $product->price_per_carot }}" id="price_per_carot" min="0" placeholder="0.00"
                                class="w-full form-input px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-highlight focus:border-transparent outline-none" required>
                        </div>
                    </div>

                    <!-- Packaging Details -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                        <div>
                            <label for="packaging_type" class="block text-dark font-medium mb-2">Packaging Type</label>
                            <select name="packaging_type" id="packaging_type"
                                class="w-full form-input px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-highlight focus:border-transparent outline-none">
                                <option value="" disabled selected>Select Package Type</option>
                                @if (isset($productType))
                                @foreach ($productType as $i)
                                <option value="{{ $i->name }}" {{ ($product->packaging_type == $i->name) ? 'selected' : '' }}>{{ $i->name }}</option>
                                @endforeach
                                @endif
                            </select>
                        </div>

                        <div>
                            <label for="units_per_carton" class="block text-dark font-medium mb-2">Units Per Carton</label>
                            <input type="number" name="units_per_carton" value="{{ $product->units_per_carton }}" id="units_per_carton" min="0" placeholder="0"
                                class="w-full form-input px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-highlight focus:border-transparent outline-none" required>
                        </div>
                    </div>

                    <!-- Weight Information -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                        <div>
                            <label for="net_weight" class="block text-dark font-medium mb-2">Net Weight (KG)</label>
                            <input type="number" name="net_weight" value="{{ $product->net_weight }}" id="net_weight" min="0" step="0.01" placeholder="0.00"
                                class="w-full form-input px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-highlight focus:border-transparent outline-none" required>
                        </div>

                        <div>
                            <label for="net_per_unit" class="block text-dark font-medium mb-2">Net Weight Per Unit</label>
                            <input type="number" name="net_per_unit" value="{{ $product->net_per_unit }}" id="net_per_unit" min="0" step="0.01" placeholder="0.00"
                                class="w-full form-input px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-highlight focus:border-transparent outline-none" required>
                        </div>
                    </div>

                    <!-- Batch & Dates -->
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                        <div>
                            <label for="batch" class="block text-dark font-medium mb-2">Batch Number</label>
                            <input type="text" name="batch" value="{{ $product->batch }}" id="batch" placeholder="Batch Number"
                                class="w-full form-input px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-highlight focus:border-transparent outline-none">
                        </div>

                        <div>
                            <label for="mfg_date" class="block text-dark font-medium mb-2">Manufacturing Date</label>
                            <input type="date" name="mfg_date" value="{{ $product->mfg_date }}" id="mfg_date"
                                class="w-full form-input px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-highlight focus:border-transparent outline-none">
                        </div>

                        <div>
                            <label for="exp_date" class="block text-dark font-medium mb-2">Expiry Date</label>
                            <input type="date" name="exp_date" value="{{ $product->exp_date }}" id="exp_date"
                                class="w-full form-input px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-highlight focus:border-transparent outline-none">
                        </div>
                    </div>

                    <!-- Error Messages -->
                    @if ($errors->any())
                    <div class="mb-6 p-4 bg-red-50 border-l-4 border-red-500 rounded">
                        @foreach ($errors->all() as $i)
                        <p class="text-red-700 flex items-center"><i class="fas fa-exclamation-circle mr-2"></i> {{ $i }}</p>
                        @endforeach
                    </div>
                    @endif

                    <!-- Submit Button -->
                    <div class="mt-10">
                        <button type="submit" id="add_product" class="btn-primary text-white px-8 py-4 rounded-lg text-lg font-medium w-full md:w-auto flex items-center justify-center">
                            <i class="fas fa-save mr-2"></i> Update Product
                        </button>
                    </div>
                </form>
            </div>
            @else
            <!-- No Product Found Message -->
            <div class="bg-white rounded-xl shadow-lg p-8 text-center">
                <i class="fas fa-exclamation-triangle text-yellow-500 text-5xl mb-4"></i>
                <h2 class="text-2xl font-bold text-dark mb-2">No Product Data Found</h2>
                <p class="text-gray-600 mb-6">The product you're trying to edit doesn't exist or has been removed.</p>
                <a href="/production" class="btn-primary text-white px-5 py-2 rounded-lg inline-flex items-center">
                    <i class="fas fa-arrow-left mr-2"></i> Back to Products
                </a>
            </div>
            @endif
        </div>
    </div>

    <script>
        // Simple animation for form elements
        document.addEventListener('DOMContentLoaded', function() {
            const formInputs = document.querySelectorAll('.form-input');

            formInputs.forEach(input => {
                input.addEventListener('focus', () => {
                    input.parentElement.classList.add('opacity-100');
                });

                input.addEventListener('blur', () => {
                    input.parentElement.classList.remove('opacity-100');
                });
            });

            // Image preview functionality (simplified)
            const imageInput = document.getElementById('image');
            if (imageInput) {
                imageInput.addEventListener('change', function(e) {
                    if (e.target.files && e.target.files[0]) {
                        const reader = new FileReader();
                        reader.onload = function(e) {
                            document.querySelector('.image-preview').innerHTML =
                                `<img src="${e.target.result}" class="w-full h-full object-cover rounded-lg" alt="Preview">`;
                        }
                        reader.readAsDataURL(e.target.files[0]);
                    }
                });
            }
        });
    </script>
</body>

</html>