@extends('layouts.admin')

@section('content')

<style>
    /* Custom Styling */
    .btn-back {
        background-color: #f1f5f9;
        border: 1px solid #e2e8f0;
        color: #475569;
        padding: 10px 24px;
        border-radius: 12px;
        font-weight: 500;
        transition: all 0.2s ease;
    }

    .btn-back:hover {
        background-color: #e2e8f0;
        border-color: #cbd5e1;
        color: #1e293b;
        transform: translateX(-2px);
    }

    .btn-borrow {
        background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
        border: none;
        color: white;
        padding: 10px 28px;
        border-radius: 12px;
        font-weight: 600;
        transition: all 0.2s ease;
        box-shadow: 0 2px 8px rgba(59, 130, 246, 0.3);
    }

    .btn-borrow:hover {
        background: linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%);
        transform: translateY(-2px);
        box-shadow: 0 6px 16px rgba(59, 130, 246, 0.4);
    }

    .btn-borrow:active {
        transform: translateY(0);
    }

    .badge-unavailable {
        background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
        padding: 10px 24px;
        border-radius: 12px;
        font-weight: 600;
        font-size: 14px;
        box-shadow: 0 2px 8px rgba(239, 68, 68, 0.3);
    }

    /* Alert Styling */
    .alert-custom {
        border: none;
        border-radius: 16px;
        padding: 16px 20px;
        margin-bottom: 24px;
        animation: slideDown 0.3s ease;
    }

    @keyframes slideDown {
        from {
            opacity: 0;
            transform: translateY(-10px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .alert-success-custom {
        background: linear-gradient(135deg, #10b981 0%, #059669 100%);
        color: white;
    }

    .alert-danger-custom {
        background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
        color: white;
    }

    .alert-custom .btn-close {
        filter: brightness(0) invert(1);
    }

    /* Header Section */
    .detail-header {
        background: white;
        border-radius: 20px;
        padding: 20px 24px;
        margin-bottom: 24px;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
        border: 1px solid #e9ecef;
    }

    /* Responsive */
    @media (max-width: 768px) {

        .btn-back,
        .btn-borrow,
        .badge-unavailable {
            width: 100%;
            text-align: center;
            justify-content: center;
        }

        .detail-header {
            padding: 16px;
        }
    }
</style>

<div class="container-fluid px-4 py-4">

    {{-- Header dengan icon dan tombol --}}
    <div class="detail-header">
        <div class="d-flex flex-wrap justify-content-between align-items-center gap-3">
            <div class="d-flex align-items-center gap-3">
                <div class="bg-primary bg-opacity-10 rounded-3 p-3">
                    <i class="ti ti-book-2 fs-4 text-primary"></i>
                </div>
                <div>
                    <h2 class="fw-bold mb-1" style="color: #1e293b;">Book Details</h2>
                    <p class="text-muted small mb-0">View Complete Book Information</p>
                </div>
            </div>

            <div class="d-flex flex-wrap gap-3">
                {{-- Tombol Kembali --}}
                <a href="{{ route('admin.books') }}" class="btn-back text-decoration-none d-inline-flex align-items-center gap-2">
                    <i class="ti ti-chevron-left"></i>
                    Back
                </a>
            </div>
        </div>
    </div>

    {{-- Book Detail Component --}}
    @include('components.book-detail')

</div>

@endsection