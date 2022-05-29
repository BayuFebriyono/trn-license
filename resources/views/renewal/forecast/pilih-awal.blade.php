@extends('renewal.dashboard.main')
@section('content')
    <style>
        .courses-container {}

        .course {
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 10px 10px rgba(0, 0, 0, 0.2);
            display: flex;
            max-width: 100%;
            margin: 20px;
            overflow: hidden;
            width: 700px;
        }

        .course h6 {
            opacity: 0.6;
            margin: 0;
            letter-spacing: 1px;
            text-transform: uppercase;
        }

        .course h2 {
            letter-spacing: 1px;
            margin: 10px 0;
        }

        .course-preview {
            background-color: #2A265F;
            color: #fff;
            padding: 30px;
            max-width: 250px;
        }

        .course-preview a {
            color: #fff;
            display: inline-block;
            font-size: 12px;
            opacity: 0.6;
            margin-top: 30px;
            text-decoration: none;
        }

        .course-info {
            padding: 30px;
            position: relative;
            width: 100%;
        }



        .btn {
            background-color: #2A265F;
            border: 0;
            border-radius: 50px;
            box-shadow: 0 10px 10px rgba(0, 0, 0, 0.2);
            color: #fff;
            font-size: 16px;
            padding: 12px 25px;
            position: absolute;
            bottom: 30px;
            right: 30px;
            letter-spacing: 1px;
        }

        /* SOCIAL PANEL CSS */
        .social-panel-container {
            position: fixed;
            right: 0;
            bottom: 80px;
            transform: translateX(100%);
            transition: transform 0.4s ease-in-out;
        }

        .social-panel-container.visible {
            transform: translateX(-10px);
        }

        .social-panel {
            background-color: #fff;
            border-radius: 16px;
            box-shadow: 0 16px 31px -17px rgba(0, 31, 97, 0.6);
            border: 5px solid #001F61;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            font-family: 'Muli';
            position: relative;
            height: 169px;
            width: 370px;
            max-width: calc(100% - 10px);
        }

        .social-panel button.close-btn {
            border: 0;
            color: #97A5CE;
            cursor: pointer;
            font-size: 20px;
            position: absolute;
            top: 5px;
            right: 5px;
        }

        .social-panel button.close-btn:focus {
            outline: none;
        }

        .social-panel p {
            background-color: #001F61;
            border-radius: 0 0 10px 10px;
            color: #fff;
            font-size: 14px;
            line-height: 18px;
            padding: 2px 17px 6px;
            position: absolute;
            top: 0;
            left: 50%;
            margin: 0;
            transform: translateX(-50%);
            text-align: center;
            width: 235px;
        }

        .social-panel p i {
            margin: 0 5px;
        }

        .social-panel p a {
            color: #FF7500;
            text-decoration: none;
        }

        .social-panel h4 {
            margin: 20px 0;
            color: #97A5CE;
            font-family: 'Muli';
            font-size: 14px;
            line-height: 18px;
            text-transform: uppercase;
        }

        .social-panel ul {
            display: flex;
            list-style-type: none;
            padding: 0;
            margin: 0;
        }

        .social-panel ul li {
            margin: 0 10px;
        }

        .social-panel ul li a {
            border: 1px solid #DCE1F2;
            border-radius: 50%;
            color: #001F61;
            font-size: 20px;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 50px;
            width: 50px;
            text-decoration: none;
        }

        .social-panel ul li a:hover {
            border-color: #FF6A00;
            box-shadow: 0 9px 12px -9px #FF6A00;
        }

        .floating-btn {
            border-radius: 26.5px;
            background-color: #001F61;
            border: 1px solid #001F61;
            box-shadow: 0 16px 22px -17px #03153B;
            color: #fff;
            cursor: pointer;
            font-size: 16px;
            line-height: 20px;
            padding: 12px 20px;
            position: fixed;
            bottom: 20px;
            right: 20px;
            z-index: 999;
        }

        .floating-btn:hover {
            background-color: #ffffff;
            color: #001F61;
        }

        .floating-btn:focus {
            outline: none;
        }

        .floating-text {
            background-color: #001F61;
            border-radius: 10px 10px 0 0;
            color: #fff;
            font-family: 'Muli';
            padding: 7px 15px;
            position: fixed;
            bottom: 0;
            left: 50%;
            transform: translateX(-50%);
            text-align: center;
            z-index: 998;
        }

        .floating-text a {
            color: #FF7500;
            text-decoration: none;
        }

        @media screen and (max-width: 480px) {

            .social-panel-container.visible {
                transform: translateX(0px);
            }

            .floating-btn {
                right: 10px;
            }
        }

    </style>
    <h3>Pilih Menu Dibawah Ini</h3>

        <div class="row">
                <div class="col-md-4">
                    <div class="courses-container">
                        <div class="course">
                            <div class="course-preview">
                                <h6 class="text-white">Total</h6>
                                <h2 class="text-white">{{ $manufacturing }}</h2>
                            </div>
                            <div class="course-info">
                                <h6>Dept/Sect</h6>
                                <h5>Manufacturing</h5>


                                {{-- <div class="progress progress-success">
                                    <div class="progress-bar" role="progressbar" style="width: {{ $status[$i]['closed']/$obj->count() * 100 }}%" aria-valuenow="25"
                                        aria-valuemin="0" aria-valuemax="100"></div>
                                </div> --}}
                                {{-- <p class="text-muted">{{ $status[$i]['closed'] }}/{{ $obj->count() }}</p> --}}
                                <a href="{{ url('/dashboard-renewal/forecast/manufacturing/'.$bulan) }}">Detail</a>


                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="courses-container">
                        <div class="course">
                            <div class="course-preview">
                                <h6 class="text-white">Total</h6>
                                <h2 class="text-white">{{ $non_manufacturing }}</h2>
                            </div>
                            <div class="course-info">
                                <h6>Dept/Sect</h6>
                                <h5>Non Manufacturing</h5>


                                {{-- <div class="progress progress-success">
                                    <div class="progress-bar" role="progressbar" style="width: {{ $status[$i]['closed']/$obj->count() * 100 }}%" aria-valuenow="25"
                                        aria-valuemin="0" aria-valuemax="100"></div>
                                </div> --}}
                                {{-- <p class="text-muted">{{ $status[$i]['closed'] }}/{{ $obj->count() }}</p> --}}
                                <a href="{{ url('/dashboard-renewal/forecast/non-manufacturing/'. $bulan) }}">Detail</a>


                            </div>
                        </div>
                    </div>
                </div>
        </div>





   
@endsection
