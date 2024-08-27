</div>
  <!-- /.content-wrapper -->

  <footer class="main-footer">
    <strong>Copyright &copy; 2022 </strong>
    All rights reserved.
    <div class="float-right d-none d-sm-inline-block">
      <b>Version</b> 1.0.0-rc
    </div>
  </footer>

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->

<!-- REQUIRED SCRIPTS -->

<!-- jQuery -->
<script src="<?= base_url() ?>/plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="<?= base_url() ?>/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- SweetAlert2 -->
<script src="<?= base_url() ?>/plugins/sweetalert2/sweetalert2.min.js"></script>
<!-- Select2 -->
<script src="<?= base_url() ?>/plugins/select2/js/select2.full.min.js"></script>
<!-- Bootstrap Switch -->
<script src="<?= base_url() ?>/plugins/bootstrap-switch/js/bootstrap-switch.min.js"></script>
<!-- DataTables  & Plugins -->
<script src="<?= base_url() ?>/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="<?= base_url() ?>/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="<?= base_url() ?>/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="<?= base_url() ?>/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script src="<?= base_url() ?>/plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
<script src="<?= base_url() ?>/plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
<script src="<?= base_url() ?>/plugins/jszip/jszip.min.js"></script>
<script src="<?= base_url() ?>/plugins/pdfmake/pdfmake.min.js"></script>
<script src="<?= base_url() ?>/plugins/pdfmake/vfs_fonts.js"></script>
<script src="<?= base_url() ?>/plugins/datatables-buttons/js/buttons.html5.min.js"></script>
<script src="<?= base_url() ?>/plugins/datatables-buttons/js/buttons.print.min.js"></script>
<script src="<?= base_url() ?>/plugins/datatables-buttons/js/buttons.colVis.min.js"></script>
<!-- jquery-validation -->
<script src="<?= base_url() ?>/plugins/jquery-validation/jquery.validate.min.js"></script>
<script src="<?= base_url() ?>/plugins/jquery-validation/additional-methods.min.js"></script>
<!-- AdminLTE -->
<script src="<?= base_url() ?>/js/adminlte.js"></script>
<!-- Page specific script -->
<script src="<?= base_url() ?>/js/main.js"></script>
<?php if($title == 'Partidos'): ?>
<script src="<?= base_url() ?>/js/matches.js"></script>
<?php endif ?>
<?php if($title == 'Brackets' || $title == 'Brackets Fase 2'): ?>
<script src="<?= base_url() ?>/js/brackets.js"></script>
<?php endif ?>
<?php if($title == 'Quinielas'): ?>
<script src="<?= base_url() ?>/js/pools.js"></script>
<?php endif ?>
<?php if($title == 'Usuarios' || $title == 'Verificación de Usuarios'): ?>
<script src="<?= base_url() ?>/js/users.js"></script>
<?php endif ?>
<?php if($title == 'Balance'): ?>
<script src="<?= base_url() ?>/js/balance.js"></script>
<?php endif ?>
<?php if($title == 'Rachas'): ?>
<script src="<?= base_url() ?>/js/streaks.js"></script>
<?php endif ?>

<script>
  $(function () {
    //Initialize Select2 Elements
    $('.select2').select2()

    //Initialize Select2 Elements
    $('.select2bs4').select2({
      theme: 'bootstrap4'
    })

    $("input[data-bootstrap-switch]").each(function(){
      $(this).bootstrapSwitch('state', $(this).prop('checked'));
    })
  })
</script>

</body>
</html>