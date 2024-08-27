<section class="content">
  <div class="container-fluid">
    <div class="row justify-content-center">
      <div class="col-12">

        <div class="card">

          <div class="card-header">
            <div class="row">
              <div class="col-md-3">
                <a href="<?= base_url() ?>/pools" class="btn btn-dark"> <i class="fas fa-angle-double-left"></i> Regresar a las quinielas</a>
              </div>
            </div>

          </div>

          <div class="card-body">
            <?php //echo "<pre>", var_dump($response), "</pre>"; ?>
            <?php 
            if (isset($response) && $response != null){
              echo "El registro fue actualizado exitosamente.";
            }else{
              echo "Registro sin actualizaciones";
            }
            ?>
          </div>

        </div>

      </div>
    </div>
  </div>
</section>