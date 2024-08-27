<?php //echo "<pre>", var_dump($resources->sponsors), "</pre>"; ?>
<?php if (isset($resources)) : ?>
<?php $x = 1; ?>
<?php foreach ($resources->sponsors as $sponsors) : ?>
<?php 
if($x == 1){
  $sponsors_file_id = $sponsors->s3_file_id;
  $sponsors_id = $sponsors->id;
  $sponsors_file_exist = '';

  // Se busca la imagen en el servidor local de lo contrario se pide al API
  $img_sponsors = 'images/sponsors/'.$sponsors->s3_file_id.'.png';
  if (file_exists($img_sponsors)) {
    $sponsors_file_exist .= $sponsors->s3_file_id;
  }
}else{
  $sponsors_file_id .= ','.$sponsors->s3_file_id;
  $sponsors_id .= ','.$sponsors->id;

  // Se busca la imagen en el servidor local de lo contrario se pide al API
  $img_sponsors = 'images/sponsors/'.$sponsors->s3_file_id.'.png';
  if (file_exists($img_sponsors)) {
    $sponsors_file_exist .= ','.$sponsors->s3_file_id;
  }
}
$x++; 
?>
<?php endforeach ?>
<?php endif ?>

<?php
//  echo "sponsors_file_id: ".$sponsors_file_id."<br>";
//  echo "sponsors_id: ".$sponsors_id."<br>";
//  echo "sponsors_file_exist: ".$sponsors_file_exist."<br>";
?>


<section class="content">
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-12">

                <div class="card">

                    <div class="card-header">
                        <div class="row">

                            <div class="col-12 col-md-3 pad-top-32">
                                <button class="btn btn-block btn-primary" data-toggle="modal" data-target="#modal-add-1"> <i class="fas fa-plus"></i> Crear Bracket</button>
                            </div>
                        </div>

                    </div>

                    <div id="divBrackets" class="card-body" style="overflow-x: scroll;">
                        <!-- table-responsive p-0 -->
                        <table id="tblBrackets" class="table table-bordered table-striped">
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
                                <?php if (isset($brackets)) : ?>
                                    <?php foreach ($brackets as $bracket) : ?>
                                        <?php
                                        if (isset($bracket->status)) {
                                            switch ($bracket->status) {
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

                                                case 'fase 1':
                                                    $_color_status1 = 'c-green';
                                                    $_color_status2 = 'c-blue';
                                                    $_color_status3 = 'c-gray-light';
                                                    $_icon_status = '<i class="fas fa-lock-open"></i>';
                                                    $_texto_status = 'en curso';
                                                    break;

                                                case 'fase 2':
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
                                        <tr>
                                            <td><?= $bracket->title ?></td>
                                            <td><?= $bracket->subtitle ?></td>
                                            <td>
                                                <img id="sport_img_<?= $bracket->sport_id ?>" src="<?= base_url() ?>/images/icons/<?= $bracket->sport_id ?>.png" class="img-fluid mrg-lr-10 sport" width="20px">
                                                <?= $bracket->sport->name ?>
                                            </td>
                                            <td class="text-center">
                                                <i class="fas fa-circle <?= $_color_status1 ?>"></i><i class="fas fa-minus <?= $_color_status2 ?>"></i><i class="fas fa-circle <?= $_color_status2 ?>"></i><i class="fas fa-minus <?= $_color_status3 ?>"></i><i class="fas fa-circle <?= $_color_status3 ?>"></i><br>
                                                <?= $_texto_status ?>
                                            </td>
                                            <td class="text-center"><?= $bracket->start_date ?></td>
                                            <td class="text-center">
                                                <button class="btn" onclick="modalEdit(<?= $bracket->id ?>)" title="editar"><i class="fas fa-pencil-alt"></i></button>
                                                <button class="btn" onclick="delBrackets(<?= $bracket->id ?>)" title="eliminar"><i class="far fa-trash-alt"></i></button>

                                                <a href="<?= base_url() ?>/brackets/phase2/<?= $bracket->id ?>" class="btn" title="fase 2"><i class="fas fa-project-diagram"></i></a>

                                                <button class="btn" onclick="chageStatus(<?= $bracket->id ?>,'<?= $bracket->status ?>')" title="cambiar estatus"><?= $_icon_status ?></button>
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


<form id="frmBracketAdd" method="post" action="<?= base_url(); ?>/brackets/save" autocomplete="off">
    <!-- modal add - Step 1 -->
    <div class="modal fade" id="modal-add-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">

                <div class="modal-header">
                    <h4 class="modal-title">Brackets</h4>
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
                                            <h3 id="card-title" class="card-title">Crear Bracket (1/5)</h3>
                                        </div>


                                        <div class="card-body">

                                            <div class="form-group">
                                                <label>Patrocinador</label>
                                                <input type="hidden" id="resources_sponsor_file" value="<?= $sponsors_file_id ?>">
                                                <input type="hidden" id="resources_sponsor_file_exist" value="<?= $sponsors_file_exist ?>">
                                                <input type="hidden" id="resources_sponsor_id" value="<?= $sponsors_id ?>">

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

                                            <div class="row">
                                                <div class="col-6">
                                                    <div class="form-group">
                                                        <label for="fecha_limite">Fecha límite para que el usuario llene la Fase 2</label>
                                                        <input type="date" id="fecha_limite" name="fecha_limite" class="form-control">
                                                    </div>
                                                </div>
                                                <div class="col-6">
                                                    <div class="form-group">
                                                        <label for="horario_limite">Horario límite para que el usuario llene la Fase 2</label>
                                                        <input type="time" id="horario_limite" name="horario_limite" class="form-control">
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
                    <h4 class="modal-title">Brackets</h4>
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
                                            <h3 id="card-title" class="card-title">Crear Bracket (2/5)</h3>
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
                    <h4 class="modal-title">Brackets</h4>
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
                                            <h3 id="card-title" class="card-title">Crear Bracket (3/5)</h3>
                                        </div>


                                        <div class="card-body">

                                            <div class="form-group">
                                                <label>Deporte</label>
                                                <div class="text-center">
                                                    <?php $x = 1; ?>
                                                    <?php if (isset($resources)) : ?>
                                                        <?php foreach ($resources->sports as $sports) : ?>
                                                            <label class="cur-pointer" onclick="selectSportModal(<?= $sports->id ?>,'add')">
                                                                <img id="sport_image_search_<?= $sports->id ?>" src="<?= base_url() ?>/images/icons/<?= $sports->id ?>.png" class="img-fluid mrg-lr-10 sport-search" width="50px">
                                                            </label>
                                                            <?php $x++; ?>
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
                    <h4 class="modal-title">Brackets</h4>
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
                                            <h3 id="card-title" class="card-title">Crear Bracket (4/5)</h3>
                                        </div>

                                        <div class="card-body">
                                            <table id="tblBracketsGroup" class="table table-bordered table-striped">
                                                <thead>
                                                    <tr>
                                                        <th>Liga</th>
                                                        <th>Local</th>
                                                        <th>Visitante</th>
                                                        <th>Fecha</th>
                                                        <th>Grupo</th>
                                                        <th>Jornada</th>
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
                    <h4 class="modal-title">Brackets</h4>
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
                                            <h3 id="card-title" class="card-title">Crear Bracket (5/5)</h3>
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
                                                        <label>Inicio: <span id="fecha_inicio_resume" class="text-normal"></span></label> |
                                                        <label>Fin: <span id="fecha_fin_resume" class="text-normal"></span></label>
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
                                                    <table id="partidos_resume" class="table">
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
                    <button type="button" class="btn btn-dark" onclick="nextModalAdd(5,4)">Atras</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                    <button type="button" class="btn btn-primary" onclick="save()">Crear Bracket</button>
                </div>

            </div>
        </div>
    </div>

</form>


<!-- ************************************************************************************************************************************** -->

<form id="frmBracketEdit" method="post" action="<?= base_url(); ?>/brackets/update" autocomplete="off">
    <input type="hidden" id="bracket_edit_id" name="bracket_edit_id" value="">
    <!-- modal edit - Step 1 -->
    <div class="modal fade" id="modal-edit-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">

                <div class="modal-header">
                    <h4 class="modal-title">Brackets</h4>
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
                                            <h3 id="card-title" class="card-title">Editar Bracket (1/5)</h3>
                                        </div>


                                        <div class="card-body">

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

                                            <div class="row">
                                                <div class="col-6">
                                                    <div class="form-group">
                                                        <label for="fecha_limite_edit">Fecha límite para que el usuario llene la Fase 2</label>
                                                        <input type="date" id="fecha_limite_edit" name="fecha_limite_edit" class="form-control">
                                                        <input type="hidden" id="fecha_limite_edit_old" name="fecha_limite_edit_old" class="form-control">
                                                    </div>
                                                </div>
                                                <div class="col-6">
                                                    <div class="form-group">
                                                        <label for="horario_limite_edit">Horario límite para que el usuario llene la Fase 2</label>
                                                        <input type="time" id="horario_limite_edit" name="horario_limite_edit" class="form-control">
                                                        <input type="hidden" id="horario_limite_edit_old" name="horario_limite_edit_old" class="form-control">
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
                    <h4 class="modal-title">Brackets</h4>
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
                                            <h3 id="card-title" class="card-title">Editar Bracket (2/5)</h3>
                                        </div>


                                        <div class="card-body">

                                            <div class="form-group">
                                                <label for="total_awards">Total de premios</label>
                                                <input type="text" id="total_awards_edit" name="total_awards_edit" class="form-control" placeholder="200">
                                            </div>
                                            <div class="form-group">
                                                <label>Cantidad: <span id="cantidad_award_edit"></span></label>
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
                    <h4 class="modal-title">Brackets</h4>
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
                                            <h3 id="card-title" class="card-title">Editar Bracket (3/5)</h3>
                                        </div>


                                        <div class="card-body">

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
                                                <button type="button" id="btn-search-edit" name="btn-search-edit" class="form-control btn btn-dark" onclick="listarBracketsMatchesEdit()"><i class="fas fa-search"></i> Buscar</button>
                                            </div>

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
                    <h4 class="modal-title">Brackets</h4>
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
                                            <h3 id="card-title" class="card-title">Editar Bracket (4/5)</h3>
                                        </div>

                                        <div class="card-body">
                                            <table id="tblBracketsGroupEdit" class="table table-bordered table-striped">
                                                <thead>
                                                    <tr>
                                                        <th>Liga</th>
                                                        <th>Local</th>
                                                        <th>Visitante</th>
                                                        <th>Fecha</th>
                                                        <th>Grupo</th>
                                                        <th>Jornada</th>
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
                    <h4 class="modal-title">Brackets</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">
                    <section class="content">
                        <div class="container-fluid">
                            <div class="row justify-content-center">
                                <div class="col-12">

                                    <div id="card-bg-title-resume-edit" class="card card-primary">

                                        <div class="card-header">
                                            <h3 id="card-title" class="card-title">Editar Bracket (5/5)</h3>
                                        </div>

                                        <div class="card-body">

                                            <label>Test: </label>
                                            <input type="checkbox" id="test" name="test" checked data-bootstrap-switch data-off-color="danger" data-on-color="success">

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
                                                        <label>Fin: <span id="fecha_fin_resume_edit" class="text-normal"></span></label>
                                                    </div>
                                                </div>
                                                <div class="col-12 col-md-6">
                                                    <div class="form-group">
                                                        <label>Patrocinador:</label>
                                                        <img id="sponsor_image_add_resume_edit" src="<?= base_url() ?>/images/sponsors/" class="img-fluid mrg-lr-10" width="70px">
                                                    </div>
                                                    <div class="form-group">
                                                        <label>Deporte:</label>
                                                        <img id="sport_image_add_resume_edit" src="<?= base_url() ?>/images/icons/" class="img-fluid mrg-lr-10" width="50px">
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
                    <button type="button" class="btn btn-primary" onclick="update()">Guardar Bracket</button>
                </div>

            </div>
        </div>
    </div>

</form>




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
                                                                <img src="<?= base_url() . '/images/physical_awards/' . $physical_awards->s3_file_id ?>.png" class="img-fluid" width="50" onclick="selectAwardAdd(<?= $physical_awards->id ?>,'<?= $physical_awards->title ?>')">
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