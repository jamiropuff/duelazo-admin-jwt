<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Duelazo : Admin</title>

  <!-- Favicon -->
  <link rel="icon" href="<?= base_url() ?>/images/logo-d.png">
  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome Icons -->
  <link rel="stylesheet" href="<?= base_url() ?>/plugins/fontawesome-free/css/all.min.css">
  <!-- iCheck for checkboxes and radio inputs -->
  <link rel="stylesheet" href="<?= base_url() ?>/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- SweetAlert2 -->
  <link rel="stylesheet" href="<?= base_url() ?>/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">
  <!-- Select2 -->
  <link rel="stylesheet" href="<?= base_url() ?>/plugins/select2/css/select2.min.css">
  <link rel="stylesheet" href="<?= base_url() ?>/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">
  <!-- DataTables -->
  <link rel="stylesheet" href="<?= base_url() ?>/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" href="<?= base_url() ?>/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
  <link rel="stylesheet" href="<?= base_url() ?>/plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="<?= base_url() ?>/css/adminlte.css">

  <!-- Custom style -->
  <link rel="stylesheet" href="<?= base_url() ?>/css/custom.css">
</head>
<body class="hold-transition sidebar-mini layout-fixed">

  <div class="wrapper pos-rel">
    
    <div id="loading1" class="loading-invisible" style="display:none;">
      <div class="loading-spinner">
        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" style="margin:auto;background:none;display:block;" width="200px" height="200px" viewBox="0 0 100 100" preserveAspectRatio="xMidYMid">
        <path fill="none" stroke="#191642" stroke-width="8" stroke-dasharray="32.07361602783203 32.07361602783203" d="M24.3 30C11.4 30 5 43.3 5 50s6.4 20 19.3 20c19.3 0 32.1-40 51.4-40 C88.6 30 95 43.3 95 50s-6.4 20-19.3 20C56.4 70 43.6 30 24.3 30z" stroke-linecap="round" style="transform:scale(0.8);transform-origin:50px 50px">
        <animate attributeName="stroke-dashoffset" repeatCount="indefinite" dur="1.5873015873015872s" keyTimes="0;1" values="0;256.58892822265625"></animate>
        </path>
        </svg>
        <span id="loadig-text-1" class="loading-text c-white">Procesando, espere un momento....</span>
      </div>
    </div>

    <div id="loading2" class="loading-invisible" style="display:none;">
      <div class="loading-spinner">
        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" style="margin: auto; background: none; display: block; shape-rendering: auto;" width="204px" height="204px" viewBox="0 0 100 100" preserveAspectRatio="xMidYMid">
        <circle cx="50" cy="50" r="0" fill="none" stroke="#013369" stroke-width="3">
          <animate attributeName="r" repeatCount="indefinite" dur="1.282051282051282s" values="0;40" keyTimes="0;1" keySplines="0 0.2 0.8 1" calcMode="spline" begin="0s"></animate>
          <animate attributeName="opacity" repeatCount="indefinite" dur="1.282051282051282s" values="1;0" keyTimes="0;1" keySplines="0.2 0 0.8 1" calcMode="spline" begin="0s"></animate>
        </circle><circle cx="50" cy="50" r="0" fill="none" stroke="#00263d" stroke-width="3">
          <animate attributeName="r" repeatCount="indefinite" dur="1.282051282051282s" values="0;40" keyTimes="0;1" keySplines="0 0.2 0.8 1" calcMode="spline" begin="-0.641025641025641s"></animate>
          <animate attributeName="opacity" repeatCount="indefinite" dur="1.282051282051282s" values="1;0" keyTimes="0;1" keySplines="0.2 0 0.8 1" calcMode="spline" begin="-0.641025641025641s"></animate>
        </circle>
        <!-- [ldio] generated by https://loading.io/ --></svg>
        <span id="loadig-text-2" class="loading-text c-white">Procesando, espere un momento....</span>
      </div>
    </div>