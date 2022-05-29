@extends('renewal.dashboard.main')
@section('content')
    <style></style>
    <div class="text-center">
        <h4 class="mb-4">List Peserta Renewal License</h4>
        <h5 class="mt-3">Expired
            {{ date("d-m-Y", strtotime($expired->last_date)) }}
        </h5>

        <h4 class="mt-3 mb-4"><b id="jam">00:00:00:00</b></h4>
    </div>



    <div class="page-heading">
        <section class="section">
            <div class="card">
                <div class="card-header">

                </div>
                <div class="card-body">
                    <table class="table table-striped" id="table1">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>NIK</th>
                                <th>Nama</th>
                                <th>Tanggal Tes</th>
                                <th>Bulan Expired</th>
                                <th>Section</th>
                                <th>Shift</th>
                                <th>Lokasi</th>
                                <th>License</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($peserta as $p)
                                <tr
                                    class="{{ $p->license->whereNull('tanggal_tes')->count() ? 'table-warning' : 'table-success' }}">
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $p->nik }}</td>
                                    <td>{{ $p->nama }}</td>
                                    <td>{{ $p->tanggal_tes }}</td>
                                    <td>{{ $p->expired_date }}</td>
                                    <td>{{ $p->section }}</td>
                                    <td>{{ $p->shift }}</td>
                                    <td>{{ $p->lokasi }}</td>
                                    <td><a href="{{ url('/dashboard-renewal/list/' . $p->nik) }}"
                                            class="btn btn-info">Detail</a></td>
                                    <td>
                                        @if ($p->license->whereNull('tanggal_tes')->count())
                                            <span class="badge bg-warning">Progress</span>
                                        @else
                                            <span class="badge bg-success">Closed</span>
                                        @endif
                                        {{-- kiri {{ $p->license->whereNotNull('tanggal_tes')->count()  }}
                                        kanan {{ $p->license->whereNull('tanggal_tes')->count() }} --}}

                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <p class="text-muted mt-5">Note : Data - Data tersebut merupakan data cut off per {{ $expired->created_at }}</p>
                </div>
            </div>




        </section>
    </div>

    <script>
        let lbJam = document.getElementById('jam');
        let bulan ='{{ date('F', strtotime($expired->last_date)) }}';
        let year = '{{ date('y', strtotime($expired->last_date)) }}';
        let date =  '{{ date('d', strtotime($expired->last_date)) }}';
        let tanggal = bulan + date+' , '+year+ ' 00:00:00';
        var countDownDate = new Date(tanggal).getTime();

        var myfunc = setInterval(function() {
            var now = new Date().getTime();
            var timeleft = countDownDate - now;

            var days = Math.floor(timeleft / (1000 * 60 * 60 * 24));
            var hours = Math.floor((timeleft % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
            var minutes = Math.floor((timeleft % (1000 * 60 * 60)) / (1000 * 60));
            var seconds = Math.floor((timeleft % (1000 * 60)) / 1000);

            if (seconds <= -1) {
                days = 0;
                hours = 0;
                minutes = 0;
                seconds = 0;
            }


            // console.log(days + ':' + hours + ':' + minutes + ':' + seconds);
            lbJam.innerHTML = days + ' Days : ' + hours + ' Hours : ' + minutes + ' Minutes : ' + seconds + ' Seconds';
        }, 1000)
        myfunc;
    </script>

    {{-- <script src="{{ asset('js/onscan.js') }}"></script> --}}
@endsection
