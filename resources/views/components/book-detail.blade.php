<div class="card">
    <div class="card-body">

        <div class="row">

            <div class="col-md-3">

                @if($book->cover)
                <img src="{{ asset('storage/'.$book->cover) }}" class="img-fluid">
                @else
                <span class="text-muted">No Image</span>
                @endif

            </div>

            <div class="col-md-9">

                <table class="table">

                    <tr>
                        <th>Judul</th>
                        <td>{{ $book->title }}</td>
                    </tr>

                    <tr>
                        <th>Penulis</th>
                        <td>{{ $book->author }}</td>
                    </tr>

                    <tr>
                        <th>Penerbit</th>
                        <td>{{ $book->publisher }}</td>
                    </tr>

                    <tr>
                        <th>Tahun</th>
                        <td>{{ $book->year }}</td>
                    </tr>

                    <tr>
                        <th>ISBN</th>
                        <td>{{ $book->isbn }}</td>
                    </tr>

                    <tr>
                        <th>Halaman</th>
                        <td>{{ $book->pages }}</td>
                    </tr>

                    <tr>
                        <th>Stok</th>
                        <td>{{ $book->stock }}</td>
                    </tr>

                    <tr>
                        <th>Kategori</th>
                        <td>{{ $book->category->name ?? '-' }}</td>
                    </tr>

                    <tr>
                        <th>Deskripsi</th>
                        <td>{{ $book->description }}</td>
                    </tr>

                </table>

            </div>

        </div>

    </div>
</div>