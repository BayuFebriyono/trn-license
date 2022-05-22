@extends('renewal.dashboard.main')
@section('content')
<div class="text-center">
    <img src="{{ asset('img/gallery/expired.png') }}" alt="Expired" class="img-fluid ">
</div>

    <h3 class="text-center">Pilih Bulan Expired</h3>
    <div class="row">
        <div class="col-md-3"></div>
        <div class="col-md-6">
            <form action="{{ url('/dashboard-renewal/forecast/dept/cek') }}" method="POST">
                @csrf
                <select name="bulan" id="month" class="form-select">
                    <option value="1">Janurari</option>
                    <option value="2">Februari</option>
                    <option value="3">Maret</option>
                    <option value="4">April</option>
                    <option value="5">Mei</option>
                    <option value="6">Juni</option>
                    <option value="7">Juli</option>
                    <option value="8">Agustus</option>
                    <option value="9">September</option>
                    <option value="10">Oktober</option>
                    <option value="11">November</option>
                    <option value="12">Desember</option>
                </select>

                <div class="text-center mt-4">
                    <button class="btn btn-primary">Submit</button>
                </div>
                
            </form>
        </div>
        <div class="col-md-3"></div>
    </div>
@endsection
