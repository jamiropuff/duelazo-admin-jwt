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
                                <button class="btn btn-block btn-primary" data-toggle="modal" data-target="#modal-add-1"> <i class="fas fa-plus"></i> Crear Racha</button>
                            </div>
                        </div>
                    </div>

                    <div id="divStreak" class="card-body" style="overflow-x: scroll;">
                        <!-- table-responsive p-0 -->
                        <table id="tblStreak" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>Título</th>
                                    <th class="text-center">Status</th>
                                    <th class="text-center">Fecha</th>
                                    <th class="text-center">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php //echo "<pre>", var_dump($streaks), "</pre>";  ?>
                                <?php if (isset($streaks)) : ?>
                                    <?php foreach ($streaks as $rachas) : ?>
                                        <?php
                                        if (isset($rachas->status)) {
                                            switch ($rachas->status) {
                                                case 'open':
                                                $_color_status1 = 'c-green';
                                                $_color_status2 = 'c-gray-light';
                                                $_color_status3 = 'c-gray-light';
                                                $_icon_status = '<i class="fas fa-lock-open"></i>';
                                                $_texto_status = 'abierta';
                                                break;

                                                case 'running':
                                                $_color_status1 = 'c-green';
                                                $_color_status2 = 'c-blue';
                                                $_color_status3 = 'c-gray-light';
                                                $_icon_status = '<i class="fas fa-lock-open"></i>';
                                                $_texto_status = 'en curso';
                                                break;

                                                case 'finished':
                                                $_color_status1 = 'c-green';
                                                $_color_status2 = 'c-blue';
                                                $_color_status3 = 'c-red';
                                                $_icon_status = '<i class="fas fa-lock"></i>';
                                                $_texto_status = 'finalizada';
                                                break;

                                                default:
                                                $_color_status1 = 'c-gray-light';
                                                $_color_status2 = 'c-gray-light';
                                                $_color_status3 = 'c-gray-light';
                                                $_icon_status = '<i class="fas fa-lock-open"></i>';
                                                $_texto_status = 'abierta';
                                                break;
                                            } // switch
                                        } // if
                                        ?>
                                        <tr id="row_<?= $rachas->id; ?>">
                                            <td><?= $rachas->title ?></td>
                                            <td class="text-center">
                                                <i class="fas fa-circle <?= $_color_status1 ?>"></i><i class="fas fa-minus <?= $_color_status2 ?>"></i><i class="fas fa-circle <?= $_color_status2 ?>"></i><i class="fas fa-minus <?= $_color_status3 ?>"></i><i class="fas fa-circle <?= $_color_status3 ?>"></i><br>
                                                <?= $_texto_status ?>
                                            </td>
                                            <td class="text-center"><?= $rachas->start_date ?></td>
                                            <td class="text-center">
                                                <button class="btn" title="agregar rachas" onclick="nextModalStreaks('',3,<?= $rachas->id; ?>)"><i class="fas fa-tshirt"></i></button>
                                                <button class="btn" title="personalizadas" onclick="personalizeModalStreaks(<?= $rachas->id; ?>)"><i class="far fa-star"></i></button>
                                                <a href="streaks/list/<?= $rachas->id; ?>" class="btn" title="ver rachas"><i class="far fa-eye"></i></a>
                                                <button class="btn" title="editar torneo" onclick="modalEditTournament(<?= $rachas->id; ?>,'<?= $rachas->sponsor_id; ?>','<?= $rachas->title; ?>','<?= $rachas->subtitle; ?>','<?= $rachas->start_date; ?>','<?= $rachas->end_date; ?>')"><i class="fas fa-pencil-alt"></i></button>
                                                <button class="btn" onclick="delStreaksTournament(<?= $rachas->id ?>)" title="eliminar"><i class="far fa-trash-alt"></i></button>
                                            </td>
                                        </tr>
                                    <?php endforeach ?>
                                <?php endif ?>
                            </tbody>
                        </table>
                    </div>

                </div>

            </div>
        </div>
    </div>
</section>


<form id="frmStreaksAdd" method="post" action="<?= base_url(); ?>/streaks/save" autocomplete="off">

  <!-- modal add - Step 1 -->
  <div class="modal fade" id="modal-add-1">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">

        <div class="modal-header">
          <h4 class="modal-title">Rachas</h4>
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
                      <h3 id="card-title" class="card-title">Crear Racha (1/3)</h3>
                    </div>


                    <div class="card-body">

                      <div class="form-group">
                        <label>Patrocinador</label>
                        <div class="form-check text-center">
                          <?php $x = 1; ?>
                          <?php if (isset($resources)) : ?>
                            <?php foreach ($resources->sponsors as $sponsors) : ?>
                              <label class="cur-pointer" onclick="selectSponsor(<?= $sponsors->id ?>,<?= $sponsors->s3_file_id ?>,'add')">
                                <img id="sponsor_image_add_<?= $sponsors->s3_file_id ?>" src="<?= base_url() ?>/images/sponsors/<?= $sponsors->s3_file_id ?>.png" class="img-fluid mrg-lr-10 sponsor-add" width="70px">
                              </label>
                              <?php $x++; ?>
                            <?php endforeach ?>
                          <?php endif ?>
                        </div>
                        <input type="hidden" id="sponsor_add_id" name="sponsor_id">
                        <input type="hidden" id="sponsor_add_image" name="sponsor_image">
                      </div>

                      <div class="form-group">
                        <label for="titulo">Título</label>
                        <input type="text" id="titulo" name="titulo" class="form-control" placeholder="Título">
                      </div>

                      <div class="form-group">
                        <label for="subtitulo">Subtítulo</label>
                        <input type="text" id="subtitulo" name="subtitulo" class="form-control" placeholder="Subtítulo">
                      </div>

                      <div class="row">
                        <div class="col-6">
                          <div class="form-group">
                            <label for="fecha_inicio">Fecha de inicio</label>
                            <input type="date" id="fecha_inicio" name="fecha_inicio" class="form-control">
                          </div>
                        </div>
                        <div class="col-6">
                          <div class="form-group">
                            <label for="horario_inicio">Horario de inicio</label>
                            <input type="time" id="horario_inicio" name="horario_inicio" class="form-control">
                          </div>
                        </div>
                      </div>

                      <div class="row">
                        <div class="col-6">
                          <div class="form-group">
                            <label for="fecha_fin">Fecha de finalización</label>
                            <input type="date" id="fecha_fin" name="fecha_fin" class="form-control">
                          </div>
                        </div>
                        <div class="col-6">
                          <div class="form-group">
                            <label for="horario_fin">Horario de finalización</label>
                            <input type="time" id="horario_fin" name="horario_fin" class="form-control">
                          </div>
                        </div>
                      </div>

                      <div class="form-group">
                        <label for="multiplicador">Multiplicador</label>
                        <input type="text" id="multiplicador" name="multiplicador" class="form-control" placeholder="1" value="1">
                      </div>


                    </div>

                  </div>

                </div>
              </div>
            </div>
          </section>
        </div>

        <div class="modal-footer justify-content-between">
          <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
          <button type="button" class="btn btn-primary" onclick="nextModalAdd(1,2)">Siguiente</button>
        </div>

      </div>
    </div>
  </div>

    <!-- modal add - Step 2 -->
    <div class="modal fade" id="modal-add-2">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">

          <div class="modal-header">
              <h4 class="modal-title">Rachas</h4>
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
                        <h3 id="card-title" class="card-title">Crear Racha (2/3)</h3>
                      </div>


                      <div class="card-body">

                        <div class="form-group">
                          <label for="total_awards">Total de premios</label>
                          <input type="text" id="total_awards" name="total_awards" class="form-control" placeholder="200">
                        </div>
                        <div class="form-group">
                          <label>Cantidad: <span id="cantidad_award"></span></label>
                          <input type="hidden" id="awards" name="awards">
                        </div>
                        <div class="form-group">
                          <button type="button" class="btn btn-info" onclick="createAwards('add')">Generar Premios</button>
                        </div>

                        <div class="form-group">
                          <button type="button" class="btn btn-dark mrg-top-10" onclick="addAward(10,'add')">$10</button> 
                          <button type="button" class="btn btn-dark mrg-top-10" onclick="addAward(25,'add')">$25</button> 
                          <button type="button" class="btn btn-dark mrg-top-10" onclick="addAward(50,'add')">$50</button> 
                          <button type="button" class="btn btn-dark mrg-top-10" onclick="addAward(75,'add')">$75</button> 
                          <button type="button" class="btn btn-dark mrg-top-10" onclick="addAward(100,'add')">$100</button> 
                          <button type="button" class="btn btn-dark mrg-top-10" onclick="addAward(125,'add')">$125</button> 
                          <button type="button" class="btn btn-dark mrg-top-10" onclick="addAward(150,'add')">$150</button> 
                          <button type="button" class="btn btn-dark mrg-top-10" onclick="addAward(175,'add')">$175</button> 
                          <button type="button" class="btn btn-dark mrg-top-10" onclick="addAward(200,'add')">$200</button> 
                          <button type="button" class="btn btn-dark mrg-top-10" onclick="addAward(250,'add')">$250</button> 
                          <button type="button" class="btn btn-dark mrg-top-10" onclick="addAward(300,'add')">$300</button> 
                          <button type="button" class="btn btn-dark mrg-top-10" onclick="addAward(400,'add')">$400</button> 
                          <button type="button" class="btn btn-dark mrg-top-10" onclick="addAward(500,'add')">$500</button> 
                          <button type="button" class="btn btn-dark mrg-top-10" onclick="addAward(750,'add')">$750</button> 
                          <button type="button" class="btn btn-dark mrg-top-10" onclick="addAward(1000,'add')">$1000</button> 
                          <button type="button" class="btn btn-dark mrg-top-10" onclick="addAward(1500,'add')">$1500</button> 
                          <button type="button" class="btn btn-dark mrg-top-10" onclick="addAward(2000,'add')">$2000</button> 
                          <button type="button" class="btn btn-dark mrg-top-10" onclick="addAward(2500,'add')">$2500</button> 
                          <button type="button" class="btn btn-dark mrg-top-10" onclick="addAward(3000,'add')">$3000</button> 
                          <button type="button" class="btn btn-dark mrg-top-10" onclick="addAward(3500,'add')">$3500</button> 
                        </div>

                        <input type="hidden" id="lugar_add" name="lugar_add">

                      </div>

                      <div class="card-body">

                        <table id="tblMatchAwardsAdd" class="table table-bordered table-striped">
                          <thead>
                            <tr>
                              <th>Lugar</th>
                              <th>Cantidad</th>
                              <th>Premio</th>
                            </tr>
                          </thead>
                          <tbody></tbody>
                        </table>

                      </div>

                    </div>

                  </div>
                </div>
              </div>
            </section>
          </div>

          <div class="modal-footer justify-content-between">
            <button type="button" class="btn btn-dark" onclick="nextModalAdd(2,1)">Atras</button>
            <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
            <button type="button" class="btn btn-primary" onclick="nextModalAdd(2,5)">Siguiente</button>
          </div>

        </div>
      </div>
    </div>

  <!-- modal add - Step 5 -->
  <div class="modal fade" id="modal-add-5">
    <div class="modal-dialog modal-xl">
      <div class="modal-content">

        <div class="modal-header">
          <h4 class="modal-title">Rachas</h4>
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
                      <h3 id="card-title" class="card-title">Crear Racha (3/3)</h3>
                    </div>

                    <div class="card-body">

                      <label>Test: </label>
                      <input type="checkbox" id="test" name="test" checked data-bootstrap-switch data-off-color="danger" data-on-color="success"> 

                      <div class="row mrg-top-20">
                        <div class="col-12 col-md-6">
                            <div class="form-group">
                                <label>Titulo: <span id="titulo_resume" class="text-normal"></span></label>
                            </div>
                            <div class="form-group">
                                <label>Subtítulo: <span id="subtitulo_resume" class="text-normal"></span></label>
                            </div>
                            <div class="form-group">
                                <label>Inicio: <span id="fecha_inicio_resume" class="text-normal"></span> | <span id="fecha_fin_resume" class="text-normal"></span></label>
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                          <div class="form-group">
                            <label>Patrocinador:</label>
                            <img id="sponsor_image_add_resume" src="<?= base_url() ?>/images/sponsors/" class="img-fluid mrg-lr-10" width="70px">
                          </div>
                          <div class="form-group">
                            <label>Deporte:</label>
                            <img id="sport_image_add_resume" src="<?= base_url() ?>/images/icons/" class="img-fluid mrg-lr-10" width="50px">
                          </div>
                        </div>
                      </div>


                      <div class="row">
                     

                        <div class="col-12 col-md-6">
                          <h2 class="text-center">Premios</h2>
                          <table id="premios_resume" class="table">
                            <thead>
                              <tr>
                                <th>Premios
                                <th>
                              </tr>
                            </thead>
                            <tbody></tbody>
                          </table>
                        </div>
                      </div>


                    </div>

                  </div>

                </div>
              </div>
            </div>
          </section>
        </div>

        <div class="modal-footer justify-content-between">
          <button type="button" class="btn btn-dark" onclick="nextModalAdd(5,2)">Atras</button>
          <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
          <button type="button" class="btn btn-primary" onclick="save()">Crear Racha</button>
        </div>

      </div>
    </div>
  </div>
</form>


<!-- ************************************************************************************************************************************** -->
<form id="frmStreaksTemplates" method="post" action="<?= base_url(); ?>/streaks/save_templates" autocomplete="off">
  <!-- modal partidos - Step 3 -->
  <div class="modal fade" id="modal-streaks-3">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">

        <div class="modal-header">
          <h4 class="modal-title">Rachas</h4>
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
                      <h3 id="card-title" class="card-title">Agregar o Actualizar Partidos (1/3)</h3>
                    </div>


                    <div class="card-body">

                    <input type="hidden" name="matches_status" id="matches_status">
                    <input type="hidden" name="tournament_id" id="tournament_id">

                      <div class="form-group">
                        <label>Deporte</label>
                        <div class="text-center">
                          <?php $x = 1; ?>
                          <?php if (isset($resources)) : ?>
                            <?php foreach ($resources->sports as $sports) : ?>
                              <?php //if ($x <= 9) : ?>
                                <label class="cur-pointer" onclick="selectSportModal(<?= $sports->id ?>,'phases')">
                                    <img id="sport_image_search_<?= $sports->id ?>_phases" src="<?= base_url() ?>/images/icons/<?= $sports->id ?>.png" class="img-fluid mrg-lr-10 sport-search-phases" width="50px">
                                </label>
                                <?php $x++; ?>
                              <?php //endif ?>
                            <?php endforeach ?>
                          <?php endif ?>
                        </div>
                        <input type="hidden" id="sport_id_search_phases" name="sport_id_search_phases">
                      </div>
                      <div class="row">
                        <div class="col-6">
                          <div class="form-group">
                            <label for="league_id_phases">Liga</label>
                            <select id="league_id_phases" name="league_id_phases" class="form-control select2" style="width: 100%;"></select>
                            <input type="hidden" id="league_id_phases_old" name="league_id_phases_old" class="form-control">
                          </div>
                        </div>
                        <div class="col-6">
                          <div class="form-group">
                            <label for="start_date_search_phases">Fecha de búsqueda</label>
                            <input type="date" id="start_date_search_phases" name="start_date_search_phases" class="form-control">
                            <input type="hidden" id="start_date_search_phases_old" name="start_date_search_phases_old" class="form-control">
                          </div>
                        </div>
                      </div>
                      <div class="form-group">
                          <button type="button" id="btn-search-phases" name="btn-search-phases" class="form-control btn btn-dark" onclick="listarBracketsMatches('Phases')"><i class="fas fa-search"></i> Buscar</button>
                      </div>

                    </div>

                    <!-- Partidos ya creados -->
                    <div id="divBracketsMatchesPhasesEdit" class="card-body">
                      <table id="tblBracketsMatchesPhasesEdit" class="table table-bordered table-striped">
                          <thead>
                              <tr>
                                  <th>Seleccionar</th>
                                  <th>Liga</th>
                                  <th>Local</th>
                                  <th>Visitante</th>
                                  <th>Fecha</th>
                              </tr>
                          </thead>
                          <tbody>
                          </tbody>
                      </table>
                    </div>

                    <!-- Nueva búsqueda para agregar partidos -->
                    <div id="divBracketsMatchesPhases" class="card-body">

                    </div>


                  </div>

                </div>
              </div>
            </div>
          </section>
        </div>

        <div class="modal-footer justify-content-between">
          <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
          <button type="button" class="btn btn-primary" onclick="nextModalStreaks(3,4)">Siguiente</button>
        </div>

      </div>
    </div>
  </div>

    <!-- modal partidos - Step 4 -->
    <div class="modal fade" id="modal-streaks-4">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">

                <div class="modal-header">
                    <h4 class="modal-title">Rachas</h4>
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
                                            <h3 id="card-title" class="card-title">Agregar o Actualizar Partidos (1/3)</h3>
                                        </div>

                                        <div class="card-body scroll-horizontal">
                                            <table id="tblBracketsGroup" class="table table-bordered table-striped">
                                                <thead>
                                                    <tr>
                                                        <th>Deporte</th>
                                                        <th>Liga</th>
                                                        <th>Local</th>
                                                        <th>Visitante</th>
                                                        <th>Fecha</th>
                                                        <th>Template</th>
                                                        <th>VIP</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                </tbody>
                                            </table>
                                        </div>

                                    </div>

                                </div>
                            </div>
                        </div>
                    </section>
                </div>

                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-dark" onclick="nextModalStreaks(4,3)">Atras</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                    <button type="button" class="btn btn-primary" onclick="saveTemplates()">Guardar</button>
                </div>

            </div>
        </div>
    </div>
</form>

<!-- ************************************************************************************************************************************** -->

<!-- modal add - Physical Awards -->
<div class="modal fade" id="modal-physical-award">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">

            <div class="modal-header">
                <h4 class="modal-title">Premio Físico</h4>
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
                                        <h3 id="card-title" class="card-title">Seleccioanr premio físico</h3>
                                    </div>

                                    <div class="card-body">

                                        <table id="tblPhysicalAwardsAdd" class="table table-bordered table-striped">
                                            <thead>
                                                <tr>
                                                    <th>Foto</th>
                                                    <th>Premio</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php $x = 1; ?>
                                                <?php //echo "<pre>", var_dump($resources), "</pre>"; 
                                                ?>
                                                <?php if (isset($resources)) : ?>
                                                    <?php foreach ($resources->physical_awards as $physical_awards) : ?>
                                                        <tr>
                                                            <td>
                                                                <img src="<?= base_url() . '/images/physical_awards/' . $physical_awards->s3_file_id ?>.png" class="img-fluid cur-pointer" width="50" onclick="selectAwardAdd(<?= $physical_awards->id ?>,'<?= $physical_awards->title ?>')">
                                                            </td>
                                                            <td><?= $physical_awards->title ?></td>
                                                        </tr>
                                                        <?php $x++; ?>
                                                    <?php endforeach ?>
                                                <?php endif ?>
                                            </tbody>
                                        </table>

                                        <input type="hidden" id="inputAwardID" name="inputAwardID">

                                    </div>

                                </div>

                            </div>
                        </div>
                    </div>
                </section>
            </div>

        </div>
    </div>
</div>

<!-- modal templates -->
<div class="modal fade" id="modal-templates">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">

            <div class="modal-header">
                <h4 class="modal-title">Rachas</h4>
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
                                        <h3 id="card-title" class="card-title">Selecciona los templates que deseas agregar</h3>
                                    </div>

                                    <div class="card-body">
                                      <input type="hidden" id="templates_sport_id" name="templates_sport_id" value="">
                                      <input type="hidden" id="templates_match_id" name="templates_match_id" value="">
                                        <table id="tblTemplates" class="table table-bordered table-striped">
                                            <thead>
                                                <tr>
                                                    <th>Seleccionar</th>
                                                    <th>Pregunta</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            </tbody>
                                        </table>
                                    </div>

                                </div>

                            </div>
                        </div>
                    </div>
                </section>
            </div>

            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-primary" onclick="addTemplates()">Agregar</button>
            </div>

        </div>
    </div>
</div>


<!-- modal - rachas personalizadas -->
<div class="modal fade" id="modal-personalize">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">

            <div class="modal-header">
                <h4 class="modal-title">Rachas</h4>
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
                                        <h3 id="card-title" class="card-title">Racha Personalizada</h3>
                                    </div>


                                    <div class="card-body">

                                        <div class="form-group">
                                            <input type="hidden" id="streak_id_fav" name="streak_id_fav">
                                        </div>

                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-12">
                                                    <label for="local_text">Deporte</label>
                                                    <input type="hidden" id="resources_sport_file" value="<?= $sport_file_id ?>">
                                                    <input type="hidden" id="resources_sport_file_exist" value="<?= $sport_file_exist ?>">
                                                    <input type="hidden" id="resources_sport_id" value="<?= $sport_id ?>">
                                                    <div id="resultSports" class="text-center">
                                                      <?php $x = 1; ?>
                                                      <?php //echo "<pre>", var_dump($resources), "</pre>";  ?>
                                                      <?php if (isset($resources)) : ?>
                                                        <?php foreach ($resources->sports as $sports) : ?>
                                                          <label class="cur-pointer" onclick="selectSport(<?= $sports->id ?>,'match')">
                                                            <img id="sport_img_<?= $sports->id ?>" src="<?= base_url() ?>/images/icons/<?= $sports->id ?>.png" class="img-fluid mrg-lr-10 sport" width="50px">
                                                          </label>
                                                          <?php $x++; ?>
                                                        <?php endforeach ?>
                                                      <?php endif ?>
                                                    </div>
                                                    <input type="hidden" id="sport_id_search" name="sport_id_search">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-12 col-md-6">
                                                    <label for="fecha_fav">Fecha</label>
                                                    <input type="date" id="fecha_fav" name="fecha_fav" class="form-control">
                                                </div>
                                                <div class="col-12 col-md-6">
                                                    <label for="horario_fav">Horario</label>
                                                    <input type="time" id="horario_fav" name="horario_fav" class="form-control">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="pregunta_fav">Pregunta</label>
                                            <input type="text" id="pregunta_fav" name="pregunta_fav" class="form-control">
                                        </div>

                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-12 col-md-5">
                                                    <label for="local_fav">Opción 1</label>
                                                    <input type="text" id="local_fav" name="local_fav" class="form-control">
                                                </div>
                                                <div class="col-12 col-md-2"></div>
                                                <div class="col-12 col-md-5">
                                                    <label for="visitante_fav">Opción 2</label>
                                                    <input type="text" id="visitante_fav" name="visitante_fav" class="form-control">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-12 col-md-5">
                                                    <label for="local_extra_fav">Extra 1</label>
                                                    <input type="text" id="local_extra_fav" name="local_extra_fav" class="form-control">
                                                </div>
                                                <div class="col-12 col-md-2"></div>
                                                <div class="col-12 col-md-5">
                                                    <label for="visitante_extra_fav">Extra 2</label>
                                                    <input type="text" id="visitante_extra_fav" name="visitante_extra_fav" class="form-control">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-12 col-md-5">
                                                    <label for="local_abv_fav">Abreviación 1</label>
                                                    <input type="text" id="local_abv_fav" name="local_abv_fav" class="form-control">
                                                </div>
                                                <div class="col-12 col-md-2"></div>
                                                <div class="col-12 col-md-5">
                                                    <label for="visitante_abv_fav">Abreviación 2</label>
                                                    <input type="text" id="visitante_abv_fav" name="visitante_abv_fav" class="form-control">
                                                </div>
                                            </div>
                                        </div>

                                    </div>

                                </div>

                            </div>
                        </div>
                    </div>
                </section>
            </div>

            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-primary" onclick="savePersonalizedStreaks()">Guardar</button>
            </div>

        </div>
    </div>
</div>


<!-- modal - edición rachas tournament -->
<div class="modal fade" id="modal-tournament">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">

            <div class="modal-header">
                <h4 class="modal-title">Rachas</h4>
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
                                        <h3 id="card-title" class="card-title">Actualizar Racha</h3>
                                    </div>


                                    <div class="card-body">

                                      <input type="hidden" id="tornament_id_edit" name="tornament_id_edit">

                                      <div class="form-group">
                                        <label>Patrocinador</label>
                                        <div class="form-check text-center">
                                          <?php $x = 1; ?>
                                          <?php if (isset($resources)) : ?>
                                            <?php foreach ($resources->sponsors as $sponsors) : ?>
                                              <label class="cur-pointer" onclick="selectSponsor(<?= $sponsors->id ?>,<?= $sponsors->s3_file_id ?>,'edit')">
                                                <img id="sponsor_image_edit_<?= $sponsors->s3_file_id ?>" src="<?= base_url() ?>/images/sponsors/<?= $sponsors->s3_file_id ?>.png" class="img-fluid mrg-lr-10 sponsor-edit" width="70px">
                                              </label>
                                              <?php $x++; ?>
                                            <?php endforeach ?>
                                          <?php endif ?>
                                        </div>
                                        <input type="hidden" id="sponsor_edit_id" name="sponsor_edit_id">
                                        <input type="hidden" id="sponsor_edit_id_old" name="sponsor_edit_id_old">
                                        <input type="hidden" id="sponsor_edit_image" name="sponsor_image">
                                      </div>

                                      <div class="form-group">
                                        <label for="titulo_edit">Título</label>
                                        <input type="text" id="titulo_edit" name="titulo_edit" class="form-control" placeholder="Título">
                                        <input type="hidden" id="titulo_edit_old" name="titulo_edit_old" class="form-control" placeholder="Título">
                                      </div>

                                      <div class="form-group">
                                        <label for="subtitulo_edit">Subtítulo</label>
                                        <input type="text" id="subtitulo_edit" name="subtitulo_edit" class="form-control" placeholder="Subtítulo">
                                        <input type="hidden" id="subtitulo_edit_old" name="subtitulo_edit_old" class="form-control" placeholder="Subtítulo">
                                      </div>

                                      <div class="row">
                                        <div class="col-6">
                                          <div class="form-group">
                                            <label for="fecha_inicio_edit">Fecha de inicio</label>
                                            <input type="date" id="fecha_inicio_edit" name="fecha_inicio_edit" class="form-control">
                                            <input type="hidden" id="fecha_inicio_edit_old" name="fecha_inicio_edit_old" class="form-control">
                                          </div>
                                        </div>
                                        <div class="col-6">
                                          <div class="form-group">
                                            <label for="horario_inicio_edit">Horario de inicio</label>
                                            <input type="time" id="horario_inicio_edit" name="horario_inicio_edit" class="form-control">
                                            <input type="hidden" id="horario_inicio_edit_old" name="horario_inicio_edit_old" class="form-control">
                                          </div>
                                        </div>
                                      </div>

                                      <div class="row">
                                        <div class="col-6">
                                          <div class="form-group">
                                            <label for="fecha_fin_edit">Fecha de finalización</label>
                                            <input type="date" id="fecha_fin_edit" name="fecha_fin_edit" class="form-control">
                                            <input type="hidden" id="fecha_fin_edit_old" name="fecha_fin_edit_old" class="form-control">
                                          </div>
                                        </div>
                                        <div class="col-6">
                                          <div class="form-group">
                                            <label for="horario_fin_edit">Horario de finalización</label>
                                            <input type="time" id="horario_fin_edit" name="horario_fin_edit" class="form-control">
                                            <input type="hidden" id="horario_fin_edit_old" name="horario_fin_edit_old" class="form-control">
                                          </div>
                                        </div>
                                      </div>

                                      <div class="form-group">
                                        <label for="multiplicador_edit">Multiplicador</label>
                                        <input type="text" id="multiplicador_edit" name="multiplicador_edit" class="form-control" placeholder="1" value="1">
                                        <input type="hidden" id="multiplicador_edit_old" name="multiplicador_edit_old" class="form-control" placeholder="1" value="1">
                                      </div>

                                    </div>

                                </div>

                            </div>
                        </div>
                    </div>
                </section>
            </div>

            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-primary" onclick="updateStreakTournament()">Guardar</button>
            </div>

        </div>
    </div>
</div>
