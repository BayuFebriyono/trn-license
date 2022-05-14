<!DOCTYPE html>
<html lang="en-US" dir="ltr">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">


    <!-- ===============================================-->
    <!--    Document Title-->
    <!-- ===============================================-->
    <title>Training Center | Home</title>


    <!-- ===============================================-->
    <!--    Favicons-->
    <!-- ===============================================-->
    <link rel="shortcut icon" href="{{ asset('img/gallery/favicon.ico') }}">


    <!-- ===============================================-->
    <!--    Stylesheets-->
    <!-- ===============================================-->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="{{ asset('css/from-online/googleapis.css') }}" rel="stylesheet">
    <link href="{{ asset('main-screen/assets/css/theme.css') }}" rel="stylesheet" />
    <link href="{{ asset('main-screen/assets/css/user.css') }}" rel="stylesheet" />

    <style>
        /* .ok{
            background-size:
        } */

    </style>
</head>


<body>

    <!-- ===============================================-->
    <!--    Main Content-->
    <!-- ===============================================-->
    <main class="main" id="top">
        <nav class="navbar navbar-expand-lg navbar-light fixed-top py-3" data-navbar-on-scroll="light">
            <div class="container"><a class="navbar-brand" href="index.html"><h4>TRN</h4></a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                    aria-expanded="false" aria-label="Toggle navigation"><span
                        class="navbar-toggler-icon"></span></button>
                <div class="collapse navbar-collapse border-top border-lg-0 mt-4 mt-lg-0" id="navbarSupportedContent">
                    <ul class="navbar-nav ms-auto pt-2 pt-lg-0 font-base align-items-center">
                        <li class="nav-item"><a class="nav-link pl-3 me-3" href="#docs">Panduan </a></li>
                        <li class="nav-item"><a class="nav-link pl-3 me-3" href="#docs">Layanan </a></li>
                    </ul>
                    @guest
                        <a href="{{ url('/login') }}" class="btn btn-success">Admin Area</a>
                    @endguest
                    @auth
                       <a href="{{ url('/logout') }}" class="btn btn-sm btn-danger">Logout</a>
                    @endauth
                </div>
            </div>
        </nav>
        <section class="py-7 py-lg-10" id="home">
            <div class="bg-holder bg-size"
                style="background-image:url({{ asset('main-screen/assets/img/illustration/2.png') }});background-position:left top;background-size:contain;">
            </div>
            <!--/.bg-holder-->

            <div class="bg-holder d-none d-xxl-block hero-bg"
                style="background-image:url({{ asset('img/gallery/main.png') }});background-position:right top;background-size:50%;">
            </div>
            <!--/.bg-holder-->

            <div class="container">
                <div class="row align-items-center h-100 justify-content-center justify-content-lg-start">
                    <div class="col-md-9 col-xxl-5 text-md-start text-center py-6 pt-8">
                        <h1 class="fs-4 fs-md-5 fs-xxl-4" data-zanim-xs='{"delay":0.3}' data-zanim-trigger="scroll">
                            Selamat Datang Di web System TC</h1>
                        <p class="fs-1" data-zanim-xs='{"delay":0.5}' data-zanim-trigger="scroll">Disini anda
                            bisa mengakses layanan dari Training Center Secara <b>Digital</b>. Nikmati layanan terbaru
                            berbentuk <b>Digital</b> dari kami.</p>
                        <div class="d-flex flex-column flex-sm-row justify-content-center justify-content-md-start mt-3"
                            data-zanim-xs='{"delay":0.5}' data-zanim-trigger="scroll"></div>
                    </div>
                </div>
            </div>
        </section>


        <!-- ============================================-->
        <!-- <section> begin ============================-->
        <section id="product">

            <div class="container">
                <div class="row mb-4">
                    <div class="col-md-6 h-100 text-center text-md-start p-0 p-md-5 pb-3">
                        <h2 class="mt-3">Layanan yang kami tawarkan</h2>
                        <p class="mb-0">Berikut adalah list layanan yang kami yang telah support di web ini.
                            Kami akan terus mengupdate aplikasi ini demi memberikan layanan yang terbaik :) &nbsp;</p>
                    </div>
                    <div class="col-md-6">
                        <div class="w-100 h-100 p-5 services-card-shadow rounded-4"><img
                                src="{{ asset('img/gallery/add-button.png') }}" alt="Dashboard" style="width:95px;" />
                            <h3 class="mt-3 lh-base">Penambahan License</h3>
                            <p class="mb-0">Pada menu ini anda dapat menginput penambahan license secara otimatis dan juga mudah. Kedepannya anda juga
                                bisa melihat list license anda.
                            </p>
                            <div class="mt-3">
                                {{-- <a href="#" role="button" class="btn-sm btn-success">Selengkapnya</a> --}}
                                <p class="text-muted">Cooming Soon</p>
                            </div>

                        </div>
                    </div>
                </div>
                <div class="row mb-4">
                    <div class="col-md-6">
                        <div class="w-100 h-100 p-5 services-card-shadow rounded-4"><img
                                src="{{ asset('img/gallery/expand.png') }}" alt="Comment" style="width:95px;" />
                            <h3 class="mt-3 lh-base">Renewal License</h3>
                            <p class="mb-0">Pada menu ini anda dapat memperbarui masa berlaku license anda. Anda juga bisa melihat list license anda cukup dengan 
                                scan ID card.
                            </p>
                            <div class="mt-3">
                                <a href="{{ url('/dashboard-renewal/list') }}" role="button"
                                    class="btn-sm btn-success">Selengkapnya</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="w-100 h-100 p-5 services-card-shadow rounded-4"><img
                                src="{{ asset('img/gallery/friend-request.png') }}" alt="Tailored"
                                style="width:95px;" />
                            <h3 class="mt-3 lh-base">Request Trainig</h3>
                            <p class="mb-0">Pada menu ini anda bisa request training secara daring. Sehingga memungkinkan anda untuk request tanpa
                                harus datang langsung ke training center.
                            </p>
                            <div class="mt-3">
                                {{-- <a href="#" role="button" class="btn-sm btn-success">Selengkapnya</a> --}}
                                <p class="text-muted">Cooming Soon</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- end of .container-->

        </section>
        <!-- <section> close ============================-->
        <!-- ============================================-->






        <p class="text-muted text-center">Training Center Departmen &copy; 2022</p>
    </main>
    <!-- ===============================================-->
    <!--    End of Main Content-->
    <!-- ===============================================-->




    <!-- ===============================================-->
    <!--    JavaScripts-->
    <!-- ===============================================-->
    <script src="{{ asset('main-screen/vendors/popper/popper.min.js') }}"></script>
    <script src="{{ asset('main-screen/vendors/popper/popper.min.js') }}"></script>
    <script src="{{ asset('main-screen/vendors/anchorjs/anchor.min.js') }}"></script>
    <script src="{{ asset('main-screen/vendors/is/is.min.js') }}"></script>
    <script src="{{ asset('main-screen/vendors/fontawesome/all.min.js') }}"></script>
    <script src="{{ asset('main-screen/vendors/lodash/lodash.min.js') }}"></script>
    <script src="https://polyfill.io/v3/polyfill.min.js?features=window.scroll"></script>
    <script src="{{ asset('js/gasp.min.js') }}"></script>
    <script src="{{ asset('main-screen/vendors/imagesloaded/imagesloaded.pkgd.js') }}"></script>
    <script src="{{ asset('main-screen/vendors/gsap/customEase.js') }}"></script>
    <script src="{{ asset('main-screen/vendors/gsap/scrollToPlugin.js') }}"></script>
    <!--script(src=`${CWD}vendors/gsap/drawSVGPlugin.js`)-->
    <script src="{{ asset('main-screen/assets/js/theme.js') }}"></script>

</body>

</html>
