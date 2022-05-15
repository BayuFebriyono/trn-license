@extends('renewal.dashboard.main')
@section('content')
    <h3 class="mb-4">List Peserta Renewal License</h3>


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
                                <th>Bulan Expired</th>
                                <th>Line/Unit Kerja</th>
                                <th>Shift</th>
                                <th>Lokasi</th>
                                <th>License</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($peserta as $p)
                           
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $p->nik }}</td>
                                    <td>{{ $p->nama }}</td>
                                    <td>{{ $p->expired_date }}</td>
                                    <td>{{ $p->line }}</td>
                                    <td>{{ $p->shift }}</td>
                                    <td>{{ $p->lokasi }}</td>
                                    <td><a href="{{ url('/dashboard-renewal/list/'. $p->nik) }}" class="btn btn-info">Detail</a></td>
                                    <td>
                                        @if ($p->license->whereNull('tanggal_tes')->count() )
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
                </div>
            </div>

        </section>
    </div>

    <script src="{{ asset('js/onscan.js') }}"></script>
    <script>
        onScan.attachTo (document, { 
    suffixKeyCodes : [ 13 ] ,  // enter-key diharapkan pada akhir pemindaian 
    reactToPaste : true ,  // Kompatibilitas dengan kewajiban bawaan dalam mode tempel (sebagai lawan dari mode keyboard) 
    onScan : function( sCode ,  iQty )  {  // Alternatif untuk document.addEventListener('scan') 
        sCode = parseInt(sCode, 10);
    let link = '{{ url("/dashboard-renewal/list") }}';
       
        window.location.href = link + '/' + sCode;
    } 
}) ;
    </script>
@endsection
