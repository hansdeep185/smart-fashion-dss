<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Input Penilaian - Smart Fashion DSS</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 p-8">

    <div class="max-w-full mx-auto bg-white shadow-md rounded-lg p-6">
        
        <div class="flex justify-between items-center mb-6 border-b pb-4">
            <div>
                <h1 class="text-2xl font-bold text-gray-800">Matriks Evaluasi Produk</h1>
                <p class="text-gray-500 text-sm">Input data alternatif dan penilaian kriteria</p>
            </div>
            <a href="{{ route('dss.result') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded shadow transition">
                Lihat Hasil Perhitungan &rarr;
            </a>
        </div>

        @if(session('success'))
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6" role="alert">
                <p>{{ session('success') }}</p>
            </div>
        @endif

        @if($errors->any())
            <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>- {{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="bg-gray-50 p-4 rounded-lg border border-gray-200 mb-8">
            <h3 class="font-bold text-gray-700 mb-3">Tambah Alternatif Baru</h3>
            <form action="{{ route('alternatives.store') }}" method="POST" class="flex gap-4 items-end">
                @csrf
                <div class="w-1/4">
                    <label class="block text-gray-600 text-xs font-bold mb-1">Kode (Contoh: A8)</label>
                    <input type="text" name="code" class="w-full border border-gray-300 p-2 rounded focus:outline-none focus:border-blue-500" required placeholder="A...">
                </div>
                <div class="w-1/2">
                    <label class="block text-gray-600 text-xs font-bold mb-1">Nama Desain</label>
                    <input type="text" name="name" class="w-full border border-gray-300 p-2 rounded focus:outline-none focus:border-blue-500" required placeholder="Nama Desain Pakaian...">
                </div>
                <button type="submit" class="bg-gray-800 hover:bg-gray-900 text-white font-bold py-2 px-6 rounded">
                    + Tambah
                </button>
            </form>
        </div>

        <form action="{{ route('evaluation.update') }}" method="POST">
            @csrf
            
            <div class="overflow-x-auto mb-6">
                <table class="min-w-full border-collapse border border-gray-300 text-sm">
                    <thead>
                        <tr class="bg-gray-200 text-gray-700">
                            <th class="border border-gray-300 p-3 text-left w-64 sticky left-0 bg-gray-200 z-10">Alternatif / Desain</th>
                            @foreach($criterias as $criteria)
                                <th class="border border-gray-300 p-3 text-center min-w-[150px]">
                                    {{ $criteria->name }} <br>
                                    <span class="text-xs font-normal text-gray-500">({{ $criteria->code }})</span>
                                </th>
                            @endforeach
                            <th class="border border-gray-300 p-3 text-center w-20">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($alternatives as $alt)
                            <tr class="hover:bg-gray-50">
                                <td class="border border-gray-300 p-3 font-medium sticky left-0 bg-white z-10 shadow-sm">
                                    <span class="font-bold text-blue-800">{{ $alt->code }}</span> - {{ $alt->name }}
                                </td>
                                
                                @foreach($criterias as $criteria)
                                    @php
                                        $savedVal = $alt->evaluations->where('criteria_id', $criteria->id)->first()->value ?? null;
                                    @endphp
                                    <td class="border border-gray-300 p-2">
                                        <select 
                                            name="values[{{ $alt->id }}][{{ $criteria->id }}]" 
                                            class="w-full border-gray-300 rounded focus:ring-blue-500 focus:border-blue-500 p-1.5 bg-white"
                                            required
                                        >
                                            <option value="" disabled {{ is_null($savedVal) ? 'selected' : '' }} class="text-gray-400">-- Pilih --</option>
                                            @foreach($criteria->subCriterias as $sub)
                                                <option value="{{ $sub->value }}" {{ $savedVal == $sub->value ? 'selected' : '' }}>
                                                    {{ $sub->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </td>
                                @endforeach

                                <td class="border border-gray-300 p-2 text-center">
                                    <button type="button" onclick="if(confirm('Hapus {{ $alt->name }}?')) document.getElementById('delete-form-{{ $alt->id }}').submit()" class="text-red-500 hover:text-red-700 font-bold px-2">
                                        &times;
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="{{ $criterias->count() + 2 }}" class="p-8 text-center text-gray-500 italic">
                                    Belum ada data alternatif. Silakan tambahkan melalui form di atas atau jalankan Seeder.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="flex justify-end border-t pt-6">
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-8 rounded-lg shadow-lg transform transition hover:scale-105">
                    💾 Simpan Semua & Hitung TOPSIS
                </button>
            </div>
        </form>

        @foreach($alternatives as $alt)
            <form id="delete-form-{{ $alt->id }}" action="{{ route('alternatives.destroy', $alt->id) }}" method="POST" style="display: none;">
                @csrf
                @method('DELETE')
            </form>
        @endforeach

    </div>

</body>
</html>