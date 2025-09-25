<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Partially Paid Entries</title>
    <x-cdnlinks />
</head>

<body class="h-screen w-screen flex">
    <x-admin-menu />
    <div class="flex-1">

        <figure>
            <table class="table-auto border border-gray-400 w-full">
                <thead>
                    <tr class="bg-gray-200">
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
                    </tr>
                </thead>
                <tr>
                    <td class="border border-gray-300 px-2 py-1">{{ $customer->invoice }}</td>
                    <td class="border border-gray-300 px-2 py-1">{{ $customer->customer_name }}</td>
                    <td class="border border-gray-300 px-2 py-1">{{ $customer->customer_type }}</td>
                    <td class="border border-gray-300 px-2 py-1">{{ $customer->date }}</td>
                    <td class="border border-gray-300 px-2 py-1">{{ $customer->payment_mode }}</td>
                    <td class="border border-gray-300 px-2 py-1">{{ $customer->payment_status }}</td>
                    <td class="border border-gray-300 px-2 py-1">{{ $customer->extra_charges }}</td>
                    <td class="border border-gray-300 px-2 py-1">{{ $customer->partial_amount }}</td>
                    <td class="border border-gray-300 px-2 py-1">{{ $customer->total_price - $customer->partial_amount }}</td>
                    <td class="border border-gray-300 px-2 py-1">{{ $customer->total_price }}</td>
                </tr>
            </table>
        </figure>

        <br>

        <form action="/update_unpaid" method="post">
            @csrf
            @method('PUT')
            <input type="hidden" name="id" id="partially_id" value="{{  $customer->id  }}" required class="">
            <input type="number" name="invoice" min="0" id="invoice" required placeholder="Enter Invoice Number">
            <input type="number" name="partial_amount" min="0" id="partial_amount" required placeholder="Enter Amount">
            <button type="submit">Pay</button>
        </form>

        <figure>
            <table class="table-auto border border-gray-400 w-full">
                <thead>
                    <tr class="bg-gray-200">
                        <th class="border border-gray-300 px-2 py-1">Name</th>
                        <th class="border border-gray-300 px-2 py-1">Brand</th>
                        <th class="border border-gray-300 px-2 py-1">MRP</th>
                        <th class="border border-gray-300 px-2 py-1">Total Packet</th>
                        <th class="border border-gray-300 px-2 py-1">Price Per Carot</th>
                        <th class="border border-gray-300 px-2 py-1">Packaging Type</th>
                        <th class="border border-gray-300 px-2 py-1">Net Weight</th>
                        <th class="border border-gray-300 px-2 py-1">Net Per Unit</th>
                        <th class="border border-gray-300 px-2 py-1">Units Per Carton</th>
                        <th class="border border-gray-300 px-2 py-1">Batch</th>
                        <th class="border border-gray-300 px-2 py-1">Payable Amount</th>
                        <th class="border border-gray-300 px-2 py-1">MFG Date</th>
                        <th class="border border-gray-300 px-2 py-1">EXP Date</th>
                    </tr>
                </thead>
                @forelse($customer->sale as $i)
                <tr class="">
                    <td class="border border-gray-300 px-2 py-1">{{ $i->name }}</td>
                    <td class="border border-gray-300 px-2 py-1">{{ $i->brand }}</td>
                    <td class="border border-gray-300 px-2 py-1">{{ $i->mrp }}</td>
                    <td class="border border-gray-300 px-2 py-1">{{ $i->total_packet }}</td>
                    <td class="border border-gray-300 px-2 py-1">{{ $i->price_per_carot }}</td>
                    <td class="border border-gray-300 px-2 py-1">{{ $i->packaging_type }}</td>
                    <td class="border border-gray-300 px-2 py-1">{{ $i->net_weight }}</td>
                    <td class="border border-gray-300 px-2 py-1">{{ $i->net_per_unit }}</td>
                    <td class="border border-gray-300 px-2 py-1">{{ $i->units_per_carton }}</td>
                    <td class="border border-gray-300 px-2 py-1">{{ $i->batch }}</td>
                    <td class="border border-gray-300 px-2 py-1">{{ $i->payable_amount }}</td>
                    <td class="border border-gray-300 px-2 py-1">{{ $i->mfg_date }}</td>
                    <td class="border border-gray-300 px-2 py-1">{{ $i->exp_date }}</td>
                </tr>
                <br><br>
                @empty
                <tr>
                    <td>Empty</td>
                </tr>
                @endforelse
            </table>
        </figure>


    </div>

</body>

</html>