<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hasil Analisis AI</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-blue-50 text-gray-800">
    <main class="mx-auto max-w-3xl p-8">
        <div class="mb-6 flex items-center justify-between">
            <h1 class="text-2xl font-semibold">Hasil Analisis AI</h1>
            <a href="{{ route('barang.index') }}" class="rounded-lg bg-blue-600 px-4 py-2 text-sm font-semibold text-white hover:bg-blue-700">
                Kembali
            </a>
        </div>

        @if($barang)
            <section class="mb-6 rounded-lg border border-blue-100 bg-white p-5 shadow-sm">
                <p class="text-sm text-gray-500">Barang</p>
                <h2 class="mt-1 text-xl font-semibold">{{ $barang->nama_barang }}</h2>
                <p class="mt-2 text-sm text-gray-600">Jumlah: {{ $barang->jumlah }} | Status: {{ $barang->status }}</p>
            </section>
        @endif

        <section class="grid gap-4 md:grid-cols-3">
            <div class="rounded-lg border border-blue-100 bg-white p-5 shadow-sm">
                <p class="text-sm font-medium text-gray-500">Prediction</p>
                <p class="mt-2 font-semibold">{{ $hasil['prediction'] ?? '-' }}</p>
            </div>
            <div class="rounded-lg border border-blue-100 bg-white p-5 shadow-sm">
                <p class="text-sm font-medium text-gray-500">Anomaly</p>
                <p class="mt-2 font-semibold">{{ $hasil['anomaly'] ?? '-' }}</p>
            </div>
            <div class="rounded-lg border border-blue-100 bg-white p-5 shadow-sm">
                <p class="text-sm font-medium text-gray-500">Recommendation</p>
                <p class="mt-2 font-semibold">{{ $hasil['recommendation'] ?? '-' }}</p>
            </div>
        </section>

        <section class="mt-6 rounded-lg border border-blue-100 bg-white p-5 text-sm text-gray-600 shadow-sm">
            <p class="font-medium text-gray-700">Payload yang dikirim ke AI service</p>
            <pre class="mt-3 overflow-auto rounded bg-gray-100 p-4">{{ json_encode($payload, JSON_PRETTY_PRINT) }}</pre>
        </section>
    </main>
</body>
</html>
