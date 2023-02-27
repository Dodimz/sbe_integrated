<div class="scrollbar-sidebar ps ps--active-y">
    <div class="app-sidebar__inner">
        <ul class="vertical-nav-menu">
            <?php
            $category_menu_groups = $this->db->query("SELECT id_category_menu FROM v_category_menu_groups WHERE group_name ='{$this->session->userdata('group_name')}'")->result_array();
            $id_category_menu = flatten($category_menu_groups);
            if(!empty($id_category_menu))
            {
                $kategori_menu = $this->menu_model->flatten('master_category_menu',['is_active'=>1],'id_category_menu',$id_category_menu,'order_number','ASC')->result_array();
                ?>
                <?php foreach ($kategori_menu as $key) : ?>
                    <li class="app-sidebar__heading"><?php echo $key['category_name']; ?></li>

                    <?php $menu = $this->db->query("SELECT * FROM v_menu_groups WHERE group_name = '{$this->session->userdata('group_name')}' AND id_category_menu = '".$key['id_category_menu']."' AND is_active = 1 ORDER BY order_number ASC")->result_array(); ?>
                    <?php foreach ($menu as $menus) : ?>
                        <li class="<?php echo $menus['link']==$link ? "mm-active" : ""; ?>">
                            <a href="<?php echo base_url($menus['link']); ?>">
                                <i class="<?php echo $menus['icon']; ?>"></i>
                                <?php echo $menus['menu_name'] ?>
                                <?php if($menus['is_parent'] == 1): ?>
                                    <i class="metismenu-state-icon pe-7s-angle-down caret-left"></i>
                                <?php endif; ?>
                            </a>
                            <?php $submenu = $this->db->query("SELECT * FROM v_sub_menu WHERE id_menu = ".$menus['id_menu']." AND is_active = 1 ORDER BY order_number ASC")->result_array(); ?>
                            <?php foreach ($submenu as $submenus): ?>
                                <ul>
                                    <li class="<?php echo $submenus['link']==$link ? "mm-active" : ""; ?>">
                                        <a href="<?php echo base_url($submenus['link_parent'].'/'.$submenus['link']); ?>">
                                            <i class="metismenu-icon"></i>
                                            <?php echo $submenus['sub_menu_name']; ?>
                                        </a>
                                    </li>
                                </ul>
                            <?php endforeach; ?>
                        </li>
                    <?php endforeach; ?>
                <?php endforeach; ?>
            <?php }else{ ?>
                <li class="app-sidebar__heading">Dashboard</li>
                <li class="mm-active">
                    <a href="<?php echo base_url(); ?>">Dashboard</a>
                </li>
            <?php } ?>
        </ul>
    </div>
</div>