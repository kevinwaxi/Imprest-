<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Warrant Template</title>

    @vite('resources/css/app.css')
</head>
<body class="antialiased flex flex-col h-screen text-sm font-sans text-gray-700 tracking-tight">
    <div class="w-full bg-white p-6 rounded-lg shadow print:shadow-none print:p-0">

        <!-- Header -->
        <div class="flex justify-between items-start border-b pb-4">
            <div>
                <h1 class="text-xl font-bold uppercase leading-tight">
                    Imprest Warrant <br> Form
                </h1>
            </div>
            <div class="flex items-center justify-center border-2 border-dashed border-gray-300 rounded-md p-4 text-gray-400 text-sm">
                @if($company->logo_path ?? false)
                    <img src="{{ asset('storage/' . $company->logo_path) }}" alt="Company Logo" class="h-16 object-contain">
                @else
                    Upload your company logo
                @endif
            </div>
        </div>

        <!-- Info Row -->
        <div class="flex justify-between mt-4 text-sm">
            <div class="space-y-1">
                <p><span class="font-semibold">Document No:</span> W: {{ $warrant->doc_number }}</p>
                <p><span class="font-semibold">Document Date:</span> {{ $warrant->created_at->format('d/m/y') }}</p>
                <p><span class="font-semibold">Staff Name:</span> {{ $warrant->staff->name }}</p>

                <div class="mt-4 space-y-1">
                    <p class="font-semibold">Payee Bank Details</p>
                    <p><span class="font-semibold">Bank:</span> {{ $warrant->bank_name ?? 'N/A' }}</p>
                    <p><span class="font-semibold">Branch:</span> {{ $warrant->bank_branch ?? 'N/A' }}</p>
                    <p><span class="font-semibold">Account Number:</span> {{ $warrant->account_number ?? '—' }}</p>
                </div>
            </div>

            <div class="text-right text-xs space-y-0.5">
                {{-- <p class="font-bold">{{ strtoupper($company->name) }}</p>
                <p>{{ $company->address }}</p>
                <p>{{ $company->city }}, {{ strtoupper($company->country) }}</p>
                <p class="mt-2">{{ $company->location }}</p>
                <p class="mt-2">Inquiries: {{ $company->phone }}</p>
                <p>Email: {{ $company->email }}</p> --}}
            </div>
        </div>

        <!-- Payment Narration -->
        <div class="mt-6">
            <p class="text-orange-600 font-semibold mb-2">Payment Narration</p>
            <table class="w-full border border-gray-300 text-sm">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="border p-2 text-left">Vote No</th>
                        <th class="border p-2 text-left">Account Name</th>
                        <th class="border p-2 text-left">Purpose</th>
                        <th class="border p-2 text-right">Amount</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($warrant->staff as $item)
                        <tr>
                            <td class="border p-2">{{ $item }}</td>
                            <td class="border p-2">{{ $item }}</td>
                            <td class="border p-2">{{ $item }}</td>
                            <td class="border p-2 text-right">{{ number_format($item, 2) }}</td>
                        </tr>
                    @endforeach
                    <tr class="font-semibold bg-gray-50">
                        <td colspan="3" class="border p-2 text-right">Total Amount (Kshs.)</td>
                        <td class="border p-2 text-right">{{ number_format($warrant->amount, 2) }}</td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- Payment Details -->
        <div class="mt-6">
            <table class="w-full border border-gray-300 text-xs">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="border p-2">Paying Bank</th>
                        <th class="border p-2">Cheque/IBANK No</th>
                        <th class="border p-2">Payment Date</th>
                        <th class="border p-2">Department</th>
                        <th class="border p-2">Program</th>
                        <th class="border p-2">Project No</th>
                        <th class="border p-2">Memo No</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="border p-2">{{ $warrant->paying_bank }}</td>
                        <td class="border p-2">{{ $warrant->cheque_number }}</td>
                        <td class="border p-2">{{ optional($warrant->payment_date)->format('d/m/Y') }}</td>
                        <td class="border p-2">{{ $warrant->department }}</td>
                        <td class="border p-2">{{ $warrant->project }}</td>
                        <td class="border p-2">{{ $warrant->project->code }}</td>
                        <td class="border p-2">{{ $warrant->memo_number }}</td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- Amount in Words -->
        <div class="mt-6 text-xs">
            <p class="bg-orange-600 text-white font-medium px-2 py-1">Amount Payable (In Words) Kshs.</p>
            <p class="border border-t-0 px-2 py-3">{{ strtoupper($warrant->amount) }}</p>
        </div>

        <!-- Document Approval -->
        <div class="mt-6">
            <p class="text-orange-600 font-semibold mb-2">Document Approval</p>
            <table class="w-full border border-gray-300 text-xs">
                <thead>
                    <tr>
                        <th class="border p-2 w-1/2"></th>
                        <th class="border p-2 w-1/4 text-center">Date & Time Prepared</th>
                        <th class="border p-2 w-1/4 text-center">Signature</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="border p-2 align-top">
                            <p><strong>Prepared by:</strong> {{ $warrant->prepared_by }}</p>
                            <p class="mt-4"><strong>Checked by:</strong> {{ $warrant->checked_by }}</p>
                        </td>
                        <td class="border p-2 text-center align-top">
                            <p>{{ $warrant->created_at->format('d/m/y') }}</p>
                            <p class="mt-4">{{ $warrant->created_at->format('d/m/y') }}</p>
                        </td>
                        <td class="border p-2 text-center align-top">
                            <p>__________</p>
                            <p class="mt-4">__________</p>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- Footer -->
        <div class="mt-8 text-xs space-y-4">
            <p>
                I certify that the amount has been captured in the system under the document number above...
            </p>

            <table class="w-full border border-gray-300">
                <tbody>
                    <tr class="bg-gray-50 font-semibold">
                        <td class="border p-2">Imprest Recipient</td>
                        <td class="border p-2 text-center">Date</td>
                        <td class="border p-2 text-center">Signature</td>
                    </tr>
                    <tr>
                        <td class="border p-2">Name: {{ $warrant->staff->name }}</td>
                        <td class="border p-2 text-center">____________</td>
                        <td class="border p-2 text-center">____________</td>
                    </tr>
                </tbody>
            </table>
        </div>

    </div>
</body>
</html>
