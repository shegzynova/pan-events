@extends('admin.layouts.app')

@section('content')
    <style>
        @media print {
            body {
                display: none; /* Hide all elements on the page by default */
            }
            #invoice {
                display: block; /* Display only the 'invoice' div */
            }
        }
    </style>
    <div class="content">
    <div class="intro-y flex flex-col sm:flex-row items-center mt-8">
        <h2 class="text-lg font-medium mr-auto">
            Invoice
        </h2>
        <div class="w-full sm:w-auto flex mt-4 sm:mt-0">
            <button class="btn btn-primary shadow-md mr-2" onclick="printInvoice()">Print</button>
            <div class="dropdown ml-auto sm:ml-0">
                <button class="dropdown-toggle btn px-2 box" aria-expanded="false" data-tw-toggle="dropdown">
                    <span class="w-5 h-5 flex items-center justify-center"> <i class="w-4 h-4" data-lucide="plus"></i> </span>
                </button>
                <div class="dropdown-menu w-40">
                    <div class="dropdown-content">
                        <a href="" class="dropdown-item" onclick="exportToWord()"> <i data-lucide="file" class="w-4 h-4 mr-2"></i> Export Word </a>
                        <a href="" class="dropdown-item"> <i data-lucide="file" class="w-4 h-4 mr-2"></i> Export PDF </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- BEGIN: Invoice -->
    <div class="intro-y box overflow-hidden mt-5" id="invoice">
        <div class="flex flex-col lg:flex-row pt-10 px-5 sm:px-20 sm:pt-20 lg:pb-20 text-center sm:text-left">
            <div class="font-semibold text-primary text-3xl">INVOICE</div>
            <div class="mt-20 lg:mt-0 lg:ml-auto lg:text-right">
                <div class="text-xl text-primary font-medium">PAN EVENTS</div>
                <div class="mt-1">admin@panevents.com</div>
                <div class="mt-1">Lagos Address</div>
            </div>
        </div>
        <div class="flex flex-col lg:flex-row border-b px-5 sm:px-20 pt-10 pb-10 sm:pb-20 text-center sm:text-left">
            <div>
                <div class="text-base text-slate-500">Client Details</div>
                <div class="text-xl text-primary font-medium">{{ $eventUser->user->full_name }}</div>
                <div class="mt-1">{{ $eventUser->user->email }}</div>
                <div class="mt-1">{{ $eventUser->city . ', ' . $eventUser->state_name->name . ', ' . $eventUser->country->name }}</div>
            </div>
            <div class="mt-10 lg:mt-0 lg:ml-auto lg:text-right">
                <div class="text-base text-slate-500">Receipt</div>
                <div class="text-lg text-primary font-medium mt-2">#{{ $eventUser->transaction->transaction_reference }}</div>
            </div>
        </div>
        <div class="px-5 sm:px-16 py-10 sm:py-20">
            <div class="overflow-x-auto">
                <table class="table">
                    <thead>
                    <tr>
                        <th class="border-b-2 dark:border-darkmode-400 whitespace-nowrap">DESCRIPTION</th>
                        <th class="border-b-2 dark:border-darkmode-400 text-right whitespace-nowrap">QTY</th>
                        <th class="border-b-2 dark:border-darkmode-400 text-right whitespace-nowrap">PRICE</th>
                        <th class="border-b-2 dark:border-darkmode-400 text-right whitespace-nowrap">SUBTOTAL</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td class="border-b dark:border-darkmode-400">
                            <div class="font-medium whitespace-nowrap">Midone HTML Admin Template</div>
                            <div class="text-slate-500 text-sm mt-0.5 whitespace-nowrap">Regular License</div>
                        </td>
                        <td class="text-right border-b dark:border-darkmode-400 w-32">2</td>
                        <td class="text-right border-b dark:border-darkmode-400 w-32">$25</td>
                        <td class="text-right border-b dark:border-darkmode-400 w-32 font-medium">$50</td>
                    </tr>
                    <tr>
                        <td class="border-b dark:border-darkmode-400">
                            <div class="font-medium whitespace-nowrap">Vuejs Admin Template</div>
                            <div class="text-slate-500 text-sm mt-0.5 whitespace-nowrap">Regular License</div>
                        </td>
                        <td class="text-right border-b dark:border-darkmode-400 w-32">1</td>
                        <td class="text-right border-b dark:border-darkmode-400 w-32">$25</td>
                        <td class="text-right border-b dark:border-darkmode-400 w-32 font-medium">$25</td>
                    </tr>
                    <tr>
                        <td class="border-b dark:border-darkmode-400">
                            <div class="font-medium whitespace-nowrap">React Admin Template</div>
                            <div class="text-slate-500 text-sm mt-0.5 whitespace-nowrap">Regular License</div>
                        </td>
                        <td class="text-right border-b dark:border-darkmode-400 w-32">1</td>
                        <td class="text-right border-b dark:border-darkmode-400 w-32">$25</td>
                        <td class="text-right border-b dark:border-darkmode-400 w-32 font-medium">$25</td>
                    </tr>
                    <tr>
                        <td>
                            <div class="font-medium whitespace-nowrap">Laravel Admin Template</div>
                            <div class="text-slate-500 text-sm mt-0.5 whitespace-nowrap">Regular License</div>
                        </td>
                        <td class="text-right w-32">3</td>
                        <td class="text-right w-32">$25</td>
                        <td class="text-right w-32 font-medium">$75</td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="px-5 sm:px-20 pb-10 sm:pb-20 flex flex-col-reverse sm:flex-row">
            <div class="text-center sm:text-left mt-10 sm:mt-0">
                <div class="text-base text-slate-500">Bank Transfer</div>
                <div class="text-lg text-primary font-medium mt-2">Elon Musk</div>
                <div class="mt-1">Bank Account : 098347234832</div>
                <div class="mt-1">Code : LFT133243</div>
            </div>
            <div class="text-center sm:text-right sm:ml-auto">
                <div class="text-base text-slate-500">Total Amount</div>
                <div class="text-xl text-primary font-medium mt-2">$20.600.00</div>
                <div class="mt-1">Taxes included</div>
            </div>
        </div>
    </div>
    <!-- END: Invoice -->
    </div>

    <script src="{{ asset('dist/js/docxtemplater.v3.29.1.js') }}"></script>
    <script src="https://unpkg.com/pizzip@3.1.4/dist/pizzip.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/FileSaver.js/1.3.8/FileSaver.js"></script>
    <script src="https://unpkg.com/pizzip@3.1.4/dist/pizzip-utils.js"></script>
    <script>
        function printInvoice() {
            window.print();
        }

        function exportToWord() {
            event.preventDefault();
            var content = $("#invoice").html();
            var template = new Docxgen();
            template.load(content);

            // Generate the Word document
            template.render();

            // Convert the generated document to a Blob
            var blob = template.getZip().generate({ type: "blob" });

            // Download the Blob as a Word file
            var fileName = "invoice.docx";
            saveAs(blob, fileName);
        }

        function exportToPDF() {
            // Logic to export the 'invoice' content to PDF format
            // You can use libraries like jsPDF, html2pdf, etc.
            alert("Exporting to PDF...");
        }
    </script>
@endsection


