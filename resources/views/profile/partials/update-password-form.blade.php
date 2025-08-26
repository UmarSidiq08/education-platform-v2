{{-- Password Update Card --}}
<div class="bg-white shadow-lg rounded-2xl border border-gray-100 hover:shadow-2xl transition duration-300 transform hover:-translate-y-1 animate-fadeSlideUp" style="animation-delay: 0.3s">

    {{-- Card Header --}}
    <div class="px-6 py-5 border-b border-gray-100 bg-gradient-to-r from-amber-50 to-white rounded-t-2xl flex items-center gap-3">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-amber-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2a3 3 0 11-6 0v-2c0-.621-.504-1.125-1.125-1.125S3.75 14.379 3.75 15v2a4.5 4.5 0 109 0v-2c0-.621.504-1.125 1.125-1.125s1.125.504 1.125 1.125z" />
        </svg>
        <div>
            <h3 class="text-lg font-semibold text-gray-800">Ubah Password</h3>
            <p class="text-sm text-gray-500">Pastikan password Anda aman dan sulit ditebak.</p>
        </div>
    </div>

    {{-- Card Content --}}
    <div class="p-6">
        <form method="POST" action="{{ route('password.update') }}" class="space-y-6">
            @csrf
            @method('PUT')

            {{-- Current Password --}}
            <div>
                <x-input-label for="update_password_current_password" :value="__('Password Saat Ini')" class="text-gray-700 font-medium" />
                <x-text-input id="update_password_current_password" name="current_password" type="password"
                              class="mt-2 block w-full rounded-lg border-gray-300 shadow-sm focus:border-amber-500 focus:ring-amber-500"
                              autocomplete="current-password" />
                <x-input-error :messages="$errors->updatePassword->get('current_password')" class="mt-2" />
            </div>

            {{-- New Password --}}
            <div>
                <x-input-label for="update_password_password" :value="__('Password Baru')" class="text-gray-700 font-medium" />
                <x-text-input id="update_password_password" name="password" type="password"
                              class="mt-2 block w-full rounded-lg border-gray-300 shadow-sm focus:border-amber-500 focus:ring-amber-500"
                              autocomplete="new-password" />
                <x-input-error :messages="$errors->updatePassword->get('password')" class="mt-2" />
                <p class="text-xs text-gray-500 mt-1">Minimal 8 karakter, kombinasi huruf dan angka</p>
            </div>

            {{-- Confirm Password --}}
            <div>
                <x-input-label for="update_password_password_confirmation" :value="__('Konfirmasi Password')" class="text-gray-700 font-medium" />
                <x-text-input id="update_password_password_confirmation" name="password_confirmation" type="password"
                              class="mt-2 block w-full rounded-lg border-gray-300 shadow-sm focus:border-amber-500 focus:ring-amber-500"
                              autocomplete="new-password" />
                <x-input-error :messages="$errors->updatePassword->get('password_confirmation')" class="mt-2" />
            </div>

            {{-- Action Buttons --}}
            <div class="flex items-center justify-between pt-6 border-t border-gray-100">
                <div></div> {{-- Spacer --}}

                <div class="flex items-center gap-4">
                    @if (session('status') === 'password-updated')
                        <p class="text-sm text-green-600 flex items-center">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            Password berhasil diperbarui
                        </p>
                    @endif

                    <button type="submit"
                            class="px-8 py-2.5 bg-gradient-to-r from-amber-500 to-orange-600 hover:from-amber-600 hover:to-orange-700 text-white font-medium rounded-lg transition-all duration-200 transform hover:scale-105 focus:outline-none focus:ring-2 focus:ring-amber-500 focus:ring-offset-2">
                        <span class="flex items-center">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            Perbarui Password
                        </span>
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
