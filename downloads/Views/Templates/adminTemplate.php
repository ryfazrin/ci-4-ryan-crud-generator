<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Ryris is a Food Delivery App.">
    <meta name="author" content="ryfazrin">

    <title><?= isset($title)? $title : "Ryris Admin" ?></title>

    <!-- Custom fonts for this template-->
    <?= link_tag('assets/vendor/fontawesome-free/css/all.min.css'); ?>
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <!-- Custom styles for this template-->
    <?= link_tag('assets/css/sb-admin-2.min.css'); ?>
    
    <?= link_tag('assets/vendor/datatables/dataTables.bootstrap4.min.css'); ?>
    <?= link_tag('assets/vendor/datatables/responsive.bootstrap4.min.css'); ?>

    <?= link_tag('assets/vendor/sweetalert2/sweetalert2.min.css'); ?>
	
    <!-- Custom styles for this page -->
    <?= $this->renderSection('css') ?>
</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
            <?= $this->include('Templates\sideMenu') ?>
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                    <?= $this->include('Templates\header') ?>
                <!-- End of Topbar -->

                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <?= $this->renderSection('content') ?>

                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

            <!-- Footer -->
            <footer class="sticky-footer bg-white">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto">
                        <span>Copyright &copy; Admin Ryris 2021</span>
                    </div>
                </div>
            </footer>
            <!-- End of Footer -->

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <!-- Logout Modal-->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    <a class="btn btn-primary" href="login.html">Logout</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap core JavaScript-->
    <?= script_tag('assets/vendor/jquery/jquery.min.js'); ?>
    <?= script_tag('assets/vendor/bootstrap/js/bootstrap.bundle.min.js'); ?>

    <!-- Core plugin JavaScript-->
    <?= script_tag('assets/vendor/jquery-validation/jquery.validate.min.js'); ?>
    <?= script_tag('assets/vendor/jquery-validation/additional-methods.min.js'); ?>
    <?= script_tag('assets/vendor/jquery-easing/jquery.easing.min.js'); ?>

	  <!-- Page level plugins -->
    <?= script_tag('assets/vendor/datatables/jquery.dataTables.min.js'); ?>
    <?= script_tag('assets/vendor/datatables/dataTables.bootstrap4.min.js'); ?>
    <?= script_tag('assets/vendor/datatables/dataTables.responsive.min.js'); ?>
    <?= script_tag('assets/vendor/datatables/responsive.bootstrap4.min.js'); ?>

    <!-- sweetalert2 core JavaScript -->
    <?= script_tag('assets/vendor/sweetalert2/sweetalert2.min.js'); ?>

    <!-- Custom scripts for all pages-->
    <?= script_tag('assets/js/sb-admin-2.min.js'); ?>

    <!-- Custom scripts -->
    <?= $this->renderSection('javascript'); ?>

</body>

</html>