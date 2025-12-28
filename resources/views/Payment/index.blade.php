@php
    use Illuminate\Support\Facades\Session;

@endphp
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Laravel PayPal Payment Gateway Integration </title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container">
    <div class="row mt-5 mb-5">
        <div class="col-10 offset-1 mt-5">
            <div class="card">
                <div class="card-header bg-primary">
                    <h3 class="text-white">Laravel PayPal Payment Gateway Integration Example </h3>
                </div>
                <div class="card-body">

                    @if ($message = Session::get('success'))
                      <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <strong>{{ $message }}</strong>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                      </div>
                    @endif

                    @if ($message = Session::get('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                          <strong>{{ $message }}</strong>
                          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <center>
                        <a href="{{ route('paypal.payment') }}" class="btn btn-success">Pay with PayPal </a>
                    </center>

                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>






{{--
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet"/>
</head>
<body class="bg-gray-100 flex justify-center items-center min-h-screen">
    <div class="bg-white p-8 rounded-lg shadow-lg w-full max-w-4xl">
        <h1 class="text-3xl font-bold mb-6">Payment</h1>
        <p class="text-lg mb-4">Choose payment method below</p>

        <!-- Payment Options -->
        <div class="flex justify-between mb-8">
            <!-- Credit Card Option -->
            <div class="border-2 border-gray-300 rounded-lg p-4 flex items-center cursor-pointer">
                <i class="fas fa-credit-card text-2xl text-gray-500 mr-4"></i>
                <span class="text-gray-500 font-semibold">PAY WITH CREDIT CARD</span>
            </div>

            <!-- PayPal Option -->
            <div class="border-2 border-blue-500 rounded-lg p-4 flex items-center cursor-pointer">
                <img alt="Pay with PayPal" class="mr-4" height="50" src="https://storage.googleapis.com/a1aa/image/YkNhCvy509pBaiQ6_lrY61HAhK7-gSAbGDTMewhkb9w.jpg" width="100"/>
                <span class="text-blue-500 font-semibold">PAY WITH PAYPAL</span>
                <i class="fas fa-check-circle text-blue-500 ml-4"></i>
            </div>

            <!-- Amazon Payments Option -->
            <div class="border-2 border-gray-300 rounded-lg p-4 flex items-center cursor-pointer">
                <img alt="Pay with Amazon Payments" class="mr-4" height="50" src="https://storage.googleapis.com/a1aa/image/Iv21i78ZQzoytEdOC-_DQL9Lrr_o-xlTJ_--kUjcqNA.jpg" width="100"/>
                <span class="text-gray-500 font-semibold">PAY WITH AMAZON PAYMENTS</span>
            </div>
        </div>

        <!-- Form for Payment -->
        <form action="{{ url('pay') }}" method="POST">
            @csrf
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <!-- Billing Info -->
                <div>
                    <h2 class="text-xl font-semibold mb-4 flex items-center">
                        <span class="bg-blue-500 text-white rounded-full w-6 h-6 flex items-center justify-center mr-2">1</span>
                        Billing Info
                    </h2>
                    <div class="mb-4">
                        <label class="block text-gray-700 mb-2">FULL NAME</label>
                        <input class="w-full border border-gray-300 rounded-lg p-2" type="text" name="full_name" value="John Doe" required/>
                    </div>
                    <div class="mb-4">
                        <label class="block text-gray-700 mb-2">BILLING ADDRESS</label>
                        <div class="relative">
                            <input class="w-full border border-gray-300 rounded-lg p-2" type="text" name="billing_address" value="Fyrton" required/>
                            <i class="fas fa-map-marker-alt absolute right-3 top-3 text-gray-500"></i>
                        </div>
                    </div>
                    <div class="grid grid-cols-2 gap-4 mb-4">
                        <div>
                            <label class="block text-gray-700 mb-2">CITY</label>
                            <input class="w-full border border-gray-300 rounded-lg p-2" type="text" name="city" value="Stockholm" required/>
                        </div>
                        <div>
                            <label class="block text-gray-700 mb-2">ZIP CODE</label>
                            <input class="w-full border border-gray-300 rounded-lg p-2" type="text" name="zip_code" value="12804" required/>
                        </div>
                    </div>
                    <div>
                        <label class="block text-gray-700 mb-2">COUNTRY</label>
                        <input class="w-full border border-gray-300 rounded-lg p-2" type="text" name="country" value="Sweden" required/>
                    </div>
                </div>

                <!-- PayPal Info -->
                <div>
                    <h2 class="text-xl font-semibold mb-4 flex items-center">
                        <span class="bg-blue-500 text-white rounded-full w-6 h-6 flex items-center justify-center mr-2">2</span>
                        PayPal Info
                    </h2>
                    <div class="mb-4">
                        <label class="block text-gray-700 mb-2">PAYPAL EMAIL</label>
                        <input class="w-full border border-gray-300 rounded-lg p-2" type="email" name="paypal_email" value="john.doe@example.com" required/>
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="flex justify-between mt-8">
                <button class="bg-gray-200 text-gray-700 px-6 py-2 rounded-lg">RETURN TO STORE</button>
                <div>
                    <button class="bg-gray-200 text-gray-700 px-6 py-2 rounded-lg mr-4">BACK TO SHIPPING</button>
                    <button type="submit" class="bg-blue-500 text-white px-6 py-2 rounded-lg">PROCEED</button>
                </div>
            </div>
        </form>
    </div>
</body>
</html> --}}
