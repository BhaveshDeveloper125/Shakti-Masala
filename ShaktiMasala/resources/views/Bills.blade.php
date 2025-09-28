<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice Bill</title>
    <x-cdnlinks />
    <style>
        /* Reset and base styles */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Times New Roman', serif;
        }

        body {
            background-color: white;
            color: black;
            line-height: 1.4;
            padding: 20px;
            font-size: 12px;
        }

        /* Bill container */
        .bill-container {
            max-width: 800px;
            margin: 0 auto;
            border: 1px solid black;
            padding: 20px;
        }

        /* Header section */
        .bill-header {
            text-align: center;
            margin-bottom: 20px;
            padding-bottom: 15px;
            border-bottom: 2px solid black;
        }

        .company-info h1 {
            font-size: 24px;
            margin-bottom: 5px;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .company-info p {
            font-size: 12px;
            margin-bottom: 3px;
        }

        .invoice-title {
            margin-top: 15px;
            font-size: 18px;
            font-weight: bold;
            text-decoration: underline;
        }

        /* Customer info section */
        .customer-info {
            margin-bottom: 20px;
        }

        .info-row {
            display: flex;
            margin-bottom: 5px;
        }

        .info-label {
            font-weight: bold;
            min-width: 150px;
        }

        /* Tables */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
            font-size: 11px;
        }

        th,
        td {
            border: 1px solid black;
            padding: 6px 8px;
            text-align: left;
        }

        th {
            font-weight: bold;
            background-color: #f0f0f0;
        }

        /* Summary section */
        .bill-summary {
            margin-top: 20px;
            padding-top: 10px;
            border-top: 2px solid black;
        }

        .summary-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 5px;
        }

        .summary-label {
            font-weight: bold;
        }

        .total-row {
            font-weight: bold;
            border-top: 1px solid black;
            padding-top: 5px;
            margin-top: 5px;
            font-size: 14px;
        }

        /* Footer section */
        .bill-footer {
            margin-top: 30px;
            padding-top: 10px;
            border-top: 1px solid black;
            text-align: center;
            font-size: 11px;
        }

        .thank-you {
            margin-bottom: 10px;
            font-weight: bold;
        }


        /* Print styles */
        @media print {
            body {
                padding: 0;
            }

            .bill-container {
                border: none;
                padding: 0;
                max-width: 100%;
            }

            .no-print {
                display: none !important;
            }
        }

        /* Print button */
        .print-button {
            display: block;
            width: 150px;
            margin: 20px auto;
            padding: 8px;
            background: white;
            color: black;
            border: 1px solid black;
            font-size: 14px;
            cursor: pointer;
        }

        .print-button:hover {
            background: #f0f0f0;
        }

        /* Rupee symbol styling */
        .rupee {
            font-family: Arial, sans-serif;
        }
    </style>
</head>

<body class=" p-4">

    <div class="bill-container">
        <!-- Header Section -->
        <div class="bill-header">
            <div class="company-info">
                <h1>Your Company Name</h1>
                <p>123 Business Street, City, State 12345</p>
                <p>Phone: (123) 456-7890 | Email: info@company.com</p>
            </div>
            <div class="invoice-title">INVOICE</div>
        </div>

        <!-- Customer Information -->
        <div class="customer-info">
            <div class="info-row">
                <div class="info-label">Invoice No:</div>
                <div>{{ $customer->invoice }}</div>
            </div>
            <div class="info-row">
                <div class="info-label">Customer Name:</div>
                <div>{{ $customer->customer_name }}</div>
            </div>
            <div class="info-row">
                <div class="info-label">Customer Type:</div>
                <div>{{ $customer->customer_type }}</div>
            </div>
            <div class="info-row">
                <div class="info-label">Date:</div>
                <div>{{ $customer->date }}</div>
            </div>
            <div class="info-row">
                <div class="info-label">Payment Mode:</div>
                <div>{{ $customer->payment_mode }}</div>
            </div>
            <div class="info-row">
                <div class="info-label">Payment Status:</div>
                <div>{{ $customer->payment_status }}</div>
            </div>
        </div>

        <!-- Items Table -->
        <table>
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Brand</th>
                    <th>MRP</th>
                    <th>Total Packet</th>
                    <th>Price Per Carat</th>
                    <th>Packaging Type</th>
                    <th>Net Weight</th>
                    <th>Payable Amount</th>
                </tr>
            </thead>
            <tbody>
                @forelse($sales as $i)
                <tr>
                    <td>{{ $i->name }}</td>
                    <td>{{ $i->brand }}</td>
                    <td><span class="rupee">₹</span>{{ $i->mrp }}</td>
                    <td>{{ $i->total_packet }}</td>
                    <td><span class="rupee">₹</span>{{ $i->price_per_carot }}</td>
                    <td>{{ $i->packaging_type }}</td>
                    <td>{{ $i->net_weight }}</td>
                    <td><span class="rupee">₹</span>{{ $i->payable_amount }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" style="text-align: center;">No items found</td>
                </tr>
                @endforelse
            </tbody>
        </table>

        <!-- Summary Section -->
        <div class="bill-summary">
            <div class="summary-row">
                <div class="summary-label">Partial Amount:</div>
                <div><span class="rupee">₹</span>{{ $customer->partial_amount }}</div>
            </div>
            <div class="summary-row">
                <div class="summary-label">Extra Charges:</div>
                <div><span class="rupee">₹</span>{{ $customer->extra_charges }}</div>
            </div>
            <div class="summary-row total-row">
                <div class="summary-label">Total Price:</div>
                <div><span class="rupee">₹</span>{{ $customer->total_price }}</div>
            </div>
        </div>

        <!-- Footer Section -->
        <div class="bill-footer">
            <div class="thank-you">Thank you for your business!</div>
            <div>If you have any questions about this invoice, please contact</div>
            <div>Phone: (123) 456-7890 | Email: info@company.com</div>
            <div style="margin-top: 10px;">Generated on: {{ $customer->created_at }}</div>
        </div>
    </div>
    <button class="print-button no-print" onclick="window.print()">Print Bill</button>


    <script>
        // Function to open print preview
        function openPrintPreview() {
            window.print();
        }

        // Add rupee symbol before all currency values
        document.addEventListener('DOMContentLoaded', function() {
            // This would be handled by your server-side rendering
            // For demo purposes, we're just showing the structure
        });
    </script>
</body>

</html>