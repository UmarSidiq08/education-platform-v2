{{-- Profile Information Card --}}
<div class="bg-white shadow-lg rounded-2xl border border-gray-100 hover:shadow-2xl transition duration-300 transform hover:-translate-y-1 animate-fadeSlideUp" style="animation-delay: 0.1s">

    {{-- Card Header --}}
    <div class="px-6 py-5 border-b border-gray-100 bg-gradient-to-r from-indigo-50 to-white rounded-t-2xl flex items-center gap-3">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
        </svg>
        <div>
            <h3 class="text-lg font-semibold text-gray-800">Informasi Profil</h3>
            <p class="text-sm text-gray-500">Perbarui data pribadi Anda.</p>
        </div>
    </div>

    {{-- Card Content --}}
    <div class="p-6">
        <form method="POST" action="{{ route('profile.update') }}" class="space-y-6" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            {{-- Avatar Section --}}
            <div class="flex flex-col items-center space-y-4 pb-6 border-b border-gray-100">
                <div class="text-center">
                    <h4 class="text-lg font-medium text-gray-800 mb-2">Foto Profil</h4>
                    <p class="text-sm text-gray-500">Upload foto profil Anda (maksimal 2MB)</p>
                </div>

                <div class="relative">
                    <div class="w-32 h-32 rounded-full bg-gray-100 border-4 border-gray-200 shadow-lg overflow-hidden">
                        <img id="avatar-preview"
                             src="{{ $user->avatar ? asset('storage/' . $user->avatar) : 'https://ui-avatars.com/api/?name=' . urlencode($user->name) . '&size=128&background=f3f4f6&color=6b7280' }}"
                             alt="Foto Profil"
                             class="w-full h-full object-cover"
                             loading="lazy"
                             onerror="this.src='data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMTI4IiBoZWlnaHQ9IjEyOCIgdmlld0JveD0iMCAwIDEyOCAxMjgiIGZpbGw9Im5vbmUiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyI+CjxyZWN0IHdpZHRoPSIxMjgiIGhlaWdodD0iMTI4IiBmaWxsPSIjRjNGNEY2Ii8+CjxjaXJjbGUgY3g9IjY0IiBjeT0iNDgiIHI9IjE2IiBmaWxsPSIjNkI3MjgwIi8+CjxwYXRoIGQ9Im00MCA5NmMwLTEzLjI1NSAxMC43NDUtMjQgMjQtMjRzMjQgMTAuNzQ1IDI0IDI0SDQweiIgZmlsbD0iIzZCNzI4MCIvPgo8L3N2Zz4K'">
                    </div>
                </div>

                <div class="w-full max-w-xs">
                    <input id="avatar" name="avatar" type="file" accept="image/jpeg,image/png,image/jpg,image/gif"
                           onchange="previewImage(event)"
                           class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100 cursor-pointer">
                    <x-input-error class="mt-2" :messages="$errors->get('avatar')" />
                    <p class="text-xs text-gray-500 mt-1">Format: JPEG, PNG, JPG, GIF (Max: 2MB)</p>
                </div>
            </div>

            {{-- Form Fields Grid --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="md:col-span-2">
                    <x-input-label for="name" :value="__('Nama Lengkap')" class="text-gray-700 font-medium" />
                    <x-text-input id="name" name="name" type="text"
                                  class="mt-2 block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                  :value="old('name', $user->name)" required autofocus autocomplete="name" />
                    <x-input-error class="mt-2" :messages="$errors->get('name')" />
                </div>

                <div>
                    <x-input-label for="email" :value="__('Email')" class="text-gray-700 font-medium" />
                    <x-text-input id="email" name="email" type="email"
                                  class="mt-2 block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                  :value="old('email', $user->email)" required autocomplete="username" />
                    <x-input-error class="mt-2" :messages="$errors->get('email')" />
                </div>

                <div>
                    <x-input-label for="phone" :value="__('Nomor Telepon')" class="text-gray-700 font-medium" />
                    <x-text-input id="phone" name="phone" type="text"
                                  class="mt-2 block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                  :value="old('phone', $user->phone)" placeholder="+62 812 3456 7890" />
                    <x-input-error class="mt-2" :messages="$errors->get('phone')" />
                </div>

                <div class="md:col-span-2">
                    <x-input-label for="location" :value="__('Lokasi')" class="text-gray-700 font-medium" />
                    <x-text-input id="location" name="location" type="text"
                                  class="mt-2 block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                  :value="old('location', $user->location)" placeholder="Contoh: Jakarta, Indonesia" />
                    <x-input-error class="mt-2" :messages="$errors->get('location')" />
                </div>

                <div class="md:col-span-2">
                    <x-input-label for="bio" :value="__('Bio')" class="text-gray-700 font-medium" />
                    <textarea id="bio" name="bio" rows="4"
                              class="mt-2 block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                              placeholder="Ceritakan sedikit tentang diri Anda...">{{ old('bio', $user->bio) }}</textarea>
                    <x-input-error class="mt-2" :messages="$errors->get('bio')" />
                    <p class="text-xs text-gray-500 mt-1">Maksimal 500 karakter</p>
                </div>
            </div>

            {{-- Action Buttons --}}
            <div class="flex items-center justify-between pt-6 border-t border-gray-100">
                <a href="{{ route('profile.index') }}"
                   class="px-6 py-2.5 bg-gray-100 hover:bg-gray-200 text-gray-700 font-medium rounded-lg transition-colors duration-200">
                    Batal
                </a>

                <button type="submit"
                        class="px-8 py-2.5 bg-gradient-to-r from-indigo-500 to-purple-600 hover:from-indigo-600 hover:to-purple-700 text-white font-medium rounded-lg transition-all duration-200 transform hover:scale-105 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                    <span class="flex items-center">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        Simpan Perubahan
                    </span>
                </button>
            </div>
        </form>
    </div>
</div>

{{-- Profile specific JavaScript --}}
@push('scripts')
<script>
    // Ensure DOM is ready
    document.addEventListener('DOMContentLoaded', function() {

        // Image preview function
        window.previewImage = function(event) {
            const file = event.target.files[0];
            const preview = document.getElementById('avatar-preview');

            if (!file) return;

            // Validate file type
            const allowedTypes = ['image/jpeg', 'image/png', 'image/jpg', 'image/gif'];
            if (!allowedTypes.includes(file.type)) {
                if (typeof showAlert === 'function') {
                    showAlert('error', 'Format File Tidak Didukung!', 'Silakan gunakan format JPEG, PNG, JPG, atau GIF.');
                } else {
                    alert('Format file tidak didukung! Gunakan JPEG, PNG, JPG, atau GIF.');
                }
                event.target.value = '';
                return;
            }

            // Validate file size (2MB)
            if (file.size > 2 * 1024 * 1024) {
                if (typeof showAlert === 'function') {
                    showAlert('error', 'Ukuran File Terlalu Besar!', 'Ukuran maksimal adalah 2MB.');
                } else {
                    alert('Ukuran file terlalu besar! Maksimal 2MB.');
                }
                event.target.value = '';
                return;
            }

            // Show loading state
            const container = preview.parentElement;
            container.classList.add('animate-pulse');

            // Show preview
            const reader = new FileReader();
            reader.onload = function(e) {
                preview.src = e.target.result;
                container.classList.remove('animate-pulse');
            };
            reader.onerror = function() {
                container.classList.remove('animate-pulse');
                if (typeof showAlert === 'function') {
                    showAlert('error', 'Gagal memuat gambar!', 'Silakan coba lagi.');
                }
            };
            reader.readAsDataURL(file);
        };

        // Character counter for bio
        const bioField = document.getElementById('bio');
        if (bioField) {
            bioField.addEventListener('input', function() {
                const maxLength = 500;
                if (this.value.length > maxLength) {
                    this.value = this.value.substring(0, maxLength);
                }
            });
        }

        // Pre-load avatar image to avoid flash
        const avatarPreview = document.getElementById('avatar-preview');
        if (avatarPreview && !avatarPreview.complete) {
            avatarPreview.style.opacity = '0';
            avatarPreview.onload = function() {
                this.style.transition = 'opacity 0.3s ease';
                this.style.opacity = '1';
            };
        }
    });
</script>
@endpush
