<!DOCTYPE html>
<html lang="ms">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>Log Masuk - Barang Dapur</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-50 antialiased font-sans flex items-center justify-center min-h-screen">

    <div class="max-w-md w-full bg-white p-8 rounded-2xl shadow-xl border border-gray-100 mx-4">

        <div class="text-center mb-10">
            <div class="text-6xl mb-4">🛒</div>
            <h1 class="text-2xl font-black text-gray-800 tracking-tight">Barang Dapur</h1>
            <p class="text-sm text-gray-500 mt-2">Urus inventori dapur anda dengan mudah dan pantas.</p>
        </div>

        <div class="space-y-4">
            <a href="{{ url('/auth/google/redirect') }}"
                class="w-full flex items-center justify-center bg-white text-gray-700 font-bold py-3 px-4 rounded-xl shadow-sm border border-gray-200 hover:bg-gray-50 transition active:scale-95">
                <img src="https://www.svgrepo.com/show/475656/google-color.svg" class="w-5 h-5 mr-3" alt="Google">
                Log Masuk dengan Google
            </a>

        </div>


        <div class="mt-8 flex items-center justify-center">
            <div class="border-t border-gray-200 w-full"></div>
            <span class="px-3 text-gray-400 text-xs font-medium uppercase tracking-wider">Atau E-mel</span>
            <div class="border-t border-gray-200 w-full"></div>
        </div>

        <form action="{{ route('login.manual') }}" method="POST" class="mt-6 space-y-4">
            @csrf

            @error('email')
                <div class="bg-red-50 text-red-600 text-xs p-3 rounded-lg border border-red-100">
                    {{ $message }}
                </div>
            @enderror

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">E-mel</label>
                <input type="email" name="email" value="{{ old('email') }}" required
                    class="w-full border-gray-300 rounded-lg shadow-sm px-4 py-2 border focus:ring-emerald-500 focus:border-emerald-500"
                    placeholder="nama@email.com">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Kata Laluan</label>
                <input type="password" name="password" required
                    class="w-full border-gray-300 rounded-lg shadow-sm px-4 py-2 border focus:ring-emerald-500 focus:border-emerald-500"
                    placeholder="••••••••">
            </div>

            <div class="flex items-center justify-between">
                <label class="flex items-center text-sm text-gray-600">
                    <input type="checkbox" name="remember"
                        class="mr-2 text-emerald-600 focus:ring-emerald-500 border-gray-300 rounded">
                    Ingat Saya
                </label>
                <a href="#" class="text-xs text-emerald-600 hover:underline">Belum ada akaun?</a>
            </div>

            <button type="submit"
                class="w-full bg-gray-800 text-white font-bold py-3 px-4 rounded-xl shadow-md hover:bg-gray-900 transition active:scale-95">
                Log Masuk Manual
            </button>
        </form>

        <div class="mt-6 flex items-center justify-center">
            <div class="border-t border-gray-200 w-full"></div>
        </div>

        <div class="mt-6">
            <a href="{{ route('quick-add') }}"
                class="w-full flex items-center justify-center bg-emerald-600 text-white font-bold py-3 px-4 rounded-xl shadow-md hover:bg-emerald-700 transition active:scale-95">
                📷 Imbas Barang (Tanpa Login)
            </a>
            <p class="text-[11px] text-center text-gray-400 mt-3">
                Rekod akan disimpan ke akaun anda apabila anda log masuk kelak.
            </p>
        </div>

    </div>

</body>

</html>
