<div class="side-navbar active-nav d-flex justify-content-between flex-wrap flex-column" id="sidebar" style="z-index: 9999;">
    <ul class="nav flex-column text-white w-100">
        <a href="{{ url('/') }}" class="nav-link h4 text-white my-2 mb-4"> Siplah Documents </a>
        <a href="{{ url('/') }}" class="nav-link">
            <i class="bx bxs-dashboard"></i>
            <span class="mx-2">Dashboard</span>
        </a>
        <a href="{{ url('pembatalan_transaksi') }}" class="nav-link">
            <i class='bx bxs-file-blank'></i>
            <span class="mx-2">Pembatalan Transaksi</span>
        </a> <br>
        <a href="{{ url('trash') }}" class="nav-link">
            <i class='bx bx-trash'></i>
            <span class="mx-2">Trash</span>
        </a>
    </ul>
</div>