<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Login - LibraSys</title>
    <link href="https://cdn.jsdelivr.net/npm/@tabler/core@latest/dist/css/tabler.min.css" rel="stylesheet"/>
</head>
<body class=" d-flex flex-column">

<div class="container container-tight py-4">
    <div class="text-center mb-4">
        <h1>LibraSys</h1>
        <p>Sistem Perpustakaan Digital</p>
    </div>

    <form method="POST" action="{{ route('login.process') }}" class="card card-md">
        @csrf

        <div class="card-body">

            @if(session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            @endif

            <div class="mb-3">
                <label class="form-label">Email</label>
                <input type="email" name="email" class="form-control" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Password</label>
                <input type="password" name="password" class="form-control" required>
            </div>

            <div class="form-footer">
                <button type="submit" class="btn btn-primary w-100">
                    Login
                </button>
            </div>

        </div>
    </form>
</div>

</body>
</html>