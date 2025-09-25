<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="meta" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sales Data</title>
    <x-cdnlinks />
</head>

<body class="h-screen w-screen flex ">
    <x-admin-menu />
    <div class="flex-1">
        <br><br>
        <h1 class="text-xl font-bold mb-4">Pending Payment Customers</h1>

        <table class="table-auto border border-gray-400 w-full mb-8">
            <thead>
                <tr class="">
                    <th class="border border-gray-300 px-2 py-1">Invoice</th>
                    <th class="border border-gray-300 px-2 py-1">Customer Name</th>
                    <th class="border border-gray-300 px-2 py-1">Customer Type</th>
                    <th class="border border-gray-300 px-2 py-1">Date</th>
                    <th class="border border-gray-300 px-2 py-1">Payment Mode</th>
                    <th class="border border-gray-300 px-2 py-1">Payment Status</th>
                    <th class="border border-gray-300 px-2 py-1">Extra Charges</th>
                    <th class="border border-gray-300 px-2 py-1">Partial Paid Amount</th>
                    <th class="border border-gray-300 px-2 py-1">Total Due Amount</th>
                    <th class="border border-gray-300 px-2 py-1">Total Payable Amount</th>
                    <th class="border border-gray-300 px-2 py-1">Action</th>
                </tr>
            </thead>
            <tbody id="pending_data" class="overflow-auto"></tbody>
        </table>

        <h1 class="text-xl font-bold mb-4">Partially Paid Customers</h1>

        <table class="table-auto border border-gray-400 w-full">
            <thead>
                <tr class="">
                    <th class="border border-gray-300 px-2 py-1">Invoice</th>
                    <th class="border border-gray-300 px-2 py-1">Customer Name</th>
                    <th class="border border-gray-300 px-2 py-1">Customer Type</th>
                    <th class="border border-gray-300 px-2 py-1">Date</th>
                    <th class="border border-gray-300 px-2 py-1">Payment Mode</th>
                    <th class="border border-gray-300 px-2 py-1">Payment Status</th>
                    <th class="border border-gray-300 px-2 py-1">Extra Charges</th>
                    <th class="border border-gray-300 px-2 py-1">Partial Paid Amount</th>
                    <th class="border border-gray-300 px-2 py-1">Total Due Amount</th>
                    <th class="border border-gray-300 px-2 py-1">Total Payable Amount</th>
                    <!-- <th class="border border-gray-300 px-2 py-1">Name</th>
                    <th class="border border-gray-300 px-2 py-1">Brand</th>
                    <th class="border border-gray-300 px-2 py-1">MRP</th>
                    <th class="border border-gray-300 px-2 py-1">Total Packet</th>
                    <th class="border border-gray-300 px-2 py-1">Price Per Carot</th>
                    <th class="border border-gray-300 px-2 py-1">Packaging Type</th>
                    <th class="border border-gray-300 px-2 py-1">Net Weight</th>
                    <th class="border border-gray-300 px-2 py-1">Net Per Unit</th>
                    <th class="border border-gray-300 px-2 py-1">Unit Per Carton</th>
                    <th class="border border-gray-300 px-2 py-1">Batch Number</th>
                    <th class="border border-gray-300 px-2 py-1">MFG Date</th>
                    <th class="border border-gray-300 px-2 py-1">EXP Date</th>
                    <th class="border border-gray-300 px-2 py-1">Payable Amount</th> -->
                    <th class="border border-gray-300 px-2 py-1">Action</th>
                </tr>
            </thead>
            <tbody id="partially_data" class="overflow-auto"></tbody>
        </table>
    </div>

    <!-- Getching the Pending and Pratially Paid Customer Details -->
    <script>
        async function UnpaidCustomerData() {
            try {
                const response = await fetch(`${window.location.origin}/unpaid_cus`);
                const result = await response.json();

                if (response.ok) {

                    // Start Displaying the Partially Paid Data
                    let partials = document.querySelector('#partially_data');
                    partials.innerHTML = '';
                    result.partially.forEach(i => {
                        let tr = document.createElement('tr');

                        tr.innerHTML = `
                            <td class="border border-gray-300 px-2 py-1"> ${i.invoice} </td>
                            <td class="border border-gray-300 px-2 py-1"> ${i.customer_name} </td>
                            <td class="border border-gray-300 px-2 py-1"> ${i.customer_type} </td>
                            <td class="border border-gray-300 px-2 py-1"> ${i.date} </td>
                            <td class="border border-gray-300 px-2 py-1"> ${i.payment_mode} </td>
                            <td class="border border-gray-300 px-2 py-1"> ${i.payment_status} </td>
                            <td class="border border-gray-300 px-2 py-1"> ${i.extra_charges} </td>
                            <td class="border border-gray-300 px-2 py-1">${i.partial_amount}</td>
                            <td class="border border-gray-300 px-2 py-1">${i.total_price - i.partial_amount}</td>
                            <td class="border border-gray-300 px-2 py-1"> ${i.total_price} </td>
                            <td class="border border-gray-300 px-2 py-1">
                                <a href="partial_emi/${i.invoice}">Add Emi Entry</a>
                            </td>
                        `;
                        partials.appendChild(tr);
                    });
                    // End Displaying the Partially Paid Data

                    // Start Displaying the Unpaid
                    let Pending = document.querySelector('#pending_data');
                    Pending.innerHTML = '';
                    result.pending.forEach(i => {
                        let tr = document.createElement('tr');

                        tr.innerHTML = `
                            <td class="border border-gray-300 px-2 py-1"> ${i.invoice} </td>
                            <td class="border border-gray-300 px-2 py-1"> ${i.customer_name} </td>
                            <td class="border border-gray-300 px-2 py-1"> ${i.customer_type} </td>
                            <td class="border border-gray-300 px-2 py-1"> ${i.date} </td>
                            <td class="border border-gray-300 px-2 py-1"> ${i.payment_mode} </td>
                            <td class="border border-gray-300 px-2 py-1"> ${i.payment_status} </td>
                            <td class="border border-gray-300 px-2 py-1"> ${i.extra_charges} </td>
                            <td class="border border-gray-300 px-2 py-1">${i.partial_amount}</td>
                            <td class="border border-gray-300 px-2 py-1">${i.total_price - i.partial_amount}</td>
                            <td class="border border-gray-300 px-2 py-1"> ${i.total_price} </td>
                             <td class="border border-gray-300 px-2 py-1">
                                <a href="partial_emi/${i.invoice}">Add Emi Entry</a>
                            </td>
                        `;
                        Pending.appendChild(tr);
                    });
                    // End Displaying the Unpaid
                } else {
                    toastr.error(result.error);
                }

            } catch (error) {
                toastr.error(error);
            }
        }

        document.addEventListener('DOMContentLoaded', UnpaidCustomerData);
    </script>

</body>

</html>