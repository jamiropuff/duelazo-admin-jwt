<?php 
$menu1 = ''; // matches
$menu2 = ''; // brackets
$menu3 = ''; // pools
$menu4 = ''; // users
$menu5 = ''; // verify users
$menu6 = ''; // balance
$menu7 = ''; // streaks

switch($title){
  case 'Partidos':
    $menu1 = 'active';
  break;

  case 'Brackets':
  case 'Brackets Fase 2':
    $menu2 = 'active';
  break;

  case 'Quinielas':
    $menu3 = 'active';
  break;

  case 'Usuarios':
    $menu4 = 'active';
  break;

  case 'Verificación de Usuarios':
    $menu5 = 'active';
  break;

  case 'Balance':
    $menu6 = 'active';
  break;

  case 'Rachas':
    $menu7 = 'active';
  break;

  default:
    $menu1 = 'active';
  break;
}
?>

<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-light-primary elevation-4">
  <!-- Brand Logo -->
  <a href="/home" class="brand-link">
    <img src="<?= base_url() ?>/images/logo-d.png" alt="Duelazo" class="brand-image img-circle elevation-3" style="opacity: .8">
    <span class="brand-text font-weight-light">&nbsp; <img src="<?= base_url() ?>/images/duelazo-letra-azul2.png" alt="Duelazo" class="brand-image" style="opacity: .8; margin-left: -35px; width: 60%; margin-top: 1px;"></span>
  </a>

  <!-- Sidebar -->
  <div class="sidebar">
    <!-- Sidebar user panel (optional) -->
    <div class="user-panel mt-3 pb-3 mb-3 d-flex">
      <div class="image">
          <img src="<?= base_url() ?>/img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image">
        </div>
      <div class="info">
        <a href="#" class="d-block"><?= session('name').' '.session('last_name'); ?></a>
      </div>
    </div>

    <!-- SidebarSearch Form -->
    <div class="form-inline">
      <div class="input-group" data-widget="sidebar-search">
        <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
        <div class="input-group-append">
          <button class="btn btn-sidebar">
            <i class="fas fa-search fa-fw"></i>
          </button>
        </div>
      </div>
    </div>


    <!-- Sidebar Menu -->
    <nav class="mt-2">
      <ul class="nav nav-pills nav-sidebar flex-column nav-child-indent text-sm" data-widget="treeview" role="menu" data-accordion="false">
        <!-- Add icons to the links using the .nav-icon class
             with font-awesome or any other icon font library -->

        <li class="nav-item">
          <a href="/matches" class="nav-link <?= $menu1; ?>">
            <i class="far fa-calendar-alt"></i>
            <p>
              Partidos
            </p>
          </a>
        </li>

        <li class="nav-item">
          <a href="/brackets" class="nav-link <?= $menu2; ?>">
            <i class="fas fa-sitemap"></i>
            <p>
              Brackets
            </p>
          </a>
        </li>

        <li class="nav-item">
          <a href="/pools" class="nav-link <?= $menu3; ?>">
            <i class="fas fa-tasks"></i>
            <p>
              Quinielas
            </p>
          </a>
        </li>

        <li class="nav-item">
          <a href="/streaks" class="nav-link <?= $menu7; ?>">
            <i class="fas fa-bolt"></i>
            <p>
              Rachas
            </p>
          </a>
        </li>

        <li class="nav-item">
          <a href="/users" class="nav-link <?= $menu4; ?>">
            <i class="fas fa-users"></i>
            <p>
              Usuarios
            </p>
          </a>
        </li>

        <li class="nav-item">
          <a href="/users/verify" class="nav-link <?= $menu5; ?>">
            <i class="fas fa-user-check"></i>
            <p>
              Verificación de Usuarios
            </p>
          </a>
        </li>

        <li class="nav-item">
          <a href="/balance" class="nav-link <?= $menu6; ?>">
            <i class="fas fa-dollar-sign"></i>
            <p>
              Balance
            </p>
          </a>
        </li>
          
        <li class="nav-item">
          <a href="/logout" class="nav-link">
            <i class="fas fa-sign-out-alt"></i>
            <p>
              Cerrar Sesión
            </p>
          </a>
        </li>
      </ul>
    </nav>
    <!-- /.sidebar-menu -->
  </div>
  <!-- /.sidebar -->
</aside>