<style>
    .book-detail-card {
        background: #ffffff;
        border-radius: 20px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
        padding: 32px;
        transition: all 0.3s ease;
    }

    .book-cover-wrapper {
        text-align: center;
        position: relative;
    }

    .book-cover-wrapper img {
        width: 100%;
        max-width: 220px;
        border-radius: 12px;
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
        transition: transform 0.3s ease;
    }

    .book-cover-wrapper img:hover {
        transform: translateY(-5px);
    }

    .book-title-main {
        font-size: 28px;
        font-weight: 700;
        color: #1e293b;
        margin-bottom: 16px;
        letter-spacing: -0.3px;
    }

    .book-meta {
        color: #475569;
        font-size: 15px;
        margin-bottom: 10px;
        display: flex;
        align-items: baseline;
        gap: 8px;
    }

    .book-meta strong {
        color: #64748b;
        font-weight: 500;
        min-width: 70px;
    }

    .book-meta span {
        color: #334155;
    }

    .status-badge {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 6px 16px;
        border-radius: 30px;
        font-size: 13px;
        font-weight: 500;
        background: #10b981;
        color: #ffffff;
    }

    .status-badge::before {
        content: "●";
        font-size: 8px;
    }

    .status-badge.tidak-tersedia {
        background: #ef4444;
    }

    .description-box {
        background: #f8fafc;
        border-radius: 16px;
        padding: 20px;
        height: 100%;
        display: flex;
        flex-direction: column;
    }

    .description-box h5 {
        color: #1e293b;
        font-weight: 600;
        margin-bottom: 12px;
        font-size: 16px;
        display: flex;
        align-items: center;
        gap: 8px;
        flex-shrink: 0;
    }

    .description-box h5::before {
        content: "📖";
        font-size: 14px;
    }

    .description-scroll {
        flex: 1;
        overflow-y: auto;
        max-height: 250px;
        padding-right: 8px;
    }

    .description-scroll::-webkit-scrollbar {
        width: 5px;
    }

    .description-scroll::-webkit-scrollbar-track {
        background: #e2e8f0;
        border-radius: 10px;
    }

    .description-scroll::-webkit-scrollbar-thumb {
        background: #94a3b8;
        border-radius: 10px;
    }

    .description-scroll::-webkit-scrollbar-thumb:hover {
        background: #64748b;
    }

    .description-box p {
        color: #475569;
        font-size: 14px;
        line-height: 1.7;
        text-align: justify;
        margin: 0;
    }

    .info-cards {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 16px;
        margin-top: 32px;
    }

    .info-card {
        background: #f8fafc;
        border-radius: 16px;
        padding: 16px;
        text-align: center;
        transition: all 0.2s ease;
    }

    .info-card:hover {
        background: #f1f5f9;
        transform: translateY(-2px);
    }

    .info-card .label {
        color: #94a3b8;
        font-size: 11px;
        text-transform: uppercase;
        letter-spacing: 0.8px;
        font-weight: 500;
        margin-bottom: 8px;
    }

    .info-card .value {
        color: #1e293b;
        font-weight: 700;
        font-size: 18px;
    }

    .info-card .value.price {
        color: #059669;
        font-size: 16px;
    }

    /* Responsive */
    @media (max-width: 992px) {
        .info-cards {
            grid-template-columns: repeat(3, 1fr);
            gap: 12px;
        }
    }

    @media (max-width: 768px) {
        .book-detail-card {
            padding: 20px;
        }

        .book-title-main {
            font-size: 22px;
            margin-top: 16px;
        }

        .info-cards {
            grid-template-columns: repeat(2, 1fr);
            gap: 12px;
        }

        .description-box {
            margin-top: 20px;
        }

        .description-scroll {
            max-height: 180px;
        }
    }

    @media (max-width: 480px) {
        .info-cards {
            grid-template-columns: 1fr;
        }
    }
</style>

<div class="book-detail-card">
    <div class="row g-4">
        <!-- Cover Section -->
        <div class="col-md-3">
            <div class="book-cover-wrapper">
                @if($book->cover)
                <img src="{{ asset('storage/'.$book->cover) }}" alt="{{ $book->title }}">
                @else
                <div class="bg-light rounded-3 d-flex align-items-center justify-content-center" style="height: 260px;">
                    <i class="ti ti-book-2 fs-1 text-muted"></i>
                </div>
                @endif
            </div>
        </div>

        <!-- Info Section -->
        <div class="col-md-5">
            <h1 class="book-title-main">{{ $book->title }}</h1>

            <div class="book-meta">
                <strong>Author</strong>
                <span>{{ $book->author }}</span>
            </div>

            <div class="book-meta">
                <strong>Publisher</strong>
                <span>{{ $book->publisher }}</span>
            </div>

            <div class="book-meta">
                <strong>Category</strong>
                <span>{{ $book->category->name ?? '-' }}</span>
            </div>

            <div class="book-meta">
                <strong>Genre</strong>
                <span>{{ $book->genres->pluck('name')->implode(', ') ?? '-' }}</span>
            </div>

            <div class="book-meta">
                <strong>ISBN</strong>
                <span>{{ $book->isbn ?? '-' }}</span>
            </div>

            <div class="mt-4">
                <div class="text-muted small mb-2">Status</div>
                <span class="status-badge {{ $book->stock > 0 ? '' : 'tidak-tersedia' }}">
                    {{ $book->stock > 0 ? 'available' : 'not available' }}
                </span>
            </div>
        </div>

        <!-- Description Section dengan Scroll -->
        <div class="col-md-4">
            <div class="description-box">
                <h5>Description</h5>
                <div class="description-scroll">
                    <p>{{ $book->description ?? 'No description available for this book.' }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Info Cards Bottom -->
    <div class="info-cards">
        <div class="info-card">
            <div class="label">Publication Year</div>
            <div class="value">{{ $book->year }}</div>
        </div>
        <div class="info-card">
            <div class="label">Number of Pages</div>
            <div class="value">{{ $book->pages ?? '-' }}</div>
        </div>
        <div class="info-card">
            <div class="label">Available Stock</div>
            <div class="value">{{ $book->stock }}</div>
        </div>
        <div class="info-card">
            <div class="label">Book Price</div>
            <div class="value price">Rp {{ number_format($book->price, 0, ',', '.') }}</div>
        </div>
    </div>
</div>