@extends('layouts.user')

@section('content')

<style>
    /* Gaya ala Gramedia seperti gambar */
    .gramedia-container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 0 20px;
    }

    /* Hero Section dengan Quote Carousel + New Arrivals */
    .hero-section {
        display: flex;
        gap: 30px;
        margin-bottom: 40px;
        flex-wrap: wrap;
    }

    /* Quote Carousel */
    .quote-carousel {
        flex: 2;
        background: linear-gradient(135deg, #1a1a2e 0%, #16213e 100%);
        border-radius: 20px;
        padding: 40px 30px;
        color: white;
        position: relative;
        overflow: hidden;
        min-width: 250px;
    }

    .quote-carousel::before {
        content: '"';
        position: absolute;
        bottom: -30px;
        right: 30px;
        font-size: 180px;
        opacity: 0.08;
        font-family: Georgia, serif;
    }

    .quote-slide {
        display: none;
    }

    .quote-slide.active {
        display: block;
        animation: fadeIn 0.5s ease;
    }

    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateX(20px);
        }

        to {
            opacity: 1;
            transform: translateX(0);
        }
    }

    .quote-category {
        font-size: 12px;
        letter-spacing: 3px;
        text-transform: uppercase;
        margin-bottom: 15px;
        opacity: 0.7;
    }

    .quote-text {
        font-size: 22px;
        line-height: 1.4;
        font-style: italic;
        margin-bottom: 15px;
    }

    .quote-author {
        font-size: 14px;
        opacity: 0.7;
        margin-top: 10px;
    }

    .quote-dots {
        display: flex;
        gap: 8px;
        margin-top: 25px;
    }

    .quote-dot {
        width: 8px;
        height: 8px;
        border-radius: 50%;
        background: rgba(255, 255, 255, 0.3);
        cursor: pointer;
        transition: all 0.3s;
    }

    .quote-dot.active {
        background: white;
        width: 24px;
        border-radius: 4px;
    }

    /* New Arrivals Side - horizontal scroll */
    .new-arrivals-side {
        flex: 1.2;
        background: #f8f8f8;
        border-radius: 20px;
        padding: 20px;
        min-width: 280px;
    }

    .new-arrivals-header {
        display: flex;
        justify-content: space-between;
        align-items: baseline;
        margin-bottom: 15px;
    }

    .new-arrivals-header h3 {
        font-size: 18px;
        font-weight: bold;
        margin: 0;
    }

    .new-arrivals-header a {
        color: #0066cc;
        text-decoration: none;
        font-size: 12px;
    }

    .new-books-horizontal {
        display: flex;
        gap: 15px;
        overflow-x: auto;
        scrollbar-width: thin;
        padding-bottom: 5px;
    }

    .new-books-horizontal::-webkit-scrollbar {
        height: 4px;
    }

    .new-books-horizontal::-webkit-scrollbar-track {
        background: #e0e0e0;
        border-radius: 10px;
    }

    .new-books-horizontal::-webkit-scrollbar-thumb {
        background: #bbb;
        border-radius: 10px;
    }

    .new-book-item-horizontal {
        flex-shrink: 0;
        width: 120px;
        text-decoration: none;
        color: inherit;
    }

    .new-book-cover-horizontal {
        width: 120px;
        height: 150px;
        background: #e0e0e0;
        border-radius: 8px;
        overflow: hidden;
        margin-bottom: 8px;
    }

    .new-book-cover-horizontal img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .new-book-title-horizontal {
        font-size: 12px;
        font-weight: 600;
        margin-bottom: 4px;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    .new-book-author-horizontal {
        font-size: 10px;
        color: #666;
    }

    /* SEARCH & FILTER SECTION - STYLING DIPERBAIKI */
    .search-filter-section {
        margin-bottom: 30px;
        padding: 20px 0;
        border-bottom: 1px solid #f0f0f0;
    }

    /* Search Box */
    .search-box {
        margin-bottom: 25px;
        position: relative;
    }

    .search-box .search-icon {
        position: absolute;
        left: 16px;
        top: 50%;
        transform: translateY(-50%);
        color: #000000;
        font-size: 18px;
        pointer-events: none;
    }

    .search-box input {
        width: 100%;
        padding: 14px 16px 14px 48px;
        border: 1px solid #5a5a5a;
        border-radius: 12px;
        font-size: 14px;
        background: white;
        transition: all 0.3s;
        font-family: inherit;
    }

    .search-box input:focus {
        outline: none;
        border-color: #1a1a2e;
        box-shadow: 0 0 0 3px rgba(26, 26, 46, 0.08);
    }

    .search-box input::placeholder {
        color: #bbb;
    }

    /* Category Chips */
    .category-chips {
        display: flex;
        gap: 12px;
        margin-bottom: 25px;
        flex-wrap: wrap;
    }

    .category-chip {
        padding: 8px 20px;
        border: 1px solid #e0e0e0;
        border-radius: 30px;
        font-size: 13px;
        cursor: pointer;
        background: white;
        transition: all 0.25s;
        font-weight: 500;
        color: #555;
    }

    .category-chip:hover {
        border-color: #1a1a2e;
        color: #1a1a2e;
        background: #fafafa;
        transform: translateY(-1px);
    }

    .category-chip.active {
        background: #1a1a2e;
        color: white;
        border-color: #1a1a2e;
        box-shadow: 0 2px 8px rgba(26, 26, 46, 0.2);
    }

    /* Filter Tabs */
    .filter-tabs {
        display: flex;
        gap: 24px;
        margin-bottom: 5px;
    }

    .filter-tabs a {
        text-decoration: none;
        color: #999;
        font-size: 14px;
        padding-bottom: 8px;
        cursor: pointer;
        transition: all 0.25s;
        font-weight: 500;
    }

    .filter-tabs a:hover {
        color: #1a1a2e;
    }

    .filter-tabs a.active {
        color: #1a1a2e;
        font-weight: 600;
        border-bottom: 2px solid #1a1a2e;
    }

    /* Rekomendasi Untuk Anda */
    .recommendation-section {
        margin-bottom: 40px;
    }

    .section-header {
        display: flex;
        justify-content: space-between;
        align-items: baseline;
        margin-bottom: 20px;
    }

    .section-header h3 {
        font-size: 22px;
        font-weight: bold;
        margin: 0;
        color: #1a1a2e;
    }

    .section-header a {
        color: #0066cc;
        text-decoration: none;
        font-size: 14px;
    }

    /* Grid Buku untuk Rekomendasi */
    .book-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(160px, 1fr));
        gap: 25px;
    }

    /* Card Buku dengan Container */
    .book-card-wrapper {
        background: white;
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 2px 12px rgba(0, 0, 0, 0.08);
        transition: all 0.3s;
        position: relative;
        border: 1px solid #f0f0f0;
    }

    .book-card-wrapper:hover {
        transform: translateY(-4px);
        box-shadow: 0 8px 24px rgba(0, 0, 0, 0.12);
    }

    .book-cover-container {
        width: 100%;
        aspect-ratio: 2/2.5;
        background: #f9f9f9;
        overflow: hidden;
    }

    .book-cover-container img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .book-info-container {
        padding: 12px;
    }

    .book-title-grid {
        font-size: 13px;
        font-weight: 600;
        margin-bottom: 4px;
        line-height: 1.4;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
        color: #333;
    }

    .book-author-grid {
        font-size: 11px;
        color: #666;
        margin-bottom: 2px;
    }

    .book-category-grid {
        font-size: 10px;
        color: #3d7d74;
        font-weight: 600;
        text-transform: uppercase;
    }

    .no-cover {
        width: 100%;
        height: 100%;
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
        font-size: 40px;
    }

    /* Button Favorite */
    .favorite-btn-wrapper {
        position: absolute;
        top: 8px;
        right: 8px;
        z-index: 10;
    }

    .favorite-btn {
        background: rgba(255, 255, 255, 0.95);
        border: none;
        border-radius: 50%;
        width: 32px;
        height: 32px;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.15);
        transition: all 0.2s;
    }

    .favorite-btn:hover {
        transform: scale(1.1);
        background: white;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
    }

    .favorite-btn i {
        font-size: 18px;
    }

    .text-danger {
        color: #e74c3c;
    }

    .text-dark {
        color: #333;
    }

    /* Breadcrumb */
    .breadcrumb {
        font-size: 13px;
        color: #666;
        margin-bottom: 20px;
    }

    .breadcrumb a {
        color: #333;
        text-decoration: none;
    }

    /* Loading Indicator */
    .loading-indicator {
        text-align: center;
        padding: 40px;
        grid-column: 1/-1;
        color: #999;
    }

    .loading-indicator span {
        font-size: 30px;
        display: inline-block;
        animation: spin 1s linear infinite;
    }

    @keyframes spin {
        0% {
            transform: rotate(0deg);
        }

        100% {
            transform: rotate(360deg);
        }
    }
</style>

<div class="gramedia-container">
    <!-- Breadcrumb -->
    <div class="breadcrumb">
        <a href="#">Home</a> <span>/</span> <span>Buku</span>
    </div>

    <!-- Hero Section: Quote Carousel + New Arrivals -->
    <div class="hero-section">
        <!-- Quote Carousel -->
        <div class="quote-carousel">
            <div class="quote-slide active">
                <div class="quote-category">TODAY'S QUOTE</div>
                <div class="quote-text">"Makin aku banyak membaca, makin aku banyak berpikir; makin aku banyak belajar, makin aku sadar bahwa aku tak mengetahui apa pun."</div>
                <div class="quote-author">- Voltaire</div>
            </div>
            <div class="quote-slide">
                <div class="quote-category">QUOTE OF THE DAY</div>
                <div class="quote-text">"The only thing you absolutely have to know is the location of the library."</div>
                <div class="quote-author">- Albert Einstein</div>
            </div>
            <div class="quote-slide">
                <div class="quote-category">INSPIRATION</div>
                <div class="quote-text">"Books are a uniquely portable magic."</div>
                <div class="quote-author">- Stephen King</div>
            </div>
            <div class="quote-dots">
                <span class="quote-dot active" data-slide="0"></span>
                <span class="quote-dot" data-slide="1"></span>
                <span class="quote-dot" data-slide="2"></span>
            </div>
        </div>

        <!-- New Arrivals Side (3 buku terbaru - horizontal) -->
        <div class="new-arrivals-side">
            <div class="new-arrivals-header">
                <h3>New Arrivals</h3>
            </div>
            <div class="new-books-horizontal">
                @php
                $newestBooks = $books->sortByDesc('created_at')->take(3);
                @endphp
                @foreach($newestBooks as $book)
                <a href="{{ route('user.books.show', $book->id) }}" class="new-book-item-horizontal">
                    <div class="new-book-cover-horizontal">
                        @if($book->cover)
                        <img src="{{ asset('storage/'.$book->cover) }}" alt="{{ $book->title }}">
                        @else
                        <div style="width:100%;height:100%;display:flex;align-items:center;justify-content:center;background:#e0e0e0;font-size:30px;">📖</div>
                        @endif
                    </div>
                    <div class="new-book-title-horizontal">{{ $book->title }}</div>
                    <div class="new-book-author-horizontal">{{ $book->author ?? $book->category->name }}</div>
                </a>
                @endforeach
            </div>
        </div>
    </div>

    <!-- SEARCH & FILTER SECTION (Greeting dihapus) -->
    <div class="search-filter-section">
        <!-- Search Box dengan ikon -->
        <div class="search-box">
            <input type="text" id="searchInput" placeholder="Cari judul buku, penulis, atau penerbit..." value="{{ request('search') }}">
        </div>

        <!-- Category Chips -->
        <div class="category-chips" id="categoryChips">
            <div class="category-chip {{ !request('category') ? 'active' : '' }}" data-id="">Semua</div>
            @foreach($categories as $cat)
            <div class="category-chip {{ request('category') == $cat->id ? 'active' : '' }}" data-id="{{ $cat->id }}">{{ $cat->name }}</div>
            @endforeach
        </div>

        <!-- Filter Tabs -->
        <div class="filter-tabs">
            <a href="#" class="tab {{ !request('type') ? 'active' : '' }}" data-type="">Semua</a>
            <a href="#" class="tab {{ request('type') == 'available' ? 'active' : '' }}" data-type="available">Tersedia</a>
            <a href="#" class="tab {{ request('type') == 'latest' ? 'active' : '' }}" data-type="latest">Terbaru</a>
        </div>
    </div>

    <!-- Rekomendasi Untuk Anda Section -->
    <div class="recommendation-section">
        <div class="section-header">
            <h3>Rekomendasi Untuk Anda</h3>
        </div>

        <!-- Book Grid -->
        <div class="book-grid" id="bookGrid">
            <!-- Book cards akan diisi oleh JavaScript -->
            <div class="loading-indicator">
                <span>⏳</span>
                <p>Memuat buku...</p>
            </div>
        </div>
    </div>
</div>

<script>
    // ========== QUOTE CAROUSEL ==========
    let currentSlide = 0;
    const slides = document.querySelectorAll('.quote-slide');
    const dots = document.querySelectorAll('.quote-dot');

    function showSlide(index) {
        slides.forEach((slide, i) => {
            slide.classList.remove('active');
            dots[i].classList.remove('active');
        });
        slides[index].classList.add('active');
        dots[index].classList.add('active');
        currentSlide = index;
    }

    function nextSlide() {
        let next = (currentSlide + 1) % slides.length;
        showSlide(next);
    }

    if (dots.length) {
        dots.forEach((dot, index) => {
            dot.addEventListener('click', () => showSlide(index));
        });
    }

    let slideInterval = setInterval(nextSlide, 5000);
    const quoteCarousel = document.querySelector('.quote-carousel');
    if (quoteCarousel) {
        quoteCarousel.addEventListener('mouseenter', () => clearInterval(slideInterval));
        quoteCarousel.addEventListener('mouseleave', () => {
            slideInterval = setInterval(nextSlide, 5000);
        });
    }

    // ========== FILTER & SEARCH TANPA RELOAD ==========
    let currentSearch = '{{ request('
    search ') }}';
    let currentCategory = '{{ request('
    category ') }}';
    let currentType = '{{ request('
    type ') }}';

    async function fetchBooksWithoutReload() {
        const bookGrid = document.getElementById('bookGrid');

        // Tampilkan loading
        bookGrid.innerHTML = `
            <div class="loading-indicator">
                <span>⏳</span>
                <p>Memuat buku...</p>
            </div>
        `;

        // Build URL menggunakan URL saat ini
        let url = window.location.pathname + '?ajax=1';
        if (currentSearch) url += '&search=' + encodeURIComponent(currentSearch);
        if (currentCategory) url += '&category=' + currentCategory;
        if (currentType) url += '&type=' + currentType;

        try {
            const response = await fetch(url, {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            });
            const data = await response.json();
            renderBooks(data.books);

            // Update URL tanpa reload
            const params = new URLSearchParams();
            if (currentSearch) params.set('search', currentSearch);
            if (currentCategory) params.set('category', currentCategory);
            if (currentType) params.set('type', currentType);
            const newUrl = window.location.pathname + (params.toString() ? '?' + params.toString() : '');
            window.history.pushState({}, '', newUrl);

        } catch (error) {
            console.error('Error fetching books:', error);
            bookGrid.innerHTML = `
                <div style="text-align: center; padding: 50px; grid-column: 1/-1; color: #999;">
                    <span style="font-size: 40px;">⚠️</span>
                    <p style="margin-top: 10px;">Gagal memuat buku. Silakan coba lagi.</p>
                </div>
            `;
        }
    }

    function renderBooks(books) {
        const bookGrid = document.getElementById('bookGrid');

        if (!books || books.length === 0) {
            bookGrid.innerHTML = `
                <div style="text-align: center; padding: 50px; grid-column: 1/-1; color: #999;">
                    <span style="font-size: 40px;">📚</span>
                    <p style="margin-top: 10px;">Buku tidak ditemukan</p>
                </div>
            `;
            return;
        }

        let html = '';
        const csrfToken = '{{ csrf_token() }}';

        books.forEach(book => {
            const isFav = book.is_favorite || false;
            const coverHtml = book.cover ?
                `<img src="/storage/${book.cover}" alt="${escapeHtml(book.title)}">` :
                `<div class="no-cover"><span>📖</span><span>No Cover</span></div>`;

            html += `
                <div class="book-card-wrapper">
                    <div class="favorite-btn-wrapper">
                        <form action="/user/favorite/${book.id}" method="POST" class="favorite-btn-form">
                            <input type="hidden" name="_token" value="${csrfToken}">
                            <button type="submit" class="favorite-btn">
                                <i class="ti ${isFav ? 'ti-heart-filled text-danger' : 'ti-heart text-dark'}"></i>
                            </button>
                        </form>
                    </div>
                    
                    <a href="/user/books/${book.id}" style="text-decoration: none; color: inherit;">
                        <div class="book-cover-container">
                            ${coverHtml}
                        </div>
                        <div class="book-info-container">
                            <div class="book-title-grid">${escapeHtml(book.title)}</div>
                            <div class="book-author-grid">${escapeHtml(book.author || 'Unknown Author')}</div>
                            <div class="book-category-grid">${escapeHtml(book.category_name)}</div>
                        </div>
                    </a>
                </div>
            `;
        });

        bookGrid.innerHTML = html;

        // Re-attach favorite form handlers
        document.querySelectorAll('.favorite-btn-form').forEach(form => {
            form.addEventListener('submit', async (e) => {
                e.preventDefault();
                e.stopPropagation();
                const formData = new FormData(form);
                try {
                    const response = await fetch(form.action, {
                        method: 'POST',
                        body: formData,
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest'
                        }
                    });
                    const result = await response.json();
                    if (result.success) {
                        fetchBooksWithoutReload();
                    }
                } catch (error) {
                    console.error('Error toggling favorite:', error);
                }
            });
        });
    }

    function escapeHtml(text) {
        if (!text) return '';
        const div = document.createElement('div');
        div.textContent = text;
        return div.innerHTML;
    }

    // Search dengan debounce
    let searchInput = document.getElementById('searchInput');
    let searchTimeout;
    if (searchInput) {
        searchInput.addEventListener('keyup', function(e) {
            clearTimeout(searchTimeout);
            searchTimeout = setTimeout(() => {
                currentSearch = this.value;
                fetchBooksWithoutReload();
            }, 300);
        });
    }

    // Category Chips
    document.querySelectorAll('.category-chip').forEach(el => {
        el.onclick = function(e) {
            document.querySelectorAll('.category-chip').forEach(chip => chip.classList.remove('active'));
            this.classList.add('active');
            currentCategory = this.dataset.id;
            fetchBooksWithoutReload();
        }
    });

    // Tab Filter
    document.querySelectorAll('.tab').forEach(el => {
        el.onclick = function(e) {
            e.preventDefault();
            document.querySelectorAll('.tab').forEach(tab => tab.classList.remove('active'));
            this.classList.add('active');
            currentType = this.dataset.type;
            fetchBooksWithoutReload();
        }
    });

    // Initial load
    fetchBooksWithoutReload();
</script>

@endsection