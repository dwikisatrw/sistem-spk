<?php
if ($this->session->status !== ('Logged')) {
  redirect('login');
}
?>

<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>Sistem Pendukung Keputusan Metode SWARA SMART</title>

  <!-- Font Awesome -->
  <link href="<?= base_url('assets/vendor/fontawesome-free/css/all.min.css') ?>"
    rel="stylesheet"
    type="text/css">

  <!-- Google Font -->
  <link href="https://fonts.googleapis.com/css?family=Nunito:200,300,400,600,700,800,900"
    rel="stylesheet">

  <!-- CSS -->
  <link href="<?= base_url('assets/css/sb-admin-2.min.css') ?>"
    rel="stylesheet">

  <link href="<?= base_url('assets/vendor/datatables/dataTables.bootstrap4.min.css') ?>"
    rel="stylesheet">

  <!-- Favicon -->
  <link rel="icon"
    href="<?= base_url('assets/img/logo2.png') ?>"
    type="image/png">

</head>

<body id="page-top">

  <!-- Page Wrapper -->
  <div id="wrapper">

    <!-- Sidebar -->
    <ul class="navbar-nav bg-gradient-danger sidebar sidebar-dark accordion"
      id="accordionSidebar">

      <!-- Brand -->
      <a class="sidebar-brand d-flex align-items-center justify-content-center"
        href="<?= base_url('Login/home'); ?>">

        <div class="sidebar-brand-icon">
          <img src="<?= base_url('assets/img/logo.png') ?>"
            alt="Logo"
            style="width:45px; height:45px; object-fit:contain;">
        </div>

        <div class="sidebar-brand-text mx-2"
          style="font-size:11px; line-height:14px;">
          PT RADHIKA PATANGGA JAGADITHA
        </div>

      </a>

      <hr class="sidebar-divider my-0">

      <!-- Dashboard -->
      <li class="nav-item <?= ($page == 'Dashboard') ? 'active' : ''; ?>">
        <a class="nav-link" href="<?= base_url('Login/home'); ?>">
          <i class="fas fa-fw fa-home"></i>
          <span>Dashboard</span>
        </a>
      </li>

      <hr class="sidebar-divider">

      <div class="sidebar-heading">
        Master Data
      </div>

      <?php if ($this->session->userdata('id_user_level') == '1'): ?>

        <li class="nav-item <?= ($page == 'Kriteria') ? 'active' : ''; ?>">
          <a class="nav-link" href="<?= base_url('Kriteria'); ?>">
            <i class="fas fa-fw fa-cube"></i>
            <span>Data Kriteria</span>
          </a>
        </li>

        <li class="nav-item <?= ($page == 'Sub Kriteria') ? 'active' : ''; ?>">
          <a class="nav-link" href="<?= base_url('Sub_kriteria'); ?>">
            <i class="fas fa-fw fa-cubes"></i>
            <span>Data Sub Kriteria</span>
          </a>
        </li>

        <li class="nav-item <?= ($page == 'Alternatif') ? 'active' : ''; ?>">
          <a class="nav-link" href="<?= base_url('Alternatif'); ?>">
            <i class="fas fa-fw fa-users"></i>
            <span>Data Alternatif</span>
          </a>
        </li>
        <li class="nav-item <?= ($page == 'Penilaian' || $page == 'Penilaian Wawancara' || $page == 'Soal Wawancara') ? 'active' : ''; ?>">
          <a class="nav-link collapsed"
            href="#"
            data-toggle="collapse"
            data-target="#collapsePenilaian"
            aria-expanded="<?= ($page == 'Penilaian' || $page == 'Penilaian Wawancara' || $page == 'Soal Wawancara') ? 'true' : 'false'; ?>"
            aria-controls="collapsePenilaian">

            <i class="fas fa-fw fa-edit"></i>
            <span>Data Penilaian</span>
          </a>

          <div id="collapsePenilaian"
            class="collapse <?= ($page == 'Penilaian' || $page == 'Penilaian Wawancara' || $page == 'Soal Wawancara') ? 'show' : ''; ?>">

            <div class="bg-white py-2 collapse-inner rounded">

              <a class="collapse-item <?= ($page == 'Soal Wawancara') ? 'active' : ''; ?>"
                href="<?= base_url('Soal_wawancara'); ?>">
                Soal Wawancara
              </a>

              <a class="collapse-item <?= ($page == 'Penilaian') ? 'active' : ''; ?>"
                href="<?= base_url('Penilaian'); ?>">
                Penilaian Awal
              </a>

              <a class="collapse-item <?= ($page == 'Penilaian Wawancara') ? 'active' : ''; ?>"
                href="<?= base_url('Penilaian_wawancara'); ?>">
                Penilaian Wawancara
              </a>

            </div>
          </div>
        </li>

        <li class="nav-item <?= ($page == 'Perhitungan') ? 'active' : ''; ?>">
          <a class="nav-link" href="<?= base_url('Perhitungan'); ?>">
            <i class="fas fa-fw fa-calculator"></i>
            <span>Data Perhitungan</span>
          </a>
        </li>

        <li class="nav-item <?= ($page == 'Hasil Sementara') ? 'active' : ''; ?>">
          <a class="nav-link"
            href="<?= base_url('Perhitungan/hasil_sementara'); ?>">
            <i class="fas fa-fw fa-user-tie"></i>
            <span>Data Hasil Sementara</span>
          </a>
        </li>

        <li class="nav-item <?= ($page == 'Hasil') ? 'active' : ''; ?>">
          <a class="nav-link"
            href="<?= base_url('Perhitungan/hasil'); ?>">
            <i class="fas fa-fw fa-chart-area"></i>
            <span>Data Hasil Akhir</span>
          </a>
        </li>

      <?php endif; ?>

      <?php if ($this->session->userdata('id_user_level') == '2'): ?>

        <li class="nav-item <?= ($page == 'Hasil') ? 'active' : ''; ?>">
          <a class="nav-link"
            href="<?= base_url('Perhitungan/hasil'); ?>">
            <i class="fas fa-fw fa-chart-area"></i>
            <span>Data Hasil Akhir</span>
          </a>
        </li>

      <?php endif; ?>

      <hr class="sidebar-divider">

      <div class="sidebar-heading">
        Master User
      </div>

      <?php if ($this->session->userdata('id_user_level') == '1'): ?>

        <li class="nav-item <?= ($page == 'User') ? 'active' : ''; ?>">
          <a class="nav-link" href="<?= base_url('User'); ?>">
            <i class="fas fa-fw fa-users-cog"></i>
            <span>Data User</span>
          </a>
        </li>

      <?php endif; ?>

      <li class="nav-item <?= ($page == 'Profile') ? 'active' : ''; ?>">
        <a class="nav-link" href="<?= base_url('Profile'); ?>">
          <i class="fas fa-fw fa-user"></i>
          <span>Data Profile</span>
        </a>
      </li>

      <hr class="sidebar-divider d-none d-md-block">

      <!-- Sidebar Toggle -->
      <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0"
          id="sidebarToggle"></button>
      </div>

    </ul>
    <!-- End Sidebar -->

    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

      <!-- Main Content -->
      <div id="content">

        <!-- Topbar -->
        <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

          <!-- Sidebar Toggle -->
          <button id="sidebarToggleTop"
            class="btn text-danger d-md-none rounded-circle mr-3">

            <i class="fa fa-bars"></i>

          </button>

          <!-- Navbar -->
          <ul class="navbar-nav ml-auto">

            <li class="nav-item dropdown no-arrow">

              <a class="nav-link dropdown-toggle"
                href="#"
                id="userDropdown"
                role="button"
                data-toggle="dropdown"
                aria-haspopup="true"
                aria-expanded="false">

                <span class="text-uppercase mr-2 d-none d-lg-inline text-gray-600 small">
                  <?= $this->session->username; ?>
                </span>

                <img src="<?= base_url('assets/img/users.png') ?>"
                  class="img-profile rounded-circle">

              </a>

              <!-- Dropdown -->
              <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
                aria-labelledby="userDropdown">

                <a class="dropdown-item"
                  href="<?= base_url('Profile'); ?>">

                  <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                  Profile

                </a>

                <div class="dropdown-divider"></div>

                <a class="dropdown-item"
                  href="#"
                  data-toggle="modal"
                  data-target="#logoutModal">

                  <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                  Logout

                </a>

              </div>

            </li>

          </ul>

        </nav>
        <!-- End Topbar -->

        <div class="container-fluid">