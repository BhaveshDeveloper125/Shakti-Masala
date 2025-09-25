<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Product Types Management</title>
    <x-cdnlinks />
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #f5f7fa 0%, #e4e8f0 100%);
        }

        .gradient-bg {
            background: linear-gradient(135deg, #1A2A80 0%, #3B38A0 100%);
        }

        .card-gradient {
            background: linear-gradient(135deg, #ffffff 0%, #f0f4ff 100%);
        }

        .btn-primary {
            background: linear-gradient(135deg, #113F67 0%, #154D71 100%);
            transition: all 0.3s ease;
        }

        .btn-primary:hover {
            background: linear-gradient(135deg, #154D71 0%, #113F67 100%);
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(17, 63, 103, 0.3);
        }

        .btn-delete {
            background: linear-gradient(135deg, #FF416C 0%, #FF4B2B 100%);
            transition: all 0.3s ease;
        }

        .btn-delete:hover {
            background: linear-gradient(135deg, #FF4B2B 0%, #FF416C 100%);
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(255, 75, 43, 0.3);
        }

        .table-row {
            transition: all 0.3s ease;
        }

        .table-row:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 12px rgba(0, 27, 183, 0.15);
        }

        .animate-in {
            animation: fadeIn 0.5s ease-out;
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

        .input-focus:focus {
            border-color: #3B38A0;
            box-shadow: 0 0 0 3px rgba(59, 56, 160, 0.2);
        }

        /* Mobile menu button styling */
        #mobile-menu-btn {
            display: none;
        }

        @media (max-width: 768px) {
            #mobile-menu-btn {
                display: block;
            }
        }
    </style>
</head>

<body class="min-h-screen flex">
    <!-- Use Laravel admin menu component -->
    <x-admin-menu />

    <!-- Mobile header -->
    <div class="gradient-bg text-white p-4 w-full fixed top-0 z-10 md:hidden">
        <div class="flex justify-between items-center">
            <h1 class="text-xl font-bold"><i class="fas fa-cubes mr-2"></i>Product Manager</h1>
            <button id="mobile-menu-btn" class="text-white focus:outline-none">
                <i class="fas fa-bars text-xl"></i>
            </button>
        </div>
    </div>

    <!-- Main Content -->
    <div class="flex-1 md:ml-0 p-4 md:p-6 mt-16 md:mt-0">
        <div class="max-w-6xl mx-auto">
            <!-- Header -->
            <div class="mb-8 animate-in">
                <h1 class="text-3xl font-bold text-gray-800">Product Packaging Types</h1>
                <p class="text-gray-600">Manage your product packaging types and categories</p>
            </div>

            <!-- Add Product Type Card -->
            <div class="card-gradient rounded-xl shadow-lg p-6 mb-8 animate-in">
                <h2 class="text-xl font-semibold text-gray-800 mb-4 flex items-center">
                    <i class="fas fa-plus-circle mr-2 text-[#113F67]"></i> Add New Product Type
                </h2>
                <form action="/add_product_type" id="product_form" method="post" class="flex flex-col md:flex-row gap-4">
                    @csrf
                    <div class="flex-grow">
                        <input type="text" name="name" id="name"
                            class="w-full p-3 border border-gray-300 rounded-lg input-focus focus:outline-none"
                            placeholder="Enter product type name" required>
                    </div>
                    <button type="submit" id="Add_Product"
                        class="btn-primary text-white font-semibold py-3 px-6 rounded-lg flex items-center justify-center">
                        <i class="fas fa-plus mr-2"></i> Add Type
                    </button>
                </form>
            </div>

            <!-- Product Types Table -->
            <div class="card-gradient rounded-xl shadow-lg overflow-hidden animate-in">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h2 class="text-xl font-semibold text-gray-800 flex items-center">
                        <i class="fas fa-list-alt mr-2 text-[#113F67]"></i> Existing Product Types
                    </h2>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead>
                            <tr class="gradient-bg text-white">
                                <th class="py-4 px-6 text-left font-semibold">Product Packaging Type</th>
                                <th class="py-4 px-6 text-center font-semibold">Action</th>
                            </tr>
                        </thead>
                        <tbody id="product_type_display" class="divide-y divide-gray-200">
                            <!-- Data will be inserted here dynamically -->
                        </tbody>
                    </table>
                </div>
                <div class="p-4 border-t border-gray-200 text-center text-gray-600 hidden" id="empty-state">
                    <i class="fas fa-inbox text-4xl mb-2 opacity-50"></i>
                    <p>No product types added yet. Add your first product type above.</p>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Toastr configuration
        toastr.options = {
            "closeButton": true,
            "progressBar": true,
            "positionClass": "toast-top-right",
            "timeOut": "3000"
        };

        // Fetch the Product Types
        async function GetProductPackagingType() {
            try {
                const response = await fetch(`${window.location.origin}/product_type`);
                if (response.ok) {
                    const result = await response.json();
                    const data = result.success;
                    let TableBody = document.querySelector('#product_type_display');
                    let emptyState = document.querySelector('#empty-state');

                    TableBody.innerHTML = '';

                    if (data.length === 0) {
                        emptyState.classList.remove('hidden');
                    } else {
                        emptyState.classList.add('hidden');

                        data.forEach(i => {
                            let tr = document.createElement('tr');
                            tr.className = 'table-row hover:bg-blue-50';
                            tr.innerHTML = `
                                <td class="py-4 px-6 font-medium text-gray-900">${i.name}</td> 
                                <td class="py-4 px-6 text-center">
                                    <button id="${i.id}" class="btn-delete text-white font-medium py-2 px-4 rounded-lg flex items-center justify-center mx-auto">
                                        <i class="fas fa-trash-alt mr-2"></i> Delete
                                    </button>
                                </td>
                            `;
                            TableBody.appendChild(tr);
                        });

                        document.querySelectorAll('.btn-delete').forEach(i => {
                            i.addEventListener('click', async (e) => {
                                try {
                                    e.preventDefault();
                                    let id = i.getAttribute('id');
                                    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

                                    // Confirmation dialog
                                    if (!confirm('Are you sure you want to delete this product type?')) {
                                        return;
                                    }

                                    const response = await fetch(`${window.location.origin}/delete_type`, {
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
                                        toastr.success(result.success);
                                        GetProductPackagingType();
                                    } else if (!response.ok) {
                                        toastr.error(result.error);
                                    }
                                } catch (error) {
                                    toastr.error(error);
                                }
                            });
                        });
                    }
                }
                if (!response.ok) {
                    const result = await response.json();
                    toastr.error(result.error);
                }
            } catch (error) {
                toastr.error(error);
            }
        }

        document.addEventListener('DOMContentLoaded', function() {
            GetProductPackagingType();

            // Form submission handler
            document.querySelector('#product_form').addEventListener('submit', async (e) => {
                e.preventDefault();
                const form = document.querySelector('#product_form');
                const formData = new FormData(form);
                const submitBtn = document.querySelector('#Add_Product');

                // Show loading state
                submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i> Adding...';
                submitBtn.disabled = true;

                try {
                    const response = await fetch(`${window.location.origin}/add_product_type`, {
                        method: 'POST',
                        body: formData,
                    });

                    if (response.ok) {
                        const result = await response.json();
                        GetProductPackagingType();
                        toastr.success(result.success);
                        form.reset();
                    }

                    if (!response.ok) {
                        const result = await response.json();
                        toastr.error(result.error);
                    }

                } catch (error) {
                    toastr.error(`API Exception: ${error}`);
                } finally {
                    // Reset button state
                    submitBtn.innerHTML = '<i class="fas fa-plus mr-2"></i> Add Type';
                    submitBtn.disabled = false;
                }
            });

            // Mobile menu toggle - this will need to be adjusted based on your admin menu implementation
            document.querySelector('#mobile-menu-btn')?.addEventListener('click', function() {
                // This would need to be customized based on your admin menu structure
                const adminMenu = document.querySelector('x-admin-menu');
                if (adminMenu) {
                    // Toggle mobile menu visibility - implementation depends on your admin menu component
                    console.log("Mobile menu toggle would need custom implementation based on your admin menu");
                }
            });
        });
    </script>
</body>

</html>