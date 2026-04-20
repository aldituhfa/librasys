@extends('layouts.admin')

@section('content')

<div class="container-fluid px-4 py-4">

    {{-- HEADER --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-semibold mb-1">Transaction Report</h4>
            <p class="text-muted small mb-0">Book Transaction Data Report</p>
        </div>
        {{-- HEADER TABLE --}}
        <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap gap-2">

            {{-- EXPORT BUTTON --}}
            <div class="dropdown">
                <button class="btn btn-sm rounded-3 px-3"
                    style="background:#4f46e5; color:white;"
                    data-bs-toggle="dropdown">
                    <i class="ti ti-download me-1"></i> Export
                </button>

                <ul class="dropdown-menu dropdown-menu-end shadow-sm border-0 rounded-3 p-2">

                    <li>
                        <a href="{{ route('admin.report.excel') }}"
                            class="dropdown-item d-flex align-items-center gap-2 rounded-2">
                            <i class="ti ti-file-spreadsheet text-success"></i>
                            Export Excel
                        </a>
                    </li>

                    <li>
                        <a href="{{ route('admin.report.pdf') }}"
                            class="dropdown-item d-flex align-items-center gap-2 rounded-2">
                            <i class="ti ti-file-type-pdf text-danger"></i>
                            Export PDF
                        </a>
                    </li>

                </ul>
            </div>

        </div>
    </div>

    {{-- CONTAINER LUAR --}}
    <div class="p-3 rounded-4" style="background:#f8fafc;">

        {{-- CARD --}}
        <div class="card border-0 rounded-4" style="box-shadow: 0 4px 20px rgba(0,0,0,0.05);">
            <div class="card-body p-4">

                {{-- HEADER TABLE --}}
                <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap gap-2">
                    <h6 class="fw-semibold mb-0">Data Report</h6>
                    <span class="badge rounded-pill px-3 py-2" style="background:#eef2ff; color:#4338ca;">
                        {{ count($transactions) }} Data
                    </span>
                </div>

                {{-- TABLE --}}
                <div class="table-responsive">
                    <table class="table align-middle mb-0 datatable">

                        <thead>
                            <tr style="border-bottom:1px solid #e5e7eb;">
                                <th class="text-muted small">No</th>
                                <th class="text-muted small">Username</th>
                                <th class="text-muted small">Book</th>
                                <th class="text-muted small">Borrow Date</th>
                                <th class="text-muted small">Status</th>
                                <th class="text-muted small">Fine</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach($transactions as $key => $trx)
                            <tr style="border-bottom:1px solid #f1f5f9;">

                                <td class="small text-muted">{{ $key+1 }}</td>

                                {{-- USER --}}
                                <td>
                                    <div class="fw-semibold">{{ $trx->user->name }}</div>
                                </td>

                                {{-- BUKU --}}
                                <td>
                                    <div class="d-flex align-items-center gap-2">
                                        <img src="{{ asset('storage/' . $trx->book->cover) }}"
                                            width="38" height="52"
                                            style="object-fit:cover; border-radius:6px">

                                        <div>
                                            <div class="fw-semibold">
                                                {{ Str::limit($trx->book->title, 35) }}
                                            </div>
                                            <small class="text-muted">
                                                {{ $trx->borrow_date }} → {{ $trx->return_date }}
                                            </small>
                                        </div>
                                    </div>
                                </td>

                                {{-- TANGGAL --}}
                                <td class="small">
                                    {{ \Carbon\Carbon::parse($trx->borrow_date)->format('d M Y') }}
                                </td>

                                {{-- STATUS --}}
                                <td>
                                    @if($trx->status == 'done')
                                    <span class="badge rounded-pill px-3 py-1" style="background:#dcfce7; color:#16a34a;">
                                        finished (Done)
                                    </span>

                                    @elseif($trx->status == 'returned')
                                    <span class="badge rounded-pill px-3 py-1" style="background:#dbeafe; color:#2563eb;">
                                        finished (Returned)
                                    </span>

                                    @elseif($trx->status == 'rejected')
                                    <span class="badge rounded-pill px-3 py-1" style="background:#fee2e2; color:#dc2626;">
                                        rejected
                                    </span>
                                    @endif
                                </td>

                                {{-- DENDA --}}
                                <td>
                                    @if($trx->fine > 0)
                                    <span class="fw-semibold" style="color:#dc2626;">
                                        Rp {{ number_format($trx->fine,0,',','.') }}
                                    </span>
                                    @else
                                    <span class="text-muted small">—</span>
                                    @endif
                                </td>

                            </tr>
                            @endforeach
                        </tbody>

                    </table>
                </div>

            </div>
        </div>
    </div>

</div>

<style>
    /* Search box */
    .dataTables_filter input {
        border-radius: 10px !important;
        padding: 6px 12px;
        border: 1px solid #e5e7eb;
    }

    /* Dropdown length */
    .dataTables_length select {
        border-radius: 10px !important;
        border: 1px solid #e5e7eb;
    }

    /* Pagination */
    .dataTables_paginate .pagination {
        gap: 5px;
    }

    .page-item.active .page-link {
        background-color: #4f46e5 !important;
        border-color: #4f46e5 !important;
    }

    .page-link {
        border-radius: 8px !important;
    }
</style>

@endsection