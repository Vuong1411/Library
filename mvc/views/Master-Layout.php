<!DOCTYPE html>
<html lang="en">

<?php require_once "./mvc/views/inc/head.php"; ?>

<body class="g-sidenav-show bg-gray-100">

    <!-- Page Wrapper -->
    <div class="min-height-300 bg-primary position-absolute w-100"></div>
    <div id="wrapper">

        <!-- Sidebar -->
        <?php require_once "./mvc/views/inc/sidebar1.php"; ?>
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <main class="main-content position-relative border-radius-lg ">

            <!-- Header -->
            <?php require_once "./mvc/views/inc/header.php"; ?>
            <!-- End of Header -->
            
            <!-- Main Content -->
            <div class="container-fluid py-4">
                <?php require_once "./mvc/views/pages/".$data["page"].".php"; ?>
            </div>
            <!-- End of Main Content -->

            <!-- Footer -->
            <?php require_once "./mvc/views/inc/footer.php"; ?>
            <!-- End of Footer -->

        </main>
        <!-- End of Content Wrapper -->

        <!-- Plugin -->
        <?php require_once "./mvc/views/inc/plugin.php"; ?>
        <!-- End of Plugin -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scrip -->
    <?php require_once "./mvc/views/inc/script.php"; ?>
    <!-- End of Script -->

</body>

</html>