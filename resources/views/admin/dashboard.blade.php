@extends('layouts.admin')

@section('title', 'Dashboard Admin')

@section('content')
<div class="min-h-screen bg-gray-50 p-6">
    <!-- Header Section -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-800">Dashboard Admin</h1>
        <p class="text-gray-600 mt-2">Selamat datang kembali! Berikut adalah ringkasan sistem Anda.</p>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <!-- Total User Card -->
        <div class="bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl p-6 text-white shadow-lg transform hover:scale-105 transition-all duration-300">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-blue-100 text-sm font-medium">Total User</p>
                    <p class="text-3xl font-bold mt-2">{{ $totalUser ?? '0' }}</p>
                </div>
                <div class="bg-blue-400 bg-opacity-30 rounded-full p-3">
                    <i class="fas fa-users text-2xl"></i>
                </div>
            </div>
        </div>

        <!-- Total Siswa Card -->
        <div class="bg-gradient-to-br from-green-500 to-green-600 rounded-xl p-6 text-white shadow-lg transform hover:scale-105 transition-all duration-300">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-green-100 text-sm font-medium">Total Siswa</p>
                    <p class="text-3xl font-bold mt-2">{{ $totalSiswa ?? '0' }}</p>
                </div>
                <div class="bg-green-400 bg-opacity-30 rounded-full p-3">
                    <i class="fas fa-user-graduate text-2xl"></i>
                </div>
            </div>
        </div>

        <!-- Total Mentor Card -->
        <div class="bg-gradient-to-br from-yellow-500 to-orange-500 rounded-xl p-6 text-white shadow-lg transform hover:scale-105 transition-all duration-300">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-yellow-100 text-sm font-medium">Total Mentor</p>
                    <p class="text-3xl font-bold mt-2">{{ $totalMentor ?? '0' }}</p>
                </div>
                <div class="bg-yellow-400 bg-opacity-30 rounded-full p-3">
                    <i class="fas fa-chalkboard-teacher text-2xl"></i>
                </div>
            </div>
        </div>

        <!-- Total Admin Card -->
        <div class="bg-gradient-to-br from-red-500 to-pink-500 rounded-xl p-6 text-white shadow-lg transform hover:scale-105 transition-all duration-300">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-red-100 text-sm font-medium">Total Admin</p>
                    <p class="text-3xl font-bold mt-2">{{ $totalAdmin ?? '0' }}</p>
                </div>
                <div class="bg-red-400 bg-opacity-30 rounded-full p-3">
                    <i class="fas fa-user-shield text-2xl"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    {{-- <div class="bg-white rounded-xl shadow-sm p-6">
        <h2 class="text-xl font-bold text-gray-800 mb-6">Aksi Cepat</h2>
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
            <a href="{{ route('admin.users.create') ?? '#' }}" class="bg-blue-50 hover:bg-blue-100 rounded-lg p-4 text-center transition-colors group">
                <div class="bg-blue-500 w-12 h-12 rounded-lg flex items-center justify-center mx-auto mb-3 group-hover:scale-110 transition-transform">
                    <i class="fas fa-user-plus text-white"></i>
                </div>
                <p class="text-sm font-medium text-gray-800">Tambah User</p>
            </a>

            <a href="{{ route('admin.siswa.index') ?? '#' }}" class="bg-green-50 hover:bg-green-100 rounded-lg p-4 text-center transition-colors group">
                <div class="bg-green-500 w-12 h-12 rounded-lg flex items-center justify-center mx-auto mb-3 group-hover:scale-110 transition-transform">
                    <i class="fas fa-list text-white"></i>
                </div>
                <p class="text-sm font-medium text-gray-800">Kelola Siswa</p>
            </a>

            <a href="{{ route('admin.mentor.index') ?? '#' }}" class="bg-yellow-50 hover:bg-yellow-100 rounded-lg p-4 text-center transition-colors group">
                <div class="bg-yellow-500 w-12 h-12 rounded-lg flex items-center justify-center mx-auto mb-3 group-hover:scale-110 transition-transform">
                    <i class="fas fa-users-cog text-white"></i>
                </div>
                <p class="text-sm font-medium text-gray-800">Kelola Mentor</p>
            </a>

            <a href="{{ route('admin.reports') ?? '#' }}" class="bg-purple-50 hover:bg-purple-100 rounded-lg p-4 text-center transition-colors group">
                <div class="bg-purple-500 w-12 h-12 rounded-lg flex items-center justify-center mx-auto mb-3 group-hover:scale-110 transition-transform">
                    <i class="fas fa-chart-bar text-white"></i>
                </div>
                <p class="text-sm font-medium text-gray-800">Laporan</p>
            </a>
        </div>
    </div> --}}
</div>
@endsection
