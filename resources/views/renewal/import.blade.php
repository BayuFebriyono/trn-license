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
                    @if (session('error'))
                        <script>
                            Swal.fire(
                                'Error',
                                '{{ session('error') }}',
                                'error'
                            )
                        </script>
                    @elseif (session('success'))
                        <script>
                            Swal.fire(
                                'Berhasil',
                                '{{ session('success') }}',
                                'success'
                            )
                        </script>
                    @endif
                    <h4 class="card-title">Import Data Excel</h4>
                    <p class="card-text">
                        Untuk memasukkan daftar peserta renewal terbaru import data excel anda pada menu dibawah ini.
                        Dibawah juga terdapat contoh format untuk import agar sistem kami bisa membaca data anda.
                    </p>
                    <p class="card-text">
                        Download format import
                    </p>


                    <a class="btn btn-primary block" href="{{asset('excel/import.xlsx')}}">Download</a>

                    <p class="mt-3">Upload file</p>

                    <form action="{{ url('/dashboard-renewal/import') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-md-6">
                                <input type="file" class="form-control" name="excel">
                            </div>
                            <div class="col-md-6">
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </div>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>
    </div>
@endsection
