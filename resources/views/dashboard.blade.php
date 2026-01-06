@extends('layouts.app')

@section('title', 'Dashboard Utama')

@section('content')
    <h2 class="text-2xl font-bold mb-4 text-gray-800">Dashboard Overview</h2>
    
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <div class="bg-white p-6 rounded-lg shadow border-l-4 border-pink-500">
            <h3 class="text-gray-500 text-sm font-bold">Total Produk</h3>
            <p class="text-3xl font-bold text-gray-800 mt-2">150</p>
        </div>
        
        <div class="bg-white p-6 rounded-lg shadow border-l-4 border-blue-500">
            <h3 class="text-gray-500 text-sm font-bold">Sudah Dinilai</h3>
            <p class="text-3xl font-bold text-gray-800 mt-2">120</p>
        </div>
    </div>

    <div class="mt-8 bg-white p-6 rounded-lg shadow">
        <h3 class="font-bold text-lg mb-2">Selamat Datang di SPK Smart Fashion</h3>
        <p class="text-gray-600">
            Gunakan menu di samping kiri untuk melakukan input penilaian kriteria fashion dan melihat hasil rekomendasi terbaik menggunakan metode TOPSIS.
        </p>
    </div>
@endsection