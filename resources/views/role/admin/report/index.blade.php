@extends('layouts.admin')

@section('content')

<div class="container-fluid px-4 py-4">

    {{-- HEADER --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-semibold mb-1">Transaction Report</h4>
            <p class="text-muted small mb-0">Book Transaction Data Report</p>
        </div>
    </div>

    {{-- CONTAINER LUAR --}}
    <div class="p-3 rounded-4" style="background:#f8fafc;">

        {{-- CARD --}}
        <div class="card border-0 rounded-4" style="box-shadow: 0 4px 20px rgba(0,0,0,0.05);">
            <div class="card-body p-4">

                {{-- FILTER & EXPORT SECTION --}}
                <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-3">
                    {{-- Filter Status --}}
                    <div class="d-flex align-items-center gap-2">
                        <select id="statusFilter" class="form-select form-select-sm rounded-3" style="width: auto; min-width: 150px; border: 1px solid #e5e7eb; padding: 5px 10px; font-size: 0.8rem;">
                            <option value="all">All Status</option>
                            <option value="done">Done</option>
                            <option value="returned">Returned</option>
                            <option value="rejected">Rejected</option>
                        </select>
                        <button id="resetFilter" class="btn btn-sm btn-light rounded-3" style="padding: 5px 12px; font-size: 0.8rem; border: 1px solid #e5e7eb;">
                            <i class="ti ti-refresh me-1"></i> Reset
                        </button>
                    </div>

                    {{-- Export Button --}}
                    <div class="dropdown">
                        <button class="btn btn-sm rounded-3 px-3" style="background:#4f46e5; color:white; padding: 5px 15px; font-size: 0.8rem;" data-bs-toggle="dropdown">
                            <i class="ti ti-download me-1"></i> Export
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end shadow-sm border-0 rounded-3 p-2">
                            <li>
                                <a id="exportExcel" href="{{ route('admin.report.excel') }}" class="dropdown-item d-flex align-items-center gap-2 rounded-2">
                                    <i class="ti ti-file-spreadsheet text-success"></i>
                                    Export Excel
                                </a>
                            </li>
                            <li>
                                <a id="exportPDF" href="{{ route('admin.report.pdf') }}" class="dropdown-item d-flex align-items-center gap-2 rounded-2">
                                    <i class="ti ti-file-type-pdf text-danger"></i>
                                    Export PDF
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>

                {{-- TABLE --}}
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0" id="transactionTable" style="width: 100%;">
                        <thead>
                            <tr style="background-color: #f8fafc; border-bottom: 2px solid #e2e8f0;">
                                <th style="width: 5%;" class="text-muted small fw-semibold">No</th>
                                <th style="width: 15%;" class="text-muted small fw-semibold">Username</th>
                                <th style="width: 35%;" class="text-muted small fw-semibold">Book</th>
                                <th style="width: 15%;" class="text-muted small fw-semibold">Borrow Date</th>
                                <th style="width: 15%;" class="text-muted small fw-semibold">Status</th>
                                <th style="width: 15%;" class="text-muted small fw-semibold">Fine</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($transactions as $key => $trx)
                            <tr data-status="{{ $trx->status }}" style="border-bottom: 1px solid #f1f5f9;">
                                <td class="small text-muted">{{ $key+1 }}</td>
                                <td>
                                    <div class="fw-semibold" style="font-size: 0.85rem;">{{ $trx->user->name }}</div>
                                    <small class="text-muted" style="font-size: 0.7rem;">{{ $trx->user->email ?? '-' }}</small>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center gap-2">
                                        <img src="{{ asset('storage/' . $trx->book->cover) }}"
                                            width="32" height="44"
                                            style="object-fit:cover; border-radius:4px;"
                                            onerror="this.src='https://placehold.co/32x44?text=📖'">
                                        <div>
                                            <div class="fw-semibold" style="font-size: 0.85rem;">
                                                {{ Str::limit($trx->book->title, 40) }}
                                            </div>
                                            <small class="text-muted" style="font-size: 0.7rem;">
                                                {{ $trx->borrow_date }} → {{ $trx->return_date }}
                                            </small>
                                        </div>
                                    </div>
                                </td>
                                <td class="small" style="font-size: 0.8rem;">
                                    {{ \Carbon\Carbon::parse($trx->borrow_date)->format('d/m/Y') }}
                                </td>
                                <td>
                                    @if($trx->status == 'done')
                                    <span class="badge rounded-pill px-2 py-1" style="background:#dcfce7; color:#16a34a; font-size: 0.7rem;">
                                        Done
                                    </span>
                                    @elseif($trx->status == 'returned')
                                    <span class="badge rounded-pill px-2 py-1" style="background:#dbeafe; color:#2563eb; font-size: 0.7rem;">
                                        Returned
                                    </span>
                                    @elseif($trx->status == 'rejected')
                                    <span class="badge rounded-pill px-2 py-1" style="background:#fee2e2; color:#dc2626; font-size: 0.7rem;">
                                        Rejected
                                    </span>
                                    @elseif($trx->status == 'pending')
                                    <span class="badge rounded-pill px-2 py-1" style="background:#fef3c7; color:#d97706; font-size: 0.7rem;">
                                        Pending
                                    </span>
                                    @elseif($trx->status == 'approved')
                                    <span class="badge rounded-pill px-2 py-1" style="background:#dbeafe; color:#2563eb; font-size: 0.7rem;">
                                        Borrowed
                                    </span>
                                    @elseif($trx->status == 'late')
                                    <span class="badge rounded-pill px-2 py-1" style="background:#fee2e2; color:#dc2626; font-size: 0.7rem;">
                                        Late
                                    </span>
                                    @else
                                    <span class="badge rounded-pill px-2 py-1" style="background:#e5e7eb; color:#6b7280; font-size: 0.7rem;">
                                        {{ $trx->status }}
                                    </span>
                                    @endif
                                </td>
                                <td>
                                    @if($trx->fine > 0)
                                    <span class="fw-semibold" style="color:#dc2626; font-size: 0.8rem;">
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
    /* DataTables Styling */
    .dataTables_wrapper .dataTables_length,
    .dataTables_wrapper .dataTables_filter {
        margin-bottom: 1rem;
    }

    .dataTables_filter input {
        border-radius: 8px !important;
        padding: 6px 12px;
        border: 1px solid #e2e8f0;
        font-size: 0.8rem;
    }

    .dataTables_length select {
        border-radius: 8px !important;
        border: 1px solid #e2e8f0;
        padding: 4px 8px;
        font-size: 0.8rem;
    }

    .dataTables_info {
        font-size: 0.8rem;
        color: #64748b;
        padding-top: 1rem !important;
    }

    .dataTables_paginate {
        padding-top: 1rem !important;
    }

    .dataTables_paginate .pagination {
        gap: 5px;
        margin: 0;
    }

    .page-item.active .page-link {
        background-color: #4f46e5 !important;
        border-color: #4f46e5 !important;
        color: white !important;
    }

    .page-link {
        border-radius: 6px !important;
        padding: 6px 12px;
        font-size: 0.8rem;
        color: #475569;
        border: 1px solid #e2e8f0;
    }

    .page-link:hover {
        background-color: #f1f5f9;
        color: #4f46e5;
    }

    #statusFilter {
        border: 1px solid #e2e8f0;
        padding: 5px 10px;
        font-size: 0.8rem;
        border-radius: 8px;
        background-color: white;
    }

    #statusFilter:focus {
        border-color: #4f46e5;
        box-shadow: 0 0 0 2px rgba(79, 70, 229, 0.1);
        outline: none;
    }

    .btn-light {
        background-color: #f8fafc;
        transition: all 0.2s ease;
        border: 1px solid #e2e8f0;
    }

    .btn-light:hover {
        background-color: #f1f5f9;
        border-color: #cbd5e1;
    }

    /* Table styling */
    .table {
        border-collapse: collapse;
    }

    .table tbody tr:hover {
        background-color: #f8fafc !important;
        transition: all 0.2s ease;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .table-responsive {
            overflow-x: auto;
        }

        .table td,
        .table th {
            white-space: nowrap;
        }
    }
</style>

@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        var table = $('#transactionTable');

        // Hancurkan DataTable jika sudah ada
        if ($.fn.dataTable.isDataTable('#transactionTable')) {
            $('#transactionTable').DataTable().destroy();
            table.removeClass('datatable');
        } else {
            table.removeClass('datatable');
        }

        // Inisialisasi DataTable
        var dataTable = table.DataTable({
            responsive: true,
            autoWidth: false,
            pageLength: 10,
            lengthMenu: [10, 25, 50, 100],
            language: {
                url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/id.json',
                search: "_INPUT_",
                searchPlaceholder: "Cari data...",
                lengthMenu: "Tampilkan _MENU_ data",
                info: "Menampilkan _START_ - _END_ dari _TOTAL_ data",
                zeroRecords: "Data tidak ditemukan",
                infoEmpty: "Tidak ada data",
                infoFiltered: "(difilter dari _MAX_ total data)"
            },
            dom: "<'row'<'col-sm-12 col-md-6'l><'col-sm-12 col-md-6'f>>" +
                "<'row'<'col-sm-12'tr>>" +
                "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
            columnDefs: [{
                targets: [0, 5],
                orderable: false
            }],
            order: [
                [3, 'desc']
            ] // Urutkan berdasarkan borrow date terbaru
        });

        // Fungsi filter menggunakan DataTables API
        function filterByStatus() {
            var selectedStatus = $('#statusFilter').val();

            $.fn.dataTable.ext.search.push(
                function(settings, data, dataIndex) {
                    var row = dataTable.row(dataIndex).node();
                    var rowStatus = $(row).attr('data-status');

                    if (selectedStatus === 'all') {
                        return true;
                    }
                    return rowStatus === selectedStatus;
                }
            );

            dataTable.draw();
            $.fn.dataTable.ext.search.pop();
        }

        // Event listener untuk filter status
        $('#statusFilter').on('change', function() {
            filterByStatus();
            updateExportLink();
        });

        // Reset filter
        $('#resetFilter').on('click', function() {
            $('#statusFilter').val('all').trigger('change');
        });

        // Inisialisasi filter pertama kali
        filterByStatus();

        // Fungsi update export link
        function updateExportLink() {
            let status = $('#statusFilter').val();
            let excelUrl = "{{ route('admin.report.excel') }}?status=" + status;
            let pdfUrl = "{{ route('admin.report.pdf') }}?status=" + status;

            $('#exportExcel').attr('href', excelUrl);
            $('#exportPDF').attr('href', pdfUrl);
        }

        // Inisialisasi export link pertama kali
        updateExportLink();
    });
</script>
@endpush