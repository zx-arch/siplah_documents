@extends('documents.layouts.template')
@section('container')
    
    @include('documents.components.navbar')
        <div class="p-1 my-container active-cont">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 border-bottom">
                <h1 class="h4 p-2">Dashboard</h1>
            </div>
            
            <div class="containers p-2">
                <form action="{{url('system/logout')}}" method="post">
                    @csrf
                    <button type="submit" class="btn btn-warning">Logout</button>
                </form>
            </div>
        </div>

@endsection