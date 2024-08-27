<?php if (isset($resources)) : ?>
<?php $x = 1; ?>
<?php foreach ($resources->sports as $sports) : ?>
<?php 
if($x == 1){
  $sport_file_id = $sports->s3_file_id;
  $sport_id = $sports->id;
  $sport_file_exist = '';

  // Se busca la imagen en el servidor local de lo contrario se pide al API
  $img_sport = 'images/icons/'.$sports->s3_file_id.'.png';
  if (file_exists($img_sport)) {
    $sport_file_exist .= $sports->s3_file_id;
  }
}else{
  $sport_file_id .= ','.$sports->s3_file_id;
  $sport_id .= ','.$sports->id;

  // Se busca la imagen en el servidor local de lo contrario se pide al API
  $img_sport = 'images/icons/'.$sports->s3_file_id.'.png';
  if (file_exists($img_sport)) {
    $sport_file_exist .= ','.$sports->s3_file_id;
  }
}
$x++; 
?>
<?php endforeach ?>
<?php endif ?>


<section class="content">
  <div class="container-fluid">
    <div class="row justify-content-center">
      <div class="col-12">

        <div class="card">

          <div class="card-header">
            <div class="row">

              <div class="col-12 col-md-3 pad-top-32">
                <button class="btn btn-block btn-primary" data-toggle="modal" data-target="#modal-add"> <i class="fas fa-plus"></i> Agregar Partido</button>
              </div>
            </div>

            <hr>

            <div class="row">
              <div class="col-12 col-md-12 col-lg-8">
                <label>Deporte</label>
                <input type="hidden" id="resources_sport_file" value="<?= $sport_file_id ?>">
                <input type="hidden" id="resources_sport_file_exist" value="<?= $sport_file_exist ?>">
                <input type="hidden" id="resources_sport_id" value="<?= $sport_id ?>">
                <div id="resultSports" class="text-center">
                  <?php /*$x = 1; ?>
                  <?php //echo "<pre>", var_dump($resources), "</pre>";  ?>
                  <?php if (isset($resources)) : ?>
                    <?php foreach ($resources->sports as $sports) : ?>
                      <label class="cur-pointer" onclick="selectSport(<?= $sports->id ?>,'match')">
                        <img id="sport_img_<?= $sports->id ?>" src="<?= base_url() ?>/images/icons/<?= $sports->id ?>.png" class="img-fluid mrg-lr-10 sport" width="50px">
                      </label>
                      <?php $x++; ?>
                    <?php endforeach ?>
                  <?php endif */ ?>
                </div>
                <input type="hidden" id="sport_id_search" name="sport_id_search">
              </div>
              <div class="col-10 col-md-3">
                <label for="start_date_search">Fecha de búsqueda</label>
                <input type="date" id="start_date_search" name="start_date_search" class="form-control">
              </div>

              <div class="col-2 col-md-1 pad-top-32">
                <button type="button" id="btn-search" name="btn-search" class="form-control btn btn-dark" onclick="listarMatches()"><i class="fas fa-search"></i></button>
              </div>

            </div>
          </div>

          <div id="divMatches" class="card-body" style="overflow-x: scroll;">
            <!-- table-responsive p-0 -->
          </div>

        </div>

      </div>
    </div>
  </div>
</section>

<!-- modal add -->
<div class="modal fade" id="modal-add">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">

      <div class="modal-header">
        <h4 class="modal-title">Partidos</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <section class="content">
          <div class="container-fluid">
            <div class="row justify-content-center">

              <div class="col-12">

                <div id="card-bg-title" class="card card-primary">
                  <div class="card-header">
                    <h3 id="card-title" class="card-title">Agregar Partido</h3>
                  </div>

                  <form id="frmMatchAdd" method="post" action="" autocomplete="off">
                    <div class="card-body">

                      <div class="form-group">
                        <label>Deporte</label>
                        <div id="resultSportsAdd" class="form-check text-center">
                          <?php /*$x = 1; ?>
                          <?php if (isset($resources)) : ?>
                            <?php foreach ($resources->sports as $sports) : ?>
                              <label class="cur-pointer" onclick="selectSport(<?= $sports->id ?>,'match_add')">
                                <img id="sport_image_add_<?= $sports->id ?>" src="<?= base_url() ?>/images/icons/<?= $sports->id ?>.png" class="img-fluid mrg-lr-10 sport-add" width="50px">
                              </label>
                              <?php $x++; ?>
                            <?php endforeach ?>
                          <?php endif */ ?>
                        </div>
                        <input type="hidden" id="sport_id" name="sport_id">
                      </div>

                      <div class="form-group">
                        <label for="league_id">Liga *</label>
                        <select id="league_id" name="league_id" class="form-control select2" style="width: 100%;"></select>
                      </div>

                      <div class="form-group">
                        <label for="local_team">Equipo Local *</label>
                        <select id="local_team" name="local_team" class="form-control select2" style="width: 100%;"></select>
                      </div>

                      <div class="form-group">
                        <label for="visitor_team">Equipo Visitante *</label>
                        <select id="visitor_team" name="visitor_team" class="form-control select2" style="width: 100%;"></select>
                      </div>

                      <div class="form-group">
                        <label for="start_date">Fecha de Inicio *</label>
                        <input type="date" id="start_date" name="start_date" class="form-control" placeholder="10/10/2022">
                      </div>

                      <div class="form-group">
                        <label for="start_time">Horario de Inicio *</label>
                        <input type="time" id="start_time" name="start_time" class="form-control" placeholder="08:30:00">
                      </div>

                      <div class="form-group">
                        <label for="spread">Spread</label>
                        <input type="text" id="spread" name="spread" class="form-control" placeholder="Ej. 2.5 ó -3.5">
                      </div>

                    </div>



                  </form>

                </div>

              </div>
            </div>
        </section>
      </div>
      <div class="modal-footer justify-content-between">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
        <button type="button" class="btn btn-primary" onclick="saveMatches()">Agregar Partido</button>
      </div>

    </div>
  </div>
</div>


<!-- modal edit -->
<div class="modal fade" id="modal-edit">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">

      <div class="modal-header">
        <h4 class="modal-title">Partidos</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <section class="content">
          <div class="container-fluid">
            <div class="row justify-content-center">

              <div class="col-12">

                <div id="card-bg-title" class="card card-primary">
                  <div class="card-header">
                    <h3 id="card-title" class="card-title">Editar Partido</h3>
                  </div>

                  <form id="frmMatchEdit" method="post" action="" autocomplete="off">
                    <div class="card-body">

                      <div class="form-group">
                        <label>Deporte</label>
                        <div id="resultSportsEdit" class="form-check text-center">
                          <?php /*$x = 1; ?>
                          <?php if (isset($resources)) : ?>
                            <?php foreach ($resources->sports as $sports) : ?>
                              <label class="cur-pointer" onclick="selectSport(<?= $sports->id ?>,'match_edit')">
                                <img id="sport_image_edit_<?= $sports->id ?>" src="<?= base_url() ?>/images/icons/<?= $sports->id ?>.png" class="img-fluid mrg-lr-10 sport-edit" width="50px">
                              </label>
                              <?php $x++; ?>
                            <?php endforeach ?>
                          <?php endif */ ?>
                        </div>
                        <input type="hidden" id="sport_edit_id" name="sport_edit_id">
                      </div>

                      <div class="form-group">
                        <label for="league_edit_id">Liga</label>
                        <select id="league_edit_id" name="league_edit_id" class="form-control select2" style="width: 100%;"></select>
                        <input type="hidden" id="league_edit_id_old" name="league_edit_id_old">
                      </div>

                      <div class="form-group">
                        <label for="local_team_edit">Equipo Local</label>
                        <select id="local_team_edit" name="local_team_edit" class="form-control select2" style="width: 100%;"></select>
                        <input type="hidden" id="local_team_edit_old" name="local_team_edit_old">
                      </div>

                      <div class="form-group">
                        <label for="local_team_score">Score Local</label>
                        <input type="number" id="local_team_score" name="local_team_score" class="form-control" placeholder="Ej. 3">
                        <input type="hidden" id="local_team_score_old" name="local_team_score_old">
                      </div>

                      <div class="form-group">
                        <label for="visitor_team_edit">Equipo Visitante</label>
                        <select id="visitor_team_edit" name="visitor_team_edit" class="form-control select2" style="width: 100%;"></select>
                        <input type="hidden" id="visitor_team_edit_old" name="visitor_team_edit_old">
                      </div>

                      <div class="form-group">
                        <label for="visitor_team_score">Score Visitante</label>
                        <input type="number" id="visitor_team_score" name="visitor_team_score" class="form-control" placeholder="Ej. 2">
                        <input type="hidden" id="visitor_team_score_old" name="visitor_team_score_old">
                      </div>

                      <div class="form-group">
                        <label for="start_date_edit">Fecha de Inicio</label>
                        <input type="date" id="start_date_edit" name="start_date_edit" class="form-control" placeholder="10/10/2022">
                        <input type="hidden" id="start_date_edit_old" name="start_date_edit_old">
                      </div>

                      <div class="form-group">
                        <label for="start_time_edit">Horario de Inicio</label>
                        <input type="time" id="start_time_edit" name="start_time_edit" class="form-control" placeholder="08:30:00">
                        <input type="hidden" id="start_time_edit_old" name="start_time_edit_old">
                      </div>

                      <div class="form-group">
                        <label for="spread_edit">Spread</label>
                        <input type="text" id="spread_edit" name="spread_edit" class="form-control" placeholder="Ej. 2.5 ó -3.5">
                        <input type="hidden" id="spread_edit_old" name="spread_edit_old">
                      </div>

                      <div class="form-group">
                        <label for="status_edit">Estatus</label>
                        <input type="text" id="status_edit" name="status_edit" class="form-control" placeholder="Ej. open, running, finished, fase 1, fase 2">
                        <input type="hidden" id="status_edit_old" name="status_edit_old">
                      </div>

                      <div class="form-group">
                        <label for="result_edit">Resultado del partido</label>
                        <select id="result_edit" name="result_edit" class="form-control select2" style="width: 100%;">
                          <option value="">Seleccionar</option>
                          <option value="local">local</option>
                          <option value="visitor">visitor</option>
                          <option value="tie">tie</option>
                        </select>
                        <input type="hidden" id="result_edit_old" name="result_edit_old">
                      </div>

                    </div>

                    <input type="hidden" id="match_edit_id" name="match_edit_id">

                  </form>

                </div>

              </div>
            </div>
        </section>
      </div>
      <div class="modal-footer justify-content-between">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
        <button type="button" class="btn btn-primary" onclick="editMatches()">Guardar cambios</button>
      </div>

    </div>
  </div>
</div>