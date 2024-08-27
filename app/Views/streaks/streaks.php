<section class="content">
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-12">

                <div class="card">

                    <div class="card-header">
                        <div class="row">
                            <div class="col-12 col-md-12 col-lg-8">

                                <div class="row">
                                    <div class="col-12 col-md-3 pad-top-32">
                                        <a href="<?= base_url() ?>/streaks" class="btn btn-dark btn-block"> <i class="fas fa-angle-double-left"></i> Regresar</a>
                                    </div>
                                    <div class="col-10 col-md-6">
                                        <label for="start_day_search">Día(s) de búsqueda</label>
                                        <input type="number" id="start_day_search" name="start_day_search" value="0" class="form-control" placeholder="Ej. -20 ó 15">
                                    </div>

                                    <div class="col-2 col-md-2 pad-top-32">
                                        <button type="button" id="btn-search" name="btn-search" class="form-control btn btn-dark" onclick="listarStreaks('tblStreaks')"><i class="fas fa-search"></i></button>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>

                    <div id="divStreaks" class="card-body" style="overflow-x: scroll;">
                        <!-- table-responsive p-0 -->
                        <table id="tblStreaks" class="table table-bordered table-striped ">
                            <thead>
                                <tr>
                                    <th>Deporte</th>
                                    <th width="20%">Pregunta</th>
                                    <th width="10%">Local</th>
                                    <th width="10%">Visitante</th>
                                    <th>Ganador</th>
                                    <th>VIP</th>
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
                                        //echo "status: ".$rachas->status."<br>";
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

                                                case 'closed':
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

                                        // Ganador
                                        $answer = '';
                                        if($rachas->answer != NULL || $rachas->answer != null){
                                            // Ganador Local
                                            if($rachas->answer == '0'){
                                                $answer = 'Local';
                                            }

                                            // Ganador Visitante
                                            if($rachas->answer == '1'){
                                                $answer = 'Visitante';
                                            }

                                            // Ganador Push
                                            if($rachas->answer == 'Push'){
                                                $answer = 'Push';
                                            }
                                        }

                                        // Opciones Local y Visitante
                                        $options1 = $rachas->options;
                                        $options2 = substr($options1, 1, -1);
                                        list($local_quote,$visitor_quote) = explode(",",$options2);
                                        $local = str_replace("'","",$local_quote);
                                        $local = trim($local);
                                        $visitante = str_replace("'","",$visitor_quote);
                                        $visitante = trim($visitante);

                                        // Abreviaturas
                                        $local_abv = '';
                                        $visitante_abv = '';
                                        if($rachas->options_abbreviation != NULL || $rachas->options_abbreviation != null){
                                            $options_abv1 = $rachas->options_abbreviation;
                                            $options_abv2 = substr($options_abv1, 1, -1);
                                            list($local_abv_quote,$visitor_abv_quote) = explode(",",$options_abv2);
                                            $local_abv = str_replace("'","",$local_abv_quote);
                                            $local_abv = trim($local_abv);
                                            $visitante_abv = str_replace("'","",$visitor_abv_quote);
                                            $visitante_abv = trim($visitante_abv);
                                        }

                                        // Extras
                                        $local_extra = '';
                                        $visitante_extra = '';
                                        if($rachas->extra != NULL || $rachas->extra != null){
                                            $extra1 = $rachas->extra;
                                            $extra2 = substr($extra1, 1, -1);
                                            list($local_extra_quote,$visitor_extra_quote) = explode(",",$extra2);
                                            $local_extra = str_replace("'","",$local_extra_quote);
                                            $local_extra = trim($local_extra);
                                            $visitante_extra = str_replace("'","",$visitor_extra_quote);
                                            $visitante_extra = trim($visitante_extra);
                                        }

                                        //VIP
                                        $is_vip = '';
                                        if(isset($rachas->is_vip) && $rachas->is_vip == 1){
                                            $is_vip = '<i class="fas fa-check"></i>';
                                        }
                                        ?>
                                        <tr id="row_<?= $rachas->id ?>">
                                            <td class="text-center"><img src="/images/icons/<?= $rachas->sport->id ?>.png" class="img-fluid" width="30px"></td>
                                            <td><?= $rachas->question ?></td>
                                            <td><?= $local ?></td>
                                            <td><?= $visitante ?></td>
                                            <td><?= $answer ?></td>
                                            <td class="text-center"><?= $is_vip ?></td>
                                            <td class="text-center">
                                                <i class="fas fa-circle <?= $_color_status1 ?>"></i><i class="fas fa-minus <?= $_color_status2 ?>"></i><i class="fas fa-circle <?= $_color_status2 ?>"></i><i class="fas fa-minus <?= $_color_status3 ?>"></i><i class="fas fa-circle <?= $_color_status3 ?>"></i><br>
                                                <?= $_texto_status ?>
                                            </td>
                                            <td class="text-center"><?= $rachas->limit_date ?></td>
                                            <td class="text-center">
                                                <button class="btn" title="editar" onclick="editStreaks('<?= $rachas->id ?>','<?= $local ?>','<?= $visitante ?>','<?= $rachas->limit_date ?>','<?= $rachas->question ?>','<?= $local_abv ?>','<?= $visitante_abv ?>','<?= $local_extra ?>','<?= $visitante_extra ?>','<?= $answer ?>','<?= $rachas->status ?>','<?= $is_vip ?>')"><i class="fas fa-pencil-alt"></i></button>
                                                <button class="btn" onclick="delStreaks(<?= $rachas->id ?>)" title="eliminar"><i class="far fa-trash-alt"></i></button>
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


<!-- modal edit -->
<div class="modal fade" id="modal-streak-edit">
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
                                        <h3 id="card-title" class="card-title">Editar Racha</h3>
                                    </div>


                                    <div class="card-body">

                                        <div class="form-group">
                                            <input type="hidden" id="streak_id" name="streak_id">
                                        </div>

                                        <div class="form-group">
                                            <label>VIP: </label>
                                            <input type="checkbox" id="vip" name="vip" data-bootstrap-switch data-off-color="danger" data-on-color="success">
                                            <input type="hidden" id="vip_old" name="vip_old" class="form-control">
                                        </div>

                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-12 col-md-6">
                                                    <label for="local_text">Local</label>
                                                    <input type="text" id="local_text" name="local_text" class="form-control" disabled>
                                                </div>
                                                <div class="col-12 col-md-6">
                                                    <label for="visitante_text">Visitante</label>
                                                    <input type="text" id="visitante_text" name="visitante_text" class="form-control" disabled>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-12 col-md-6">
                                                    <label for="show_streak_id">ID</label>
                                                    <input type="text" id="show_streak_id" name="show_streak_id" class="form-control" disabled>
                                                </div>
                                                <div class="col-12 col-md-6">
                                                    <label for="fecha">Fecha</label>
                                                    <input type="text" id="fecha" name="fecha" class="form-control" disabled>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-12 col-md-6">
                                                    <label for="fecha_limite">Fecha</label>
                                                    <input type="date" id="fecha_limite" name="fecha_limite" class="form-control">
                                                    <input type="hidden" id="fecha_limite_old" name="fecha_limite_old" class="form-control">
                                                </div>
                                                <div class="col-12 col-md-6">
                                                    <label for="horario_limite">Horario</label>
                                                    <input type="time" id="horario_limite" name="horario_limite" class="form-control">
                                                    <input type="hidden" id="horario_limite_old" name="horario_limite_old" class="form-control">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-12">
                                                    <label>Estatus</label>
                                                </div>
                                                <div class="col-12 col-md-5 text-center">
                                                    <label for="status_open">Abierto</label><br>
                                                    <input type="radio" id="status_open" name="status" class="status" value="open">
                                                </div>
                                                <div class="col-12 col-md-2 text-center">
                                                    <label for="status_running">En curso</label><br>
                                                    <input type="radio" id="status_running" name="status" class="status" value="running">
                                                </div>
                                                <div class="col-12 col-md-5 text-center">
                                                    <label for="status_closed">Finalizado</label><br>
                                                    <input type="radio" id="status_closed" name="status" class="status" value="closed">
                                                </div>
                                                <input type="hidden" id="status_old" name="status_old" class="form-control">
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="pregunta">Pregunta</label>
                                            <input type="text" id="pregunta" name="pregunta" class="form-control">
                                            <input type="hidden" id="pregunta_old" name="pregunta_old" class="form-control">
                                        </div>

                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-12 col-md-5">
                                                    <label for="local">Opción 1</label>
                                                    <input type="text" id="local" name="local" class="form-control">
                                                    <input type="hidden" id="local_old" name="local_old" class="form-control">
                                                </div>
                                                <div class="col-12 col-md-2"></div>
                                                <div class="col-12 col-md-5">
                                                    <label for="visitante">Opción 2</label>
                                                    <input type="text" id="visitante" name="visitante" class="form-control">
                                                    <input type="hidden" id="visitante_old" name="visitante_old" class="form-control">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-12 col-md-5">
                                                    <label for="local_extra">Extra 1</label>
                                                    <input type="text" id="local_extra" name="local_extra" class="form-control">
                                                    <input type="hidden" id="local_extra_old" name="local_extra_old" class="form-control">
                                                </div>
                                                <div class="col-12 col-md-2"></div>
                                                <div class="col-12 col-md-5">
                                                    <label for="visitante_extra">Extra 2</label>
                                                    <input type="text" id="visitante_extra" name="visitante_extra" class="form-control">
                                                    <input type="hidden" id="visitante_extra_old" name="visitante_extra_old" class="form-control">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-12 col-md-5">
                                                    <label for="local_abv">Abreviación 1</label>
                                                    <input type="text" id="local_abv" name="local_abv" class="form-control">
                                                    <input type="hidden" id="local_abv_old" name="local_abv_old" class="form-control">
                                                </div>
                                                <div class="col-12 col-md-2"></div>
                                                <div class="col-12 col-md-5">
                                                    <label for="visitante_abv">Abreviación 2</label>
                                                    <input type="text" id="visitante_abv" name="visitante_abv" class="form-control">
                                                    <input type="hidden" id="visitante_abv_old" name="visitante_abv_old" class="form-control">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-12 col-md-5 text-center">
                                                    <label for="ganador_local">Ganador</label>
                                                    <input type="radio" id="ganador_local" name="ganador" class="form-control ganador" value="Local">
                                                </div>
                                                <div class="col-12 col-md-2 text-center">
                                                    <label for="ganador_push">Push</label>
                                                    <input type="radio" id="ganador_push" name="ganador" class="form-control ganador" value="Push">
                                                </div>
                                                <div class="col-12 col-md-5 text-center">
                                                    <label for="ganador_visitante">Ganador</label>
                                                    <input type="radio" id="ganador_visitante" name="ganador" class="form-control ganador" value="Visitante">
                                                </div>
                                                <input type="hidden" id="ganador_old" name="ganador_old" class="form-control">
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
                <button type="button" class="btn btn-primary" onclick="updateStreaks()">Guardar</button>
            </div>

        </div>
    </div>
</div>