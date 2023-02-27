<div class="app-header header-shadow <?php echo theme('header'); ?>">
    <div class="app-header__logo">
        <div class="logo-src"></div>
        <div class="header__pane ml-auto">
            <div>
                <button type="button" class="hamburger close-sidebar-btn hamburger--elastic" data-class="closed-sidebar">
                    <span class="hamburger-box">
                        <span class="hamburger-inner"></span>
                    </span>
                </button>
            </div>
        </div>
    </div>
    <div class="app-header__mobile-menu">
        <div>
            <button type="button" class="hamburger hamburger--elastic mobile-toggle-nav">
                <span class="hamburger-box">
                    <span class="hamburger-inner"></span>
                </span>
            </button>
        </div>
    </div>
    <div class="app-header__menu">
        <span>
            <button type="button" class="btn-icon btn-icon-only btn btn-info btn-sm mobile-toggle-header-nav">
                <span class="btn-icon-wrapper">
                    <i class="fa fa-ellipsis-v fa-w-6"></i>
                </span>
            </button>
        </span>
    </div>
    <div class="app-header__content">
        <div class="app-header-left">
            



<?php 
$hari = ['','Senin','Selasa','Rabu','Kamis','Jum\'at','Sabtu','Minggu'];
 ?>



                        <div class="widget-content p-0">
                            <div class="widget-content-wrapper">
                                <div class="widget-content-right header-user-info ml-3">
                                    <button type="button" class="btn-shadow p-1 btn btn-info btn-sm">
                                        <i class="fa text-white fa-clock pr-1 pl-1"></i>
                                    </button>
                                </div>
                                <div class="widget-content-left  ml-3 header-user-info">
                                    <div class="widget-subheading">
                                        <?php echo $hari[date('w')].', '.intval(date('d')).' '.bulan_global(date('n')).' '.date('Y') ?>
                                    </div>
                                    <div class="widget-heading">
                                        <span id="jam"></span> :
                                            <span id="menit"></span> :
                                            <span id="detik"></span>
                                    </div>
                                </div>

                               
                            </div>
                        </div>

                



            

            


        </div>
        <div class="app-header-right">




























                        <div class="widget-content p-0">
                            <div class="widget-content-wrapper">
                                <div class="widget-content-right header-user-info ml-3">
                                    <button type="button" class="btn-shadow p-1 btn btn-info btn-sm">
                                        <i class="fa text-white fa-money-bill pr-1 pl-1"></i>
                                    </button>
                                </div>
                                <div class="widget-content-left  ml-3 header-user-info">
                                    <div class="widget-subheading">
                                        Tahun Anggaran
                                    </div>
                                    <div class="widget-heading">
                                        <?php echo tahun_anggaran() ?>
                                    </div>
                                </div>
                            </div>
                        </div>
            



            

            <div class="header-btn-lg pr-0">
                <div class="widget-content p-0">
                    <div class="widget-content-wrapper">
                        
                        <div class="widget-content p-0">
                            <div class="widget-content-wrapper">
                                <div class="widget-content-right header-user-info ml-3">
                                    <button type="button" class="btn-shadow p-1 btn btn-info btn-sm">
                                        <i class="fa text-white fa-calendar pr-1 pl-1"></i>
                                    </button>
                                </div>
                                <div class="widget-content-left  ml-3 header-user-info">
                                    <div class="widget-subheading">
                                        Tahapan APBD
                                    </div>
                                    <div class="widget-heading">
                                        <?php echo nama_tahapan() ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            

            <div class="header-btn-lg pr-0">
                <div class="widget-content p-0">
                    <div class="widget-content-wrapper">
                       <div class="widget-content p-0">
                            <div class="widget-content-wrapper">
                                <div class="widget-content-right header-user-info ml-3">
                                    <button type="button" class="btn-shadow p-1 btn btn-info btn-sm">
                                        <i class="fa text-white fas fa-file-signature pr-1 pl-1"></i>
                                    </button>
                                </div>
                                <div class="widget-content-left  ml-3 header-user-info">
                                    <div class="widget-subheading">
                                        Bulan Pelaporan Aktif
                                    </div>
                                    <div class="widget-heading">
                                        
                                        <?php echo konversi_bulan(bulan_aktif()) . ' ' . tahun_anggaran(); ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

<?php if ($this->session->userdata('id_group')==5) { ?>
            <div class="header-btn-lg pr-0">
                <div class="widget-content p-0">
                    <div class="widget-content-wrapper">
                        <div class="header-dots">
                            <div class="dropdown">
                                <div class="widget-content p-0">
                                        <div class="widget-content-wrapper">
                                            <div class="widget-content-right header-user-info ml-3">
                                                <button type="button" class="btn-shadow p-1 btn btn-info btn-sm">
                                                    <i class="fa text-white fa-calendar pr-1 pl-1"></i>
                                                </button>
                                            </div>
                                            <div class="widget-content-left  ml-3 header-user-info">
                                                <div class="widget-subheading">
                                                    Notifikasi
                                                </div>
                                                <div class="widget-heading">
                                                     <a  aria-haspopup="true" aria-expanded="false" data-toggle="dropdown" class="p-0 mr-2 btn btn-link">
                                                    <b><span class="total-notif"></span> Notif</b>
                                                    
                                                    <i class="fa fa-angle-down ml-2 opacity-8"></i>
                                                </a>
                                                    <div tabindex="-1" role="menu" aria-hidden="true" class="dropdown-menu-xl rm-pointers dropdown-menu dropdown-menu-right">
                                                        <div class="dropdown-menu-header mb-0">
                                                            <div class="dropdown-menu-header-inner bg-deep-blue">
                                                                <div class="menu-header-image opacity-1" style="background-image: url('assets/images/dropdown-header/city3.jpg');"></div>
                                                                <div class="menu-header-content text-dark">
                                                                    <h5 class="menu-header-title">Notifications</h5>
                                                                    <h6 class="menu-header-subtitle">You have <b class="total-notif">0</b> unread messages</h6>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <ul class="tabs-animated-shadow tabs-animated nav nav-justified tabs-shadow-bordered p-3">
                                                            <li class="nav-item">
                                                                <a role="tab" class="nav-link active" data-toggle="tab" href="#tab-messages-header">
                                                                    <span>Paket Ditolak <b class="total-notif">0</b></span>
                                                                </a>
                                                            </li>
                                                        </ul>
                                                        <div class="tab-content">
                                                            <div class="tab-pane active" id="tab-messages-header" role="tabpanel">
                                                                <div class="scroll-area-sm">
                                                                    <div class="scrollbar-container">
                                                                        <div class="p-3">
                                                                            <div class="notifications-box" id="notif-paket-ditolak">

                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <ul class="nav flex-column">
                                                            <li class="nav-item-divider nav-item"></li>
                                                            <li class="nav-item-btn text-center nav-item">
                                                                <a class="btn-shadow btn-wide btn-pill btn btn-focus btn-sm" href="<?php echo base_url() ?>realisasi/reject_fisik">Tampil Semua Notifikasi</a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>


                             
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
<?php } ?>
            

            <div class="header-btn-lg pr-0">
                <div class="widget-content p-0">
                    <div class="widget-content-wrapper">
                        <div class="widget-content-left">
                            <div class="btn-group">
                                <a data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="p-0 btn">
                                    <img width="42" class="rounded-circle" src="<?php echo base_url(); ?>assets/sbe/image/user.jpg" alt="">
                                    <i class="fa fa-angle-down ml-2 opacity-8"></i>
                                </a>
                                <div tabindex="-1" role="menu" aria-hidden="true" class="rm-pointers dropdown-menu-lg dropdown-menu dropdown-menu-right">
                                    <div class="dropdown-menu-header">
                                        <div class="dropdown-menu-header-inner bg-info">
                                            <div class="menu-header-image opacity-2" style="background-image: url('assets/images/dropdown-header/city3.jpg');"></div>
                                            <div class="menu-header-content text-left">
                                                <div class="widget-content p-0">
                                                    <div class="widget-content-wrapper">
                                                        <div class="widget-content-left mr-3">
                                                            <img width="42" class="rounded-circle" src="<?php echo base_url(); ?>assets/sbe/image/user.jpg" alt="">
                                                        </div>
                                                        <div class="widget-content-left">
                                                            <div class="widget-heading">
                                                                <?php echo $this->session->userdata('full_name'); ?>
                                                            </div>
                                                            <div class="widget-subheading opacity-8">
                                                                <?php echo $this->session->userdata('group_name'); ?>
                                                            </div>
                                                        </div>
                                                        <div class="widget-content-right mr-2">
                                                            <a href="<?php echo base_url('auth/logout') ?>" class="btn-pill btn-shadow btn-shine btn btn-focus">Logout</a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="scroll-area-xs" style="height: auto;">
                                        <div class="scrollbar-container ps">
                                            <ul class="nav flex-column">
                                                <li class="nav-item-header nav-item">My Account
                                                </li>
                                                <li class="nav-item">
                                                    <a href="javascript:void(0);" class="nav-link">User Theme</a>
                                                </li>
                                                <li class="nav-item">
                                                    <a href="<?php echo base_url() ?>dashboard/my_profile" class="nav-link">My Profile</a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="widget-content-left  ml-3 header-user-info">
                            <div class="widget-heading">
                                <?php echo $this->session->userdata('full_name'); ?> 
                            </div>
                            <div class="widget-subheading">
                                <?php echo $this->session->userdata('nama_instansi'); ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>



          
        </div>
    </div>
</div>


