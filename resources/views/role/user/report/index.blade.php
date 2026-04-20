@extends('layouts.user')

@section('content')

<div class="container-fluid px-4 py-4">

    {{-- HEADER --}}
    <div class="mb-4">
        <h4 class="fw-semibold mb-1">Report Peminjaman</h4>
        <p class="text-muted small mb-0">Riwayat peminjaman buku kamu</p>
    </div>

    {{-- CARD --}}
    <div class="card border-0 rounded-4" style="box-shadow:0 4px 20px rgba(0,0,0,0.05);">
        <div class="card-body p-4">

            {{-- TOP BAR --}}
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h6 class="fw-semibold mb-0">Data Report</h6>

                <span class="badge rounded-pill px-3 py-2"
                    style="background:#eef2ff; color:#4338ca;">
                    {{ count($transactions) }} Data
                </span>
            </div>

            {{-- TABLE --}}
            <div class="table-responsive">
                <table id="reportTable" class="table align-middle mb-0">

                    <thead>
                        <tr style="border-bottom:1px solid #e5e7eb;">
                            <th class="small text-muted">No</th>
                            <th class="small text-muted">Buku</th>
                            <th class="small text-muted">Tanggal</th>
                            <th class="small text-muted">Status</th>
                            <th class="small text-muted">Denda</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach($transactions as $key => $trx)
                        <tr style="border-bottom:1px solid #f1f5f9;">

                            {{-- NO --}}
                            <td class="small text-muted">{{ $key+1 }}</td>

                            {{-- BUKU --}}
                            <td>
                                <div class="d-flex align-items-center gap-3">
                                    <img src="{{ asset('storage/' . $trx->book->cover) }}"
                                        width="42" height="60"
                                        style="object-fit:cover; border-radius:8px;">

                                    <div>
                                        <div class="fw-semibold">
                                            {{ Str::limit($trx->book->title, 40) }}
                                        </div>
                                        <small class="text-muted">
                                            {{ \Carbon\Carbon::parse($trx->borrow_date)->format('d M Y') }}
                                            →
                                            {{ \Carbon\Carbon::parse($trx->return_date)->format('d M Y') }}
                                        </small>
                                    </div>
                                </div>
                            </td>

                            {{-- TANGGAL (SINGKAT) --}}
                            <td class="small">
                                {{ \Carbon\Carbon::parse($trx->borrow_date)->format('d M Y') }}
                            </td>

                            {{-- STATUS --}}
                            <td>
                                @if($trx->status == 'done')
                                <span class="badge rounded-pill px-3 py-1"
                                    style="background:#dcfce7; color:#16a34a;">
                                    Selesai (Lunas)
                                </span>

                                @elseif($trx->status == 'returned')
                                <span class="badge rounded-pill px-3 py-1"
                                    style="background:#dbeafe; color:#2563eb;">
                                    Selesai
                                </span>

                                @elseif($trx->status == 'rejected')
                                <span class="badge rounded-pill px-3 py-1"
                                    style="background:#fee2e2; color:#dc2626;">
                                    Ditolak
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

{{-- STYLE DATATABLE --}}
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

    /* Table hover */
    table tbody tr:hover {
        background-color: #f8fafc;
        transition: 0.2s;
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

{{-- SCRIPT --}}
<script>
    $(document).ready(function() {
        $('#reportTable').DataTable({
            pageLength: 5,
            language: {
                search: "Cari:",
                lengthMenu: "Tampilkan _MENU_ data",
                info: "Menampilkan _START_ - _END_ dari _TOTAL_ data",
                paginate: {
                    previous: "‹",
                    next: "›"
                }
            }
        });
    });
</script>

@endsection