<section class="content">
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-12">

                <div class="card">

                    <div class="card-header">
                        <div class="row justify-content-center">
                            <?php  //echo "<pre>", var_dump($resources), "</pre>";  ?>

                            <div class="col-12 col-md-6 balance-info">

                                <div class="col-12 pad-top-10">
                                    <div class="row">
                                        <div class="col-6 text-right">
                                            <label>Premios: </label>
                                        </div>
                                        <div class="col-6 text-left">
                                            <?= $resources->premios_quinielas ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 pad-top-10">
                                    <div class="row">
                                        <div class="col-6 text-right">
                                            <label>Balances: </label>
                                        </div>
                                        <div class="col-6 text-left">
                                            <?= $resources->balance_usuarios ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 pad-top-10">
                                    <div class="row">
                                        <div class="col-6 text-right">
                                            <label>Invitaciones: </label>
                                        </div>
                                        <div class="col-6 text-left">
                                            <?= $resources->invitaciones ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 pad-top-10">
                                    <div class="row">
                                        <div class="col-6 text-right">
                                            <label>Retiros: </label>
                                        </div>
                                        <div class="col-6 text-left">
                                            <?= $resources->retiros ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 pad-top-10">
                                    <div class="row">
                                        <div class="col-6 text-right">
                                            <label>Total: </label>
                                        </div>
                                        <div class="col-6 text-left">
                                            <?= $resources->suma ?>
                                        </div>
                                    </div>
                                </div>
                            
                            </div>
                        </div>

                        <div class="row justify-content-center mrg-top-10">
                            <a href="<?= base_url(); ?>/balance" class="btn btn-primary mrg-lr-10">Balance Pendiente</a>
                            <a href="<?= base_url(); ?>/balance?status=deposited" class="btn btn-primary mrg-lr-10">Balance Depositado</a>
                            <a href="<?= base_url(); ?>/balance?status=rejected" class="btn btn-primary mrg-lr-10">Balance Rechazado</a>
                        </div>

                    </div>

                    <div id="divBalance" class="card-body" style="overflow-x: scroll;">
                        <!-- table-responsive p-0 -->
                        <table id="tblBalance" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>Nickname</th>
                                    <th>Email</th>
                                    <th>Cantidad</th>
                                    <th class="text-center">Fecha</th>
                                    <th class="text-center">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php //echo "<pre>", var_dump($balance), "</pre>";  ?>
                                <?php if (isset($balance)) : ?>
                                    <?php foreach ($balance as $user_balance) : ?>
                                        <?php
                                        $nombre = $user_balance->user->name.' '.$user_balance->user->last_name;
                                        $banco = $user_balance->user_verification->bank;
                                        $cuenta_deposito = $user_balance->user_verification->deposit_number;
                                        $cantidad = $user_balance->quantity;
                                        $cantidad_formateada = "$".number_format($user_balance->quantity,2,'.',',');
                                        $status_verification = $user_balance->user_verification->status_id_verification;

                                        $cuenta_verificada = 'No';
                                        if( isset($status_verification) && $status_verification == 9 ){
                                            $cuenta_verificada = 'Si';
                                        }
                                        ?>
                                        <tr id="row_<?= $user_balance->id ?>">
                                            <td><?= $user_balance->user->nickname ?></td>
                                            <td><?= $user_balance->user->email ?></td>
                                            <td><?= $cantidad_formateada ?></td>
                                            <td class="text-center"><?= $user_balance->created ?></td>
                                            <td class="text-center">
                                                <button class="btn" onclick="modalBalance(<?= $user_balance->id ?>,<?= $user_balance->user_id ?>,<?= $user_balance->status_id ?>,'<?= $nombre ?>','<?= $banco ?>','<?= $cuenta_deposito ?>','<?= $cantidad_formateada ?>','<?= $cuenta_verificada ?>')" title="ver"><i class="far fa-eye"></i></button>
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

<!-- modal balance -->
<div class="modal fade" id="modal-balance">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">

      <div class="modal-header">
        <h4 class="modal-title">Balance</h4>
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
                    <h3 id="card-title" class="card-title">Solicitud de Retiro</h3>
                  </div>

                  <form id="frmBalance" method="post" action="" autocomplete="off">
                    <div class="card-body">

                      <div class="form-group">
                        <label for="nombre">Nombre</label>
                        <input type="text" id="nombre" name="nombre" class="form-control" disabled> 
                      </div>

                      <div class="form-group">
                        <label for="banco">Banco</label>
                        <input type="text" id="banco" name="banco" class="form-control" disabled> 
                      </div>

                      <div class="form-group">
                        <label for="clabe">CLABE</label>
                        <input type="text" id="clabe" name="clabe" class="form-control" disabled>
                      </div>

                      <div class="form-group">
                        <label for="cantidad">Cantidad (MXN)</label>
                        <input type="text" id="cantidad" name="cantidad" class="form-control" disabled>
                      </div>

                      <div class="form-group">
                        <label for="cuenta_verificada">Cuenta Verificada</label>
                        <input type="text" id="cuenta_verificada" name="cuenta_verificada" class="form-control" disabled>
                      </div>

                      <div class="form-group">
                        <label for="estado_transferencia">Estado de Transferencia</label>
                        <select id="estado_transferencia" name="estado_transferencia" class="form-control select2" style="width: 100%;">
                            <option value="10">En progreso</option>
                            <option value="11">Depositado</option>
                            <option value="12">Rechazado</option>
                        </select>
                      </div>

                      <div class="form-group">
                        <label for="comentarios">Comentarios</label>
                        <textarea id="comentarios" name="comentarios" class="form-control"></textarea>
                      </div>

                    </div>

                    <input type="hidden" id="balance_id" name="balance_id">

                  </form>

                </div>

              </div>
            </div>
        </section>
      </div>
      <div class="modal-footer justify-content-between">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
        <button type="button" class="btn btn-primary" onclick="save()">Guardar cambios</button>
      </div>

    </div>
  </div>
</div>