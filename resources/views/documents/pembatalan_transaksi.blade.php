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

                                @if (Session::has('add_type_invalid'))
                                    <p class="text-danger fw-bold">{{Session::get('type_invalid')}}</p>
                                @elseif (Session::has('add_size_invalid'))
                                    <p class="text-danger fw-bold">{{Session::get('size_invalid')}}</p>
                                @endif

                                <button type="submit" class="btn btn-primary mb-2">Upload</button>
                                <br>
                                <span>* file harus PDF</span><br>
                                <span>* max ukuran upload 300 KB</span>
                            </form>
                            
                            @if (Session::has('add_document_success'))
                                <p class="text-success fw-bold mt-2">{{ Session::get('add_document_success') }}</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            @if (sizeof($getdata) > 0)

                <form action="{{url('pembatalan_transaksi')}}" method="post" id="search">
                    @csrf
                    
                    @if (Session::has('tanggal_mulai') || Session::has('tanggal_akhir'))
                        <div class="inputform" style="margin-left: 10px; display: flex; align-items: center;">
                            <div class="start">
                                <label for="tanggal_mulai">Tanggal mulai</label>
                                <input type="date" name="tanggal_mulai" id="tanggal_mulai" value="{{Session::get('tanggal_mulai')}}" class="form-control" style="width: 200px; margin-top: 5px; margin-right: 10px;">
                            </div>

                            <div class="end">
                                <label for="tanggal_akhir">Tanggal akhir</label>
                                <input type="date" name="tanggal_akhir" id="tanggal_akhir" value="{{Session::get('tanggal_akhir')}}" class="form-control" style="width: 200px; margin-top: 5px; margin-right: 10px;">
                            </div>
                            <button type="submit" class="btn btn-primary mt-3">Search</button>
                        </div>
                        
                        @php (Session::forget('tanggal_mulai'))
                        @php (Session::forget('tanggal_akhir'))
                    @else
                        <div class="inputform" style="margin-left: 10px; display: flex; align-items: center;">
                            <div class="start">
                                <label for="tanggal_mulai">Tanggal mulai</label>
                                <input type="date" name="tanggal_mulai" id="tanggal_mulai" class="form-control" style="width: 200px; margin-top: 5px; margin-right: 10px;">
                            </div>

                            <div class="end">
                                <label for="tanggal_akhir">Tanggal akhir</label>
                                <input type="date" name="tanggal_akhir" id="tanggal_akhir" class="form-control" style="width: 200px; margin-top: 5px; margin-right: 10px;">
                            </div>

                            <button type="submit" class="btn btn-primary mt-3 ml-5">Search</button>
                            
                        </div>
                    @endif
                </form>
                
                <form action="{{url('pembatalan_transaksi')}}" method="post" id="form-sorting">
                    @csrf
                    
                    @if (Session::has('sorting'))
                        @if (Session::get('sorting') == 'document_terbaru')
                            <div class="sorting ms-2" style="margin-left: auto;">
                                <select name="sorting" id="sorting" class="form-control" style="width: 200px; margin-top: 18px;">
                                    <option selected disabled value="document_terbaru">Document Terbaru</option>
                                    <option value="document_terlama">Document Terlama</option>
                                </select>
                            </div>
                            @php (Session::forget('sorting'))
                        @else
                            <div class="sorting ms-2" style="margin-left: auto;">
                                <select name="sorting" id="sorting" class="form-control" style="width: 200px; margin-top: 18px;">
                                    <option value="document_terbaru">Document Terbaru</option>
                                    <option selected disabled value="document_terlama">Document Terlama</option>
                                </select>
                            </div>
                        @php (Session::forget('sorting'))
                        @endif

                    @else
                        <div class="sorting ms-2" style="margin-left: auto;">
                            <select name="sorting" id="sorting" class="form-control border border-info" style="width: 200px; margin-top: 18px;">
                                <option selected disabled>Urutkan Berdasarkan</option>
                                <option value="document_terbaru">Document Terbaru</option>
                                <option value="document_terlama">Document Terlama</option>
                            </select>
                        </div>

                    @endif
                </form>
                
                <div class="table-responsive mb-4 p-2">
                    <div id="w0-container" class="table-responsive kv-grid-container">

                        @if (Session::has('delete_document_success'))
                            <p class="text-danger fw-bold">{{Session::get('delete_document_success')}}</p>
                        @elseif (Session::has('restore_document_success'))
                            <p class="text-success fw-bold">{{Session::get('restore_document_success')}}</p>
                        @elseif (Session::has('update_document_success'))
                            <p class="text-success fw-bold">{{Session::get('update_document_success')}}</p>
                        @elseif (Session::has('update_size_invalid'))
                            <p class="text-success fw-bold">{{Session::get('update_size_invalid')}}</p>
                        @elseif (Session::has('update_type_invalid'))
                            <p class="text-success fw-bold">{{Session::get('update_type_invalid')}}</p>
                        @endif

                        <div class="d-flex">
                            <table class="table text-nowrap mt-2 table-striped table-bordered mb-0 kv-grid-table kv-table-wrap border border-dark w-75" style="overflow-y: auto">
                                <thead>
                                    <tr>
                                        <td>No</td>
                                        <td data-col-seq="1">Kode Document</td>
                                        <td data-col-seq="2">Nama Document</td>
                                        <td data-col-seq="3">Tanggal Dibuat</td>
                                        <td data-col-seq="3">Tanggal Update</td>
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
                                            <td>{{$get->updated_at}}</td>
                                            <form action="{{url('pembatalan_transaksi/download_document_upload')}}" method="post">
                                                @csrf
                                                <input type="hidden" name="user" value="{{$get->user}}">
                                                <input type="hidden" name="kode_document" value="{{$get->kode_document}}">
                                                <td>
                                                    <button type="submit" class="btn btn-warning"><i class='bx bxs-download'></i> </button>
                                                    
                                                    <a href="#" class="btn btn-secondary update_document" data-csrf = "{{csrf_token()}}" data-id="{{ $get->id }}" data-kode-document="{{ $get->kode_document }}" data-img = "{{asset('img/pdf_icon.png')}}"><i class='bx bx-edit'></i> </a>
                                                    
                                                    <a href="#" class="btn btn-danger deletetemporary" data-user="{{ $get->user }}" data-kode-document="{{ $get->kode_document }}"><i class='bx bx-trash'></i> </a>
                                                </td>
                                            </form>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

            @endif
        </div>

        <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script src="{{ asset('js/script.js') }}"></script>

@endsection