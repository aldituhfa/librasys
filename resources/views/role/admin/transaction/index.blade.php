@extends('layouts.admin')

@section('content')

<div class="container-fluid px-4 py-4">

    {{-- HEADER --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-semibold mb-1">Manage Book Transactions</h4>
            <p class="text-muted small mb-0">Manage library book borrowing data</p>
        </div>
        <div class="text-muted small">
            <i class="ti ti-calendar me-1"></i> {{ now()->format('d F Y') }}
        </div>
    </div>

    {{-- ALERT --}}
    @if(session('success'))
    <div class="alert border-0 rounded-3 mb-4 py-2 px-3" style="background:#e8f5e9;">
        {{ session('success') }}
    </div>
    @endif

    @if(session('error'))
    <div class="alert border-0 rounded-3 mb-4 py-2 px-3" style="background:#ffebee;">
        {{ session('error') }}
    </div>
    @endif

    {{-- CONTAINER BELAKANG (LAYER 1) --}}
    <div class="p-3 rounded-4" style="background:#f8fafc;">

        {{-- CARD UTAMA (LAYER 2) --}}
        <div class="card border-0 rounded-4" style="box-shadow: 0 4px 20px rgba(0,0,0,0.05);">
            <div class="card-body p-4">

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
                                <th class="text-muted small">Payment</th>
                                <th class="text-muted small text-end">Actions</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach($transactions as $key => $trx)
                            <tr style="border-bottom:1px solid #f1f5f9;">

                                <td class="small text-muted">{{ $key+1 }}</td>

                                {{-- USER --}}
                                <td>
                                    <div class="fw-semibold">{{ $trx->user->name }}</div>
                                    <small class="text-muted">{{ $trx->user->email }}</small>
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
                                    @php
                                    $isLate = now()->gt($trx->return_date) && $trx->status == 'approved';
                                    @endphp

                                    @if($trx->status == 'pending')
                                    <span class="badge rounded-pill px-3 py-1" style="background:#fef3c7; color:#d97706;">Pending</span>

                                    @elseif($trx->status == 'approved' && !$isLate)
                                    <span class="badge rounded-pill px-3 py-1" style="background:#dcfce7; color:#16a34a;">Borrowed</span>

                                    @elseif($isLate)
                                    <span class="badge rounded-pill px-3 py-1" style="background:#fee2e2; color:#dc2626;">Late</span>

                                    @elseif($trx->status == 'returned')
                                    <span class="badge rounded-pill px-3 py-1" style="background:#dbeafe; color:#2563eb;">Finished</span>

                                    @elseif($trx->status == 'done')
                                    <span class="badge rounded-pill px-3 py-1" style="background:#dcfce7; color:#16a34a;">Done</span>

                                    @elseif($trx->status == 'rejected')
                                    <span class="badge rounded-pill px-3 py-1" style="background:#fee2e2; color:#dc2626;">Rejected</span>
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

                                {{-- BAYAR --}}
                                <td>
                                    @if($trx->fine > 0)
                                    @if($trx->is_paid)
                                    <span class="badge rounded-pill px-2 py-1" style="background:#dcfce7; color:#16a34a;">Paid</span>
                                    @else
                                    <span class="badge rounded-pill px-2 py-1" style="background:#fef3c7; color:#d97706;">Unpaid</span>
                                    @endif
                                    @else
                                    <span class="text-muted small">—</span>
                                    @endif
                                </td>

                                {{-- AKSI --}}
                                <td class="text-end">
                                    <div class="d-flex justify-content-end gap-2 flex-wrap">

                                        @if($trx->status == 'pending')
                                        <form action="{{ route('admin.transactions.approve',$trx->id) }}" method="POST">
                                            @csrf
                                            <button class="btn btn-sm rounded-3"
                                                style="background:#dcfce7; color:#16a34a;">
                                                Approve
                                            </button>
                                        </form>

                                        <form action="{{ route('admin.transactions.reject',$trx->id) }}" method="POST">
                                            @csrf
                                            <button class="btn btn-sm rounded-3"
                                                style="background:#fee2e2; color:#dc2626;">
                                                Reject
                                            </button>
                                        </form>
                                        @endif

                                        @if($trx->fine > 0 && !$trx->is_paid)
                                        <form action="{{ route('admin.transactions.confirm',$trx->id) }}" method="POST">
                                            @csrf
                                            <button class="btn btn-sm rounded-3"
                                                style="background:#dbeafe; color:#2563eb;">
                                                Confirm Payment
                                            </button>
                                        </form>
                                        @endif

                                    </div>
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

@endsection