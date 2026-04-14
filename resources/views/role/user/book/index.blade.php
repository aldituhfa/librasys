@extends('layouts.user')

@section('content')

<style>
    /* Gaya ala Gramedia */
    .gramedia-container {
        max-width: 1200px;
        margin: 0 auto;
    }

    /* Breadcrumb */
    .breadcrumb-gramedia {
        font-size: 13px;
        color: #666;
        margin-bottom: 20px;
    }

    .breadcrumb-gramedia a {
        color: #333;
        text-decoration: none;
    }

    .breadcrumb-gramedia span {
        margin: 0 5px;
    }

    /* Headline Kategori */
    .category-headline {
        font-size: 28px;
        font-weight: bold;
        margin-bottom: 20px;
        border-left: 4px solid #dc2626;
        padding-left: 15px;
    }

    /* Search - lebih menonjol */
    .search-gramedia {
        margin-bottom: 30px;
        background: linear-gradient(135deg, #dae8ec 0%, #e7e7e7 100%);
        padding: 25px 20px;
        border-radius: 12px;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
    }

    .search-gramedia input {
        width: 100%;
        padding: 14px 20px;
        border: none;
        border-radius: 20px;
        font-size: 16px;
        background: white;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        transition: all 0.3s;
    }

    .search-gramedia input:focus {
        outline: none;
        box-shadow: 0 0 0 3px rgba(255, 255, 255, 0.3), 0 2px 10px rgba(0, 0, 0, 0.1);
        transform: scale(1.01);
    }

    /* Category Container - 2 baris dengan scroll horizontal */
    .category-wrapper {
        margin-bottom: 25px;
        overflow-x: auto;
        overflow-y: hidden;
        scrollbar-width: thin;
    }

    .category-wrapper::-webkit-scrollbar {
        height: 6px;
    }

    .category-wrapper::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: 10px;
    }

    .category-wrapper::-webkit-scrollbar-thumb {
        background: #ccc;
        border-radius: 10px;
    }

    .category-scroll {
        display: flex;
        flex-direction: column;
        gap: 12px;
        width: max-content;
        min-width: 100%;
    }

    .category-row {
        display: flex;
        gap: 12px;
    }

    .category-item {
        padding: 10px 24px;
        border: 1.5px solid #e0e0e0;
        border-radius: 10px;
        font-size: 14px;
        font-weight: 500;
        white-space: nowrap;
        cursor: pointer;
        background: white;
        transition: all 0.2s;
        flex-shrink: 0;
    }

    .category-item:hover {
        background: #f5f5f5;
        border-color: #dc2626;
        transform: translateY(-2px);
    }

    .category-item.active {
        background: #1f2937;
        color: white;
        border-color: #1f2937;
    }

    /* Tab Filter */
    .filter-tabs {
        display: flex;
        gap: 30px;
        margin-bottom: 25px;
        border-bottom: 1px solid #eee;
    }

    .filter-tabs a {
        text-decoration: none;
        color: #888;
        font-size: 14px;
        font-weight: 500;
        padding-bottom: 10px;
    }

    .filter-tabs a.active {
        color: #333;
        font-weight: 600;
        border-bottom: 2px solid #333;
    }

    /* Grid Buku */
    .book-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(165px, 1fr));
        gap: 25px;
    }

    /* Card Buku */
    .book-card {
        text-decoration: none;
        color: inherit;
        background: white;
        border-radius: 12px;
        overflow: hidden;
        transition: all 0.3s;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.08);
        border: 1px solid #f0f0f0;
    }

    .book-card:hover {
        transform: translateY(-6px);
        box-shadow: 0 15px 30px rgba(0, 0, 0, 0.12);
        border-color: #e0e0e0;
    }

    .book-cover {
        width: 100%;
        aspect-ratio: 2/2.7;
        object-fit: cover;
        background: #f9f9f9;
    }

    .book-info {
        padding: 12px 12px 16px;
    }

    .book-title {
        font-size: 13px;
        font-weight: 700;
        line-height: 1.4;
        margin-bottom: 6px;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
        color: #1a1a1a;
    }

    .book-category {
        font-size: 11px;
        color: #3d7d74;
        font-weight: 600;
        margin-bottom: 4px;
        text-transform: uppercase;
        letter-spacing: 0.3px;
    }

    .book-pages {
        font-size: 11px;
        color: #999;
    }

    .no-cover {
        width: 100%;
        aspect-ratio: 2/2.7;
        display: flex;
        align-items: center;
        justify-content: center;
        background: #fafafa;
        color: #bbb;
        font-size: 12px;
        flex-direction: column;
        gap: 8px;
    }

    .no-cover span {
        font-size: 30px;
    }
</style>

<div class="gramedia-container">
    <!-- Breadcrumb -->
    <div class="breadcrumb-gramedia">
        <a href="#">Home</a> <span>/</span> <span>Buku</span>
    </div>

    <!-- Headline Kategori -->
    <div class="category-headline">
        {{ request('category') ? ($categories->find(request('category'))?->name ?? 'Agama') : (request('search') ? 'Hasil Pencarian' : 'Agama') }}
    </div>

    <!-- Search -->
    <div class="search-gramedia">
        <input type="text" id="searchInput" placeholder=" Cari judul buku, penulis, atau penerbit..." value="{{ request('search') }}">
    </div>

    <!-- Category Container - 2 baris dengan scroll horizontal -->
    <div class="category-wrapper">
        <div class="category-scroll" id="categoryScroll">
            <div class="category-row" id="categoryRow1"></div>
            <div class="category-row" id="categoryRow2"></div>
        </div>
    </div>

    <!-- Filter Tabs -->
    <div class="filter-tabs">
        <a href="#" class="tab {{ !request('type') ? 'active' : '' }}" data-type="">Semua</a>
        <a href="#" class="tab {{ request('type') == 'available' ? 'active' : '' }}" data-type="available">Tersedia</a>
        <a href="#" class="tab {{ request('type') == 'latest' ? 'active' : '' }}" data-type="latest">Terbaru</a>
    </div>

    <!-- Book Grid -->
    <div class="book-grid">
        
        @php
        $activeBorrow = \App\Models\Transaction::where('user_id', auth()->id())
        ->whereIn('status', ['pending','approved'])
        ->exists();
        @endphp

        @forelse($books as $book)
        <a href="{{ route('user.books.show', $book->id) }}" class="book-card">
            @if($book->cover)
            <img src="{{ asset('storage/'.$book->cover) }}" class="book-cover" alt="{{ $book->title }}">
            @else
            <div class="no-cover">
                <span>📖</span>
                <span>No Cover</span>
            </div>
            @endif
            <div class="book-info">
                <div class="book-title">{{ $book->title }}</div>
                <div class="book-category">{{ $book->category->name }}</div>
                <div class="book-pages">{{ $book->pages }} halaman</div>
            </div>
        </a>
        @empty
        <div style="text-align: center; padding: 50px; grid-column: 1/-1; color: #999;">
            <span style="font-size: 40px;">📚</span>
            <p style="margin-top: 10px;">Buku tidak ditemukan</p>
        </div>
        @endforelse
    </div>
</div>

<script>
    // Data kategori dari server
    const categories = @json($categories);
    const currentCategoryId = '{{ request('
    category ') }}';

    // Fungsi untuk membagi kategori ke 2 baris
    function renderCategories() {
        const row1 = document.getElementById('categoryRow1');
        const row2 = document.getElementById('categoryRow2');

        // Kosongkan dulu
        row1.innerHTML = '';
        row2.innerHTML = '';

        // Buat item "Semua" di baris 1
        const semuaItem = document.createElement('div');
        semuaItem.className = 'category-item' + (!currentCategoryId ? ' active' : '');
        semuaItem.setAttribute('data-id', '');
        semuaItem.innerText = 'Semua';
        semuaItem.onclick = function() {
            category = this.dataset.id;
            fetchBooks();
        };
        row1.appendChild(semuaItem);

        // Bagi kategori ke 2 baris
        const half = Math.ceil(categories.length / 2);
        const firstHalf = categories.slice(0, half);
        const secondHalf = categories.slice(half);

        // Baris 1
        firstHalf.forEach(cat => {
            const item = document.createElement('div');
            item.className = 'category-item' + (currentCategoryId == cat.id ? ' active' : '');
            item.setAttribute('data-id', cat.id);
            item.innerText = cat.name;
            item.onclick = function() {
                category = this.dataset.id;
                fetchBooks();
            };
            row1.appendChild(item);
        });

        // Baris 2
        secondHalf.forEach(cat => {
            const item = document.createElement('div');
            item.className = 'category-item' + (currentCategoryId == cat.id ? ' active' : '');
            item.setAttribute('data-id', cat.id);
            item.innerText = cat.name;
            item.onclick = function() {
                category = this.dataset.id;
                fetchBooks();
            };
            row2.appendChild(item);
        });
    }

    let search = '{{ request('
    search ') }}';
    let category = '{{ request('
    category ') }}';
    let type = '{{ request('
    type ') }}';

    function fetchBooks() {
        let params = new URLSearchParams();
        if (search) params.append('search', search);
        if (category) params.append('category', category);
        if (type) params.append('type', type);
        window.location.href = window.location.pathname + '?' + params.toString();
    }

    // Search dengan debounce
    let searchInput = document.getElementById('searchInput');
    let timeout;
    searchInput.addEventListener('keyup', function(e) {
        clearTimeout(timeout);
        timeout = setTimeout(() => {
            search = this.value;
            fetchBooks();
        }, 300);
    });

    // Tab
    document.querySelectorAll('.tab').forEach(el => {
        el.onclick = function(e) {
            e.preventDefault();
            type = this.dataset.type;
            fetchBooks();
        }
    });

    // Render kategori saat halaman dimuat
    renderCategories();
</script>

@endsection