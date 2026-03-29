<!DOCTYPE html>
<html lang="ms">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>Dashboard Inventori</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 antialiased font-sans pb-20">

    <div class="max-w-md mx-auto min-h-screen relative flex flex-col">

        <header class="bg-emerald-600 text-white p-5 sticky top-0 z-50 shadow-md rounded-b-xl">
            <div class="flex justify-between items-center">
                <div>
                    <h1 class="text-xl font-bold">DapurKu 📦</h1>
                    <p class="text-sm opacity-90">Hai, {{ auth()->user()->name }}</p>
                </div>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit"
                        class="bg-emerald-800 text-xs px-3 py-2 rounded-full hover:bg-emerald-900 transition shadow-sm">
                        Keluar
                    </button>
                </form>


            </div>
        </header>

        <main class="flex-1 p-4 space-y-4 mt-2">

            <h2 class="text-lg font-bold text-gray-700 mb-2">Senarai Barang Dapur</h2>

            @forelse($items as $item)
                <div class="bg-white p-4 rounded-xl shadow-sm border border-gray-100 flex justify-between items-start">
                    <div class="flex-1">
                        <div class="mt-3">
                            <a href="{{ route('inventory.edit', $item->id) }}"
                                class="text-blue-600 bg-blue-50 px-3 py-1 rounded-md text-xs font-semibold border border-blue-200 hover:bg-blue-100 transition">
                                ✏️ Edit Barang
                            </a>
                        </div>
                        <h3 class="font-bold text-gray-800 text-lg leading-tight">{{ $item->name }}</h3>
                        <p class="text-xs text-gray-500 mt-1">Kategori: {{ $item->category }} |
                            {{ $item->packaging_type }}</p>

                        @if ($item->expired_date)
                            <p
                                class="text-xs mt-2 {{ \Carbon\Carbon::parse($item->expired_date)->isPast() ? 'text-red-600 font-bold' : 'text-orange-500' }}">
                                ⏳ Luput: {{ \Carbon\Carbon::parse($item->expired_date)->format('d M Y') }}
                            </p>
                        @endif
                    </div>

                    <div class="text-right flex flex-col items-end justify-between min-h-full">
                        <span class="text-2xl font-black text-emerald-600">
                            {{ rtrim(rtrim(number_format($item->quantity, 2), '0'), '.') }}
                            <span class="text-sm text-gray-500 font-normal">{{ $item->unit }}</span>
                        </span>

                        @if ($item->quantity <= $item->low_stock_threshold)
                            <span class="bg-red-100 text-red-700 text-[10px] font-bold px-2 py-1 rounded mt-2">Stok
                                Rendah</span>
                        @else
                            <span class="bg-green-100 text-green-700 text-[10px] font-bold px-2 py-1 rounded mt-2">Stok
                                Cukup</span>
                        @endif
                    </div>
                </div>
            @empty
                <div class="text-center py-10">
                    <div class="text-5xl mb-3">📭</div>
                    <h3 class="text-gray-500 font-medium">Inventori anda masih kosong.</h3>
                    <p class="text-sm text-gray-400 mt-1">Sila tambah barang untuk mula menjejak stok dapur anda.</p>
                </div>
            @endforelse

            <div class="mt-4">
                {{ $items->links() }}
            </div>

        </main>

        <a href="{{ url('/') }}"
            class="fixed bottom-6 right-6 bg-emerald-600 text-white w-14 h-14 rounded-full shadow-lg flex items-center justify-center text-3xl hover:bg-emerald-700 active:scale-90 transition-transform z-50 md:right-auto md:left-[calc(50%+130px)]">
            +
        </a>

    </div>

</body>

</html>
