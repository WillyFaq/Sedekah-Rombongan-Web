<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="A simple and basic Crowdfunding Platform">
    <meta name="author" content="sedekaholic">
    <meta property="og:title" content="Sedekah Rombongan - Berkhidmat Untuk Dhuafa Sakit" />
    <meta property="og:description"
        content="Sedekah Rombongan Adalah Gerakan Sosial Berbasis Kerelawanan Untuk Mendampingi Para Dhuafa yang Berikhtiar Menjemput Kesembuhannya" />
    <meta property="og:url" content="https://sedekahrombongan.com/" />
    <meta property="og:site_name" content="Sedekah Rombongan" />
    <meta property="og:image"
        content="https://sedekahrombongan.com/wp-content/uploads/2021/12/profil-sedekah-rombongan.jpeg" />
    <meta property="og:image:width" content="650" />
    <meta property="og:image:height" content="350" />
    <meta property="og:image:type" content="image/jpeg" />
    <meta name="twitter:card" content="summary_large_image" />
    <link rel="icon" type="image/x-icon" href="{{ asset('assets/imgs/icon-32.png') }}">
    <title>
        @isset($page_title)
            {{ $page_title . ' | ' }}
        @endisset
        Sedekah Rombongan - Berkhidmat Untuk Dhuafa Sakit
    </title>
    <!-- Custom fonts for this template-->
    <link href="{{ asset('assets/vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">
    <!-- Custom styles for this template-->
    <link href="{{ asset('assets/css/sb-admin-2.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/style.css') }}" rel="stylesheet">

    <!-- Custom styles for this page -->
    <link href="{{ asset('assets/vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
</head>

<body id="page-top">
    <div id="wrapper">
        <x-sidebar></x-sidebar>
        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">
            <!-- Main Content -->
            <x-topbar></x-topbar>
            <div id="content" class="d-flex flex-column">
                <div class="container-fluid">
                    {{ $slot }}
                </div>

                <!-- Footer -->
                <footer class="sticky-footer bg-white">
                    <div class="container my-auto">
                        <div class="copyright text-center my-auto">
                            <span>Copyright &copy; Sedekaholic 2024</span>
                        </div>
                    </div>
                </footer>
                <!-- End of Footer -->
            </div>
        </div>
    </div>
    @if (session()->has('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>Sukses!</strong> {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    <!-- Bootstrap core JavaScript-->
    <script src="{{ asset('assets/vendor/jquery/jquery.min.js') }}"></script>
    {{-- <script src="assets/vendor/bootstrap/js/popper.min.js"></script> --}}
    <script src="{{ asset('assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

    <!-- Core plugin JavaScript-->
    <script src="{{ asset('assets/vendor/jquery-easing/jquery.easing.min.js') }}"></script>

    <!-- Custom scripts for all pages-->
    <script src="{{ asset('assets/js/sb-admin-2.min.js') }}"></script>

    <!-- Page level plugins -->
    <script src="{{ asset('assets/vendor/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/datatables/dataTables.bootstrap4.min.js') }}"></script>
    <script>
        // const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]')
        // const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(
        //     tooltipTriggerEl))
        $(document).ready(function() {
            $('[data-toggle="tooltip"]').tooltip()
            $('.dataTable').DataTable()

            setTimeout(() => {
                $('.alert').alert('close')
            }, 3000);
        });
    </script>
</body>

</html>
