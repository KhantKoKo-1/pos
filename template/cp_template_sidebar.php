<?php 
require ('../require/common.php');
?>
<div class="col-md-3 left_col">
    <div class="left_col scroll-view">
        <div class="navbar nav_title" style="border: 0;">
            <a href="index.html" class="site_title"><i class="fa fa-paw"></i> <span>Gentelella Alela!</span></a>
        </div>
        <div class="clearfix"></div>

        <div class="profile clearfix">
            <div class="profile_pic">
                <img src="<?php echo $base_url;?>asset/images/img.jpg" alt="..." class="img-circle profile_img">
            </div>
            <div class="profile_info">
                <span>Welcome,</span>
                <h2>John Doe</h2>
            </div>
        </div>
        <br />

        <!-- sidebar menu -->
        <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
            <div class="menu_section">
                <h3>General</h3>
                <ul class="nav side-menu">
                    <li><a><i class="fa fa-home" href="index.html"></i> Home</a>
                    </li>
                    <li><a><i class="fa fa-edit"></i> Shift <span class="fa fa-chevron-down"></span></a>
                        <ul class="nav child_menu">
                            <li><a href="<?php $cp_base_url;?>shift">list</a></li>
                        </ul>
                    </li>
                    <li><a><i class="fa fa-edit"></i> Category <span class="fa fa-chevron-down"></span></a>
                        <ul class="nav child_menu">
                            <li><a href="<?php $cp_base_url;?>category_create">Create</a></li>
                            <li><a href="<?php $cp_base_url;?>category_list">list</a></li>
                        </ul>
                    </li>
                    <li><a><i class="fa fa-edit"></i> Item <span class="fa fa-chevron-down"></span></a>
                        <ul class="nav child_menu">
                            <li><a href="<?php $cp_base_url;?>item_create">Create</a></li>
                            <li><a href="<?php $cp_base_url;?>item_list">list</a></li>
                        </ul>
                    </li>
                    <li><a><i class="fa fa-edit"></i> Promotion <span class="fa fa-chevron-down"></span></a>
                        <ul class="nav child_menu">
                            <li><a href="<?php $cp_base_url;?>discount_create">Create</a></li>
                            <li><a href="<?php $cp_base_url;?>discount_list">list</a></li>
                        </ul>
                    </li>
                    <li><a><i class="fa fa-edit"></i> User <span class="fa fa-chevron-down"></span></a>
                        <ul class="nav child_menu">
                            <li><a href="<?php $cp_base_url;?>user_create">Create</a></li>
                            <li><a href="<?php $cp_base_url;?>user_list">list</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
        <!-- /sidebar menu -->

    </div>
</div>