@extends('documents.layouts.template')
@section('container')
    
    @include('documents.components.navbar')
        <div class="p-1 my-container active-cont">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 border-bottom">
                <h1 class="h4 p-2">Surat Kesepakatan Pembatalan Transaksi</h1>
            </div>
            
            <div class="containers p-2">
                <a class="btn btn-warning" href="{{ asset('template/surat_kesepakatan_pembatalan_transaksi.pdf') }}" download="Surat Kesepakatan Pembatalan Transaksi.pdf">Template</a>

                <div class="card border border-success mt-3">
                    <div class="card-header bg-success">
                        <span>Upload Document</span>
                    </div>
                    <div class="card-body">
                        <div class="update-foto w-50">
                    
                            <form action="{{ url('pembatalan_transaksi/upload/surat_pembatalan_transaksi') }}" method="post" id="update_document" class="p-2 mr-3" enctype='multipart/form-data'>
                                @csrf
                                <div class="mb-1">
                                    <input class="form-control" name="document" type="file" id="formFile" accept=".pdf" required>
                                    
                                    <span class="error_document text-danger p-2 mb-1"></span>
                                </div>

                                <img id="pdfPreview" src="#" alt="Preview PDF" class="mb-2" style="max-width: 100%; display: none;" width="100">
                                <p id="filename" style="display: none;"></p>

                                @if (Session::has('type_invalid'))
                                    <p class="text-danger fw-bold">{{Session::get('type_invalid')}}</p>
                                @elseif (Session::has('size_invalid'))
                                    <p class="text-danger fw-bold">{{Session::get('size_invalid')}}</p>
                                @endif

                                <button type="submit" class="btn btn-primary mb-2">Upload</button>
                                <br>
                                <span>* file harus PDF</span><br>
                                <span>* max ukuran upload 300 KB</span>
                            </form>
                            
                            @if (Session::has('update_document_success'))
                                <p class="text-success fw-bold mt-2">{{ Session::get('update_document_success') }}</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <div class="table-responsive mb-4 p-2">
                <div id="w0-container" class="table-responsive kv-grid-container">
                    @if (Session::has('delete_document_success'))
                        <p class="text-danger fw-bold">{{Session::get('delete_document_success')}}</p>
                    @elseif (Session::has('restore_document_success'))
                        <p class="text-success fw-bold">{{Session::get('restore_document_success')}}</p>
                    @endif

                    @if (sizeof($getdata) > 0)
                        <div class="d-flex">
                            <table class="table text-nowrap mt-2 table-striped table-bordered mb-0 kv-grid-table kv-table-wrap w-50 border border-dark">
                                <thead>
                                    <tr>
                                        <td>No</td>
                                        <td data-col-seq="1">Kode Transaksi</td>
                                        <td data-col-seq="2">Nama Document</td>
                                        <td data-col-seq="3">Tanggal Dibuat</td>
                                        <td data-col-seq="3">Action</td>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php ($count = 0)
                                    @foreach ($getdata as $get)
                                        @php ($count++)
                                        <tr>
                                            <td>{{$count}}</td>
                                            <td>{{$get->kode_document}}</td>
                                            <td>{{$get->nama_document}}</td>
                                            <td>{{$get->created_at}}</td>
                                            <form action="{{url('pembatalan_transaksi/download_document_upload')}}" method="post">
                                                @csrf
                                                <input type="hidden" name="user" value="{{$get->user}}">
                                                <input type="hidden" name="kode_document" value="{{$get->kode_document}}">
                                                <td>
                                                    <button type="submit" class="btn btn-warning"><i class='bx bxs-download'></i></button>
                                                    <a href="#" class="btn btn-danger deletetemporary" data-user="{{ $get->user }}" data-kode-document="{{ $get->kode_document }}"><i class='bx bx-trash'></i></a>
                                                </td>
                                            </form>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                    
                </div>
            </div>
        </div>
        <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

        <script>
            document.addEventListener('DOMContentLoaded', function () {
                // Mendapatkan elemen input file
                const fileInput = document.getElementById('formFile');

                // Mendapatkan elemen pratinjau gambar
                const pdfPreview = document.getElementById('pdfPreview');
                const filename = document.getElementById('filename');

                // Menambahkan event change pada input file
                fileInput.addEventListener('change', function (event) {
                    // Mendapatkan file yang dipilih
                    const selectedFile = event.target.files[0];
                    console.log(selectedFile);
                    // Mengecek apakah file yang dipilih adalah PDF
                    if (selectedFile && selectedFile.type === 'application/pdf') {
                        // Membaca file dan menetapkan sumber gambar ke pratinjau
                        if (selectedFile.size <= 307200) {
                            const reader = new FileReader();
                            reader.onload = function (e) {
                                pdfPreview.style.display = 'block';
                                filename.style.display = 'block';
                                filename.innerHTML = selectedFile.name;
                                pdfPreview.src = "{{ asset('img/pdf_icon.png')}}";
                            };
                            reader.readAsDataURL(selectedFile);
                        } else {
                            filename.style.display = 'block';
                            filename.classList.add('text-danger');
                            filename.style.fontWeight = 'bold';
                            filename.innerHTML = 'Ukuran PDF minimal 300 KB';
                        }
                    } else {
                        // Menyembunyikan pratinjau jika file bukan PDF
                        pdfPreview.style.display = 'none';
                        filename.style.display = 'block';
                        filename.classList.add('text-danger');
                        filename.style.fontWeight = 'bold';
                        filename.innerHTML = 'Jenis file tidak diijinkan';
                    }
                });

                const deleteButtons = document.querySelectorAll('.deletetemporary');
                deleteButtons.forEach(function (button) {
                    button.addEventListener('click', function (event) {
                    event.preventDefault();
                    const user = this.getAttribute('data-user');
                    const kodeDocument = this.getAttribute('data-kode-document');
                    Swal.fire({
                        title: 'Ingin menghapus data?',
                        text: "Data masih dapat dipulihkan di halaman Trash",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Yes, delete it!'
                        }).then((result) => {
                        if (result.isConfirmed) {
                            Swal.fire(
                            'Deleted!',
                            'Data berhasil dihapus',
                            'success'
                            )
                            window.location.href = `{{ url('pembatalan_transaksi/delete') }}/${user}/${kodeDocument}`;
                        }
                    })

                });

                });
                
            });
        </script>

@endsection