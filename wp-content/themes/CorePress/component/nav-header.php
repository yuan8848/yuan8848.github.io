<script>
    function openMenu() {
        $('body').css('overflow', 'hidden');
        $(".drawer-menu-plane").addClass("drawer-menu-plane-show");
        $(".menu-plane").appendTo($(".drawer-menu-list"));
        $(".user-menu-plane").appendTo($(".drawer-menu-list"));
        //$(".menu-item-has-children").append('<div class="m-dropdown" onclick="mobile_menuclick(event,this)" ><i class="fa fa-angle-down"></i></div>')
        $(".user-menu-main").not('.user-menu-main-notlogin').append('<div class="m-dropdown" onclick="mobile_menuclick(event,this)"><i class="fal fa-angle-down"></i></div>')
    }
    function closeMenu() {
        $('body').css('overflow', 'auto');
        $(".drawer-menu-plane").removeClass("drawer-menu-plane-show");
        $(".user-menu-plane").prependTo($(".header-menu"));
        $(".menu-plane").prependTo($(".header-menu"));
        $(".m-dropdown").remove();
    }

    function openSearch() {
        $(".dialog-search-plane").addClass("dialog-search-plane-show");
    }

    function closeSearch() {
        $(".dialog-search-plane").removeClass("dialog-search-plane-show");
    }
</script>
<div class="mobile-menu-btn" onclick="openMenu()">
    <i class="fa fa-bars" aria-hidden="true"></i>
</div>
<div class="drawer-menu-plane">
    <div class="drawer-menu-list">
        <?php

        $wp_nav_mobile = wp_nav_menu(array(
                'menu' => 'header_menu',
                'theme_location' => 'header_menu',
                'depth' => 3,
                'echo' => false,
                'container' => 'div',
                'container_class' => 'menu-mobile',
                'menu_class' => 'menu-mobile-header-list',
                'items_wrap' => '<ul class="%2$s">%3$s</ul>',
            )
        );
        echo $wp_nav_mobile;
        ?>
    </div>
    <div class="drawer-menu-write" onclick="closeMenu()">
    </div>
</div>
<div class="header-logo-plane">
    <div class="header-logo">
        <?php
        global $set;
        $logourl = $set['routine']['logo'];
        if ($logourl == '') {
            echo '<a href="' . get_bloginfo('url') . '" title="' . get_bloginfo('name') . '"><h2>CorePress</h2></a>';
        } else {
            if ($set['seo']['openseo'] == 1) {
                echo '<a href="' . get_bloginfo('url') . '" title="' . $set['seo']['indextitle'] . '"><img src="' . $logourl . '" alt="' . $set['seo']['indextitle'] . '"></a>';
            } else {
                echo '<a href="' . get_bloginfo('url') . '" title="' . get_bloginfo('name') . '"><img src="' . $logourl . '" alt="' . get_bloginfo('name') . '"></a>';
            }
        }
        ?>
    </div>
</div>
<div class="mobile-search-btn" onclick="openSearch()">
    <i class="fa fa-search"></i>
</div>
<div class="dialog-search-plane">
    <div class="dialog-mask" onclick="closeSearch()"></div>
    <div class="dialog-plane">
        <h2>????????????</h2>
        <form class="search-form" action="<?php echo get_bloginfo('url'); ?>" method="get" role="search">
            <div class="search-form-input-plane">
                <input type="text" class="search-keyword" name="s" placeholder="????????????"
                       value="<?php echo get_search_query(); ?>">
            </div>
            <div>
                <button type="submit" class="search-submit" value="&#xf002;">??????</button>
            </div>
        </form>
    </div>
</div>


<div class="header-menu">
    <div class="menu-plane">
        <?php
        $locations = get_nav_menu_locations();
        if (isset($locations['header_menu'])) {
            wp_nav_menu(array(
                    'menu' => 'header_menu',
                    'theme_location' => 'header_menu',
                    'depth' => 3,
                    'container' => 'nav',
                    'container_class' => 'menu-header-plane',
                    'menu_class' => 'menu-header-list',
                    'items_wrap' => '<ul id="%1$s" class="%2$s">%3$s</ul>'
                )
            );
        } else {
            echo '<div class="menu-header-plane">??????????????????????????????????????? <a href="https://www.yuque.com/applek/corepress/menu" target="_blank">????????????</a> </div>';
        }
        ?>

    </div>
    <div class="user-menu-plane">
        <div class="user-menu-pc-search" onclick="openSearch()" title="??????">
            <i class="fal fa-search"></i>
        </div>
        <?php
        if (islogin()) {
            ?>
            <ul class="user-menu">
                <li>
                    <a class="user-menu-main"><img class="user-avatar" width="30" height="30"
                                                   src="<?php echo corepress_get_avatar_url() ?>"><span
                                class="user-menu-name"><?php echo corepress_get_user_nickname() ?></span></a>
                    <ul class="user-sub-menu sub-menu">
                        <?php
                        if ($set['user']['usercenter'] == 1 && $set['user']['usercenterurl'] != null) {
                            echo ' <li><a href="' . $set['user']['usercenterurl'] . '"><i class="fas fa-user-cog"></i> ????????????</a></li>';
                        }
                        ?>

                        <?php
                        if (isadmin()) {
                            ?>
                            <li><a href="<?php echo admin_url(); ?>"><i class="fas fa-tachometer-alt"></i> ????????????</a></li>
                            <?php
                        }
                        if (current_user_can('edit_posts')) {
                            ?>
                            <li><a href="<?php echo admin_url() . 'post-new.php'; ?>"><i class="far fa-edit"></i>
                                    ????????????</a></li>
                            <?php
                        }
                        ?>
                        <li><a href="<?php echo wp_logout_url(get_bloginfo('url')) ?>"><i
                                        class="fas fa-sign-out-alt"></i> ????????????</a></li>
                    </ul>
                </li>
            </ul>
            <?php
        } else {
            if ($set['user']['hideloginbtn'] != 1) {
                ?>
                <span class="user-menu-main user-menu-main-notlogin">
                 <a href="<?php echo loginAndBack(); ?>"><button class="login-btn-header">??????</button></a>

            <?php if (get_option('users_can_register')) {
                ?>
                <a href="<?php echo wp_registration_url(); ?>"><button
                            class="login-btn-header reg-btn-header">??????</button></a>
                <?php
            } ?>
            </span>
                <?php
            }
        }
        ?>
    </div>
</div>
