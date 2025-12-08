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
        body {
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

        /* Production-specific styles */
        .status-badge {
            padding: 0.25rem 0.75rem;
            border-radius: 9999px;
            font-size: 0.75rem;
            font-weight: 500;
        }

        .status-active {
            background-color: rgba(34, 197, 94, 0.1);
            color: rgb(21, 128, 61);
        }

        .status-pending {
            background-color: rgba(251, 191, 36, 0.1);
            color: rgb(180, 83, 9);
        }

        .status-completed {
            background-color: rgba(59, 130, 246, 0.1);
            color: rgb(30, 64, 175);
        }

        .status-cancelled {
            background-color: rgba(239, 68, 68, 0.1);
            color: rgb(185, 28, 28);
        }

        .action-btn {
            padding: 0.5rem;
            border-radius: 0.375rem;
            transition: all 0.2s;
        }

        .action-btn:hover {
            background-color: rgba(59, 56, 160, 0.1);
        }
    </style>
</head>

<body class="min-h-screen flex">
    <!-- Sidebar Navigation -->
    <x-admin-menu />

    <!-- Main Content -->
    <div class="flex-1 overflow-auto p-6">
        <!-- Header with Actions -->
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8 animate-fade-in">
            <div>
                <h1 class="text-3xl font-bold text-primary mb-2">Inventory Management</h1>
                <p class="text-gray-600">Monitor and manage your production workflow and inventory</p>
            </div>
            <div class="mt-4 md:mt-0 flex space-x-3">
                <!-- <button class="bg-white border border-gray-300 text-gray-700 py-2 px-4 rounded-lg font-medium hover:bg-gray-50 transition-colors flex items-center">
                    <i class="fas fa-file-export mr-2"></i> Export Report
                </button> -->
                <a href="/production" class="bg-primary text-white py-2 px-4 rounded-lg font-medium hover:bg-secondary transition-colors flex items-center">
                    <i class="fas fa-plus-circle mr-2"></i> New Production Order
                </a>
            </div>
        </div>

        <!-- Stats Overview -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <div class="bg-white rounded-xl shadow-lg p-6 card-hover">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-sm font-medium text-gray-600">Total Products</p>
                        <p id="total_product" class="text-3xl font-bold text-primary mt-2">0</p>
                    </div>
                    <div class="bg-blue-100 p-3 rounded-full">
                        <i class="fas fa-boxes text-blue-600 text-xl"></i>
                    </div>
                </div>
                <p class="text-xs text-gray-500 mt-3">All products in inventory</p>
            </div>

            <div class="bg-white rounded-xl shadow-lg p-6 card-hover">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-sm font-medium text-red-600">Expired Products</p>
                        <p id="expired" class="text-3xl font-bold text-red-600 mt-2"></p>
                    </div>
                    <div class="bg-red-100 p-3 rounded-full">
                        <i class="fas fa-exclamation-triangle text-red-600 text-xl"></i>
                    </div>
                </div>
                <p class="text-xs text-red-500 mt-3">Currently in Stock</p>
            </div>


            <div class="bg-white rounded-xl shadow-lg p-6 card-hover">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-sm font-medium text-gray-600">Expiring Products</p>
                        <p id="NearExp" class="text-3xl font-bold text-yellow-600 mt-2"></p>
                    </div>
                    <div class="bg-yellow-100 p-3 rounded-full">
                        <i class="fas fa-clock text-yellow-600 text-xl"></i>
                    </div>
                </div>
                <p class="text-xs text-gray-500 mt-3">Expired soon products</p>
            </div>

            <div class="bg-white rounded-xl shadow-lg p-6 card-hover">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-sm font-medium text-gray-600">Total Stock</p>
                        <p id="TotalStock" class="text-3xl font-bold text-purple-600 mt-2"></p>
                    </div>
                    <div class="bg-purple-100 p-3 rounded-full">
                        <i class="fas fa-archive text-purple-600 text-xl"></i>
                    </div>
                </div>
                <p class="text-xs text-gray-500 mt-3">Sum of total stock</p>
            </div>


        </div>

        <!-- Production Overview -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mb-8">
            <!-- Inventory Status -->
            <div class="bg-white rounded-xl shadow-lg p-6 card-hover lg:col-span-2">
                <div class="flex items-center justify-between mb-6">
                    <h2 class="text-xl font-semibold text-primary">Inventory Status</h2>
                    <button class="text-sm text-primary font-medium hover:text-secondary transition-colors">
                        View All <i class="fas fa-chevron-right ml-1"></i>
                    </button>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="bg-blue-50 p-4 rounded-lg border-l-4 border-primary">
                        <p class="text-sm text-gray-600">Highest Stock</p>
                        <p id="highest_stock_name" class="text-sm text-gray-600 font-medium mt-1">Product Name</p>
                        <p id="highest_stock" class="text-2xl font-bold text-primary mt-2">0 units</p>
                    </div>

                    <div class="bg-yellow-50 p-4 rounded-lg border-l-4 border-yellow-500">
                        <p class="text-sm text-gray-600">Lowest Stock</p>
                        <p id="lowest_stock_name" class="text-sm text-gray-600 font-medium mt-1">Product Name</p>
                        <p id="lowest_stock" class="text-2xl font-bold text-yellow-600 mt-2">0 units</p>
                    </div>
                </div>

                <!-- Expiry Alerts -->
                <div class="mt-6">
                    <h3 class="text-lg font-medium text-gray-800 mb-4">Expiry Alerts</h3>
                    <div id="overview" class="space-y-3 overview-scroll" style="max-height: 200px; overflow-y: auto;">
                        <!-- Expiry items will be added here -->
                    </div>
                </div>
            </div>

            <!-- Recent Activity -->
            <div class="bg-white rounded-xl shadow-lg p-6 card-hover">
                <div class="flex items-center justify-between mb-6">
                    <h2 class="text-xl font-semibold text-primary">Recent Activity</h2>
                    <button class="text-sm text-primary font-medium hover:text-secondary transition-colors">
                        View All <i class="fas fa-chevron-right ml-1"></i>
                    </button>
                </div>

                <div class="space-y-4">
                    <div class="flex items-start">
                        <div class="bg-green-100 p-2 rounded-full mr-3 mt-1">
                            <i class="fas fa-check text-green-600 text-sm"></i>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-800">Production #PO-1024 completed</p>
                            <p class="text-xs text-gray-500">2 hours ago</p>
                        </div>
                    </div>

                    <div class="flex items-start">
                        <div class="bg-blue-100 p-2 rounded-full mr-3 mt-1">
                            <i class="fas fa-plus text-blue-600 text-sm"></i>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-800">New order received for 500 units</p>
                            <p class="text-xs text-gray-500">5 hours ago</p>
                        </div>
                    </div>

                    <div class="flex items-start">
                        <div class="bg-yellow-100 p-2 rounded-full mr-3 mt-1">
                            <i class="fas fa-exclamation text-yellow-600 text-sm"></i>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-800">Low stock alert for Product B</p>
                            <p class="text-xs text-gray-500">Yesterday</p>
                        </div>
                    </div>

                    <div class="flex items-start">
                        <div class="bg-purple-100 p-2 rounded-full mr-3 mt-1">
                            <i class="fas fa-sync-alt text-purple-600 text-sm"></i>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-800">Production #PO-1021 status updated</p>
                            <p class="text-xs text-gray-500">2 days ago</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Products Table -->
        <div class="bg-white rounded-xl shadow-lg overflow-hidden animate-slide-up">
            <div class="px-6 py-4 border-b border-gray-200 flex flex-col md:flex-row justify-between items-start md:items-center">
                <h2 class="text-xl font-semibold text-primary mb-2 md:mb-0">Production Inventory</h2>

            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full">
                    <thead>
                        <tr class="bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            <th class="px-6 py-3">Product ID</th>
                            <th class="px-6 py-3">Image</th>
                            <th class="px-6 py-3">Name</th>
                            <th class="px-6 py-3">Brand</th>
                            <th class="px-6 py-3">Stock</th>
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
                btn.className = `pagination-btn py-1 px-3 border rounded-md ${i == CurrentPage ? 'bg-primary text-white' : ''}`;
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
                    let TotalStock = 0;

                    products.forEach(i => {
                        TotalStock += i.total_packet;
                        const tr = document.createElement('tr');
                        tr.className = 'table-row';
                        tr.innerHTML = `
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-primary">${i.product_id}</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <img loading="lazy" src="${i.image}" alt="${i.name}" class="w-10 h-10 rounded-full object-cover shadow-sm" />
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">${i.name}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">${i.brand_name}</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium ${i.total_packet > 50 ? 'bg-green-100 text-green-800' : i.total_packet > 20 ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800'}">
                                    ${i.total_packet}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">${i.packaging_type}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">₹${i.mrp}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">${i.net_weight}kg</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">${i.units_per_carton}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">${i.batch}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">${i.mfg_date}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">${i.exp_date}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-center">
                                <div class="flex justify-center space-x-2">
                                    <button class="action-btn text-info hover:text-blue-700">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button id="${i.id}" class="DeleteProduct action-btn text-red-500 hover:text-red-700">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                    <button class="action-btn text-green-500 hover:text-green-700">
                                        <i class="fas fa-chart-line"></i>
                                    </button>
                                </div>
                            </td>
                        `;
                        document.querySelector('#display_table').appendChild(tr);
                    });

                    document.querySelector('#TotalStock').innerText = TotalStock;

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

            // Check if the element exists before trying to manipulate it
            if (!OptionContainer) {
                console.log('Option container not found - product form removed');
                return;
            }

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
            let TotalExpiredProduct = 0;
            e.preventDefault();
            try {
                const response = await fetch(`${window.location.origin}/overview`);
                const result = await response.json();
                if (response.ok) {
                    document.querySelector('#total_product').innerText = result.totalProducts;
                    document.querySelector('#highest_stock').innerText = result.highestStock.units_per_carton + ' units';
                    document.querySelector('#highest_stock_name').innerText = result.highestStock.name;
                    document.querySelector('#lowest_stock').innerText = result.lowestStock.units_per_carton + ' units';
                    document.querySelector('#lowest_stock_name').innerText = result.lowestStock.name;

                    // Add expiry items with scrolling
                    if (result.expiry && result.expiry.length > 0) {

                        let NearExpDate = 0;

                        result.expires.forEach(i => {
                            NearExpDate++;
                            const expiryElement = document.createElement('div');
                            const currentDate = new Date();
                            const futureDate = new Date(i.exp_date);

                            // Calculate the difference in milliseconds
                            const diffInMs = futureDate - currentDate;

                            // Convert milliseconds to days
                            const diffInDays = Math.ceil(diffInMs / (1000 * 60 * 60 * 24));

                            console.log(`Days until expiration: ${diffInDays}`);

                            expiryElement.className = 'bg-orange-100 p-3 rounded-lg border-l-4 border-orange-500 mb-2';
                            expiryElement.innerHTML = `
                                <p class="text-sm text-orange-600 font-medium">Expires in ${diffInDays} Days</p>
                                <p class="text-sm font-bold text-orange-600">${i.name}</p>
                                <p class="text-xs text-orange-600">Expires: ${i.exp_date}</p>
                            `;

                            document.querySelector('#overview').appendChild(expiryElement);
                        });
                        document.querySelector('#NearExp').innerText = NearExpDate;

                        result.expiry.forEach(i => {
                            TotalExpiredProduct++;
                            const expiryElement = document.createElement('div');
                            expiryElement.className = 'bg-red-100 p-3 rounded-lg border-l-4 border-red-500 mb-2';
                            expiryElement.innerHTML = `
                                <p class="text-sm text-red-600 font-medium">Expired Product</p>
                                <p class="text-sm font-bold text-red-700">${i.name}</p>
                                <p class="text-xs text-red-500">Expired: ${i.exp_date}</p>
                            `;
                            document.querySelector('#overview').appendChild(expiryElement);
                        });

                        document.querySelector('#expired').innerText = TotalExpiredProduct;
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