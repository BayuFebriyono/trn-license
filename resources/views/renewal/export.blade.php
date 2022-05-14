@extends('renewal.dashboard.main')
@section('content')
    <div class="col-md-12 col-sm-12">
        <div class="card">
            <div class="card-content">
                <div class="d-flex justify-content-center mt-4">
                    <div class="text-center col-md-1">
                        <img src="{{ asset('img/gallery/data.png') }}" alt="" class="img-fluid">
                    </div>
                </div>
                <div class="card-body mt-3">
                    <h4 class="card-title">Export Data Excel</h4>
                    <p class="card-text">
                        Jika data sekarang ini diperlukan anda dapat mengunduhnya dengan cara export dibawah ini.
                    </p>
                    <p class="card-text">
                        Export Data
                    </p>

                    <form action="{{ url('/dashboard-renewal/export/gas') }}" method="POST">
                        @csrf
                        <div class="row mt-5">
                            <div class="col-md-6">
                                <label for="bulan">Pilih Bulan</label>
                                <select name="bulan" id="bulan" class="form-select">
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
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary block mt-4">Export</button>
                    </form>

                    {{-- <a class="btn btn-primary block" href="{{ url('/dashboard-renewal/export/gas') }}">Export</a> --}}

                </div>

            </div>
        </div>
    </div>
    </div>
@endsection
