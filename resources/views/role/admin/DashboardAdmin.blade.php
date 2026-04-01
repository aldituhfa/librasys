@extends('layouts.admin')

@section('content')
<h2>Dashboard Admin</h2>
<p>Selamat datang {{ auth()->user()->name }}</p>
@endsection