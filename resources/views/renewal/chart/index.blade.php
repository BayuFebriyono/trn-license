@extends('renewal.dashboard.main')
@section('content')
    <script src="{{ asset('js/cart.js') }}"></script>

    <style>
        .card {
            border-radius: 4px;
            background: #fff;
            box-shadow: 0 6px 10px rgba(0, 0, 0, .08), 0 0 6px rgba(0, 0, 0, .05);
            transition: .3s transform cubic-bezier(.155, 1.105, .295, 1.12), .3s box-shadow, .3s -webkit-transform cubic-bezier(.155, 1.105, .295, 1.12);
            padding: 14px 80px 18px 36px;
            cursor: pointer;
        }

        .card:hover {
            transform: scale(1.05);
            box-shadow: 0 10px 20px rgba(0, 0, 0, .12), 0 4px 8px rgba(0, 0, 0, .06);
        }

        .card h3 {
            font-weight: 600;
        }

        .card img {
            position: absolute;
            top: 20px;
            right: 15px;
            max-height: 120px;
        }

        .card-1 {
            background-image: url('{{ asset("/img/gallery/thumbs-up.png") }}');
            background-repeat: no-repeat;
            background-position: right;
            background-size: 80px;
        }

        .card-2 {
            background-image: url('{{ asset("/img/gallery/work-in-progress.png") }}');
            background-repeat: no-repeat;
            background-position: right;
            background-size: 80px;
        }

        .card-3 {
            background-image: url('{{ asset("/img/gallery/all.png") }}');
            background-repeat: no-repeat;
            background-position: right;
            background-size: 80px;
        }

        .card-4 {
            background-image: url('{{ asset("/img/gallery/verified.png") }}');
            background-repeat: no-repeat;
            background-position: right;
            background-size: 80px;
        }

        .card-5 {
            background-image: url('{{ asset("/img/gallery/task.png") }}');
            background-repeat: no-repeat;
            background-position: right;
            background-size: 80px;
        }

        @media(max-width: 990px) {
            .card {
                margin: 20px;
            }
        }

    </style>

    <div class="container">
        <h2 class="mb-5">Summary Renewal License</h2>
        <div class="row">
            <div class="col-md-1"><label for="bulan">Expired : </label></div>
            <div class="col-md-5">
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
            </div>
        </div>
        <div class="row mt-5">
            <div class="col-md-4">
                <div class="card card-1">
                    <h3 id="PesertaClosed">{{ $ok }}</h3>
                    <p>Total Peserta Renewal License Closed</p>
                    <p>
                        {{-- <a href="#" id="btn_closed"><u>Detail</u></a> --}}
                    </p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card card-2">
                    <h3 id="PesertaProgress">{{ $progress->count() }}</h3>
                    <p>Total Peserta Renewal License Progress</p>
                    <p>
                        {{-- <a href="#" id="btn_progress"><u>Detail</u></a> --}}
                    </p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card card-3">
                    <h3 id="Peserta">0</h3>
                    <p >Total Peserta Renewal License</p>
                    <p>
                        {{-- <a href="#" id="btn_peserta"><u>Detail</u></a> --}}
                    </p>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card card-4">
                    <h3 id="LicenseClosed"></h3>
                    <p >Total License Closed</p>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card card-5">
                    <h3 id="LicenseProgress">0</h3>
                    <p >Total License In Progress</p>
                </div>
            </div>
        </div>

        
        <p class="text-muted">Note : Total Peserta merupakan total per orang sedangkan total license merupakan total semua license yang tercatat</p>

        {{-- Cart --}}
        <div class="row mt-5">
            <div class="col-md-7">
                <div class="card">
                    <div class="card-content">
                        <div class="card-body">
                            <h4 class="card-title">Jumlah Written Test Harian</h4>
                            <p>
                                <canvas id="myChart2"></canvas>
                            </p>
                        </div>

                    </div>
                </div>

            </div>
            <div class="col-md-5">
                <div class="card">
                    <div class="card-content">
                        <div class="card-body">
                            <h6 class="card-title">Summary License Closed</h6>
                            <p>
                                <canvas id="myChart"></canvas>
                            </p>
                        </div>

                    </div>
                </div>

            </div>
        </div>




    </div>



    <script>
        var ctx = document.getElementById("myChart").getContext('2d');

        var myChart = new Chart(ctx, {
            type: 'pie',
            data: {
                labels: ["Progress", "Closed"],
                datasets: [{
                    label: '',
                    data: [],
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.2)',
                        'rgba(54, 162, 235, 0.2)'
                    ],
                    borderColor: [
                        'rgba(255,99,132,1)',
                        'rgba(54, 162, 235, 1)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero: true
                        }
                    }]
                }
            }
        });



        //mebuat chart
        var myChart2 = new Chart(
            //masukan chart ke element canvas dengan id myChart2
            document.getElementById('myChart2'), {
                //tipe chart yg digunakan adalah line chart atau diagram garis
                type: 'line',
                data: {
                    //data labels akan diganti dengan data api pada step berikutnya
                    labels: [
                        <?php
                        foreach ($lcn as $l) {
                            echo '"' . $l->date . '",';
                        }
                        
                        ?>
                    ],
                    datasets: [{
                        label: 'Jumlah Written Test',
                        //data akan diganti dengan data api pada step berikutnya
                        data: [
                            <?php
                            foreach ($lcn as $l) {
                                echo '"' . $l->jumlah . '",';
                            }
                            
                            ?>
                        ],
                        //line akan diwarnai dengan warna merah
                        backgroundColor: [
                            'rgb(255, 99, 132)',
                        ],
                        hoverOffset: 4
                    }]
                }
            }
        );


        $(document).ready(function() {
            let bulan = 1;
            $('#month').on('change', function() {
                bulan = this.value;
                // console.log(this.value);
                
            });

            // $('#btn_closed').on('click', function(){
            //     let link = "{{ url('/dashboard-renewal/dashboard/closed') }}" + "/" + bulan;

            //     window.location.href = link;
            // });
            // $('#btn_peserta').on('click', function(){
            //     let link = "{{ url('/dashboard-renewal/dashboard/list') }}" + "/" + bulan;

            //     window.location.href = link;
            // });

            // $('#btn_progress').on('click', function(){
            //     let link = "{{ url('/dashboard-renewal/dashboard/progress') }}" + "/" + bulan;

            //     window.location.href = link;
            // });

            function cek() {

                $.ajax({
                    url: "{{ route('dashboard') }}",
                    type: 'GET',
                    data: {
                        bulan: bulan
                    },
                    dataType: 'json',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(data) {
                        
                        // console.log(data);
                        $("#PesertaClosed").html(data.closed[1]);
                        $("#PesertaProgress").html(data.closed[0]);
                        $("#Peserta").html(data.peserta);
                        $("#LicenseClosed").html(data.lcn_closed);
                        $("#LicenseProgress").html(data.lcn_progress);

                        myChart.data.datasets[0].data = data.closed;
                        myChart.update();

                        myChart2.data.labels = data.lcn_date;
                        myChart2.data.datasets[0].data = data.lcn_jumlah;
                        myChart2.update();
                    },
                    error: function(data) {
                        console.log(data);
                    }
                });
            }

            cek();

            setInterval(() => {
                cek();
                // console.log(bulan);
                // console.log('tws');
            }, 1000);
        });
    </script>
@endsection
