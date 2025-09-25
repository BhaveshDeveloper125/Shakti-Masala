<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="meta" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Production Management</title>
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
                    },
                    animation: {
                        'fade-in': 'fadeIn 0.5s ease-out forwards',
                        'slide-up': 'slideUp 0.5s ease-out forwards',
                        'bounce-light': 'bounce 1s infinite'
                    },
                    keyframes: {
                        fadeIn: {
                            '0%': {
                                opacity: '0'
                            },
                            '100%': {
                                opacity: '1'
                            }
                        },
                        slideUp: {
                            '0%': {
                                transform: 'translateY(20px)',
                                opacity: '0'
                            },
                            '100%': {
                                transform: 'translateY(0)',
                                opacity: '1'
                            }
                        }
                    }
                }
            }
        }
    </script>
    <style type="text/css">
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap');

        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #f5f7fa 0%, #e4e8f0 100%);
        }

        .card-hover {
            transition: all 0.3s ease;
        }

        .card-hover:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 30px -10px rgba(26, 42, 128, 0.15);
        }

        .btn-primary {
            background: linear-gradient(45deg, #1A2A80, #3B38A0);
            transition: all 0.3s ease;
        }

        .btn-primary:hover {
            background: linear-gradient(45deg, #3B38A0, #1A2A80);
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(26, 42, 128, 0.3);
        }

        .form-input:focus {
            border-color: #3B38A0;
            box-shadow: 0 0 0 3px rgba(59, 56, 160, 0.2);
        }

        .table-row {
            transition: all 0.2s ease;
        }

        .table-row:hover {
            background-color: rgba(59, 56, 160, 0.05);
        }

        .pagination-btn {
            transition: all 0.2s ease;
        }

        .pagination-btn:hover:not(.disabled) {
            background-color: #3B38A0;
            color: white;
        }

        @keyframes shimmer {
            0% {
                background-position: -1000px 0;
            }

            100% {
                background-position: 1000px 0;
            }
        }

        .shimmer {
            background: linear-gradient(to right, #f6f7f8 8%, #edeef1 18%, #f6f7f8 33%);
            background-size: 1000px 100%;
            animation: shimmer 2s infinite linear;
        }

        /* Custom scrollbar for overview section */
        .overview-scroll {
            scrollbar-width: thin;
            scrollbar-color: #3B38A0 #f1f1f1;
        }

        .overview-scroll::-webkit-scrollbar {
            width: 6px;
        }

        .overview-scroll::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 10px;
        }

        .overview-scroll::-webkit-scrollbar-thumb {
            background: #3B38A0;
            border-radius: 10px;
        }

        .overview-scroll::-webkit-scrollbar-thumb:hover {
            background: #1A2A80;
        }
    </style>
</head>

<body class="min-h-screen flex">
    <!-- Sidebar Navigation -->
    <x-admin-menu />

    <!-- Main Content -->
    <div class="flex-1 overflow-auto p-6">
        <div class="mb-8 animate-fade-in">
            <h1 class="text-3xl font-bold text-primary mb-2">Product Management</h1>
            <p class="text-gray-600">Add and manage your production items</p>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-12">
            <!-- Add Product Form -->
            <div class="bg-white rounded-xl shadow-lg p-6 card-hover">
                <div class="flex items-center mb-6">
                    <div class="bg-primary p-3 rounded-full mr-4">
                        <i class="fas fa-plus"></i>
                    </div>
                    <h2 class="text-xl font-semibold text-primary">Add New Product</h2>
                </div>

                <form action="" id="add_product_form" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Product Image</label>
                            <div class="relative border-2 border-dashed border-gray-300 rounded-lg p-4 text-center hover:border-secondary transition-colors">
                                <input type="file" name="image" id="image" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer">
                                <i class="fas fa-cloud-upload-alt text-3xl text-primary mb-2"></i>
                                <p class="text-sm text-gray-600">Click to upload product image</p>
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Product Name</label>
                            <input type="text" name="name" value="{{ old('name') }}" id="name"
                                class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-secondary form-input"
                                placeholder="Enter Product Name" required>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Brand Name</label>
                            <input type="text" name="brand_name" value="{{ old('brand_name') }}" id="brand_name"
                                class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-secondary form-input"
                                placeholder="Enter Brand Name" required>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">MRP per Unit</label>
                            <input type="number" name="mrp" value="{{ old('mrp') }}" id="mrp" min="0"
                                class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-secondary form-input"
                                placeholder="MRP per Unit" required>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Total Packet</label>
                            <input type="number" name="total_packet" value="{{ old('total_packet') }}" id="total_packet" min="0"
                                class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-secondary form-input"
                                placeholder="Total Packet" required>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Price Per Box</label>
                            <input type="number" name="price_per_carot" value="{{ old('price_per_carot') }}" id="price_per_carot" min="0"
                                class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-secondary form-input"
                                placeholder="Price Per Box" required>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Packaging Type</label>
                            <select name="packaging_type" id="packaging_type"
                                class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-secondary form-input">
                                <option value="" disabled selected>Select Package Type</option>
                                <div id="option_container">
                                    <!-- Options will be populated here -->
                                </div>
                            </select>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Net Weight (in KG)</label>
                            <input type="number" name="net_weight" value="{{ old('net_weight') }}" id="net_weight" min="0"
                                class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-secondary form-input"
                                placeholder="Net Weight" required>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Net Weight Per Unit</label>
                            <input type="number" name="net_per_unit" value="{{ old('net_per_unit') }}" id="net_per_unit" min="0"
                                class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-secondary form-input"
                                placeholder="Net Weight Per Unit" required>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Units Per Cartoon</label>
                            <input type="number" name="units_per_carton" value="{{ old('units_per_carton') }}" id="units_per_carton" min="0"
                                class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-secondary form-input"
                                placeholder="Units Per Cartoon" required>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Batch Number</label>
                            <input type="text" name="batch" value="{{ old('batch') }}" id="batch"
                                class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-secondary form-input"
                                placeholder="Batch Number">
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Mfg Date</label>
                                <input type="date" name="mfg_date" value="{{ old('mfg_date') }}" id="mfg_date"
                                    class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-secondary form-input">
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Exp Date</label>
                                <input type="date" name="exp_date" value="{{ old('exp_date') }}" id="exp_date"
                                    class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-secondary form-input">
                            </div>
                        </div>
                    </div>

                    <div class="mt-6">
                        <button type="submit" id="add_product"
                            class="w-full text-white py-3 px-4 rounded-lg font-semibold btn-primary focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-secondary transition-all duration-300">
                            <i class="fas fa-plus-circle mr-2"></i>Add Product
                        </button>
                    </div>

                    @if ($errors->any())
                    <div class="mt-4 p-3 bg-red-100 border-l-4 border-red-500 text-red-700 rounded">
                        @foreach ($errors->all() as $i)
                        <p class="text-sm">{{ $i }}</p>
                        @endforeach
                    </div>
                    @endif
                </form>
            </div>

            <!-- Stats Overview -->
            <div class="bg-white rounded-xl shadow-lg p-8 card-hover">
                <div class="flex items-center mb-6">
                    <div class="bg-info p-3 rounded-full mr-4">
                        <i class="fas fa-chart-pie "></i>
                    </div>
                    <h2 class="text-xl font-semibold text-primary">Production Overview</h2>
                </div>

                <div id="overview" class="grid grid-cols-1 gap-4 p-4 mb-2 overview-scroll" style="max-height: 400px; overflow-y: auto;">
                    <div class="bg-blue-50 p-4 rounded-lg border-l-4 border-primary">
                        <p class="text-sm text-gray-600">Total Products</p>
                        <p id="total_product" class="text-2xl font-bold text-primary"></p>
                    </div>

                    <div class="bg-green-50 p-4 rounded-lg border-l-4 border-green-500">
                        <p class="text-sm text-gray-600">Highest Stock</p>
                        <p id="highest_stock_name" class="text-sm text-gray-600"></p>
                        <p id="highest_stock" class="text-2xl font-bold text-green-600"></p>
                    </div>

                    <div class="bg-yellow-50 p-4 rounded-lg border-l-4 border-yellow-500">
                        <p class="text-sm text-gray-600">Lowest Stock</p>
                        <p id="lowest_stock_name" class="text-sm text-gray-600"></p>
                        <p id="lowest_stock" class="text-2xl font-bold text-yellow-600"></p>
                    </div>

                    <!-- Expiry items will be added here -->
                </div>
            </div>
        </div>

        <!-- Products Table -->
        <div class="bg-white rounded-xl shadow-lg overflow-hidden animate-slide-up">
            <div class="overflow-x-auto">
                <table class="min-w-full">
                    <thead>
                        <tr class="bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            <th class="px-6 py-3">Product ID</th>
                            <th class="px-6 py-3">Image</th>
                            <th class="px-6 py-3">Name</th>
                            <th class="px-6 py-3">Brand</th>
                            <th class="px-6 py-3">Packets</th>
                            <th class="px-6 py-3">Packaging</th>
                            <th class="px-6 py-3">MRP</th>
                            <th class="px-6 py-3">Net Weight</th>
                            <th class="px-6 py-3">Units/Carton</th>
                            <th class="px-6 py-3">Batch</th>
                            <th class="px-6 py-3">MFG Date</th>
                            <th class="px-6 py-3">EXP Date</th>
                            <th class="px-6 py-3 text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody id="display_table" class="divide-y divide-gray-200">
                        <!-- Table rows will be populated here -->
                    </tbody>
                </table>
            </div>

            <div id="pagination" class="px-6 py-4 bg-gray-50 flex justify-center items-center space-x-2">
                <!-- Pagination will be populated here -->
            </div>
        </div>
    </div>

    <script>
        // Submiting the form
        document.querySelector('#add_product').addEventListener('click', async (e) => {
            e.preventDefault();
            const form = document.querySelector('#add_product_form');
            const formData = new FormData(form);

            try {
                const response = await fetch('/add_product', {
                    method: 'POST',
                    body: formData
                });

                const responseData = await response.json();
                if (response.ok) {
                    toastr.success(responseData.success);
                    GetProductData();
                    form.reset();

                } else if (!response.ok) {
                    toastr.error(responseData.error);
                }
            } catch (e) {
                toastr.error('API Exception Error ', e);
            }

        });
    </script>

    <script>
        // Fetching the Product Data
        document.addEventListener('DOMContentLoaded', GetProductData);
        // function that fetches the product Data
        function Pagination(paginationData) {
            const paginationContainer = document.querySelector('#pagination');

            const TotalPages = paginationData.last_page;
            const CurrentPage = paginationData.current_page;

            paginationContainer.innerHTML = '';

            const FirstBtn = document.createElement('button');
            FirstBtn.textContent = "<<";
            FirstBtn.className = "pagination-btn py-1 px-3 border rounded-md";
            CurrentPage == 1 ? FirstBtn.disabled = true : '';
            FirstBtn.addEventListener('click', () => GetProductData(1));
            paginationContainer.appendChild(FirstBtn);

            for (let i = 1; i <= TotalPages; i++) {
                const btn = document.createElement('button');
                btn.textContent = i;
                btn.className = `pagination-btn py-1 px-3 border rounded-md ${i == CurrentPage ? 'bg-primary' : ''}`;
                btn.addEventListener('click', () => GetProductData(i));
                paginationContainer.appendChild(btn);
            }

            const LastBtn = document.createElement('button');
            LastBtn.textContent = ">>";
            LastBtn.className = "pagination-btn py-1 px-3 border rounded-md";
            CurrentPage == TotalPages ? LastBtn.disabled = true : '';
            LastBtn.addEventListener('click', () => GetProductData(TotalPages));
            paginationContainer.appendChild(LastBtn);

        }
        let currentPage = 1;
        async function GetProductData(page = 1) {
            currentPage = page;
            try {
                // Show loading state
                document.querySelector('#display_table').innerHTML = `
                    <tr class="table-row">
                        <td colspan="13" class="px-6 py-4">
                            <div class="shimmer h-8 rounded-md"></div>
                        </td>
                    </tr>
                    <tr class="table-row">
                        <td colspan="13" class="px-6 py-4">
                            <div class="shimmer h-8 rounded-md"></div>
                        </td>
                    </tr>
                    <tr class="table-row">
                        <td colspan="13" class="px-6 py-4">
                            <div class="shimmer h-8 rounded-md"></div>
                        </td>
                    </tr>
                `;

                const response = await fetch(`http://127.0.0.1:8000/products?page=${page}`);
                if (response.ok) {
                    const data = await response.json();
                    const products = data.product.data;

                    document.querySelector('#display_table').innerHTML = '';

                    products.forEach(i => {
                        const tr = document.createElement('tr');
                        tr.className = 'table-row';
                        tr.innerHTML = `
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-primary">${i.product_id}</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <img loading="lazy" src="${i.image}" alt="${i.name}" class="w-10 h-10 rounded-full object-cover shadow-sm" />
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">${i.name}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">${i.brand_name}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">${i.total_packet}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">${i.packaging_type}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">₹${i.mrp}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">${i.net_weight}kg</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">${i.units_per_carton}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">${i.batch}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">${i.mfg_date}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">${i.exp_date}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-center">
                                <a href="/populate_product/${i.id}" class="text-info hover:text-blue-700 mr-3"><i class="fas fa-edit"></i></a>
                                <button id="${i.id}" class="DeleteProduct text-red-500 hover:text-red-700 cursor-pointer"><i class="fas fa-trash-alt"></i></button>
                            </td>
                        `;
                        document.querySelector('#display_table').appendChild(tr);
                    });

                    document.querySelectorAll('.DeleteProduct').forEach(i => {
                        i.addEventListener('click', async (e) => {
                            e.preventDefault();
                            let id = i.getAttribute('id');
                            const csrfToken = document.querySelector('meta[name="meta"]').getAttribute('content');

                            if (!confirm("Are you Sure You want to Delete this Product ?")) {
                                return;
                            }

                            const response = await fetch(`${window.location.origin}/ProductDelete`, {
                                method: "DELETE",
                                headers: {
                                    'Content-Type': 'application/json',
                                    'X-CSRF-Token': csrfToken
                                },
                                body: JSON.stringify({
                                    id: id
                                })
                            });
                            const result = await response.json();
                            if (response.ok) {
                                GetProductData();
                                toastr.success(result.success)
                            }
                            if (!response.ok) {
                                toastr.error(result.error)
                            }
                        });
                    });
                    Pagination(data.product);
                }
                if (!response.ok) {
                    const error = await response.json();
                    toastr.error(`Backend Error : ${error.error}`);
                }
            } catch (e) {
                toastr.error(`API EXCEPTION : ${e}`);
            }
        }
    </script>

    <!-- Fetch Product Type -->
    <script>
        document.addEventListener('DOMContentLoaded', GetProductType);

        async function GetProductType() {
            let OptionContainer = document.querySelector('#option_container');
            try {
                const response = await fetch(`${window.location.origin}/product_type`);

                if (response.ok) {
                    const type = await response.json();

                    OptionContainer.innerHTML = ''
                    const result = type.success
                    result.forEach(i => {
                        let option = document.createElement('option');
                        option.value = i.name;
                        option.innerText = i.name;
                        OptionContainer.appendChild(option);
                    });

                }

                if (!response.ok) {
                    const error = await response.json();
                    toastr.error(`Backend Error Exception : ${error.error}`);
                    OptionContainer.innerHTML = '';
                    OptionContainer.innerHTML = `<option value="packet">Packet</option>
                                                 <option value="pouch">Pouch</option>
                                                 <option value="jar">Jar</option>`;
                }

            } catch (error) {
                toastr.error(`API Exception : ${error}`);
                OptionContainer.innerHTML = `<option value="packet">Packet</option>
                                            <option value="pouch">Pouch</option>
                                            <option value="jar">Jar</option>`;
            }

        }
    </script>

    <!-- Toastr Notification (if not already included via x-cdnlinks) -->
    <script>
        toastr.options = {
            "closeButton": true,
            "progressBar": true,
            "positionClass": "toast-top-right",
            "timeOut": "3000"
        };
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', async (e) => {
            e.preventDefault();
            try {
                const response = await fetch(`${window.location.origin}/overview`);
                const result = await response.json();
                if (response.ok) {
                    console.log(result);

                    document.querySelector('#total_product').innerText = result.totalProducts;
                    document.querySelector('#highest_stock').innerText = result.highestStock.units_per_carton;
                    document.querySelector('#highest_stock_name').innerText = result.highestStock.name;
                    document.querySelector('#lowest_stock').innerText = result.lowestStock.units_per_carton;
                    document.querySelector('#lowest_stock_name').innerText = result.lowestStock.name;

                    // Add expiry items with scrolling
                    if (result.expiry && result.expiry.length > 0) {

                        result.expires.forEach(i => {
                            const expiryElement = document.createElement('div');
                            const currentDate = new Date();
                            const futureDate = new Date(i.exp_date);

                            // Calculate the difference in milliseconds
                            const diffInMs = futureDate - currentDate;

                            // Convert milliseconds to days
                            const diffInDays = Math.ceil(diffInMs / (1000 * 60 * 60 * 24));

                            console.log(`Days until expiration: ${diffInDays}`);

                            expiryElement.className = 'bg-orange-100 p-4 rounded-lg border-l-4 border-orange-500';
                            expiryElement.innerHTML = `
                                <p class="text-sm text-orange-600 font-medium">Expires in ${diffInDays} Days</p>
                                <p class="text-lg font-bold text-orange-600">${i.name}</p>
                                <p class="text-sm text-orange-600">Expires at : ${i.exp_date}</p>
                            `;

                            document.querySelector('#overview').appendChild(expiryElement);
                        });

                        result.expiry.forEach(i => {
                            const expiryElement = document.createElement('div');
                            expiryElement.className = 'bg-red-50 p-4 rounded-lg border-l-4 border-red-500';
                            expiryElement.innerHTML = `
                                <p class="text-sm text-red-600 font-medium">Expired Product</p>
                                <p class="text-lg font-bold text-red-700">${i.name}</p>
                                <p class="text-sm text-red-500">Expired: ${i.exp_date}</p>
                            `;
                            document.querySelector('#overview').appendChild(expiryElement);
                        });
                    }
                }

                if (!response.ok) {
                    toastr.error(result.error);
                }
            } catch (error) {
                toastr.error(error);
            }
        });
    </script>

</body>

</html>