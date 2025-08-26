{{-- Delete Account Card --}}
<div class="bg-white shadow-lg rounded-2xl border border-gray-100 hover:shadow-2xl transition duration-300 transform hover:-translate-y-1 animate-fadeSlideUp" style="animation-delay: 0.5s">

    {{-- Card Header --}}
    <div class="px-6 py-5 border-b border-gray-100 bg-gradient-to-r from-red-50 to-white rounded-t-2xl flex items-center gap-3">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5-4h4m-4 0v4m4-4v4" />
        </svg>
        <div>
            <h3 class="text-lg font-semibold text-red-600">Hapus Akun</h3>
            <p class="text-sm text-gray-500">Tindakan ini permanen dan tidak dapat dibatalkan.</p>
        </div>
    </div>

    {{-- Card Content --}}
    <div class="p-6">
        <div class="space-y-4">
            <div class="bg-red-50 border border-red-200 rounded-lg p-4">
                <h4 class="text-red-800 font-medium mb-2">⚠️ Peringatan Penting</h4>
                <p class="text-sm text-red-700">
                    Setelah akun dihapus, seluruh data dan informasi akan hilang secara permanen.
                    Pastikan Anda telah mengunduh data penting sebelum melanjutkan.
                </p>
            </div>

            <div class="flex justify-end">
                <button type="button"
                        onclick="confirmDeleteAccount()"
                        class="px-6 py-2.5 bg-gradient-to-r from-red-500 to-red-600 hover:from-red-600 hover:to-red-700 text-white font-medium rounded-lg transition-all duration-200 transform hover:scale-105 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2">
                    <span class="flex items-center">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5-4h4m-4 0v4m4-4v4" />
                        </svg>
                        Hapus Akun
                    </span>
                </button>
            </div>
        </div>
    </div>
</div>

{{-- Delete Account JavaScript --}}
@push('scripts')
<script>
    function confirmDeleteAccount() {
        Swal.fire({
            title: 'Konfirmasi Hapus Akun',
            html: `
                <div class="text-left">
                    <p class="mb-4 text-gray-600">Apakah Anda yakin ingin menghapus akun? Tindakan ini akan:</p>
                    <ul class="text-sm text-red-600 space-y-1 mb-4">
                        <li>• Menghapus seluruh data pribadi</li>
                        <li>• Menghapus riwayat aktivitas</li>
                        <li>• Menonaktifkan akses ke sistem</li>
                        <li>• Tidak dapat dikembalikan</li>
                    </ul>
                    <p class="text-gray-600 mb-3">Masukkan password untuk konfirmasi:</p>
                    <input type="password" id="delete-password" class="w-full p-3 border border-gray-300 rounded-lg" placeholder="Password Anda">
                </div>
            `,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#DC2626',
            cancelButtonColor: '#6B7280',
            confirmButtonText: 'Ya, Hapus Akun',
            cancelButtonText: 'Batal',
            focusConfirm: false,
            preConfirm: () => {
                const password = document.getElementById('delete-password').value;
                if (!password) {
                    Swal.showValidationMessage('Password harus diisi');
                    return false;
                }
                return password;
            }
        }).then((result) => {
            if (result.isConfirmed) {
                // Create and submit form
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = '{{ route("profile.destroy") }}';

                // CSRF token
                const csrfInput = document.createElement('input');
                csrfInput.type = 'hidden';
                csrfInput.name = '_token';
                csrfInput.value = '{{ csrf_token() }}';

                // Method spoofing
                const methodInput = document.createElement('input');
                methodInput.type = 'hidden';
                methodInput.name = '_method';
                methodInput.value = 'DELETE';

                // Password input
                const passwordInput = document.createElement('input');
                passwordInput.type = 'hidden';
                passwordInput.name = 'password';
                passwordInput.value = result.value;

                form.appendChild(csrfInput);
                form.appendChild(methodInput);
                form.appendChild(passwordInput);

                document.body.appendChild(form);
                form.submit();
            }
        });
    }
</script>
@endpush
