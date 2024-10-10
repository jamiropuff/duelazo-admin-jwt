<section class="content">
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-12">

                <div class="card">

                    <div class="card-header">
                        <div class="row justify-content-center">
                            <a href="<?= base_url(); ?>/users/verify" class="btn btn-primary mrg-lr-10">Usuarios Pendientes de Verificacion</a>
                            <a href="<?= base_url(); ?>/users/verify?status=verified" class="btn btn-primary mrg-lr-10">Usuarios Verificados</a>
                        </div>

                    </div>

                    <div id="divVerification" class="card-body" style="overflow-x: scroll;">
                        <!-- table-responsive p-0 -->
                        <table id="tblVerification" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>Estatus</th>
                                    <th>Nickname</th>
                                    <th>Nombre</th>
                                    <th>Usuario ID</th>
                                    <th>Domicilio</th>
                                    <th>ID</th>
                                    <th>CLABE</th>
                                    <th>CURP</th>
                                    <th>Plan</th>
                                    <th class="text-center">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php /*echo "<pre>", var_dump($response), "</pre>";*/  ?>
                                <?php if (isset($response)) : ?>
                                    <?php foreach ($response as $user_verify) : ?>
                                        <?php
                                        $status_id_verification = $user_verify->status_id_verification;
                                        $comments = $user_verify->comments;

                                        $user_id = $user_verify->user_id;
                                        $nickname = $user_verify->user->nickname;
                                        $nombre = $user_verify->user->name.' '.$user_verify->user->last_name;

                                        $curp = $user_verify->curp;
                                        $file_ine = $user_verify->file_id_ine;
                                        $bank = $user_verify->bank;
                                        $deposit_number = $user_verify->deposit_number;
                                        $file_domicilio = $user_verify->file_id_comprobante_de_domicilio;

                                        $status_id_curp = $user_verify->status_id_curp;
                                        $status_id_ine = $user_verify->status_id_ine;
                                        $status_id_estado_de_cuenta = $user_verify->status_id_estado_de_cuenta;
                                        $status_id_comprobante_de_domicilio = $user_verify->status_id_comprobante_de_domicilio;

                                        // MISSING = 5
                                        // IN_VERIFICATION = 6
                                        // ACEPTED = 7
                                        // REJECTED = 8

                                        // verificación del usuario
                                        $_class_color_status = 'c-gray-light';
                                        
                                        if($status_id_verification == 5){
                                          $_class_color_status = 'c-gray-light';
                                        }
                                        if($status_id_verification == 6){
                                          $_class_color_status = 'c-yellow';
                                        }
                                        if($status_id_verification == 7){
                                          $_class_color_status = 'c-green';
                                        }
                                        if($status_id_verification == 8){
                                          $_class_color_status = 'c-red';
                                        }


                                        // comprobante de domicilio
                                        $_class_color_domicilio = 'c-gray-light';
                                        
                                        if($status_id_comprobante_de_domicilio == 5){
                                          $_class_color_domicilio = 'c-gray-light';
                                        }
                                        if($status_id_comprobante_de_domicilio == 6){
                                          $_class_color_domicilio = 'c-yellow';
                                        }
                                        if($status_id_comprobante_de_domicilio == 7){
                                          $_class_color_domicilio = 'c-green';
                                        }
                                        if($status_id_comprobante_de_domicilio == 8){
                                          $_class_color_domicilio = 'c-red';
                                        }

                                        // Identificación Oficial
                                        $_class_color_ine = 'c-gray-light';
                                        
                                        if($status_id_ine == 5){
                                          $_class_color_ine = 'c-gray-light';
                                        }
                                        if($status_id_ine == 6){
                                          $_class_color_ine = 'c-yellow';
                                        }
                                        if($status_id_ine == 7){
                                          $_class_color_ine = 'c-green';
                                        }
                                        if($status_id_ine == 8){
                                          $_class_color_ine = 'c-red';
                                        }

                                        // Cuenta de Depósito
                                        $_class_color_clabe = 'c-gray-light';
                                        
                                        if($status_id_estado_de_cuenta == 5){
                                          $_class_color_clabe = 'c-gray-light';
                                        }
                                        if($status_id_estado_de_cuenta == 6){
                                          $_class_color_clabe = 'c-yellow';
                                        }
                                        if($status_id_estado_de_cuenta == 7){
                                          $_class_color_clabe = 'c-green';
                                        }
                                        if($status_id_estado_de_cuenta == 8){
                                          $_class_color_clabe = 'c-red';
                                        }

                                        // Cuenta de Depósito
                                        $_class_color_curp = 'c-gray-light';
                                        
                                        if($status_id_curp == 5){
                                          $_class_color_curp = 'c-gray-light';
                                        }
                                        if($status_id_curp == 6){
                                          $_class_color_curp = 'c-yellow';
                                        }
                                        if($status_id_curp == 7){
                                          $_class_color_curp = 'c-green';
                                        }
                                        if($status_id_curp == 8){
                                          $_class_color_curp = 'c-red';
                                        }

                                        ?>
                                        <tr id="row_<?= $user_id ?>">
                                            <td class="text-center"><i class="fas fa-circle <?= $_class_color_status; ?>"></i></td>
                                            <td><?= $nickname ?></td>
                                            <td><?= $nombre ?></td>
                                            <td><?= $user_id ?></td>
                                            <td class="text-center"><i class="fas fa-circle <?= $_class_color_domicilio; ?>"></i></td>
                                            <td class="text-center"><i class="fas fa-circle <?= $_class_color_ine; ?>"></i></td>
                                            <td class="text-center"><i class="fas fa-circle <?= $_class_color_clabe; ?>"></i></td>
                                            <td class="text-center"><i class="fas fa-circle <?= $_class_color_curp; ?>"></i></td>
                                            <td>Gratis</td>
                                            <td class="text-center">
                                                <button class="btn" onclick="modalVerify('<?= $user_id ?>','<?= $nombre ?>','<?= $nickname ?>','<?= $curp ?>','<?= $bank ?>','<?= $deposit_number ?>','<?= $file_ine ?>','<?= $file_domicilio ?>','<?= $_class_color_domicilio ?>','<?= $_class_color_ine ?>','<?= $_class_color_clabe ?>','<?= $_class_color_curp ?>','<?= $status_id_curp ?>','<?= $status_id_ine ?>','<?= $status_id_estado_de_cuenta ?>','<?= $status_id_comprobante_de_domicilio ?>')" title="editar"><i class="fas fa-pencil-alt"></i></button>
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

<!-- modal varify -->
<div class="modal fade" id="modal-verify">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">

      <div class="modal-header">
        <h4 class="modal-title">Verificación de Usuario</h4>
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
                    <h3 id="card-title" class="card-title">ID de Usuario: <span id="userID"></span></h3>
                  </div>

                  <form id="frmVerify" method="post" action="" autocomplete="off">
                    <div class="card-body">

                      <div class="form-group">
                        <label for="nombre">Nombre</label>
                        <input type="text" id="nombre" name="nombre" class="form-control" disabled> 
                      </div>

                      <div class="form-group">
                        <label for="nickname">Nickname</label>
                        <input type="text" id="nickname" name="nickname" class="form-control" disabled> 
                      </div>

                      <hr>

                      <div class="form-group">
                        <div class="row">
                          <div class="col-12 col-md-6">
                            <label for="comprobante_domicilio">Comprobante Bancario <i id="circle_comprobante" class="fas fa-circle"></i></label><br>
                            <i class="far fa-file-image fa-2x cur-pointer" onclick="showDomicilio()"></i>

                            <input type="hidden" id="status_id_comprobante_de_domicilio">
                            <input type="hidden" id="status_id_comprobante_de_domicilio_old">
                          </div>
                          <div class="col-12 col-md-6">

                            <div class="row">
                              <div class="col-6 text-center">
                                <i class="fas fa-check-circle fa-2x c-green cur-pointer" onclick="statusDomicilio(7)"></i>
                              </div>
                              <div class="col-6 text-center">
                                <i class="fas fa-times-circle fa-2x c-red cur-pointer" onclick="statusDomicilio(8)"></i>
                              </div>
                            </div>

                          </div>
                        </div>
                      </div>

                      <hr>

                      <div class="form-group">
                        <div class="row">
                          <div class="col-12 col-md-6">
                            <label for="identificacion">Identificación <i id="circle_identificacion" class="fas fa-circle"></i></label><br>
                            <i class="far fa-file-image fa-2x cur-pointer" onclick="showIdentification()"></i>

                            <input type="hidden" id="status_id_ine">
                            <input type="hidden" id="status_id_ine_old">
                          </div>
                          <div class="col-12 col-md-6">

                            <div class="row">
                              <div class="col-6 text-center">
                                <i class="fas fa-check-circle fa-2x c-green cur-pointer" onclick="statusIdentificacion(7)"></i>
                              </div>
                              <div class="col-6 text-center">
                                <i class="fas fa-times-circle fa-2x c-red cur-pointer" onclick="statusIdentificacion(8)"></i>
                              </div>
                            </div>

                          </div>
                        </div>
                      </div>

                      <hr>

                      <div class="form-group">
                        <div class="row">
                          <div class="col-12 col-md-6">
                            <label for="curp">CURP <i id="circle_curp" class="fas fa-circle"></i></label>
                            <input type="text" id="curp" name="curp" class="form-control" disabled>

                            <input type="hidden" id="status_id_curp">
                            <input type="hidden" id="status_id_curp_old">
                          </div>
                          <div class="col-12 col-md-6">

                            <div class="row">
                              <div class="col-6 text-center">
                                <i class="fas fa-check-circle fa-2x c-green cur-pointer" onclick="statusCURP(7)"></i>
                              </div>
                              <div class="col-6 text-center">
                                <i class="fas fa-times-circle fa-2x c-red cur-pointer" onclick="statusCURP(8)"></i>
                              </div>
                            </div>

                          </div>
                        </div>
                      </div>

                      <hr>

                      <div class="form-group">
                        <div class="row">
                          <div class="col-12 col-md-6">
                            <label for="banco">Banco <i id="circle_banco" class="fas fa-circle"></i></label>
                            <input type="text" id="banco" class="form-control" disabled>

                            <label for="cuenta">Cuenta</label>
                            <input type="text" id="cuenta" class="form-control" disabled>

                            <input type="hidden" id="status_id_estado_de_cuenta">
                            <input type="hidden" id="status_id_estado_de_cuenta_old">
                          </div>
                          <div class="col-12 col-md-6">

                            <div class="row">
                              <div class="col-6 text-center">
                                <i class="fas fa-check-circle fa-2x c-green cur-pointer" onclick="statusCuenta(7)"></i>
                              </div>
                              <div class="col-6 text-center">
                                <i class="fas fa-times-circle fa-2x c-red cur-pointer" onclick="statusCuenta(8)"></i>
                              </div>
                            </div>

                          </div>
                        </div>
                      </div>

                      <hr>

                      <div class="form-group">
                        <label for="comentarios">Comentarios</label>
                        <textarea id="comentarios" class="form-control"></textarea>
                        <input type="hidden" id="comentarios_old">
                      </div>

                    </div>

                    <input type="hidden" id="file_ine" name="file_ine">
                    <input type="hidden" id="file_domicilio" name="file_domicilio">
                    <input type="hidden" id="user_id" name="user_id">

                  </form>

                </div>

              </div>
            </div>
        </section>
      </div>
      <div class="modal-footer justify-content-between">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
        <button type="button" class="btn btn-primary" onclick="saveVerify()">Guardar cambios</button>
      </div>

    </div>
  </div>
</div>


<!-- modal image -->
<div class="modal fade" id="modal-file">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">

      <div class="modal-header">
        <h4 class="modal-title">Verificación</h4>
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
                    <h3 id="card-title-file" class="card-title"></h3>
                  </div>

                  <div class="card-body">

                    <div class="form-group">
                      <img id="file-image" class="img-fluid">
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