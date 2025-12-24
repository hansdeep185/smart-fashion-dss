<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hasil Rekomendasi - Smart Fashion DSS</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 p-8 text-gray-800">

    <div class="max-w-7xl mx-auto space-y-10">
        
        <div class="flex justify-between items-center bg-white p-6 rounded-lg shadow-sm border border-gray-200">
            <div>
                <h1 class="text-3xl font-bold text-blue-900">Hasil Rekomendasi Desain</h1>
                <p class="text-gray-500">Metode TOPSIS (Technique for Order of Preference by Similarity to Ideal Solution)</p>
            </div>
            <a href="{{ route('evaluation.index') }}" class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-md text-sm font-medium transition">
                &larr; Kembali ke Input Data
            </a>
        </div>

        <div class="bg-white rounded-lg shadow-lg border-t-4 border-blue-600 overflow-hidden">
            <div class="p-6 bg-blue-50 border-b border-blue-100">
                <h2 class="text-xl font-bold text-blue-800 flex items-center">
                    🏆 Peringkat Keputusan Akhir
                </h2>
                <p class="text-sm text-blue-600 mt-1">Diurutkan dari nilai preferensi tertinggi (rekomendasi utama) ke terendah.</p>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full text-left text-sm">
                    <thead class="bg-blue-100 text-blue-900 uppercase font-semibold">
                        <tr>
                            <th class="p-4 w-16 text-center">Rank</th>
                            <th class="p-4">Kode</th>
                            <th class="p-4">Nama Desain Alternatif</th>
                            <th class="p-4 text-right">Nilai Preferensi (V)</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @foreach($results['ranks'] as $rank)
                            <tr class="hover:bg-blue-50 transition {{ $loop->first ? 'bg-yellow-50' : '' }}">
                                <td class="p-4 text-center font-bold text-lg {{ $loop->first ? 'text-yellow-600' : 'text-gray-500' }}">
                                    #{{ $rank['rank'] }}
                                </td>
                                <td class="p-4 font-mono text-gray-600">{{ $rank['alternative_code'] }}</td>
                                <td class="p-4 font-medium {{ $loop->first ? 'text-blue-700 font-bold' : '' }}">
                                    {{ $rank['alternative_name'] }}
                                    @if($loop->first)
                                        <span class="ml-2 inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                            Rekomendasi Utama
                                        </span>
                                    @endif
                                </td>
                                <td class="p-4 text-right font-bold text-gray-700">
                                    {{ number_format($rank['score'], 4) }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <div class="space-y-6">
            <h3 class="text-xl font-bold text-gray-700 border-l-4 border-gray-400 pl-3">Rincian Perhitungan Matematis</h3>

            <div class="bg-white rounded-lg shadow-sm p-6 border border-gray-200">
                <h4 class="font-bold text-gray-700 mb-4">Langkah 1: Matriks Ternormalisasi (R)</h4>
                <div class="overflow-x-auto">
                    <table class="min-w-full border text-xs text-center">
                        <thead class="bg-gray-100">
                            <tr>
                                <th class="border p-2">Alternatif</th>
                                @foreach($results['criterias'] as $c)
                                    <th class="border p-2">{{ $c->code }}</th>
                                @endforeach
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($results['alternatives'] as $alt)
                                <tr>
                                    <td class="border p-2 font-medium bg-gray-50 text-left">{{ $alt->code }}</td>
                                    @foreach($results['criterias'] as $c)
                                        <td class="border p-2 text-gray-600">
                                            {{ number_format($results['normalized_matrix'][$alt->id][$c->id], 4) }}
                                        </td>
                                    @endforeach
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow-sm p-6 border border-gray-200">
                <h4 class="font-bold text-gray-700 mb-4">Langkah 2: Matriks Ternormalisasi Terbobot (Y)</h4>
                <div class="overflow-x-auto">
                    <table class="min-w-full border text-xs text-center">
                        <thead class="bg-gray-100">
                            <tr>
                                <th class="border p-2">Alternatif</th>
                                @foreach($results['criterias'] as $c)
                                    <th class="border p-2">{{ $c->code }}</th>
                                @endforeach
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($results['alternatives'] as $alt)
                                <tr>
                                    <td class="border p-2 font-medium bg-gray-50 text-left">{{ $alt->code }}</td>
                                    @foreach($results['criterias'] as $c)
                                        <td class="border p-2 text-blue-600 font-medium">
                                            {{ number_format($results['weighted_matrix'][$alt->id][$c->id], 4) }}
                                        </td>
                                    @endforeach
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="bg-white rounded-lg shadow-sm p-6 border border-gray-200">
                    <h4 class="font-bold text-gray-700 mb-4">Langkah 3: Solusi Ideal (A+ & A-)</h4>
                    <table class="w-full text-xs text-left border">
                        <thead class="bg-gray-100">
                            <tr>
                                <th class="border p-2">Kriteria</th>
                                <th class="border p-2 text-green-600">Positif (A+)</th>
                                <th class="border p-2 text-red-600">Negatif (A-)</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($results['criterias'] as $c)
                                <tr>
                                    <td class="border p-2">{{ $c->code }}</td>
                                    <td class="border p-2 font-mono">{{ number_format($results['ideal_positive'][$c->id], 4) }}</td>
                                    <td class="border p-2 font-mono">{{ number_format($results['ideal_negative'][$c->id], 4) }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="bg-white rounded-lg shadow-sm p-6 border border-gray-200">
                    <h4 class="font-bold text-gray-700 mb-4">Langkah 4: Jarak Solusi (D+ & D-)</h4>
                    <table class="w-full text-xs text-left border">
                        <thead class="bg-gray-100">
                            <tr>
                                <th class="border p-2">Kode</th>
                                <th class="border p-2">Jarak ke Positif (D+)</th>
                                <th class="border p-2">Jarak ke Negatif (D-)</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($results['alternatives'] as $alt)
                                <tr>
                                    <td class="border p-2 font-bold">{{ $alt->code }}</td>
                                    <td class="border p-2">{{ number_format($results['distances']['positive'][$alt->id], 4) }}</td>
                                    <td class="border p-2">{{ number_format($results['distances']['negative'][$alt->id], 4) }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
    
    <div class="text-center mt-10 mb-6 text-gray-400 text-sm">
        &copy; {{ date('Y') }} Jago Konveksi DSS System
    </div>

</body>
</html>