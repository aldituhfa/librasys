<div class="modal fade" id="editBook{{ $book->id }}" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">

            <form action="{{ route('admin.books.update',$book->id) }}" method="POST" enctype="multipart/form-data">

                @csrf
                @method('PUT')

                <div class="modal-header">
                    <h5 class="modal-title">Edit Buku</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">

                    <div class="row mb-2">

                        <div class="col-md-6">
                            <label>Judul Buku</label>
                            <input type="text" name="title" class="form-control"
                                value="{{ $book->title }}" required>
                        </div>

                        <div class="col-md-6">
                            <label>Penulis</label>
                            <input type="text" name="author" class="form-control"
                                value="{{ $book->author }}" required>
                        </div>

                    </div>


                    <div class="row mb-2">

                        <div class="col-md-6">
                            <label>Penerbit</label>
                            <input type="text" name="publisher" class="form-control"
                                value="{{ $book->publisher }}">
                        </div>

                        <div class="col-md-6">
                            <label>Tahun</label>
                            <input type="number" name="year" class="form-control"
                                value="{{ $book->year }}">
                        </div>

                    </div>


                    <div class="row mb-2">

                        <div class="col-md-6">
                            <label>ISBN</label>
                            <input type="text" name="isbn" class="form-control"
                                value="{{ $book->isbn }}">
                        </div>

                        <div class="col-md-6">
                            <label>Halaman</label>
                            <input type="number" name="pages" class="form-control"
                                value="{{ $book->pages }}">
                        </div>

                    </div>


                    <div class="row mb-2">

                        <div class="col-md-4">
                            <label>Stok</label>
                            <input type="number" name="stock" class="form-control"
                                value="{{ $book->stock }}">
                        </div>

                        <div class="col-md-4">
                            <label>Kategori</label>

                            <select name="category_id" class="form-control">

                                @foreach($categories as $category)

                                <option value="{{ $category->id }}"
                                    {{ $book->category_id == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>

                                @endforeach

                            </select>

                        </div>

                        <div class="mb-2">
                            <label>Harga Buku</label>
                            <input type="number" name="price" class="form-control"
                                value="{{ $book->price }}" required>
                        </div>

                        <div class="col-md-4">
                            <label>Cover</label>
                            <input type="file" name="cover" class="form-control">
                        </div>

                    </div>


                    <div class="mb-2">
                        <label>Deskripsi</label>
                        <textarea name="description" class="form-control">{{ $book->description }}</textarea>
                    </div>

                </div>


                <div class="modal-footer">

                    <button class="btn btn-primary">
                        Update Buku
                    </button>

                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        Batal
                    </button>

                </div>

            </form>

        </div>
    </div>
</div>