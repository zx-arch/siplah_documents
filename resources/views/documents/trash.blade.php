@extends('documents.layouts.template')
@section('container')
    
    @include('documents.components.navbar')
    <div class="p-1 my-container active-cont">
        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 border-bottom">
            <h1 class="h4 p-2">Document yang Dihapus</h1>
        </div>
        <div class="table-responsive mb-4 p-2">
            <div id="w0-container" class="table-responsive kv-grid-container">
                @if (Session::has('delete_document_success'))
                    <p class="text-danger fw-bold">{{Session::get('delete_document_success')}}</p>
                @endif

                    @if (sizeof($checkdocument) > 0)
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
                                    @foreach ($checkdocument as $check)
                                        @php ($count++)
                                        <tr>
                                            <td>{{$count}}</td>
                                            <td>{{$check->kode_document}}</td>
                                            <td>{{$check->nama_document}}</td>
                                            <td>{{$check->created_at}}</td>
                                            <form action="{{url('trash/restore')}}" method="post">
                                                @csrf
                                                <input type="hidden" name="id" value="{{$check->id}}">
                                                <input type="hidden" name="kode_document" value="{{$check->kode_document}}">
                                                <td>
                                                    <button type="submit" class="btn btn-warning">Restore</button>
                                                    <a href="#" class="btn btn-danger deletepermanent" data-id="{{ $check->id }}" data-kode-document="{{ $check->kode_document }}">Delete</a>
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
        
        <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const deleteButtons = document.querySelectorAll('.deletepermanent');

                deleteButtons.forEach(function (button) {
                    button.addEventListener('click', function (event) {
                        event.preventDefault();
                        const id = this.getAttribute('data-id');
                        const kodeDocument = this.getAttribute('data-kode-document');
                        Swal.fire({
                            title: 'Ingin menghapus data?',
                            text: "Data akan dihapus permanent",
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
                                window.location.href = `{{ url('trash/delete') }}/${id}/${kodeDocument}`;
                            }
                        });
                    });
                });

            });
        </script>

    </div>
@endsection