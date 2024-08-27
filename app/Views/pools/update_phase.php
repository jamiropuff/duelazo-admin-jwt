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
            if (isset($response) && $response['matches_add'] != null){
              //echo "<pre>", var_dump($response['matches_add']), "</pre>";
              echo "Los partidos se agregaron exitosamente. <br>";
            }else{
              echo "Partidos sin actualizaciones <br>";
            }

            if (isset($response) && $response['tiebreakers_add'] != null){
              //echo "<pre>", var_dump($response['tiebreakers_add']), "</pre>";
              echo "Las preguntas nuevas se agregaron exitosamente. <br>";
            }else{
              echo "No hay preguntas nuevas <br>";
            }

            if (isset($response) && $response['tiebreakers_upd'] != null){
              //echo "<pre>", var_dump($response['tiebreakers_upd']), "</pre>";
              echo "Las preguntas se actualizaron exitosamente. <br>";
              
            }
            ?>
          </div>

        </div>

      </div>
    </div>
  </div>
</section>