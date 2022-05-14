@extends('renewal.dashboard.main')
@section('content')
    <section id="input-with-icons">
        <div class="row match-height">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Input NIK</h4>
                    </div>

                    <div class="card-body">
                        <div class="row">
                            <div class="col-12">
                                <p class="mt-2">Masukkan NIK pada field dibawah ini. Atau anda juga bisa
                                    menggunakan scanner barcode.
                                </p>
                            </div>
                            <form action="{{ url('/dashboard-renewal/cekNik/detail') }}" method="POST">
                                @csrf
                                <div class="row">
                                    <div class="col-sm-6 col-md-6 mt-3">
                                        <div class="form-group position-relative has-icon-left">
                                            <input type="text" class="form-control" name="nik" placeholder="Masukkan NIK" autofocus>
                                            <div class="form-control-icon">
                                                <i class="bi bi-person"></i>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-3">
                                        <div class="mt-3">
                                            <button type="submit" class="btn btn-primary">Submit</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
