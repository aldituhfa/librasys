@extends('layouts.admin')

@section('content')

<h2 class="mb-3">Detail Buku</h2>

@include('components.book-detail')

<a href="{{ route('admin.books') }}" class="btn btn-secondary mt-3">
    Kembali
</a>

@endsection