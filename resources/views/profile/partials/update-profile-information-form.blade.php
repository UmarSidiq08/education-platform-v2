<form method="POST" action="{{ route('profile.update') }}" class="mt-6 space-y-6" enctype="multipart/form-data">
    @csrf
    @method('PUT')

    <!-- Foto Profil -->
    <div>
        <x-input-label for="avatar" :value="__('Foto Profil')" />

        <!-- Preview Foto -->
        @if ($user->avatar)
            <img src="{{ asset('storage/' . $user->avatar) }}" alt="Foto Profil"
                class="w-20 h-20 rounded-full object-cover mb-2">
        @endif

        <input id="avatar" name="avatar" type="file" class="mt-1 block w-full border rounded-md" accept="image/*">
        <x-input-error class="mt-2" :messages="$errors->get('avatar')" />
    </div>

    <!-- Nama Lengkap -->
    <div>
        <x-input-label for="name" :value="__('Nama Lengkap')" />
        <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name', $user->name)"
            required autofocus autocomplete="name" />
        <x-input-error class="mt-2" :messages="$errors->get('name')" />
    </div>

    <!-- Email -->
    <div>
        <x-input-label for="email" :value="__('Email')" />
        <x-text-input id="email" name="email" type="email" class="mt-1 block w-full" :value="old('email', $user->email)"
            required autocomplete="username" />
        <x-input-error class="mt-2" :messages="$errors->get('email')" />
    </div>

    <!-- Nomor Telepon -->
    <div>
        <x-input-label for="phone" :value="__('Nomor Telepon')" />
        <x-text-input id="phone" name="phone" type="text" class="mt-1 block w-full" :value="old('phone', $user->phone)" />
        <x-input-error class="mt-2" :messages="$errors->get('phone')" />
    </div>

    <!-- Lokasi -->
    <div>
        <x-input-label for="location" :value="__('Lokasi')" />
        <x-text-input id="location" name="location" type="text" class="mt-1 block w-full" :value="old('location', $user->location)" />
        <x-input-error class="mt-2" :messages="$errors->get('location')" />
    </div>

    <!-- Bio -->
    <div>
        <x-input-label for="bio" :value="__('Bio')" />
        <textarea id="bio" name="bio"
            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">{{ old('bio', $user->bio) }}</textarea>
        <x-input-error class="mt-2" :messages="$errors->get('bio')" />
    </div>

    <div class="flex items-center gap-4">
        <x-primary-button>{{ __('Simpan') }}</x-primary-button>
    </div>
</form>

{{-- SweetAlert2 CDN --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

{{-- Alert Script --}}
@if (session('status') === 'profile-updated')
    <script>
        Swal.fire({
            title: 'Berhasil!',
            text: 'Profile berhasil diperbarui',
            icon: 'success',
            confirmButtonText: 'OK',
            confirmButtonColor: '#3B82F6'
        }).then((result) => {
            if (result.isConfirmed) {
                // Redirect ke halaman profile
                window.location.href = "{{ route('profile.index') }}"; // atau route yang sesuai
            }
        });
    </script>
@endif

{{-- Alternatif: Jika ada error --}}
@if ($errors->any())
    <script>
        Swal.fire({
            title: 'Error!',
            text: 'Terdapat kesalahan dalam pengisian form',
            icon: 'error',
            confirmButtonText: 'OK',
            confirmButtonColor: '#EF4444'
        });
    </script>
@endif