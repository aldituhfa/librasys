@extends('layouts.user')

@section('content')
<h2>Dashboard User</h2>
<p>Selamat datang {{ auth()->user()->name }}</p>
@endsection