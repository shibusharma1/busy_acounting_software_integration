<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Create Account</title>
    @vite('resources/css/app.css')
</head>

<body class="bg-gray-100 p-6">

<div class="max-w-4xl mx-auto bg-white p-6 rounded-xl shadow">
    <h2 class="text-2xl font-bold mb-6">Create Account (BUSY)</h2>

    <form method="POST" action="{{ route('busy.account.store') }}">
        @csrf

        <div class="grid grid-cols-2 gap-4">

            <input type="text" name="name" placeholder="Name" class="border p-2 rounded">
            <input type="text" name="mobile" placeholder="Mobile" class="border p-2 rounded">

            <input type="text" name="whatsapp" placeholder="WhatsApp" class="border p-2 rounded">
            <input type="text" name="pan" placeholder="PAN" class="border p-2 rounded">

            <input type="text" name="gst" placeholder="GST" class="border p-2 rounded">
            <input type="text" name="state" placeholder="State" class="border p-2 rounded">

            <input type="text" name="address1" placeholder="Address 1" class="border p-2 rounded">
            <input type="text" name="address2" placeholder="Address 2" class="border p-2 rounded">

            <input type="text" name="acc_no" placeholder="Account No" class="border p-2 rounded">
            <input type="text" name="ifsc" placeholder="IFSC" class="border p-2 rounded">

            <input type="text" name="bank" placeholder="Bank" class="border p-2 rounded">
            <input type="text" name="branch" placeholder="Branch Code" class="border p-2 rounded">

        </div>

        <button class="mt-6 bg-blue-600 text-white px-4 py-2 rounded">
            Create Account
        </button>
    </form>

    @if(session('response'))
        <div class="mt-4 p-4 bg-green-100 rounded">
            {{ session('response') }}
        </div>
    @endif

</div>

</body>
</html>