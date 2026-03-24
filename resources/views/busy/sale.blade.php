<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Create Sale</title>
    @vite('resources/css/app.css')
</head>

<body class="bg-gray-100 p-6">

    <div class="max-w-4xl mx-auto bg-white p-6 rounded-xl shadow">
        <h2 class="text-2xl font-bold mb-6">Create Sale (BUSY)</h2>

        <form method="POST" action="{{ route('busy.sale.store') }}">
            @csrf

            <div class="grid grid-cols-2 gap-4">

                <!-- Customer -->
                <div>
                    <label class="block text-sm">Customer Name</label>
                    <input type="text" name="customer"
                        value="{{ old('customer', 'Customer-Amit Gupta') }}"
                        class="w-full border p-2 rounded bg-gray-100" readonly>
                </div>

                <!-- Voucher No -->
                <div>
                    <label class="block text-sm">Voucher No</label>
                    <input type="text" name="vch_no"
                        value="{{ old('vch_no') }}"
                        class="w-full border p-2 rounded">
                    @error('vch_no')
                        <p class="text-red-500 text-sm">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Date -->
                <div>
                    <label class="block text-sm">Date</label>
                    <input type="date" name="date"
                        value="{{ old('date') }}"
                        class="w-full border p-2 rounded">
                    @error('date')
                        <p class="text-red-500 text-sm">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Item -->
                <div>
                    <label class="block text-sm">Item Name</label>
                    <select name="item" class="w-full border p-2 rounded">
                        <option value="">Select Item</option>

                        <option value="Acer Laptop"
                            {{ old('item') == 'Acer Laptop' ? 'selected' : '' }}>
                            Acer Laptop
                        </option>

                        <option value="HP Victus"
                            {{ old('item') == 'HP Victus' ? 'selected' : '' }}>
                            HP Victus
                        </option>

                        <option value="Lenovo PC"
                            {{ old('item') == 'Lenovo PC' ? 'selected' : '' }}>
                            Lenovo PC
                        </option>
                    </select>
                    @error('item')
                        <p class="text-red-500 text-sm">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Quantity -->
                <div>
                    <label class="block text-sm">Quantity</label>
                    <input type="number" name="qty"
                        value="{{ old('qty') }}"
                        class="w-full border p-2 rounded">
                    @error('qty')
                        <p class="text-red-500 text-sm">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Price -->
                <div>
                    <label class="block text-sm">Price</label>
                    <input type="number" name="price"
                        value="{{ old('price') }}"
                        class="w-full border p-2 rounded">
                    @error('price')
                        <p class="text-red-500 text-sm">{{ $message }}</p>
                    @enderror
                </div>

            </div>

            <button class="mt-6 bg-blue-600 text-white px-4 py-2 rounded">
                Submit to BUSY
            </button>
        </form>

        <!-- Success Response -->
        @if (session('response'))
            <div class="mt-4 p-4 bg-green-100 rounded">
                {{ session('response') }}
            </div>
        @endif

    </div>

</body>

</html>