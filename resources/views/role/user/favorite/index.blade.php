@extends('layouts.user')

@section('content')

<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,700;1,500&family=DM+Sans:wght@400;500;600&display=swap" rel="stylesheet">

<style>
    *,
    *::before,
    *::after {
        box-sizing: border-box;
    }

    .fav-page {
        font-family: 'DM Sans', sans-serif;
        max-width: 1200px;
        margin: 0 auto;
        padding: 32px 24px 60px;
    }

    /* ===== HERO BANNER ===== */
    .hero {
        position: relative;
        background: #1a1a2e;
        border-radius: 20px;
        padding: 36px 36px 0;
        margin-bottom: 28px;
        overflow: hidden;
        min-height: 200px;
    }

    /* dot-grid texture */
    .hero::before {
        content: '';
        position: absolute;
        inset: 0;
        background-image: radial-gradient(circle, rgba(255, 255, 255, .07) 1px, transparent 1px);
        background-size: 22px 22px;
        pointer-events: none;
    }

    /* warm glow blob */
    .hero::after {
        content: '';
        position: absolute;
        top: -60px;
        right: -60px;
        width: 280px;
        height: 280px;
        border-radius: 50%;
        background: rgba(231, 76, 60, .18);
        pointer-events: none;
    }

    .hero-inner {
        position: relative;
        z-index: 2;
        display: flex;
        justify-content: space-between;
        align-items: flex-end;
        gap: 20px;
    }

    .hero-text {
        flex: 1;
    }

    .hero-eyebrow {
        display: inline-flex;
        align-items: center;
        gap: 7px;
        font-size: 11px;
        font-weight: 600;
        letter-spacing: .8px;
        text-transform: uppercase;
        color: rgba(255, 255, 255, .5);
        margin-bottom: 12px;
    }

    .eyebrow-dot {
        width: 6px;
        height: 6px;
        border-radius: 50%;
        background: #e74c3c;
        display: inline-block;
        flex-shrink: 0;
    }

    .hero-title {
        font-family: 'Playfair Display', serif;
        font-size: 34px;
        font-weight: 700;
        color: #fff;
        line-height: 1.15;
        margin: 0 0 10px;
    }

    .hero-title em {
        font-style: italic;
        color: #ffb3ae;
    }

    .hero-sub {
        font-size: 13px;
        color: rgba(255, 255, 255, .5);
        margin: 0 0 22px;
    }

    /* stat chips */
    .hero-stats {
        display: flex;
        gap: 10px;
        flex-wrap: wrap;
        margin-bottom: 30px;
    }

    .hstat {
        display: flex;
        align-items: center;
        gap: 7px;
        padding: 5px 15px;
        border-radius: 20px;
        background: rgba(255, 255, 255, .09);
        border: 1px solid rgba(255, 255, 255, .12);
        color: rgba(255, 255, 255, .7);
        font-size: 12px;
        font-weight: 500;
    }

    .hstat-num {
        font-weight: 700;
        color: #fff;
        font-size: 15px;
    }

    /* decorative stacked books */
    .book-deco {
        display: flex;
        align-items: flex-end;
        gap: 5px;
        flex-shrink: 0;
        align-self: flex-end;
    }

    .bk {
        border-radius: 4px 4px 0 0;
        width: 22px;
        flex-shrink: 0;
    }

    .bk-label {
        position: absolute;
        top: 12px;
        left: 50%;
        transform: translateX(-50%) rotate(-90deg);
        white-space: nowrap;
        font-size: 8px;
        font-weight: 700;
        color: rgba(255, 255, 255, .55);
        letter-spacing: 1px;
        text-transform: uppercase;
    }

    /* ===== CONTROLS ===== */
    .controls {
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 12px;
        margin-bottom: 20px;
    }

    .filter-row {
        display: flex;
        gap: 8px;
        flex-wrap: wrap;
    }

    .chip {
        padding: 6px 18px;
        border-radius: 24px;
        font-size: 12px;
        font-weight: 500;
        cursor: pointer;
        border: 1px solid #e0e0e0;
        background: #fff;
        color: #666;
        transition: all .18s ease;
        font-family: 'DM Sans', sans-serif;
    }

    .chip:hover {
        border-color: #1a1a2e;
        color: #1a1a2e;
    }

    .chip.active {
        background: #1a1a2e;
        color: #fff;
        border-color: #1a1a2e;
    }

    .search-wrap {
        position: relative;
    }

    .search-wrap input {
        padding: 9px 16px 9px 38px;
        border: 1px solid #e0e0e0;
        border-radius: 24px;
        font-size: 13px;
        width: 240px;
        background: #fff;
        color: #333;
        font-family: 'DM Sans', sans-serif;
        transition: border-color .2s;
    }

    .search-wrap input:focus {
        outline: none;
        border-color: #1a1a2e;
    }

    .search-wrap i {
        position: absolute;
        left: 13px;
        top: 50%;
        transform: translateY(-50%);
        color: #aaa;
        font-size: 14px;
    }

    /* ===== DIVIDER ===== */
    .div-row {
        display: flex;
        align-items: center;
        gap: 12px;
        margin-bottom: 22px;
    }

    .div-line {
        flex: 1;
        height: 1px;
        background: #eeeeee;
    }

    .div-label {
        font-size: 11px;
        font-weight: 600;
        letter-spacing: .7px;
        text-transform: uppercase;
        color: #bbb;
        white-space: nowrap;
    }

    /* ===== BOOKS GRID ===== */
    .books-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(155px, 1fr));
        gap: 20px;
    }

    /* ===== BOOK CARD ===== */
    .book-card {
        background: #ffffff;
        border-radius: 14px;
        border: 1px solid #eeeeee;
        overflow: hidden;
        transition: transform .22s ease, box-shadow .22s ease, border-color .22s ease;
        position: relative;
        cursor: pointer;
    }

    .book-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 28px rgba(0, 0, 0, .08);
        border-color: #e0e0e0;
    }

    .book-cover {
        width: 100%;
        aspect-ratio: 2 / 2.9;
        position: relative;
        overflow: hidden;
        background: #f5f5f5;
    }

    .book-cover img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        display: block;
        transition: transform .3s ease;
    }

    .book-card:hover .book-cover img {
        transform: scale(1.04);
    }

    .cover-placeholder {
        width: 100%;
        height: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
        background: linear-gradient(145deg, #f0f0f0, #e5e5e5);
    }

    .cover-placeholder i {
        font-size: 40px;
        color: #c8c8c8;
    }

    .fav-badge {
        position: absolute;
        top: 9px;
        left: 9px;
        background: #e74c3c;
        color: #fff;
        font-size: 10px;
        font-weight: 600;
        padding: 3px 9px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        gap: 3px;
        z-index: 2;
    }

    .fav-badge i {
        font-size: 10px;
    }

    .remove-btn {
        position: absolute;
        top: 9px;
        right: 9px;
        background: rgba(255, 255, 255, .95);
        border: none;
        border-radius: 50%;
        width: 30px;
        height: 30px;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        box-shadow: 0 2px 8px rgba(0, 0, 0, .12);
        transition: all .18s ease;
        z-index: 10;
        color: #e74c3c;
    }

    .remove-btn:hover {
        background: #e74c3c;
        color: #fff;
        transform: scale(1.1);
    }

    .remove-btn i {
        font-size: 13px;
        transition: color .18s;
    }

    .book-info {
        padding: 11px 12px 13px;
        background: #fff;
    }

    .book-title {
        font-size: 13px;
        font-weight: 600;
        color: #1a1a2e;
        line-height: 1.45;
        margin-bottom: 5px;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    .book-category {
        font-size: 10px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: .5px;
        color: #0f6e56;
    }

    .book-card[data-catkey="fiksi"] .book-category {
        color: #533ab7;
    }

    .book-card[data-catkey="nonfiksi"] .book-category {
        color: #0f6e56;
    }

    .book-card[data-catkey="bisnis"] .book-category {
        color: #993c1d;
    }

    .book-card[data-catkey="sains"] .book-category {
        color: #185fa5;
    }

    .book-card[data-catkey="sejarah"] .book-category {
        color: #854f0b;
    }

    .book-card[data-catkey="agama"] .book-category {
        color: #3b6d11;
    }

    .rating-row {
        display: flex;
        align-items: center;
        gap: 2px;
        margin-top: 6px;
    }

    .star {
        color: #f0c040;
        font-size: 11px;
    }

    .star-off {
        color: #e5e7eb;
        font-size: 11px;
    }

    .rating-num {
        font-size: 11px;
        color: #aaa;
        margin-left: 3px;
    }

    /* ===== EMPTY STATE ===== */
    .empty-state,
    .no-results {
        text-align: center;
        padding: 60px 20px;
        grid-column: 1 / -1;
    }

    .empty-state i,
    .no-results i {
        font-size: 56px;
        color: #ddd;
        display: block;
        margin-bottom: 14px;
    }

    .empty-state h5,
    .no-results h5 {
        font-size: 17px;
        font-weight: 600;
        color: #333;
        margin-bottom: 8px;
    }

    .empty-state p,
    .no-results p {
        font-size: 13px;
        color: #999;
        margin-bottom: 20px;
    }

    .btn-explore {
        display: inline-flex;
        align-items: center;
        gap: 7px;
        background: #1a1a2e;
        color: #fff;
        padding: 10px 24px;
        border-radius: 24px;
        font-size: 13px;
        font-weight: 500;
        text-decoration: none;
        transition: opacity .18s;
    }

    .btn-explore:hover {
        opacity: .85;
        color: #fff;
        text-decoration: none;
    }

    .book-card.removing {
        transform: scale(0.85) !important;
        opacity: 0 !important;
        transition: transform .2s ease, opacity .2s ease !important;
    }

    /* ===== RESPONSIVE ===== */
    @media (max-width: 768px) {
        .fav-page {
            padding: 16px 14px 40px;
        }

        .hero {
            padding: 24px 20px 0;
            border-radius: 16px;
        }

        .hero-title {
            font-size: 26px;
        }

        .book-deco {
            display: none;
        }

        .controls {
            flex-direction: column;
            align-items: stretch;
        }

        .search-wrap input {
            width: 100%;
        }

        .books-grid {
            grid-template-columns: repeat(auto-fill, minmax(130px, 1fr));
            gap: 14px;
        }
    }

    @media (max-width: 480px) {
        .books-grid {
            grid-template-columns: repeat(2, 1fr);
        }
    }

    @keyframes spin {
        to {
            transform: rotate(360deg);
        }
    }
</style>

<div class="fav-page">

    {{-- ===== HERO BANNER ===== --}}
    <div class="hero">
        <div class="hero-inner">
            <div class="hero-text">
                <div class="hero-eyebrow">
                    <span class="eyebrow-dot"></span>
                    Koleksi Pribadi
                </div>
                <h1 class="hero-title">Buku <em>Favoritmu</em></h1>
                <p class="hero-sub">Semua buku yang pernah kamu tandai sebagai kesukaan</p>

                <div class="hero-stats">
                    <div class="hstat">
                        <span class="hstat-num" id="totalCount">{{ $favorites->count() }}</span>
                        <span>Buku tersimpan</span>
                    </div>
                    <div class="hstat">
                        <span class="hstat-num" id="categoryCount">0</span>
                        <span>Kategori</span>
                    </div>
                </div>
            </div>

            {{-- Dekorasi buku bertumpuk --}}
            <div class="book-deco" aria-hidden="true">
                <div class="bk" style="height:100px;background:#a78bfa;"></div>
                <div class="bk" style="height:130px;background:#fb923c;"></div>
                <div class="bk" style="height:85px;background:#34d399;"></div>
                <div class="bk" style="height:155px;background:#60a5fa;width:26px;position:relative;">
                    <span class="bk-label">Novel</span>
                </div>
                <div class="bk" style="height:115px;background:#f472b6;"></div>
                <div class="bk" style="height:70px;background:#fbbf24;"></div>
            </div>
        </div>
    </div>

    {{-- ===== FILTER & SEARCH ===== --}}
    <div class="controls">
        <div class="filter-row">
            <button class="chip active" data-filter="all">Semua</button>

            @foreach($categories as $cat)
            <button class="chip" data-filter="{{ strtolower($cat->name) }}">
                {{ $cat->name }}
            </button>
            @endforeach
        </div>

        <div class="search-wrap">
            <i class="ti ti-search"></i>
            <input type="text" id="searchInput" placeholder="Cari buku favorit...">
        </div>
    </div>

    {{-- ===== DIVIDER ===== --}}
    <div class="div-row">
        <div class="div-line"></div>
        <span class="div-label" id="resultLabel">{{ $favorites->count() }} buku ditemukan</span>
        <div class="div-line"></div>
    </div>

    {{-- ===== BOOKS GRID ===== --}}
    <div class="books-grid" id="booksGrid">

        @forelse($favorites as $fav)

        @php
        $rawCat = strtolower($fav->book->category->name ?? 'umum');
        $catKey = str_replace([' ', '-'], '', $rawCat);
        @endphp

        <div class="book-card"
            data-title="{{ strtolower($fav->book->title) }}"
            data-catkey="{{ $catKey }}">

            <form action="{{ route('user.favorite.toggle', $fav->book->id) }}"
                method="POST"
                class="remove-form"
                style="position:absolute;top:9px;right:9px;z-index:10;">
                @csrf
                <button type="submit" class="remove-btn" title="Hapus dari favorit">
                    <i class="ti ti-heart-filled"></i>
                </button>
            </form>

            <a href="{{ url('/user/books/' . $fav->book->id) }}"
                style="text-decoration:none;color:inherit;display:block;">

                <div class="book-cover">
                    @if($fav->book->cover)
                    <img src="{{ asset('storage/' . $fav->book->cover) }}"
                        alt="{{ $fav->book->title }}"
                        loading="lazy">
                    @else
                    <div class="cover-placeholder">
                        <i class="ti ti-book"></i>
                    </div>
                    @endif

                    <div class="fav-badge">
                        <i class="ti ti-star-filled"></i> Favorit
                    </div>
                </div>

                <div class="book-info">
                    <div class="book-title">{{ $fav->book->title }}</div>
                    <div class="book-category">{{ $fav->book->category->name ?? 'Umum' }}</div>
                </div>

            </a>
        </div>

        @empty

        <div class="empty-state">
            <i class="ti ti-heart"></i>
            <h5>Belum Ada Buku Favorit</h5>
            <p>Jelajahi koleksi dan klik ikon hati pada buku yang kamu suka!</p>
            <a href="{{ url('/user/books') }}" class="btn-explore">
                <i class="ti ti-books"></i> Jelajahi Buku
            </a>
        </div>

        @endforelse

    </div>
</div>

<script>
    (function() {
        const searchInput = document.getElementById('searchInput');
        const filterBtns = document.querySelectorAll('.chip');
        const booksGrid = document.getElementById('booksGrid');
        const totalCountEl = document.getElementById('totalCount');
        const catCountEl = document.getElementById('categoryCount');
        const resultLabelEl = document.getElementById('resultLabel');

        let currentFilter = 'all';
        let currentSearch = '';

        function updateStats() {
            const cards = booksGrid.querySelectorAll('.book-card');
            let visible = 0;
            const cats = new Set();

            cards.forEach(c => {
                if (c.style.display !== 'none') {
                    visible++;
                    const k = c.dataset.catkey;
                    if (k) cats.add(k);
                }
            });

            if (totalCountEl) totalCountEl.textContent = visible;
            if (catCountEl) catCountEl.textContent = cats.size;
            if (resultLabelEl) resultLabelEl.textContent = visible + ' buku ditemukan';
        }

        function filterBooks() {
            const cards = booksGrid.querySelectorAll('.book-card');
            let visible = 0;

            cards.forEach(card => {
                const title = card.dataset.title || '';
                const catkey = card.dataset.catkey || '';

                const matchFilter = currentFilter === 'all' || catkey === currentFilter;
                const matchSearch = !currentSearch || title.includes(currentSearch);

                if (matchFilter && matchSearch) {
                    card.style.display = '';
                    visible++;
                } else {
                    card.style.display = 'none';
                }
            });

            updateStats();

            const existing = booksGrid.querySelector('.no-results');
            const emptyState = booksGrid.querySelector('.empty-state');

            if (visible === 0 && booksGrid.querySelectorAll('.book-card').length > 0 && !emptyState) {
                if (!existing) {
                    const div = document.createElement('div');
                    div.className = 'no-results';
                    div.innerHTML = `
                    <i class="ti ti-search-off"></i>
                    <h5>Tidak ditemukan</h5>
                    <p>Coba ubah kata kunci atau filter kategori</p>`;
                    booksGrid.appendChild(div);
                }
            } else if (existing) {
                existing.remove();
            }
        }

        if (searchInput) {
            searchInput.addEventListener('input', function() {
                currentSearch = this.value.toLowerCase().trim();
                filterBooks();
            });
        }

        filterBtns.forEach(btn => {
            btn.addEventListener('click', function() {
                filterBtns.forEach(b => b.classList.remove('active'));
                this.classList.add('active');
                currentFilter = this.dataset.filter;
                filterBooks();
            });
        });

        booksGrid.addEventListener('submit', async function(e) {
            const form = e.target.closest('.remove-form');
            if (!form) return;

            e.preventDefault();
            e.stopPropagation();

            const card = form.closest('.book-card');
            const btn = form.querySelector('button');
            const originalHtml = btn.innerHTML;

            btn.innerHTML = '<i class="ti ti-loader-2" style="animation:spin .6s linear infinite"></i>';
            btn.disabled = true;

            try {
                const res = await fetch(form.action, {
                    method: 'POST',
                    body: new FormData(form),
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                });
                const data = await res.json();

                if (res.ok && data.success !== false) {
                    card.classList.add('removing');
                    setTimeout(() => {
                        card.remove();
                        updateStats();
                        filterBooks();

                        if (!booksGrid.querySelector('.book-card')) {
                            booksGrid.innerHTML = `
                            <div class="empty-state">
                                <i class="ti ti-heart"></i>
                                <h5>Belum Ada Buku Favorit</h5>
                                <p>Jelajahi koleksi dan klik ikon hati pada buku yang kamu suka!</p>
                                <a href="/user/books" class="btn-explore">
                                    <i class="ti ti-books"></i> Jelajahi Buku
                                </a>
                            </div>`;
                        }
                    }, 220);
                } else {
                    btn.innerHTML = originalHtml;
                    btn.disabled = false;
                }
            } catch {
                btn.innerHTML = originalHtml;
                btn.disabled = false;
            }
        });

        updateStats();
    })();
</script>

@endsection