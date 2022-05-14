@extends('renewal.dashboard.main')
@section('content')
    @if ($license->count())
        <div class="col-12 col-md-12">
            <div class="card">
                <div class="card-content">
                    <div class="card-body">
                        <p class="text-muted">Identitas</p>
                        <div class="row mt-4">
                            <div class="col-md-6">
                                <label for="nik">NIK</label>
                                <input type="text" class="form-control" name="nik" id="nik" disabled
                                    value="{{ $license[0]->nik }}">
                            </div>

                            <div class="col-md-6">
                                <label for="nama">Nama</label>
                                <input type="text" class="form-control" name="nama" id="nama" disabled
                                    value="{{ $license[0]->employe->nama }}">
                            </div>

                            <div class="mt-4">
                                <div class="col-md-6 ">
                                    <label for="bulan">Bulan Expired</label>
                                    <input type="text" class="form-control" name="bulan" id="bulan" disabled
                                        value="{{ $license[0]->employe->expired_date }}">
                                </div>
                            </div>

                        </div>
                        <p class="text-muted mt-3">Daftar License</p>
                        <!-- Table with outer spacing -->

                        <button type="button" class="btn btn-outline-primary" data-bs-toggle="modal"
                            data-bs-target="#primary">
                            Add Input
                        </button>

                        <!--primary theme Modal -->
                        <div class="modal fade text-left" id="primary" tabindex="-1" role="dialog"
                            aria-labelledby="myModalLabel160" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
                                <div class="modal-content">
                                    <div class="modal-header bg-primary">
                                        <h5 class="modal-title white" id="myModalLabel160">Add Input License
                                        </h5>
                                        <button type="button" class="close" data-bs-dismiss="modal"
                                            aria-label="Close">
                                            <i data-feather="x"></i>
                                        </button>
                                    </div>
                                    <form action="{{ url('/dashboard-renewal/add') }}" method="POST">
                                        <div class="modal-body">

                                            @csrf
                                            <input type="hidden" name="nik" value="{{ $license[0]->nik }}">
                                            <label for="license">License</label>
                                            <input type="text" class="form-control" name="license" id="license"
                                                placeholder="License">
                                            <label for="expired">Bulan Expired</label>
                                            <select name="month_expired" class="form-select" id="expired">
                                                <option value="1">Januari</option>
                                                <option value="2">Februari</option>
                                                <option value="3">Maret</option>
                                                <option value="4">April</option>
                                                <option value="5">Mei</option>
                                                <option value="6">Juni</option>
                                                <option value="7">July</option>
                                                <option value="8">Agustus</option>
                                                <option value="9">September</option>
                                                <option value="10">Oktober</option>
                                                <option value="11">November</option>
                                                <option value="12">Desember</option>
                                            </select>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-light-secondary" data-bs-dismiss="modal">
                                                <i class="bx bx-x d-block d-sm-none"></i>
                                                <span class="d-none d-sm-block">Cancel</span>
                                            </button>
                                            <button type="submit" class="btn btn-primary ml-1">
                                                <i class="bx bx-check d-block d-sm-none"></i>
                                                <span class="d-none d-sm-block">Submit</span>
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <table class="table table-striped" id="table1">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Nama License</th>
                                    <th>Tanggal Tes</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($license as $l)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $l->license }}</td>
                                        <td>{{ $l->tanggal_tes ? $l->tanggal_tes : '-' }}</td>
                                        <td>{{ $l->tanggal_tes ? 'DONE' : 'PROCESS' }}</td>
                                        <td>
                                            @if ($l->tanggal_tes)
                                                <button class="btn btn-success">Done</button>
                                                <span><a class="btn btn-danger" id="cancel"
                                                        onclick="alertCancel('{{ url('/') }}/dashboard-renewal/cancel/{{ $l->id }}/{{ $l->nik }}')">Cancel</a></span>
                                            @else
                                                <span><a class="btn btn-warning"
                                                        href="{{ url('/dashboard-renewal/update/' . $l->id . '/' . $l->nik) }}">Passed</a></span>
                                                <span><a class="btn btn-danger" id="hapus"
                                                        onclick="alertHapus('{{ url('/') }}/dashboard-renewal/hapus/{{ $l->id }}/{{ $l->nik }}')">Delete</a></span>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-1">
                    <span class="badge bg-success">Done</span>
                </div>
                <div class="col-md-3">
                    <p>Sudah dan Lulus Tes</p>
                </div>
            </div>
            <div class="row">
                <div class="col-md-1">
                    <span class="badge bg-warning">Passed</span>
                </div>
                <div class="col-md-3">
                    <p>Tombol untuk meluluskan written tes</p>
                </div>
            </div>

            <div class="row">
                <div class="col-md-1">
                    <span class="badge bg-danger">Delete</span>
                </div>
                <div class="col-md-3">
                    <p>Tombol untuk menghapus license</p>
                </div>
            </div>

            <div class="row">
                <div class="col-md-1">
                    <span class="badge bg-danger">Cancel</span>
                </div>
                <div class="col-md-3">
                    <p>Membatalkan Status Lulus</p>
                </div>
            </div>
        </div>
    @else
        @include('notfound')
    @endif


    <script>
        function alertHapus(link) {
            Swal.fire({
                title: 'Apakah Anda Yakin?',
                text: "License ini akan dihapus dari data!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, saya yakin',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = link
                }
            })
        }
    </script>

    <script>
        function alertCancel(link) {
            Swal.fire({
                title: 'Apakah Anda Yakin?',
                text: "Status License Akan Diubah Menjadi Progress!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, saya yakin',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = link
                }
            })

        }
    </script>


    @if (session('success'))
        <script>
            Swal.fire(
                'Sukess!',
                '{{ session('success') }}',
                'success'
            )
        </script>
    @endif

    <script src="{{ asset('js/onscan.js') }}"></script>
    <script>
        onScan.attachTo(document, {
            suffixKeyCodes: [13], // enter-key diharapkan pada akhir pemindaian 
            reactToPaste: true, // Kompatibilitas dengan kewajiban bawaan dalam mode tempel (sebagai lawan dari mode keyboard) 
            onScan: function(sCode, iQty) { // Alternatif untuk document.addEventListener('scan') 
                sCode = '/' + sCode;
                let link = '{{ url('/dashboard-renewal/cekNik/detail/') }}';

                window.location.href = link + sCode;
            }
        });
    </script>
@endsection
