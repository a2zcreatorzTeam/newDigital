<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>StateLife - Digital Premium Voucher</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body class="bg-slate-50 font-sans antialiased">

    <div class="max-w-2xl mx-auto my-12 px-4">
        <div class="bg-white shadow-xl rounded-2xl overflow-hidden border border-slate-100">

            <div class="bg-gradient-to-r from-emerald-800 to-teal-700 p-8 text-center text-white relative">
                <div class="absolute top-4 right-4 bg-emerald-600/30 text-emerald-200 text-xs px-3 py-1 rounded-full font-medium tracking-wider uppercase">
                    Official Payment Voucher
                </div>
                <div class="w-16 h-16 bg-white/10 rounded-full flex items-center justify-center mx-auto mb-4 backdrop-blur-sm border border-white/20">
                    <i class="fa-solid fa-shield-halved text-3xl text-amber-400"></i>
                </div>
                <h1 class="text-2xl font-bold tracking-wide uppercase">StateLife Insurance Corporation</h1>
                <p class="text-emerald-100 text-sm mt-1">Securing Your Future, Today</p>
            </div>

            <div class="p-8 text-center border-b border-slate-100 bg-emerald-50/30">
                <div class="w-12 h-12 bg-emerald-100 text-emerald-600 rounded-full flex items-center justify-center mx-auto mb-3">
                    <i class="fa-solid fa-circle-check text-2xl"></i>
                </div>
                <h2 class="text-xl font-bold text-slate-800">Thank You for Choosing StateLife!</h2>
                <p class="text-slate-600 text-sm max-w-md mx-auto mt-2 leading-relaxed">
                    Your digital premium payment voucher has been generated successfully. Your trust is our greatest asset, and we remain dedicated to protecting you and your loved ones.
                </p>
            </div>

            <div class="p-8 space-y-6">
                <h3 class="text-xs font-bold uppercase tracking-wider text-slate-400 mb-2">Policy & Consumer Information</h3>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 bg-slate-50 p-6 rounded-xl border border-slate-100">
                    <div>
                        <label class="block text-xs font-medium text-slate-500 uppercase">Customer Name</label>
                        <span class="block text-base font-semibold text-slate-800 mt-1">{{ $voucher->customer_name }}</span>
                    </div>

                    <div>
                        <label class="block text-xs font-medium text-slate-500 uppercase">Policy Number</label>
                        <span class="block text-base font-mono font-bold text-slate-800 mt-1 tracking-wide">{{ $voucher->policy_id }}</span>
                    </div>

                    <div>
                        <label class="block text-xs font-medium text-slate-500 uppercase">Premium Amount Due</label>
                        <span class="block text-lg font-bold text-emerald-700 mt-1">PKR {{ number_format($voucher->amount_within_due_date, 2) }}</span>
                    </div>

                    <div>
                        <label class="block text-xs font-medium text-slate-500 uppercase">Due Date</label>
                        <span class="block text-base font-semibold text-rose-600 mt-1">{{ \Carbon\Carbon::parse($voucher->due_date)->format('d M, Y') }}</span>
                    </div>
                </div>

                <div class="bg-gradient-to-br from-slate-900 to-slate-800 rounded-xl p-6 text-white shadow-md border border-slate-700 relative overflow-hidden">
                    <div class="absolute -right-6 -bottom-6 text-slate-700/20 text-8xl font-black select-none pointer-events-none">
                        BILL
                    </div>

                    <div class="flex items-center justify-between mb-3">
                        <span class="text-xs font-bold tracking-widest text-amber-400 uppercase">Main Voucher / Consumer ID</span>
                        <span class="text-[10px] bg-slate-700 text-slate-300 px-2 py-0.5 rounded font-mono">Kuickpay Enabled</span>
                    </div>

                    <div onclick="copyConsumerId('{{ $voucher->consumer_number }}')" class="text-2xl sm:text-3xl font-mono font-bold tracking-widest text-center py-3 bg-black/20 rounded-lg border border-white/5 shadow-inner cursor-pointer hover:bg-black/40 transition group relative" title="Click to copy Consumer ID">
                        <span id="consumer-num">{{ $voucher->consumer_number }}</span>
                        <i class="fa-regular fa-copy text-sm text-slate-400 ml-2 group-hover:text-amber-400 transition"></i>
                    </div>

                    <p class="text-slate-400 mt-3 text-center text-[11px]">
                        <i class="fa-solid fa-info-circle text-amber-400 mr-1"></i> Tip: **Click the ID above** to copy it automatically. Use it on any Bank App, ATM, or Mobile Wallet.
                    </p>
                </div>
            </div>

            <div class="px-8 pb-8">
                <div class="border-t border-slate-100 pt-6">
                    <h4 class="text-sm font-bold text-slate-700 mb-3"><i class="fa-solid fa-wallet text-emerald-600 mr-2"></i>How to Pay via Bank App / Wallet:</h4>
                    <ul class="text-xs text-slate-600 space-y-2 pl-6 list-decimal leading-relaxed">
                        <li>Log in to your **Mobile Banking App** (HBL, Alfalah, UBL, etc.) or **EasyPaisa / JazzCash**.</li>
                        <li>Navigate to **Bill Payments** ➔ Select **Kuickpay** (or search for Kuickpay / Payments Aggregator).</li>
                        <li>Enter the **Consumer ID** shown above in the bill reference field.</li>
                        <li>Verify your StateLife policy details and premium amount, then tap **Confirm Payment**.</li>
                    </ul>
                </div>
            </div>

            <div class="bg-slate-100 p-4 text-center text-[11px] text-slate-500 border-t border-slate-200">
                <p>© {{ date('Y') }} StateLife Insurance Corporation of Pakistan. All rights reserved.</p>
                <p class="mt-1 text-slate-400">This is a system-generated secure digital payment voucher. No physical signature required.</p>
            </div>

        </div>

        <div class="flex justify-between items-center mt-6 px-2 text-sm">
            <a href="{{route('frontend.index')}}" class="text-slate-600 hover:text-slate-800 transition flex items-center font-medium">
                <i class="fa-solid fa-arrow-left mr-2"></i> Back to Website
            </a>
            <button onclick="window.print()" class="bg-slate-800 hover:bg-slate-900 text-white px-4 py-2 rounded-lg font-medium shadow transition flex items-center">
                <i class="fa-solid fa-print mr-2"></i> Print Voucher
            </button>
        </div>
    </div>

    <script>
        // 1. Globally Configured Toast Mixin (For reusable clean toasts)
        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
            didOpen: (toast) => {
                toast.addEventListener('mouseenter', Swal.stopTimer)
                toast.addEventListener('mouseleave', Swal.resumeTimer)
            }
        });

        // 2. Sirf tab chalega jab Controller se 'success' ya 'error' ka session aayega
      
        Swal.fire({
            title: 'Voucher Generated!',
            text: "{{ session('success') }}",
            icon: 'success',
            confirmButtonColor: '#065f46',
            confirmButtonText: 'Great, Thank You!'
        });
      


        // 3. Consumer ID copy karne par Toast alert trigger karna (Yeh pehle ki tarah hi rahega)
        function copyConsumerId(text) {
            navigator.clipboard.writeText(text).then(() => {
                Toast.fire({
                    icon: 'success',
                    title: 'Consumer ID copied to clipboard!'
                });
            }).catch(err => {
                Toast.fire({
                    icon: 'error',
                    title: 'Failed to copy text'
                });
            });
        }
    </script>
</body>

</html>