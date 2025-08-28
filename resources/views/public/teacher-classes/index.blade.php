@extends('layouts.app')

@section('title', 'Daftar Mata Pelajaran')

@section('content')
<div class="container mx-auto px-4 py-8">
    <!-- Header Section -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900 mb-2">Daftar eMaster</h1>
        <p class="text-gray-600">Jelajahi berbagai mata pelajaran yang tersedia dan temukan mentor terbaik</p>
    </div>

    <!-- Stats Section -->
    <div class="mb-8">
        <div class="bg-gradient-to-r from-blue-500 to-purple-600 rounded-lg p-6 text-white">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div class="text-center">
                    <div class="text-2xl font-bold">{{ $teacherClasses->total() }}</div>
                    <div class="text-blue-100">Mata Pelajaran</div>
                </div>
                <div class="text-center">
                    <div class="text-2xl font-bold">{{ $teacherClasses->sum('approved_mentors_count') }}</div>
                    <div class="text-blue-100">Total Mentor</div>
                </div>
                <div class="text-center">
                    <div class="text-2xl font-bold">{{ $teacherClasses->where('approved_mentors_count', '>', 0)->count() }}</div>
                    <div class="text-blue-100">Kelas Aktif</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Search and Filter Section -->
    <div class="mb-8 bg-white rounded-lg shadow-sm p-6">
        <div class="flex flex-col lg:flex-row gap-4">
            <!-- Search Box -->
            <div class="flex-1">
                <form action="{{ route('public.teacher-classes.search') }}" method="GET" class="relative">
                    <input
                        type="text"
                        name="q"
                        value="{{ request('q') }}"
                        placeholder="Cari mata pelajaran atau nama eMaster..."
                        class="w-full pl-10 pr-12 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200"
                        autocomplete="off"
                        autocapitalize="off"
                    >
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </div>
                    <!-- Clear button -->
                    <button type="button" class="absolute inset-y-0 right-0 pr-3 flex items-center" onclick="clearSearch()" style="display: {{ request('q') ? 'flex' : 'none' }};" id="clear-button">
                        <svg class="h-4 w-4 text-gray-400 hover:text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </form>
            </div>

            <!-- Subject Filter -->
            @if(isset($subjects) && $subjects->count() > 0)
            <div class="lg:w-64">
                <form action="{{ route('public.teacher-classes.filter') }}" method="GET">
                    <select name="subject" onchange="this.form.submit()" class="w-full py-3 px-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        <option value="">Semua Mata Pelajaran</option>
                        @foreach($subjects as $subjectOption)
                            <option value="{{ $subjectOption }}" {{ request('subject') == $subjectOption ? 'selected' : '' }}>
                                {{ $subjectOption }}
                            </option>
                        @endforeach
                    </select>
                </form>
            </div>
            @endif
        </div>
    </div>

    <!-- Search Info -->
    <div id="search-info">
        @if(request('q'))
            <div class="text-sm text-gray-600 mb-4">
                Menampilkan <strong>{{ $teacherClasses->total() }}</strong> hasil untuk "<strong>{{ request('q') }}</strong>"
                <button class="ml-2 text-blue-500 hover:text-blue-700" onclick="clearSearch()">
                    <svg class="w-4 h-4 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                    Hapus pencarian
                </button>
            </div>
        @endif
    </div>

    <!-- Classes Grid -->
    <div id="classes-grid">
        @include('public.teacher-classes.partials.class-grid', ['teacherClasses' => $teacherClasses])
    </div>

    <!-- Pagination Container -->
    <div class="pagination-container mt-8">
        {{ $teacherClasses->links() }}
    </div>
</div>

@push('scripts')
  <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script>

// AJAX Realtime Search - Updated Version
$(document).ready(function() {
    let searchTimeout;
    const searchInput = $('input[name="q"]');
    const classesGrid = $('#classes-grid');
    const searchForm = $('form[action*="search"]');
    const clearButton = $('#clear-button');

    // Prevent form submission on Enter key
    searchForm.on('submit', function(e) {
        e.preventDefault();
        const query = searchInput.val();
        performSearch(query);
    });

    // Show/hide clear button based on input
    searchInput.on('input', function() {
        const hasValue = $(this).val().length > 0;
        clearButton.toggle(hasValue);

        clearTimeout(searchTimeout);
        const query = $(this).val().trim();

        searchTimeout = setTimeout(function() {
            performSearch(query);
        }, 300);
    });

    // Clear search function
    window.clearSearch = function() {
        searchInput.val('').trigger('input').focus();
        clearButton.hide();
    };

    function performSearch(query) {
        // Update URL without page reload
        const url = new URL(window.location);
        if (query) {
            url.searchParams.set('q', query);
        } else {
            url.searchParams.delete('q');
        }
        window.history.replaceState({}, '', url);

        $.ajax({
            url: '{{ route("public.teacher-classes.search") }}',
            method: 'GET',
            data: {
                q: query,
                ajax: 1
            },
            beforeSend: function() {
                classesGrid.html(`
                    <div class="text-center py-12">
                        <div class="inline-flex items-center px-4 py-2 text-blue-600">
                            <svg class="animate-spin -ml-1 mr-3 h-6 w-6" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                            <span>Mencari...</span>
                        </div>
                    </div>
                `);
            },
            success: function(response) {
                classesGrid.html(response.html);

                if (response.pagination) {
                    $('.pagination-container').html(response.pagination);
                }

                updateSearchInfo(query, response.total || 0);
            },
            error: function(xhr) {
                classesGrid.html(`
                    <div class="text-center py-12">
                        <div class="text-red-500 mb-2">
                            <svg class="w-12 h-12 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <h3 class="text-lg font-medium">Terjadi Kesalahan</h3>
                            <p class="text-sm text-gray-500 mt-1">Gagal memuat data. Silakan coba lagi.</p>
                        </div>
                        <button onclick="location.reload()" class="px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition-colors">
                            Muat Ulang
                        </button>
                    </div>
                `);
            }
        });
    }

    function updateSearchInfo(query, total) {
        const searchInfo = $('#search-info');

        if (query) {
            searchInfo.html(`
                <div class="text-sm text-gray-600 mb-4">
                    Menampilkan <strong>${total}</strong> hasil untuk "<strong>${query}</strong>"
                    <button class="ml-2 text-blue-500 hover:text-blue-700" onclick="clearSearch()">
                        <svg class="w-4 h-4 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                        Hapus pencarian
                    </button>
                </div>
            `);
        } else {
            searchInfo.html('');
        }
    }

    // Handle browser back/forward buttons
    window.addEventListener('popstate', function(e) {
        const urlParams = new URLSearchParams(window.location.search);
        const query = urlParams.get('q') || '';
        searchInput.val(query);
        clearButton.toggle(query.length > 0);
        performSearch(query);
    });
});
</script>
@endpush
@endsection
