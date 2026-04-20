@extends('layouts.user')

@section('content')

<style>
    /* Custom styling untuk tabel */
    .dataTables_wrapper .dataTables_length,
    .dataTables_wrapper .dataTables_filter,
    .dataTables_wrapper .dataTables_info,
    .dataTables_wrapper .dataTables_paginate {
        padding: 0.75rem 1.25rem;
    }

    .dataTables_wrapper .dataTables_filter input {
        border: 1px solid #e2e8f0;
        border-radius: 10px;
        padding: 8px 16px;
        margin-left: 8px;
        outline: none;
        transition: all 0.2s;
        background-color: #ffffff;
    }

    .dataTables_wrapper .dataTables_filter input:focus {
        border-color: #3b82f6;
        box-shadow: 0 0 0 2px rgba(59, 130, 246, 0.1);
    }

    .dataTables_wrapper .dataTables_length select {
        border: 1px solid #e2e8f0;
        border-radius: 10px;
        padding: 6px 12px;
        margin: 0 4px;
        background-color: #ffffff;
    }

    .dataTables_wrapper .dataTables_paginate .paginate_button {
        border-radius: 8px !important;
        padding: 6px 12px !important;
        margin: 0 2px !important;
        border: 1px solid #e2e8f0 !important;
        background: #ffffff !important;
        color: #475569 !important;
    }

    .dataTables_wrapper .dataTables_paginate .paginate_button.current {
        background: #3b82f6 !important;
        border-color: #3b82f6 !important;
        color: #ffffff !important;
    }

    .dataTables_wrapper .dataTables_paginate .paginate_button:hover {
        background: #f8fafc !important;
        border-color: #cbd5e1 !important;
        color: #1e293b !important;
    }

    .dataTables_wrapper .dataTables_info {
        color: #64748b;
        font-size: 13px;
    }
</style>

<div class="container-fluid px-4 py-4">

    {{-- HEADER --}}
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">
        <div>
            <div class="d-flex align-items-center gap-3">
                <div>
                    <h4 class="fw-bold mb-1" style="color: #1e293b;">Riwayat Peminjaman</h4>
                    <p class="text-muted small mb-0">Lihat semua aktivitas peminjaman buku Anda</p>
                </div>
            </div>
        </div>
        <div>
            <span class="badge bg-light text-dark rounded-pill px-3 py-2">
                <i class="ti ti-chart-bar me-1"></i>
                Total: {{ $transactions->count() }} Transaksi
            </span>
        </div>
    </div>

    @php
    // semua transaksi yang punya denda
    $fineTransactions = $transactions->filter(function($trx){
    return $trx->fine > 0;
    });

    $totalUserFine = $fineTransactions->sum('fine');
    @endphp

    {{-- ALERT DENDA --}}
    @if($fineTransactions->count() > 0)
    <div class="alert border-0 rounded-3 mb-3 py-3" style="background: linear-gradient(135deg, #fff7ed, #ffedd5); color: #9a3412;">
        <div class="d-flex align-items-start gap-3">

            <div class="rounded-circle p-2" style="background-color: #fed7aa;">
                <i class="ti ti-coin fs-5" style="color: #ea580c;"></i>
            </div>

            <div style="flex:1;">
                <div class="fw-semibold mb-1">
                    Anda memiliki denda yang belum dibayar
                </div>

                <div class="small mb-2">
                    Total denda:
                    <span class="fw-bold" style="color:#dc2626;">
                        Rp {{ number_format($totalUserFine,0,',','.') }}
                    </span>
                    dari {{ $fineTransactions->count() }} transaksi.
                </div>

                <div class="small text-muted mb-2">
                    Denda bisa disebabkan karena keterlambatan, kerusakan, atau kehilangan buku.
                    Segera lakukan pembayaran ke admin untuk menyelesaikan transaksi.
                </div>

                {{-- DETAIL LIST --}}
                <div class="small">
                    <ul class="mb-0 ps-3">
                        @foreach($fineTransactions->take(3) as $trx)
                        <li>
                            {{ Str::limit($trx->book->title, 30) }} →
                            <span style="color:#dc2626;">
                                Rp {{ number_format($trx->fine,0,',','.') }}
                            </span>
                        </li>
                        @endforeach

                        @if($fineTransactions->count() > 3)
                        <li class="text-muted">
                            dan {{ $fineTransactions->count() - 3 }} lainnya...
                        </li>
                        @endif
                    </ul>
                </div>

            </div>

        </div>
    </div>
    @endif

    @php
    $activeLoans = $transactions->where('status', 'approved');
    $lateLoans = $transactions->where('status', 'approved')->filter(function($trx){
    return now()->gt($trx->return_date);
    });
    @endphp

    {{-- ALERT TERLAMBAT --}}
    @if($lateLoans->count() > 0)
    <div class="alert border-0 rounded-3 mb-3 py-3" style="background-color: #fef2f2; color: #991b1b;">
        <div class="d-flex align-items-center gap-3">
            <div class="rounded-circle p-2" style="background-color: #fecaca;">
                <i class="ti ti-alert-triangle fs-5" style="color: #dc2626;"></i>
            </div>
            <div>
                <strong class="fw-semibold">Peringatan!</strong>
                <span class="small">Kamu memiliki {{ $lateLoans->count() }} buku yang sudah terlambat dikembalikan. Segera kembalikan untuk menghindari denda.</span>
            </div>
        </div>
    </div>
    @endif

    {{-- ALERT MASIH PINJAM --}}
    @if($activeLoans->count() > 0 && $lateLoans->count() == 0)
    <div class="alert border-0 rounded-3 mb-3 py-3" style="background-color: #fffbeb; color: #92400e;">
        <div class="d-flex align-items-center gap-3">
            <div class="rounded-circle p-2" style="background-color: #fde68a;">
                <i class="ti ti-info-circle fs-5" style="color: #d97706;"></i>
            </div>
            <div>
                <span class="small">Jangan lupa mengembalikan buku yang sedang kamu pinjam ya.</span>
            </div>
        </div>
    </div>
    @endif

    {{-- CARD TABEL --}}
    <div class="card border-0 rounded-4 shadow-sm overflow-hidden">
        <div class="card-header bg-white border-0 pt-4 px-4 pb-0">
            <div class="d-flex align-items-center gap-2">
                <i class="ti ti-table text-primary"></i>
                <h6 class="fw-semibold mb-0" style="color: #1e293b;">Daftar Peminjaman</h6>
            </div>
        </div>

        <div class="card-body p-4 pt-3">
            <div class="table-responsive">
                <table id="historyTable" class="table align-middle mb-0" style="width:100%">
                    <thead>
                        <tr style="border-bottom: 1px solid #e9ecef;">
                            <th class="py-3 text-muted fw-semibold small" style="width: 50px;">No</th>
                            <th class="py-3 text-muted fw-semibold small">Buku</th>
                            <th class="py-3 text-muted fw-semibold small">Tanggal Pinjam</th>
                            <th class="py-3 text-muted fw-semibold small">Tanggal Kembali</th>
                            <th class="py-3 text-muted fw-semibold small">Status</th>
                            <th class="py-3 text-muted fw-semibold small">Denda</th>
                            <th class="py-3 text-muted fw-semibold small text-center" style="width: 120px;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($transactions as $key => $trx)
                        <tr style="border-bottom: 1px solid #f8f9fa;">
                            <td class="py-3">
                                <span class="text-muted small">{{ $key+1 }}</span>
                            </td>

                            {{-- BUKU --}}
                            <td class="py-3">
                                <div class="d-flex align-items-center gap-3">
                                    <img src="{{ asset('storage/' . $trx->book->cover) }}"
                                        width="42" height="56"
                                        class="rounded-2 shadow-sm"
                                        style="object-fit: cover;"
                                        onerror="this.src='https://placehold.co/42x56?text=📖'">
                                    <div>
                                        <div class="fw-medium" style="color: #1e293b;">{{ Str::limit($trx->book->title, 40) }}</div>
                                        <small class="text-muted">{{ $trx->book->author ?? 'Unknown Author' }}</small>
                                    </div>
                                </div>
                            </td>

                            {{-- TANGGAL PINJAM --}}
                            <td class="py-3">
                                <span class="small">{{ \Carbon\Carbon::parse($trx->borrow_date)->translatedFormat('d F Y') }}</span>
                            </td>

                            {{-- TANGGAL KEMBALI --}}
                            <td class="py-3">
                                <span class="small {{ now()->gt($trx->return_date) && $trx->status == 'approved' ? 'text-danger fw-semibold' : '' }}">
                                    {{ \Carbon\Carbon::parse($trx->return_date)->translatedFormat('d F Y') }}
                                </span>
                                @if(now()->gt($trx->return_date) && $trx->status == 'approved')
                                <div class="text-danger" style="font-size: 0.65rem;">Terlambat</div>
                                @endif
                            </td>

                            {{-- STATUS --}}
                            <td class="py-3">
                                @php
                                $statusConfig = [
                                'pending' => ['class' => 'bg-warning bg-opacity-10 text-warning', 'label' => 'Pending'],
                                'approved' => ['class' => 'bg-success bg-opacity-10 text-success', 'label' => 'Dipinjam'],
                                'return_pending' => ['class' => 'bg-warning bg-opacity-10 text-warning', 'label' => 'Menunggu Pembayaran'],
                                'done' => ['class' => 'bg-success bg-opacity-10 text-success', 'label' => 'Selesai (Lunas)'],
                                'returned' => ['class' => 'bg-info bg-opacity-10 text-info', 'label' => 'Selesai'],
                                'rejected' => ['class' => 'bg-danger bg-opacity-10 text-danger', 'label' => 'Ditolak'],
                                ];

                                $currentStatus = $trx->status;
                                if ($currentStatus == 'approved' && now()->gt($trx->return_date)) {
                                $currentStatus = 'overdue';
                                $statusConfig['overdue'] = ['class' => 'bg-danger bg-opacity-10 text-danger', 'label' => 'Terlambat'];
                                }
                                $status = $statusConfig[$currentStatus] ?? ['class' => 'bg-secondary bg-opacity-10 text-secondary', 'label' => ucfirst($trx->status)];
                                @endphp
                                <span class="badge py-2 px-3 rounded-pill {{ $status['class'] }}" style="font-weight: 500; font-size: 0.7rem;">
                                    {{ $status['label'] }}
                                </span>
                            </td>

                            {{-- DENDA --}}
                            <td class="py-3">
                                @if($trx->fine > 0)
                                <span class="fw-semibold" style="color: #dc2626;">
                                    Rp {{ number_format($trx->fine, 0, ',', '.') }}
                                </span>
                                @else
                                <span class="text-muted small">—</span>
                                @endif
                            </td>

                            {{-- AKSI --}}
                            <td class="py-3 text-center">
                                @if($trx->status == 'approved')
                                <button class="btn btn-sm rounded-pill px-3 py-1"
                                    style="background-color: #fef3c7; color: #b45309; border: none; font-size: 0.75rem;"
                                    data-bs-toggle="modal"
                                    data-bs-target="#returnModal{{ $trx->id }}">
                                    Kembalikan
                                </button>
                                @include('role.user.transaction.modal-return')
                                @elseif($trx->status == 'return_pending')
                                <span class="small" style="color: #b45309;">
                                    Silakan bayar ke admin
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

<script>
    $(document).ready(function() {
        $('#historyTable').DataTable({
            responsive: true,
            language: {
                url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/id.json',
                search: "Cari:",
                searchPlaceholder: "Cari peminjaman...",
                lengthMenu: "Tampilkan _MENU_",
                info: "Menampilkan _START_ - _END_ dari _TOTAL_ transaksi",
                infoEmpty: "Tidak ada data",
                zeroRecords: "Data tidak ditemukan",
                paginate: {
                    first: "«",
                    last: "»",
                    next: "→",
                    previous: "←"
                }
            },
            columnDefs: [{
                    className: "text-center",
                    targets: [0, 6]
                },
                {
                    orderable: false,
                    targets: [6]
                }
            ],
            order: [
                [2, 'desc']
            ],
            pageLength: 10,
            dom: '<"d-flex justify-content-between align-items-center mb-3 flex-wrap"<"dt-length"l><"dt-search"f>>rt<"d-flex justify-content-between align-items-center mt-3 flex-wrap"<"dt-info"i><"dt-pagination"p>>'
        });
    });
</script>

@endsection