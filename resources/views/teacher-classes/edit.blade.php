@extends('layouts.admin')
@section('content')
<div class="container mx-auto px-4 py-8 max-w-4xl">
    <div class="flex items-center mb-6">
        <a href="{{ route('teacher-classes.index') }}" class="text-blue-600 hover:text-blue-800 mr-4">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
        </a>
        <h1 class="text-3xl font-bold text-gray-900">Edit Kelas</h1>
    </div>

    @if($errors->any())
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6">
            <ul class="list-disc list-inside">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="bg-white rounded-lg shadow-md p-8">
        <form action="{{ route('teacher-classes.update', $teacherClass) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="space-y-6">
                <!-- Nama Kelas -->
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                        Nama Kelas <span class="text-red-500">*</span>
                    </label>
                    <input type="text"
                           id="name"
                           name="name"
                           value="{{ old('name', $teacherClass->name) }}"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('name') border-red-500 @enderror"
                           placeholder="Masukkan nama kelas"
                           required>
                    @error('name')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Subject -->
                <div>
                    <label for="subject" class="block text-sm font-medium text-gray-700 mb-2">
                        Mata Pelajaran
                    </label>
                    <input type="text"
                           id="subject"
                           name="subject"
                           value="{{ old('subject', $teacherClass->subject) }}"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('subject') border-red-500 @enderror"
                           placeholder="Masukkan mata pelajaran (opsional)">
                    @error('subject')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Deskripsi -->
                <div>
                    <label for="description" class="block text-sm font-medium text-gray-700 mb-2">
                        Deskripsi
                    </label>
                    <textarea id="description"
                              name="description"
                              rows="4"
                              class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('description') border-red-500 @enderror"
                              placeholder="Masukkan deskripsi kelas (opsional)">{{ old('description', $teacherClass->description) }}</textarea>
                    @error('description')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Info Stats -->
                <div class="bg-blue-50 rounded-lg p-4">
                    <h3 class="font-medium text-blue-800 mb-2">Informasi Kelas</h3>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 text-sm">
                        <div class="text-center">
                            <div class="font-semibold text-blue-600">{{ $teacherClass->implementationClasses->count() }}</div>
                            <div class="text-blue-600">Implementation Classes</div>
                        </div>
                        <div class="text-center">
                            <div class="font-semibold text-green-600">{{ $teacherClass->approvedMentors->count() }}</div>
                            <div class="text-green-600">Mentor Aktif</div>
                        </div>
                        <div class="text-center">
                            <div class="font-semibold text-orange-600">{{ $teacherClass->pending_requests_count }}</div>
                            <div class="text-orange-600">Pending Request</div>
                        </div>
                    </div>
                </div>

                <!-- Buttons -->
                <div class="flex justify-between items-center pt-6 border-t border-gray-200">
                    <a href="{{ route('teacher-classes.index') }}"
                       class="px-6 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition-colors">
                        Batal
                    </a>

                    <div class="space-x-3">
                        <a href="{{ route('teacher-classes.show', $teacherClass) }}"
                           class="px-6 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700 transition-colors">
                            Lihat Detail
                        </a>

                        <button type="submit"
                                class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                            Simpan Perubahan
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <!-- Warning Box -->
    @if($teacherClass->implementationClasses->count() > 0 || $teacherClass->mentorRequests->count() > 0)
        <div class="mt-6 bg-yellow-50 border border-yellow-200 rounded-lg p-4">
            <div class="flex items-start">
                <svg class="w-5 h-5 text-yellow-600 mt-0.5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                </svg>
                <div>
                    <h3 class="text-yellow-800 font-medium">Perhatian!</h3>
                    <p class="text-yellow-700 text-sm mt-1">
                        Kelas ini sudah memiliki implementation classes atau mentor requests.
                        Mengubah nama atau subjek kelas dapat mempengaruhi tampilan pada sistem mentor dan siswa.
                    </p>
                </div>
            </div>
        </div>
    @endif
</div>
@endsection
