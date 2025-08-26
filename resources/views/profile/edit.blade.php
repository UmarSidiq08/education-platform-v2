{{-- Profile Settings Main Page --}}
@extends("layouts.app")
<x-slot name="header">
    <h2 class="font-bold text-2xl text-gray-900 leading-tight tracking-wide flex items-center gap-3">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7 text-indigo-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.121 17.804A13.937 13.937 0 0112 15c2.486 0 4.797.755 6.879 2.047M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
        </svg>
        {{ __('Profile Settings') }}
    </h2>
    <p class="text-gray-500 mt-1 text-sm">Kelola informasi pribadi dan keamanan akun Anda.</p>
</x-slot>

{{-- Include shared CSS & JS --}}
@push('styles')
<link rel="preconnect" href="https://ui-avatars.com">
<style>
    @keyframes fadeSlideUp {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }
    .animate-fadeSlideUp {
        animation: fadeSlideUp 0.6s ease-out forwards;
        opacity: 0;
    }

    /* Prevent layout shift */
    .avatar-container {
        min-height: 128px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    /* Loading state */
    .loading-shimmer {
        background: linear-gradient(90deg, #f0f0f0 25%, #e0e0e0 50%, #f0f0f0 75%);
        background-size: 200% 100%;
        animation: shimmer 2s infinite;
    }

    @keyframes shimmer {
        0% { background-position: -200% 0; }
        100% { background-position: 200% 0; }
    }
</style>
@endpush

<div class="py-12 bg-gray-50 min-h-screen">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">

        {{-- Update Profile Information --}}
        @include('profile.partials.update-profile-information-form')

        {{-- Update Password --}}
        @include('profile.partials.update-password-form')

        {{-- Delete Account --}}
        @include('profile.partials.delete-user-form')

    </div>
</div>

{{-- Shared Scripts --}}
@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    // Ensure DOM is ready before executing
    document.addEventListener('DOMContentLoaded', function() {

        // Shared alert handler
        window.showAlert = function(type, title, message, redirect = null) {
            const config = {
                title: title,
                text: message,
                icon: type,
                confirmButtonText: 'OK',
                confirmButtonColor: type === 'success' ? '#3B82F6' : '#EF4444',
                timer: 3000,
                timerProgressBar: true
            };

            Swal.fire(config).then((result) => {
                if (redirect && (result.isConfirmed || result.dismiss === Swal.DismissReason.timer)) {
                    window.location.href = redirect;
                }
            });
        };

        // Handle session alerts
        @if (session('status') === 'profile-updated')
            showAlert('success', 'Berhasil!', 'Profile berhasil diperbarui', "{{ route('profile.index') }}");
        @endif

        @if (session('status') === 'password-updated')
            showAlert('success', 'Berhasil!', 'Password berhasil diperbarui');
        @endif

        @if (session('success'))
            showAlert('success', 'Berhasil!', '{{ session('success') }}');
        @endif

        @if ($errors->any())
            const errorList = @json($errors->all());
            const errorHtml = 'Terdapat kesalahan:<br><ul style="text-align: left; margin-top: 10px;">' +
                             errorList.map(error => `<li>• ${error}</li>`).join('') + '</ul>';

            showAlert('error', 'Perhatian!', errorHtml);
        @endif
    });
</script>
@endpush
