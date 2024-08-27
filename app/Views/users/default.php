<section class="content">
  <div class="container-fluid">
    <div class="row justify-content-center">
      <div class="col-12">

        <div class="card">

          <div class="card-header">
            <div class="row">

              <div class="col-12 col-md-3 pad-top-32">
                <!--<button class="btn btn-block btn-primary" data-toggle="modal" data-target="#modal-add"> <i class="fas fa-plus"></i> Agregar Partido</button>-->
              </div>
            </div>

            <hr>

            <div class="row">
              <div class="col-12 col-md-4 col-lg-3">
                <label for="nickname">Nickname</label>
                <input type="text" name="nickname" id="nickname" class="form-control">
              </div>

              <div class="col-10 col-md-4 col-lg-3">
                <label for="email">Email</label>
                <input type="email" name="email" id="email" class="form-control">
              </div>

              <div class="col-10 col-md-2 col-lg-2">
                <label for="user_id">ID del usuario</label>
                <input type="number" name="user_id" id="user_id" class="form-control">
              </div>

              <div class="col-2 col-md-1 pad-top-32">
                <button type="button" id="btn-search" name="btn-search" class="form-control btn btn-dark" onclick="searchUser()"><i class="fas fa-search"></i></button>
              </div>

            </div>
          </div>

          <div id="divUsers" class="card-body" style="overflow-x: scroll;">
            <!-- table-responsive p-0 -->
          </div>

        </div>

      </div>
    </div>
  </div>
</section>


<!-- modal edit -->
<div class="modal fade" id="modal-edit">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">

      <div class="modal-header">
        <h4 class="modal-title">Usuarios</h4>
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
                    <h3 id="card-title" class="card-title">Editar Usuario</h3>
                  </div>

                  <form id="frmUserEdit" method="post" action="users/update" autocomplete="off">
                    <div class="card-body">

                    <input type="hidden" name="search_type" id="search_type">

                      <div class="form-group">
                        <label for="rol_user_edit">Rol del Usuario</label>
                        <select id="rol_user_edit" name="rol_user_edit" class="form-control select2" style="width: 100%;"></select>
                        <input type="hidden" id="rol_user_edit_old" name="rol_user_edit_old">
                      </div>

                      <div class="form-group">
                        <label for="name_edit">Nombre</label>
                        <input type="text" id="name_edit" name="name_edit" class="form-control" placeholder="Ej. Alberto">
                        <input type="hidden" id="name_edit_old" name="name_edit_old">
                      </div>

                      <div class="form-group">
                        <label for="last_name_edit">Apellido(s)</label>
                        <input type="text" id="last_name_edit" name="last_name_edit" class="form-control" placeholder="Ej. López">
                        <input type="hidden" id="last_name_edit_old" name="last_name_edit_old">
                      </div>

                      <div class="form-group">
                        <label for="nickname_edit">Nickname</label>
                        <input type="text" id="nickname_edit" name="nickname_edit" class="form-control" placeholder="Ej. Duelalo">
                        <input type="hidden" id="nickname_edit_old" name="nickname_edit_old">
                      </div>

                      <div class="form-group">
                        <label for="email_edit">Correo</label>
                        <input type="email" id="email_edit" name="email_edit" class="form-control" placeholder="Ej. daniel@duelazo.com">
                        <input type="hidden" id="email_edit_old" name="email_edit_old">
                      </div>

                      <div class="form-group">
                        <label for="phone_edit">Teléfono</label>
                        <input type="email" id="phone_edit" name="phone_edit" class="form-control" placeholder="Ej. 5512345678">
                        <input type="hidden" id="phone_edit_old" name="phone_edit_old">
                      </div>

                      <div class="form-group">
                        <label for="birthday_edit">Fecha de nacimiento</label>
                        <input type="date" id="birthday_edit" name="birthday_edit" class="form-control" placeholder="10/10/1992">
                        <input type="hidden" id="birthday_edit_old" name="birthday_edit_old">
                      </div>

                      <div class="form-group">
                        <label for="balance_edit">Balance</label>
                        <input type="number" id="balance_edit" name="balance_edit" class="form-control">
                        <input type="hidden" id="balance_edit_old" name="balance_edit_old">
                      </div>

                      <div class="form-group">
                        <label for="diamonds_edit">Diamantes</label>
                        <input type="number" id="diamonds_edit" name="diamonds_edit" class="form-control" placeholder="Ej. 1232">
                        <input type="hidden" id="diamonds_edit_old" name="diamonds_edit_old">
                      </div>

                      <div class="form-group">
                        <label for="tokens_edit">Tokens</label>
                        <input type="number" id="tokens_edit" name="tokens_edit" class="form-control" placeholder="Ej. 5">
                        <input type="hidden" id="tokens_edit_old" name="tokens_edit_old">
                      </div>

                      <div class="form-group">
                        <label for="boosts_edit">Comodines</label>
                        <input type="number" id="boosts_edit" name="boosts_edit" class="form-control" placeholder="Ej. 5">
                        <input type="hidden" id="boosts_edit_old" name="boosts_edit_old">
                      </div>

                      <div class="form-group">
                        <label for="confirmed_email_edit">Correo confirmado</label>
                        <input type="checkbox" id="confirmed_email_edit" name="confirmed_email_edit" class="form-control">
                        <input type="hidden" id="confirmed_email_edit_old" name="confirmed_email_edit_old">
                        <input type="hidden" id="confirmed_email_edit_source" name="confirmed_email_edit_source">
                      </div>

                      <div class="form-group">
                        <label for="confirmed_phone_edit">Teléfono confirmado</label>
                        <input type="checkbox" id="confirmed_phone_edit" name="confirmed_phone_edit" class="form-control">
                        <input type="hidden" id="confirmed_phone_edit_old" name="confirmed_phone_edit_old">
                        <input type="hidden" id="confirmed_phone_edit_source" name="confirmed_phone_edit_source">
                      </div>

                      <div class="form-group">
                        <label for="verified_edit">Usuario verificado</label>
                        <input type="checkbox" id="verified_edit" name="verified_edit" class="form-control">
                        <input type="hidden" id="verified_edit_old" name="verified_edit_old">
                        <input type="hidden" id="verified_edit_source" name="verified_edit_source">
                      </div>

                      <div class="form-group">
                        <label for="is_subscriber_edit">Suscriptor</label>
                        <input type="checkbox" id="is_subscriber_edit" name="is_subscriber_edit" class="form-control">
                        <input type="hidden" id="is_subscriber_edit_old" name="is_subscriber_edit_old">
                        <input type="hidden" id="is_subscriber_edit_source" name="is_subscriber_edit_source">
                      </div>

                      <div class="form-group">
                        <label for="suscription_type_id_edit">Tipo de Suscriptor</label>
                        <select id="suscription_type_id_edit" name="suscription_type_id_edit" class="form-control select2" style="width: 100%;"></select>
                        <input type="hidden" id="suscription_type_id_edit_old" name="suscription_type_id_edit_old">
                      </div>

                      <div class="form-group">
                        <label for="is_subscriber_edit">Suscriptor desde</label>
                        <input type="datetime-local" id="suscriber_until_edit" name="suscriber_until_edit" class="form-control">
                        <input type="hidden" id="suscriber_until_edit_old" name="suscriber_until_edit_old" class="form-control">
                      </div>

                    </div>

                    <input type="hidden" id="user_id_edit" name="user_id_edit">

                  </form>

                </div>

              </div>
            </div>
        </section>
      </div>
      <div class="modal-footer justify-content-between">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
        <button type="button" class="btn btn-primary" onclick="update()">Guardar cambios</button>
      </div>

    </div>
  </div>
</div>


<!-- modal compras del usuario -->
<div class="modal fade" id="modal-compras">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">

      <div class="modal-header">
        <h4 class="modal-title">Usuario - Compras</h4>
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
                    <h3 id="card-title" class="card-title">Compras del usuario</h3>
                  </div>

                  <!-- Partidos ya creados -->
                  <div id="divCompras" class="card-body">
                    <input type="hidden" name="user_id_compras" id="user_id_compras">

                    <table id="tblCompras" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Título</th>
                                <th>Descripción</th>
                                <th>Pagado con</th>
                                <th>Cantidad</th>
                                <th>Fecha</th>
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
      </div>

    </div>
  </div>
</div>


<!-- modal registros de ganador -->
<div class="modal fade" id="modal-registros-ganador">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">

      <div class="modal-header">
        <h4 class="modal-title">Usuario - Registro de Ganador</h4>
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
                    <h3 id="card-title" class="card-title">Registro de ganador del usuario</h3>
                  </div>

                  <!-- Partidos ya creados -->
                  <div id="divRegistroGanadores" class="card-body">
                    <input type="hidden" name="user_id_compras" id="user_id_compras">

                    <table id="tblRegistroGanadores" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Juego</th>
                                <th>Título</th>
                                <th>Cantidad</th>
                                <th>Fecha</th>
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
      </div>

    </div>
  </div>
</div>