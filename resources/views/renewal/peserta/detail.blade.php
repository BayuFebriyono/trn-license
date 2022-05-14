@extends('renewal.dashboard.main')
@section('content')
    @if ($license->count())
        <h3 class="text-dark mb-5">License Detail</h3 class="text-primary">
        <div class="col-12 col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">{{ $license[0]->employe->nama }} / {{ $license[0]->employe->nik }}</h4>

                </div>
                <div class="card-content">
                    <div class="card-body">

                        <!-- Table with outer spacing -->
                        <div class="table-responsive">
                            <table class="table table-lg">
                                <thead>
                                    <tr>
                                        <th>License</th>
                                        <th>Tanggal Tes</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($license as $l)
                                        <tr>
                                            <td class="text-bold-500">{{ $l->license }}</td>
                                            <td>{{ $l->tanggal_tes ? $l->tanggal_tes : '-' }}</td>
                                            <td class="text-bold-500">
                                                @if ($l->tanggal_tes)
                                                    <span class="badge bg-success">Closed</span>
                                                @else
                                                    <span class="badge bg-warning">Progress</span>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row mt-4">
                <div class="col-md-1">
                    <span class="badge bg-success">Closed</span>
                </div>
                <div class="col-md-5">
                    <p>Sudah dan Lulus Tes</p>
                </div>
                <div class="col-md-1">
                    <span class="badge bg-warning">Progress</span>
                </div>
                <div class="col-md-5">
                    <p>Belum melakukan dan lulus tes</p>
                </div>
            </div>
        </div>
    @else
        @include('notfound')
    @endif

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
