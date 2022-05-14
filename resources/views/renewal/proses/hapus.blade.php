@extends('renewal.dashboard.main')
@section('content')
    <div class="col-md-12 col-sm-12">
        <div class="card">
            <div class="card-content">
                <div class="card-body mt-3">
                    <h3 class="card-title">Hapus Data Peserta</h3>
                    <p class="card-text">
                        Hapus Data Renewal yang suda selesai agar waktu export data hanya yang update yang sedang berjalan
                        pilih berdasarkan bulan dibawah ini.
                    </p>
                    <form action="{{ url('/dashboard-renewal/delete') }}" method="POST">
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
                        <button type="submit" class="btn btn-primary block mt-4"
                            href="{{ url('/dashboard-renewal/delete') }}">Hapus</button>
                    </form>



                </div>

            </div>
        </div>
    </div>

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
    </div>
@endsection
