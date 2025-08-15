<x-slot name="header">
    <h2 class="font-bold text-2xl text-gray-900 leading-tight tracking-wide flex items-center gap-3">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7 text-indigo-500" fill="none" viewBox="0 0 24 24"
            stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M5.121 17.804A13.937 13.937 0 0112 15c2.486 0 4.797.755 6.879 2.047M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
        </svg>
        {{ __('Profile Settings') }}
    </h2>
    <p class="text-gray-500 mt-1 text-sm">
        Kelola informasi pribadi dan keamanan akun Anda.
    </p>
</x-slot>

<div class="py-12 bg-gray-50 min-h-screen">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">

        {{-- Update Profile Information --}}
        <div class="bg-white shadow-lg rounded-2xl border border-gray-100 hover:shadow-2xl transition duration-300 transform hover:-translate-y-1 animate-fadeSlideUp"
            style="animation-delay: 0.1s">
            <div
                class="px-6 py-5 border-b border-gray-100 bg-gradient-to-r from-indigo-50 to-white rounded-t-2xl flex items-center gap-3">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-indigo-600" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                <div>
                    <h3 class="text-lg font-semibold text-gray-800">Informasi Profil</h3>
                    <p class="text-sm text-gray-500">Perbarui data pribadi Anda.</p>
                </div>
            </div>
            <div class="p-6">
                <div class="max-w-xl">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>
        </div>

        {{-- Update Password --}}
        <div class="bg-white shadow-lg rounded-2xl border border-gray-100 hover:shadow-2xl transition duration-300 transform hover:-translate-y-1 animate-fadeSlideUp"
            style="animation-delay: 0.3s">
            <div
                class="px-6 py-5 border-b border-gray-100 bg-gradient-to-r from-amber-50 to-white rounded-t-2xl flex items-center gap-3">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-amber-600" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 11c0-1.105.895-2 2-2h.172a2 2 0 011.414.586l.828.828a2 2 0 010 2.828l-1.414 1.414a2 2 0 01-2.828 0l-.828-.828A2 2 0 0112 13V11z" />
                </svg>
                <div>
                    <h3 class="text-lg font-semibold text-gray-800">Ubah Password</h3>
                    <p class="text-sm text-gray-500">Pastikan password Anda aman dan sulit ditebak.</p>
                </div>
            </div>
            <div class="p-6">
                <div class="max-w-xl">
                    @include('profile.partials.update-password-form')
                </div>
            </div>
        </div>

        {{-- Delete User --}}
        <div class="bg-white shadow-lg rounded-2xl border border-gray-100 hover:shadow-2xl transition duration-300 transform hover:-translate-y-1 animate-fadeSlideUp"
            style="animation-delay: 0.5s">
            <div
                class="px-6 py-5 border-b border-gray-100 bg-gradient-to-r from-red-50 to-white rounded-t-2xl flex items-center gap-3">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-red-600" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5-4h4m-4 0v4m4-4v4" />
                </svg>
                <div>
                    <h3 class="text-lg font-semibold text-red-600">Hapus Akun</h3>
                    <p class="text-sm text-gray-500">Tindakan ini permanen dan tidak dapat dibatalkan.</p>
                </div>
            </div>
            <div class="p-6">
                <div class="max-w-xl">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>
        </div>
        <script src="https://cdn.tailwindcss.com"></script>

    </div>
</div>