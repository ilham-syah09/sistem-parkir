<!-- sidebar menu -->
<div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
    <div class="menu_section">
        <h3>Menu</h3>
        <ul class="nav side-menu">
            <li><a href="<?= base_url('user'); ?>"><i class="fa fa-home"></i>Dashboard</a></li>
            <li><a href="<?= base_url('user/data'); ?>"><i class="fa fa-book"></i>Rekap Parkir</a></li>
            <li><a href="<?= base_url('user/profile'); ?>"><i class="fa fa-user"></i>Profile</a></li>
            <li><a href="<?= base_url('auth/logout'); ?>" onclick="return confirm('Apakah yakin akan meninggalkan halaman ini?')"><i class="fa fa-sign-out"></i>Logout</a></li>
        </ul>
    </div>

</div>
<!-- /sidebar menu -->