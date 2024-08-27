<section class="content">
  <div class="container-fluid">
    <div class="row justify-content-center">
      <div class="col-12">

        <div class="card">

          <div class="card-header">
            <ul class="nav nav-tabs" id="custom-tabs-pools-tab" role="tablist">
              <li class="nav-item">
                <a class="nav-link active" id="tabs-pools-cumulative-tab" data-toggle="pill" href="#tabs-pools-cumulative" role="tab" aria-controls="tabs-pools-cumulative" aria-selected="true">Quinielas Acumuladas</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" id="tabs-pools-tab" data-toggle="pill" href="#tabs-pools" role="tab" aria-controls="tabs-pools" aria-selected="false">Quinielas Normales</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" id="tabs-pools-finished-tab" data-toggle="pill" href="#tabs-pools-finished" role="tab" aria-controls="tabs-pools-finished" aria-selected="false">Quinielas Finalizadas</a>
              </li>
            </ul>

            <div class="row">
              <div class="col-12 col-md-3 pad-top-32">
                <button class="btn btn-block btn-primary" data-toggle="modal" data-target="#modal-add-1"> <i class="fas fa-plus"></i> Crear Quiniela</button>
              </div>
            </div>

          </div>

          <div id="divBrackets" class="card-body" style="overflow-x: scroll;">

            <div class="tab-content" id="custom-tabs-pools-tab-Content">
              <!-- Quinielas Acumuladas -->
              <div class="tab-pane fade show active" id="tabs-pools-cumulative" role="tabpanel" aria-labelledby="tabs-pools-cumulative-tab">
                <!-- table-responsive p-0 -->
                <table id="tblCumulativePools" class="table table-bordered table-striped">
                  <thead>
                    <tr>
                      <th>Título</th>
                      <th>Subtítulo</th>
                      <th>Deporte</th>
                      <th class="text-center">Status</th>
                      <th class="text-center">Fecha</th>
                      <th class="text-center">Acciones</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php if (isset($pools)) : ?>
                      <?php foreach ($pools as $pool) : ?>
                        <?php
                        if (isset($pool->status)) {
                          switch ($pool->status) {
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


                        //echo "sport_id".$pool->sport_id."<br>";
                        //echo '<img src="'.base_url().'/pools/file/1003" >'

                        if ($pool->status != 'finished' && $pool->is_cumulative == 1):

                          ?>
                          <tr>
                            <td><?= $pool->title ?></td>
                            <td><?= $pool->subtitle ?></td>
                            <td>
                              <img id="sport_img_<?= $pool->sport_id ?>" src="images/icons/<?= $pool->sport_id ?>.png" class="img-fluid mrg-lr-10 sport" width="20px">
                              <?php //$pool->sport->name; 
                              ?>
                            </td>
                            <td class="text-center">
                              <i class="fas fa-circle <?= $_color_status1 ?>"></i><i class="fas fa-minus <?= $_color_status2 ?>"></i><i class="fas fa-circle <?= $_color_status2 ?>"></i><i class="fas fa-minus <?= $_color_status3 ?>"></i><i class="fas fa-circle <?= $_color_status3 ?>"></i><br>
                              <?= $_texto_status ?>
                            </td>
                            <td class="text-center"><?= $pool->limit_date ?></td>
                            <td class="text-center">
                              <button class="btn" onclick="modalEdit(<?= $pool->id ?>)" title="editar"><i class="fas fa-pencil-alt"></i></button>
                              <button class="btn" onclick="modalPhases(<?= $pool->id ?>,'<?= $pool->title ?>')" title="fases"><i class="fas fa-network-wired"></i></button>
                              
                              <button class="btn" onclick="delPools(<?= $pool->id ?>,'tblCumulativePools')" title="eliminar"><i class="far fa-trash-alt"></i></button>

                              <button class="btn" onclick="modalTiebreakers(<?= $pool->id ?>)" title="calificar preguntas"><i class="fas fa-list-ul"></i></button>
                              <button class="btn" onclick="chageStatus(<?= $pool->id ?>)" title="cambiar estatus"><?= $_icon_status ?></button>
                            </td>
                          </tr>
                        <?php endif ?>
                      <?php endforeach ?>
                    <?php endif ?>
                  </tbody>
                </table>
              </div>

              <!-- Quinielas Normales -->
              <div class="tab-pane fade" id="tabs-pools" role="tabpanel" aria-labelledby="tabs-pools-tab">
                <!-- table-responsive p-0 -->
                <table id="tblPools" class="table table-bordered table-striped">
                  <thead>
                    <tr>
                      <th>Título</th>
                      <th>Subtítulo</th>
                      <th>Deporte</th>
                      <th class="text-center">Status</th>
                      <th class="text-center">Fecha</th>
                      <th class="text-center">Acciones</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php if (isset($pools)) : ?>
                      <?php foreach ($pools as $pool) : ?>
                        <?php
                        if (isset($pool->status)) {
                          switch ($pool->status) {
                            case 'open':
                              $_color_status1 = 'c-green';
                              $_color_status2 = 'c-gray-light';
                              $_color_status3 = 'c-gray-light';
                              $_icon_sport = '<i class="fas fa-baseball-ball"></i>';
                              $_icon_status = '<i class="fas fa-lock-open"></i>';
                              $_texto_status = 'abierta';
                              break;

                            case 'running':
                              $_color_status1 = 'c-green';
                              $_color_status2 = 'c-blue';
                              $_color_status3 = 'c-gray-light';
                              $_icon_sport = '<i class="fas fa-baseball-ball"></i>';
                              $_icon_status = '<i class="fas fa-lock-open"></i>';
                              $_texto_status = 'en curso';
                              break;

                            case 'finished':
                              $_color_status1 = 'c-green';
                              $_color_status2 = 'c-blue';
                              $_color_status3 = 'c-red';
                              $_icon_sport = '<i class="fas fa-baseball-ball"></i>';
                              $_icon_status = '<i class="fas fa-lock"></i>';
                              $_texto_status = 'finalizada';
                              break;

                            default:
                              $_color_status1 = 'c-gray-light';
                              $_color_status2 = 'c-gray-light';
                              $_color_status3 = 'c-gray-light';
                              $_icon_sport = '<i class="fas fa-baseball-ball"></i>';
                              $_icon_status = '<i class="fas fa-lock-open"></i>';
                              $_texto_status = 'abierta';
                              break;
                          } // switch
                        } // if


                        //echo "sport_id".$pool->sport_id."<br>";
                        //echo '<img src="'.base_url().'/pools/file/1003" >'

                        if ($pool->status != 'finished' && $pool->is_cumulative == 0):

                          ?>
                          <tr>
                            <td><?= $pool->title ?></td>
                            <td><?= $pool->subtitle ?></td>
                            <td>
                              <img id="sport_img_<?= $pool->sport_id ?>" src="images/icons/<?= $pool->sport_id ?>.png" class="img-fluid mrg-lr-10 sport" width="20px">
                              <?php //$pool->sport->name; 
                              ?>
                            </td>
                            <td class="text-center">
                              <i class="fas fa-circle <?= $_color_status1 ?>"></i><i class="fas fa-minus <?= $_color_status2 ?>"></i><i class="fas fa-circle <?= $_color_status2 ?>"></i><i class="fas fa-minus <?= $_color_status3 ?>"></i><i class="fas fa-circle <?= $_color_status3 ?>"></i><br>
                              <?= $_texto_status ?>
                            </td>
                            <td class="text-center"><?= $pool->limit_date ?></td>
                            <td class="text-center">
                              <button class="btn" onclick="modalEdit(<?= $pool->id ?>)" title="editar"><i class="fas fa-pencil-alt"></i></button>
                              <button class="btn" onclick="delPools(<?= $pool->id ?>,'tblPools')" title="eliminar"><i class="far fa-trash-alt"></i></button>

                              <button class="btn" onclick="modalTiebreakers(<?= $pool->id ?>)" title="calificar preguntas"><i class="fas fa-list-ul"></i></button>
                              <button class="btn" onclick="changeSport(<?= $pool->id ?>,'tblPools',<?= $pool->sport_id ?>)" title="cambiar icono deporte"><?= $_icon_sport ?></button>
                              <button class="btn" onclick="chageStatus(<?= $pool->id ?>)" title="cambiar estatus"><?= $_icon_status ?></button>
                            </td>
                          </tr>
                        <?php endif ?>
                      <?php endforeach ?>
                    <?php endif ?>
                  </tbody>
                </table>
              </div>

              <!-- Quinielas Finalizadas -->
              <div class="tab-pane fade" id="tabs-pools-finished" role="tabpanel" aria-labelledby="tabs-pools-finished-tab">
                <!-- table-responsive p-0 -->
                <table id="tblPoolsFinished" class="table table-bordered table-striped">
                  <thead>
                    <tr>
                      <th>Título</th>
                      <th>Subtítulo</th>
                      <th>Deporte</th>
                      <th class="text-center">Status</th>
                      <th class="text-center">Fecha</th>
                      <th class="text-center">Acciones</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php if (isset($pools)) : ?>
                      <?php foreach ($pools as $pool) : ?>
                        <?php
                        if (isset($pool->status)) {
                          switch ($pool->status) {
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


                        //echo "sport_id".$pool->sport_id."<br>";
                        //echo '<img src="'.base_url().'/pools/file/1003" >'

                        if ($pool->status == 'finished'):

                          ?>
                          <tr>
                            <td><?= $pool->title ?></td>
                            <td><?= $pool->subtitle ?></td>
                            <td>
                              <img id="sport_img_<?= $pool->sport_id ?>" src="images/icons/<?= $pool->sport_id ?>.png" class="img-fluid mrg-lr-10 sport" width="20px">
                              <?php //$pool->sport->name; 
                              ?>
                            </td>
                            <td class="text-center">
                              <i class="fas fa-circle <?= $_color_status1 ?>"></i><i class="fas fa-minus <?= $_color_status2 ?>"></i><i class="fas fa-circle <?= $_color_status2 ?>"></i><i class="fas fa-minus <?= $_color_status3 ?>"></i><i class="fas fa-circle <?= $_color_status3 ?>"></i><br>
                              <?= $_texto_status ?>
                            </td>
                            <td class="text-center"><?= $pool->limit_date ?></td>
                            <td class="text-center">
                              <button class="btn" onclick="modalEdit(<?= $pool->id ?>)" title="editar"><i class="fas fa-pencil-alt"></i></button>
                              <button class="btn" onclick="delPools(<?= $pool->id ?>,'tblPoolsFinished')" title="eliminar"><i class="far fa-trash-alt"></i></button>

                              <button class="btn" onclick="modalTiebreakers(<?= $pool->id ?>)" title="calificar preguntas"><i class="fas fa-list-ul"></i></button>
                              <button class="btn" onclick="chageStatus(<?= $pool->id ?>)" title="cambiar estatus"><?= $_icon_status ?></button>
                            </td>
                          </tr>
                        <?php endif ?>
                      <?php endforeach ?>
                    <?php endif ?>
                  </tbody>
                </table>
              </div>
            </div>
          </div>

        </div>

      </div>
    </div>
  </div>
</section>


<form id="frmPoolAdd" method="post" action="<?= base_url(); ?>/pools/save" autocomplete="off">

  <!-- modal add - Step 1 -->
  <div class="modal fade" id="modal-add-1">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">

        <div class="modal-header">
          <h4 class="modal-title">Quinielas</h4>
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
                      <h3 id="card-title" class="card-title">Crear Quiniela (1/5)</h3>
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
                        <input type="hidden" id="sponsor_add_id" name="sponsor_add_id">
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
              <h4 class="modal-title">Quinielas</h4>
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
                        <h3 id="card-title" class="card-title">Crear Quiniela (2/5)</h3>
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
            <button type="button" class="btn btn-primary" onclick="nextModalAdd(2,3)">Siguiente</button>
          </div>

        </div>
      </div>
    </div>

    <!-- modal add - Step 3 -->
    <div class="modal fade" id="modal-add-3">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">

          <div class="modal-header">
              <h4 class="modal-title">Quinielas</h4>
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
                        <h3 id="card-title" class="card-title">Crear Quiniela (3/5)</h3>
                      </div>


                      <div class="card-body">

                      <label>Quiniela Acumulativa </label>
                      <input type="checkbox" id="is_cumulative" name="is_cumulative" data-bootstrap-switch data-off-color="danger" data-on-color="success" onchange="cumulativeShow()">

                      <div id="cumulative_phase" style="display:block">
                        <div class="form-group">
                          <label for="phase_name">Nombre de la Fase</label>
                          <input type="text" id="phase_name" name="phase_name" class="form-control" placeholder="Título">
                        </div>

                        <div class="row">
                          <div class="col-6">
                            <div class="form-group">
                              <label for="fecha_inicio_cumulative">Fecha de inicio</label>
                              <input type="date" id="fecha_inicio_cumulative" name="fecha_inicio_cumulative" class="form-control">
                            </div>
                          </div>
                          <div class="col-6">
                            <div class="form-group">
                              <label for="horario_inicio_cumulative">Horario de inicio</label>
                              <input type="time" id="horario_inicio_cumulative" name="horario_inicio_cumulative" class="form-control">
                            </div>
                          </div>
                        </div>

                        <div class="row">
                          <div class="col-6">
                            <div class="form-group">
                              <label for="fecha_fin_cumulative">Fecha de finalización</label>
                              <input type="date" id="fecha_fin_cumulative" name="fecha_fin_cumulative" class="form-control">
                            </div>
                          </div>
                          <div class="col-6">
                            <div class="form-group">
                              <label for="horario_fin_cumulative">Horario de finalización</label>
                              <input type="time" id="horario_fin_cumulative" name="horario_fin_cumulative" class="form-control">
                            </div>
                          </div>
                        </div>
                      </div>

                      <hr>

                        <div class="form-group">
                          <label>Deporte</label>
                          <div class="text-center">
                            <?php $x = 1; ?>
                            <?php if (isset($resources)) : ?>
                              <?php foreach ($resources->sports as $sports) : ?>
                                <?php //if ($x<10) : ?>
                                  <label class="cur-pointer" onclick="selectSportModal(<?= $sports->id ?>,'add')">
                                      <img id="sport_image_search_<?= $sports->id ?>" src="<?= base_url() ?>/images/icons/<?= $sports->id ?>.png" class="img-fluid mrg-lr-10 sport-search" width="50px">
                                  </label>
                                  <?php $x++; ?>
                                <?php //endif ?>
                              <?php endforeach ?>
                            <?php endif ?>
                          </div>
                          <input type="hidden" id="sport_id_search" name="sport_id_search">
                        </div>
                        <div class="row">
                          <div class="col-6">
                            <div class="form-group">
                              <label for="league_id">Liga</label>
                              <select id="league_id" name="league_id" class="form-control select2" style="width: 100%;"></select>
                            </div>
                          </div>
                          <div class="col-6">
                            <div class="form-group">
                              <label for="start_date_search">Fecha de búsqueda</label>
                              <input type="date" id="start_date_search" name="start_date_search" class="form-control">
                            </div>
                          </div>
                        </div>
                        <div class="form-group">
                            <button type="button" id="btn-search" name="btn-search" class="form-control btn btn-dark" onclick="listarBracketsMatches()"><i class="fas fa-search"></i> Buscar</button>
                        </div>

                      </div>

                      <!-- Partidos ya creados -->
                      <div id="divBracketsMatchesAdded" class="card-body">
                        <table id="tblBracketsMatchesAdded" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>Seleccionar</th>
                                    <th>Liga</th>
                                    <th>Local</th>
                                    <th>Visitante</th>
                                    <th>Fecha</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                      </div>

                      <div id="divBracketsMatches" class="card-body">

                      </div>

                    </div>

                  </div>
                </div>
              </div>
            </section>
          </div>

          <div class="modal-footer justify-content-between">
            <button type="button" class="btn btn-dark" onclick="nextModalAdd(3,2)">Atras</button>
            <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
            <button type="button" class="btn btn-primary" onclick="nextModalAdd(3,4)">Siguiente</button>
          </div>

        </div>
    </div>
  </div>

    <!-- modal add - Step 4 -->
    <div class="modal fade" id="modal-add-4">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">

          <div class="modal-header">
              <h4 class="modal-title">Quinielas</h4>
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
                        <h3 id="card-title" class="card-title">Crear Quiniela (4/5)</h3>
                      </div>


                      <div class="card-body">

                        <div class="form-group col-md-12" role="listitem">
                          <fieldset id="buildyourform"></fieldset>
                        </div>

                        <aside>
                          <button type="button" class="add btn btn-success" id="add" onclick="createTiebreakers()"><i class="fas fa-plus"></i> Nueva pregunta</button>
                        </aside>

                      </div>

                    </div>

                  </div>
                </div>
              </div>
            </section>
          </div>

          <div class="modal-footer justify-content-between">
            <button type="button" class="btn btn-dark" onclick="nextModalAdd(4,3)">Atras</button>
            <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
            <button type="button" class="btn btn-primary" onclick="nextModalAdd(4,5)">Siguiente</button>
          </div>

        </div>
    </div>
  </div>

  <!-- modal add - Step 5 -->
  <div class="modal fade" id="modal-add-5">
    <div class="modal-dialog modal-xl">
      <div class="modal-content">

        <div class="modal-header">
          <h4 class="modal-title">Quinielas</h4>
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
                      <h3 id="card-title" class="card-title">Crear Quiniela (5/5)</h3>
                    </div>

                    <div class="card-body">

                      <label>Test: </label>
                      <input type="checkbox" id="test" name="test" checked data-bootstrap-switch data-off-color="danger" data-on-color="success"> 

                      <label>VIP: </label>
                      <input type="checkbox" id="vip" name="vip" data-bootstrap-switch data-off-color="danger" data-on-color="success">

                      <div class="row mrg-top-20">
                        <div class="col-12 col-md-6">
                            <div class="form-group">
                                <label>Titulo: <span id="titulo_resume" class="text-normal"></span></label>
                            </div>
                            <div class="form-group">
                                <label>Subtítulo: <span id="subtitulo_resume" class="text-normal"></span></label>
                            </div>
                            <div class="form-group">
                                <label>Inicio: <span id="fecha_inicio_resume" class="text-normal"></span></label> |
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                          <div class="form-group">
                            <label>Patrocinador:</label>
                            <img id="sponsor_image_add_resume" src="<?= base_url() ?>/images/sponsors/" class="img-fluid mrg-lr-10" width="70px">
                          </div>
                          <div class="form-group">
                            <label>Deporte:</label>
                            <img id="sport_image_add_resume" src="<?= base_url() ?>/images/icons/" class="img-fluid mrg-lr-10" width="30px">
                          </div>
                        </div>
                      </div>


                      <div class="row">
                        <div class="col-12 col-md-6">
                          <h2 class="text-center">Partidos</h2>
                          <table id="partidos_resume" class="table">
                            <thead>
                              <tr>
                                <th>Partidos</th>
                                <th>&nbsp;</th>
                              </tr>
                            </thead>
                            <tbody></tbody>
                          </table>
                        </div>

                        <div class="col-12 col-md-6">
                          <h2 class="text-center">Premios</h2>
                          <table id="premios_resume" class="table">
                            <thead>
                              <tr>
                                <th>Premios</th>
                                <th>&nbsp;</th>
                                <th>&nbsp;</th>
                              </tr>
                            </thead>
                            <tbody></tbody>
                          </table>
                        </div>
                      </div>

                      <div class="row">
                        <div class="col-12">
                          <h2 class="text-center">Preguntas</h2>
                          <table id="preguntas_resume" class="table">
                            <thead>
                              <tr>
                                <th>Pregunta</th>
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
          <button type="button" class="btn btn-dark" onclick="nextModalAdd(5,4)">Atras</button>
          <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
          <button type="button" class="btn btn-primary" onclick="save()">Crear Quiniela</button>
        </div>

      </div>
    </div>
  </div>

</form>


<!-- ************************************************************************************************************************************** -->

<form id="frmPoolEdit" method="post" action="<?= base_url(); ?>/pools/update" autocomplete="off">
  <input type="hidden" id="pool_edit_id" name="pool_edit_id" value="">
  <!-- modal edit - Step 1 -->
  <div class="modal fade" id="modal-edit-1">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">

        <div class="modal-header">
          <h4 class="modal-title">Quinielas</h4>
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
                      <h3 id="card-title" class="card-title">Editar Quiniela (1/5)</h3>
                    </div>


                    <div class="card-body">

                      <div class="form-group">
                        <label>Patrocinador</label>
                        <div class="form-check text-center">
                          <?php $x = 1; ?>
                          <?php if (isset($resources)) : ?>
                            <?php foreach ($resources->sponsors as $sponsors) : ?>
                              <label class="cur-pointer" onclick="selectSponsor(<?= $sponsors->id ?>,<?= $sponsors->s3_file_id ?>,'add')">
                                <img id="sponsor_image_edit_<?= $sponsors->s3_file_id ?>" src="<?= base_url() ?>/images/sponsors/<?= $sponsors->s3_file_id ?>.png" class="img-fluid mrg-lr-10 sponsor-edit" width="70px">
                              </label>
                              <?php $x++; ?>
                            <?php endforeach ?>
                          <?php endif ?>
                        </div>
                        <input type="hidden" id="sponsor_edit_id" name="sponsor_edit_id">
                        <input type="hidden" id="sponsor_edit_image" name="sponsor_edit_image">

                        <input type="hidden" id="sponsor_edit_id_old" name="sponsor_edit_id_old">
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
                            <input type="hidden" id="fecha_inicio_edit_old" name="fecha_inicio_edit_old" class="form-control" placeholder="Subtítulo">
                          </div>
                        </div>
                        <div class="col-6">
                          <div class="form-group">
                            <label for="horario_inicio_edit">Horario de inicio</label>
                            <input type="time" id="horario_inicio_edit" name="horario_inicio_edit" class="form-control">
                            <input type="hidden" id="horario_inicio_edit_old" name="horario_inicio_edit_old" class="form-control" placeholder="Subtítulo">
                          </div>
                        </div>
                      </div>

                      <div class="form-group">
                        <label for="multiplicador_edit">Multiplicador</label>
                        <input type="text" id="multiplicador_edit" name="multiplicador_edit" class="form-control" placeholder="1">
                        <input type="hidden" id="multiplicador_edit_old" name="multiplicador_edit_old" class="form-control" placeholder="Subtítulo">
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
          <button type="button" class="btn btn-primary" onclick="nextModalEdit(1,2)">Siguiente</button>
        </div>

      </div>
    </div>
  </div>

  <!-- modal edit - Step 2 -->
  <div class="modal fade" id="modal-edit-2">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">

        <div class="modal-header">
            <h4 class="modal-title">Quinielas</h4>
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
                      <h3 id="card-title" class="card-title">Editar Quiniela (2/5)</h3>
                    </div>


                    <div class="card-body">

                      <div class="form-group">
                        <label for="total_awards_edit">Total de premios</label>
                        <input type="text" id="total_awards_edit" name="total_awards_edit" class="form-control" placeholder="200">
                      </div>
                      <div class="form-group">
                        <label>Cantidad: <span id="cantidad_award"></span></label>
                        <input type="hidden" id="awards_edit" name="awards_edit">
                      </div>
                      <div class="form-group">
                        <button type="button" class="btn btn-info" onclick="createAwards('edit')">Generar Premios</button>
                      </div>

                    </div>

                    <div class="card-body">

                      <table id="tblMatchAwardsEdit" class="table table-bordered table-striped">
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
          <button type="button" class="btn btn-dark" onclick="nextModalEdit(2,1)">Atras</button>
          <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
          <button type="button" class="btn btn-primary" onclick="nextModalEdit(2,3)">Siguiente</button>
        </div>

      </div>
    </div>
  </div>

    <!-- modal edit - Step 3 -->
    <div class="modal fade" id="modal-edit-3">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">

          <div class="modal-header">
              <h4 class="modal-title">Quinielas</h4>
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
                        <h3 id="card-title" class="card-title">Edit Quiniela (3/5)</h3>
                      </div>


                      <div class="card-body">

                        <label>Quiniela Acumulativa </label>
                        <input type="checkbox" id="is_cumulative_edit" name="is_cumulative_edit" data-bootstrap-switch data-off-color="danger" data-on-color="success" onchange="cumulativeShow('edit')">

                        <div id="cumulative_phase_edit" style="display:block">
                          <div class="form-group">
                            <label for="phase_name_edit">Nombre de la Fase</label>
                            <input type="text" id="phase_name_edit" name="phase_name_edit" class="form-control" placeholder="Título">
                            <input type="hidden" id="phase_name_edit_old" name="phase_name_edit_old" class="form-control" placeholder="Título">
                          </div>

                          <div class="row">
                            <div class="col-6">
                              <div class="form-group">
                                <label for="fecha_inicio_cumulative_edit">Fecha de inicio</label>
                                <input type="date" id="fecha_inicio_cumulative_edit" name="fecha_inicio_cumulative_edit" class="form-control">
                                <input type="hidden" id="fecha_inicio_cumulative_edit_old" name="fecha_inicio_cumulative_edit_old" class="form-control">
                              </div>
                            </div>
                            <div class="col-6">
                              <div class="form-group">
                                <label for="horario_inicio_cumulative_edit">Horario de inicio</label>
                                <input type="time" id="horario_inicio_cumulative_edit" name="horario_inicio_cumulative_edit" class="form-control">
                                <input type="hidden" id="horario_inicio_cumulative_edit_old" name="horario_inicio_cumulative_edit_old" class="form-control">
                              </div>
                            </div>
                          </div>

                          <div class="row">
                            <div class="col-6">
                              <div class="form-group">
                                <label for="fecha_fin_cumulative_edit">Fecha de finalización</label>
                                <input type="date" id="fecha_fin_cumulative_edit" name="fecha_fin_cumulative_edit" class="form-control">
                                <input type="hidden" id="fecha_fin_cumulative_edit_old" name="fecha_fin_cumulative_edit_old" class="form-control">
                              </div>
                            </div>
                            <div class="col-6">
                              <div class="form-group">
                                <label for="horario_fin_cumulative_edit">Horario de finalización</label>
                                <input type="time" id="horario_fin_cumulative_edit" name="horario_fin_cumulative_edit" class="form-control">
                                <input type="hidden" id="horario_fin_cumulative_edit_old" name="horario_fin_cumulative_edit_old" class="form-control">
                              </div>
                            </div>
                          </div>
                        </div>

                        <hr>

                        <div class="form-group">
                          <label>Deporte</label>
                          <div class="text-center">
                            <?php $x = 1; ?>
                            <?php if (isset($resources)) : ?>
                              <?php foreach ($resources->sports as $sports) : ?>
                                <label class="cur-pointer" onclick="selectSportModal(<?= $sports->id ?>,'edit')">
                                    <img id="sport_image_search_<?= $sports->id ?>_edit" src="<?= base_url() ?>/images/icons/<?= $sports->id ?>.png" class="img-fluid mrg-lr-10 sport-search-edit" width="50px">
                                </label>
                                <?php $x++; ?>
                              <?php endforeach ?>
                            <?php endif ?>
                          </div>
                          <input type="hidden" id="sport_id_search_edit" name="sport_id_search_edit">
                        </div>
                        <div class="row">
                          <div class="col-6">
                            <div class="form-group">
                              <label for="league_id_edit">Liga</label>
                              <select id="league_id_edit" name="league_id_edit" class="form-control select2" style="width: 100%;"></select>
                              <input type="hidden" id="league_id_edit_old" name="league_id_edit_old" class="form-control">
                            </div>
                          </div>
                          <div class="col-6">
                            <div class="form-group">
                              <label for="start_date_search_edit">Fecha de búsqueda</label>
                              <input type="date" id="start_date_search_edit" name="start_date_search_edit" class="form-control">
                              <input type="hidden" id="start_date_search_edit_old" name="start_date_search_edit_old" class="form-control">
                            </div>
                          </div>
                        </div>
                        <div class="form-group">
                            <button type="button" id="btn-search-edit" name="btn-search-edit" class="form-control btn btn-dark" onclick="listarBracketsMatches('Edit')"><i class="fas fa-search"></i> Buscar</button>
                        </div>

                      </div>

                      <!-- Partidos ya creados -->
                      <div id="divBracketsMatchesEditAdded" class="card-body">
                        <table id="tblBracketsMatchesEditAdded" class="table table-bordered table-striped">
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

                      <div id="divBracketsMatchesEdit" class="card-body">

                      </div>

                    </div>

                  </div>
                </div>
              </div>
            </section>
          </div>

          <div class="modal-footer justify-content-between">
            <button type="button" class="btn btn-dark" onclick="nextModalEdit(3,2)">Atras</button>
            <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
            <button type="button" class="btn btn-primary" onclick="nextModalEdit(3,4)">Siguiente</button>
          </div>

        </div>
    </div>
  </div>

  <!-- modal edit - Step 4 -->
  <div class="modal fade" id="modal-edit-4">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">

        <div class="modal-header">
          <h4 class="modal-title">Quinielas</h4>
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
                      <h3 id="card-title" class="card-title">Editar Quiniela (4/5)</h3>
                    </div>


                    <div class="card-body">

                      <div class="form-group col-md-12" role="listitem">
                        <fieldset id="buildyourformedit"></fieldset>
                      </div>

                      <aside>
                        <button type="button" class="add btn btn-success" id="add" onclick="createTiebreakers('edit')"><i class="fas fa-plus"></i> Nueva pregunta</button>
                      </aside>

                    </div>

                  </div>

                </div>
              </div>
            </div>
          </section>
        </div>

        <div class="modal-footer justify-content-between">
          <button type="button" class="btn btn-dark" onclick="nextModalEdit(4,3)">Atras</button>
          <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
          <button type="button" class="btn btn-primary" onclick="nextModalEdit(4,5)">Siguiente</button>
        </div>

      </div>
    </div>
  </div>

  <!-- modal edit - Step 5 -->
  <div class="modal fade" id="modal-edit-5">
    <div class="modal-dialog modal-xl">
      <div class="modal-content">

        <div class="modal-header">
          <h4 class="modal-title">Quinielas</h4>
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
                      <h3 id="card-title" class="card-title">Editar Quiniela (5/5)</h3>
                    </div>

                    <div class="card-body">

                      <label>Test: </label>
                      <input type="checkbox" id="test_edit" name="test_edit" checked data-bootstrap-switch data-off-color="danger" data-on-color="success">

                      <label>VIP: </label>
                      <input type="checkbox" id="vip_edit" name="vip_edit" data-bootstrap-switch data-off-color="danger" data-on-color="success">

                      <div class="row mrg-top-20">
                        <div class="col-12 col-md-6">
                            <div class="form-group">
                                <label>Titulo: <span id="titulo_resume_edit" class="text-normal"></span></label>
                            </div>
                            <div class="form-group">
                                <label>Subtítulo: <span id="subtitulo_resume_edit" class="text-normal"></span></label>
                            </div>
                            <div class="form-group">
                                <label>Inicio: <span id="fecha_inicio_resume_edit" class="text-normal"></span></label> |
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
                          <h2 class="text-center">Partidos</h2>
                          <table id="partidos_resume_edit" class="table">
                            <thead>
                              <tr>
                                <th>Partidos
                                <th>
                              </tr>
                            </thead>
                            <tbody></tbody>
                          </table>
                        </div>

                        <div class="col-12 col-md-6">
                          <h2 class="text-center">Premios</h2>
                          <table id="premios_resume_edit" class="table">
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

                      <div class="row">
                        <div class="col-12">
                          <h2 class="text-center">Preguntas</h2>
                          <table id="preguntas_resume_edit" class="table">
                            <thead>
                              <tr>
                                <th>Pregunta</th>
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
          <button type="button" class="btn btn-dark" onclick="nextModalEdit(5,4)">Atras</button>
          <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
          <button type="button" class="btn btn-primary" onclick="update()">Guardar Quniela</button>
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


<!-- modal tiebreakers - Select Winner -->
<div class="modal fade" id="modal-tiebreakers">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">

      <div class="modal-header">
        <h4 class="modal-title">Quinielas</h4>
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
                    <h3 id="card-title" class="card-title">Calificar preguntas</h3>
                  </div>


                  <div class="card-body">

                    <div class="form-group col-md-12" role="listitem">
                      <form id="frmPoolTiebreakers" method="post" action="<?= base_url(); ?>/pools/tiebreakers" autocomplete="off">
                        <fieldset id="buildyourformwinner"></fieldset>
                      </form>
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
        <button type="button" class="btn btn-primary" onclick="qualifyTiebreakers()">Guardar</button>
      </div>

    </div>
  </div>
</div>


<!-- modal Pools Sport -->
<div class="modal fade" id="modal-sport">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">

      <div class="modal-header">
        <h4 class="modal-title">Quinielas</h4>
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
                    <h3 id="card-title" class="card-title">Cambiar Icono del Deporte</h3>
                  </div>


                  <div class="card-body">
                    <div class="row">
                      

                      <?php $x = 1; ?>
                      <?php if (isset($resources)) : ?>
                        <?php foreach ($resources->sports as $sports) : ?>
                          <?php //if ($x<10) : ?>
                            <label class="cur-pointer" onclick="selectSportChange(<?= $sports->id ?>)">
                                <img id="sport_image_change_<?= $sports->id ?>" src="<?= base_url() ?>/images/icons/<?= $sports->id ?>.png" class="img-fluid mrg-lr-10 sport-change" width="50px">
                            </label>
                            <?php $x++; ?>
                          <?php //endif ?>
                        <?php endforeach ?>
                      <?php endif ?>

                      
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
        <button type="button" class="btn btn-primary" onclick="saveNewSportIcon()">Guardar</button>
        <input type="hidden" id="pool_id_chg_sport" value="">
        <input type="hidden" id="multi_sport_id" value="">
      </div>

    </div>
  </div>
</div>


<!-- modal Pools Status -->
<div class="modal fade" id="modal-status">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">

      <div class="modal-header">
        <h4 class="modal-title">Quinielas</h4>
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
                    <h3 id="card-title" class="card-title">Cambiar estatus</h3>
                  </div>


                  <div class="card-body">

                    <div id="divStatus" class="form-group col-md-12" role="listitem">
                      
                      
                      
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
        <button type="button" class="btn btn-primary" onclick="saveStatus()">Guardar</button>
      </div>

    </div>
  </div>
</div>


<!-- modal Pools Phases -->
<div class="modal fade" id="modal-phases">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">

      <div class="modal-header">
        <h4 class="modal-title">Quinielas - Fases</h4>
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
                    <h3 id="card-title" class="card-title">Fases <span id="quiniela-fases"></span></h3>
                  </div>


                  <div class="card-body">

                    <div id="divPhases" class="form-group col-md-12" role="listitem">
                      
                      
                      
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
      </div>

    </div>
  </div>
</div>


<!-- modal Pools Phases - Add New Phase -->
<div class="modal fade" id="modal-phases-add">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">

      <div class="modal-header">
        <h4 class="modal-title">Quinielas - Fases</h4>
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
                    <h3 id="card-title" class="card-title">Agregar Nueva Fase</h3>
                  </div>


                  <div class="card-body">

                    <input type="hidden" id="pool_id_new" name="pool_id_new">

                    <div id="cumulative_phase" style="display:block">
                      <div class="form-group">
                        <label for="phase_name_new">Nombre de la Fase</label>
                        <input type="text" id="phase_name_new" name="phase_name_new" class="form-control" placeholder="Título">
                      </div>

                      <div class="row">
                        <div class="col-6">
                          <div class="form-group">
                            <label for="fecha_inicio_cumulative_new">Fecha de inicio</label>
                            <input type="date" id="fecha_inicio_cumulative_new" name="fecha_inicio_cumulative_new" class="form-control">
                          </div>
                        </div>
                        <div class="col-6">
                          <div class="form-group">
                            <label for="horario_inicio_cumulative_new">Horario de inicio</label>
                            <input type="time" id="horario_inicio_cumulative_new" name="horario_inicio_cumulative_new" class="form-control">
                          </div>
                        </div>
                      </div>

                      <div class="row">
                        <div class="col-6">
                          <div class="form-group">
                            <label for="fecha_fin_cumulative_new">Fecha de finalización</label>
                            <input type="date" id="fecha_fin_cumulative_new" name="fecha_fin_cumulative_new" class="form-control">
                          </div>
                        </div>
                        <div class="col-6">
                          <div class="form-group">
                            <label for="horario_fin_cumulative_new">Horario de finalización</label>
                            <input type="time" id="horario_fin_cumulative_new" name="horario_fin_cumulative_new" class="form-control">
                          </div>
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
        <button type="button" class="btn btn-primary" onclick="savePhasesAdd()">Guardar</button>
      </div>

    </div>
  </div>
</div>

<!-- ************************************************************************************************************************************** -->

<form id="frmPoolPhase" method="post" action="<?= base_url(); ?>/pools/update_phase" autocomplete="off">
  <input type="hidden" id="pool_id_phases" name="pool_id_phases">
  <!-- modal phases - Información de la Fase -->
  <div class="modal fade" id="modal-phases-2">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">

        <div class="modal-header">
          <h4 class="modal-title">Quinielas - Fases</h4>
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
                      <h3 id="card-title" class="card-title">Agregar o Actualizar Partidos</h3>
                    </div>


                    <div class="card-body">

                      <input type="hidden" name="phase_id_new" id="phase_id_new">
                      <input type="hidden" name="phase_step" id="phase_step">

                      <div id="cumulative_phase_phases" style="display:block">
                        <div class="form-group">
                          <label for="phase_name_phases">Nombre de la Fase</label>
                          <input type="text" id="phase_name_phases" name="phase_name_phases" class="form-control" placeholder="Título">
                          <input type="hidden" id="phase_name_phases_old" name="phase_name_phases_old" class="form-control" placeholder="Título">
                        </div>

                        <div class="row">
                          <div class="col-6">
                            <div class="form-group">
                              <label for="fecha_inicio_cumulative_phases">Fecha de inicio</label>
                              <input type="date" id="fecha_inicio_cumulative_phases" name="fecha_inicio_cumulative_phases" class="form-control">
                              <input type="hidden" id="fecha_inicio_cumulative_phases_old" name="fecha_inicio_cumulative_phases_old" class="form-control">
                            </div>
                          </div>
                          <div class="col-6">
                            <div class="form-group">
                              <label for="horario_inicio_cumulative_phases">Horario de inicio</label>
                              <input type="time" id="horario_inicio_cumulative_phases" name="horario_inicio_cumulative_phases" class="form-control">
                              <input type="hidden" id="horario_inicio_cumulative_phases_old" name="horario_inicio_cumulative_phases_old" class="form-control">
                            </div>
                          </div>
                        </div>

                        <div class="row">
                          <div class="col-6">
                            <div class="form-group">
                              <label for="fecha_fin_cumulative_phases">Fecha de finalización</label>
                              <input type="date" id="fecha_fin_cumulative_phases" name="fecha_fin_cumulative_phases" class="form-control">
                              <input type="hidden" id="fecha_fin_cumulative_phases_old" name="fecha_fin_cumulative_phases_old" class="form-control">
                            </div>
                          </div>
                          <div class="col-6">
                            <div class="form-group">
                              <label for="horario_fin_cumulative_phases">Horario de finalización</label>
                              <input type="time" id="horario_fin_cumulative_phases" name="horario_fin_cumulative_phases" class="form-control">
                              <input type="hidden" id="horario_fin_cumulative_phases_old" name="horario_fin_cumulative_phases_old" class="form-control">
                            </div>
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
          <button type="button" class="btn btn-primary" onclick="nextModalPhases(2,3)">Siguiente</button>
        </div>

      </div>
    </div>
  </div>

  <!-- modal phases - Partidos -->
  <div class="modal fade" id="modal-phases-3">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">

        <div class="modal-header">
          <h4 class="modal-title">Quinielas - Fases</h4>
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
                      <h3 id="card-title" class="card-title">Agregar o Actualizar Partidos</h3>
                    </div>


                    <div class="card-body">

                    <input type="hidden" name="matches_status" id="matches_status">

                      <div class="form-group">
                        <label>Deporte</label>
                        <div class="text-center">
                          <?php $x = 1; ?>
                          <?php if (isset($resources)) : ?>
                            <?php foreach ($resources->sports as $sports) : ?>
                              <label class="cur-pointer" onclick="selectSportModal(<?= $sports->id ?>,'phases')">
                                  <img id="sport_image_search_<?= $sports->id ?>_phases" src="<?= base_url() ?>/images/icons/<?= $sports->id ?>.png" class="img-fluid mrg-lr-10 sport-search-phases" width="50px">
                              </label>
                              <?php $x++; ?>
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
          <button type="button" class="btn btn-primary" onclick="nextModalPhases(3,4)">Siguiente</button>
        </div>

      </div>
    </div>
  </div>

  <!-- modal phases - Preguntas -->
  <div class="modal fade" id="modal-phases-4">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">

        <div class="modal-header">
          <h4 class="modal-title">Quinielas - Fases</h4>
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
                      <h3 id="card-title" class="card-title">Agregar o Actualizar Preguntas</h3>
                    </div>


                    <div class="card-body">

                      <div class="form-group col-md-12" role="listitem">
                        <fieldset id="buildyourformphases"></fieldset>
                      </div>

                      <aside>
                        <button type="button" class="add btn btn-success" id="add" onclick="createTiebreakers('phases')"><i class="fas fa-plus"></i> Nueva pregunta</button>
                      </aside>

                    </div>

                  </div>

                </div>
              </div>
            </div>
          </section>
        </div>

        <div class="modal-footer justify-content-between">
          <button type="button" class="btn btn-dark" onclick="nextModalPhases(4,3)">Atras</button>
          <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
          <button type="button" class="btn btn-primary" onclick="nextModalPhases(4,5)">Siguiente</button>
        </div>

      </div>
    </div>
  </div>


  <!-- modal phases - Resumen -->
  <div class="modal fade" id="modal-phases-5">
    <div class="modal-dialog modal-xl">
      <div class="modal-content">

        <div class="modal-header">
          <h4 class="modal-title">Quinielas - Fases</h4>
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
                      <h3 id="card-title" class="card-title">Resumen</h3>
                    </div>

                    <div class="card-body">

                      <div class="row mrg-top-20">
                        <div class="col-12 col-md-6">
                            <div class="form-group">
                                <label>Titulo: <span id="titulo_resume_phases" class="text-normal"></span></label>
                            </div>
                            <div class="form-group">
                                <label>Inicio: <span id="fecha_inicio_resume_phases" class="text-normal"></span></label>
                            </div>
                            <div class="form-group">
                                <label>Fin: <span id="fecha_fin_resume_phases" class="text-normal"></span></label>
                            </div>
                        </div>
                      </div>


                      <div class="row">
                        <div class="col-12 col-md-6">
                          <h2 class="text-center">Partidos</h2>
                          <table id="partidos_resume_phases" class="table">
                            <thead>
                              <tr>
                                <th>Partidos</th>
                                <th></th>
                              </tr>
                            </thead>
                            <tbody></tbody>
                          </table>
                        </div>

                        <div class="col-12 col-md-6">
                          <h2 class="text-center">Preguntas</h2>
                          <table id="preguntas_resume_phases" class="table">
                            <thead>
                              <tr>
                                <th>Preguntas</th>
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
          <button type="button" class="btn btn-dark" onclick="nextModalPhases(5,4)">Atras</button>
          <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
          <button type="button" class="btn btn-primary" onclick="updatePhases()">Guardar Fase</button>
        </div>

      </div>
    </div>
  </div>
</form>