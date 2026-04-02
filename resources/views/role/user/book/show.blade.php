@extends('layouts.user')

@section('content')

<h2 class="mb-3">Detail Buku</h2>

{{-- ALERT SUCCESS --}}
@if(session('success'))
<div class="alert alert-success alert-dismissible fade show">
    {{ session('success') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
@endif

{{-- ALERT ERROR --}}
@if(session('error'))
<div class="alert alert-danger alert-dismissible fade show">
    {{ session('error') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
@endif

@include('components.book-detail')

<div class="mt-4 d-flex gap-2">

    <a href="{{ route('user.books') }}" class="btn btn-secondary">
        Kembali
    </a>

    @if($book->stock > 0)
    <button class="btn btn-primary"
        data-bs-toggle="modal"
        data-bs-target="#borrowModal{{ $book->id }}">
        <i class="ti ti-book-2"></i> Pinjam Buku
    </button>
    @else
    <span class="badge bg-danger">Buku tidak tersedia</span>
    @endif

</div>

{{-- INCLUDE MODAL --}}
@include('role.user.transaction.borrow-modal', ['book' => $book])

@endsection