<?php
/*
Template Name: CorrPress主题页面
Template Post Type: post, page
*/
the_post();
?>
<!doctype html>
<html lang="zh">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>CorePress - 高颜值 高性能主题</title>
    <meta name="keywords" content="CorePress,CorePress官方主题,CorePress最新版,wordpress主题,博客主题"/>
    <meta name="description" content="CorePress主题发布页面，CorePress是一款基于WordPress制作的一款主题，适合多站点，注重内容，界面清爽干净，功能强大。"/>
    <?php
    file_load_css('corepress/style.css');
    global $set;
    if ($set['routine']['favicon'] != null) {
        ?>
        <link rel="icon" href="<?php echo $set['routine']['favicon'] ?>" type="image/x-icon"/>
        <?php
    }
    ?>

</head>
<body>
<header>
    <div class="container">
        <a href="/"><img src="https://www.lovestu.com/wp-content/uploads/2021/03/logo4.svg" alt="" class="logo"></a>
    </div>
</header>
<div id="app">
    <div class="plane-head-bac"
         style="background-image: url('<?php echo file_get_img_url('corepress/corepressbanner.webp') ?>')">
        <div class="plane-head container">
            <div class="theme-info-left">
                <p class="theme-subtitle">极致优化，专为极客</p>
                <p class="theme-title">
                    CorePress 主题
                    <a href="https://github.com/ghboke/CorePressWPTheme" target="_blank"><img
                                src="https://img.shields.io/github/stars/ghboke/CorePressWPTheme.svg?style=social"
                                alt=""></a>
                </p>
                <p class="theme-description">
                    CorePress主题，强大的WordPress定制主题，体积小，性能强，功能多，不可多得的一款高性能，高颜值主题。
                </p>
                <div>
                    <?php
                    $post_content = get_the_content();
                    ?>
                    <p class="version-info">
                        最新版本：<?php echo corepress_getSubstr($post_content, '[version]', '[/version]') ?>
                        更新日期：<?php echo format_date(get_post_time('U', false, $post)); ?> </p>
                </div>
                <div class="down-plane">
                    <div class="down-plane-item">
                        <a href="https://ghpym.lanzoui.com/b00znf9kd" target="_blank">
                            <button class="theme-btn btn-down">立即下载</button>
                        </a>
                        <a href="/" target="_blank">
                            <button class="theme-btn btn-danger">查看演示</button>
                        </a>
                    </div>
                    <div class="down-plane-item">
                        <a href="https://www.yuque.com/applek/corepress" target="_blank">
                            <button class="theme-btn theme-btn-default">文档</button>
                        </a>
                        <a href="https://github.com/ghboke/CorePressWPTheme" target="_blank">
                            <button class="theme-btn theme-btn-default">Github</button>
                        </a>
                        <a href="https://gitee.com/ghboke/corepress" target="_blank">
                            <button class="theme-btn theme-btn-default">Gitee</button>
                        </a>
                        <a href="https://support.qq.com/products/326735/" target="_blank">
                            <button class="theme-btn theme-btn-default">反馈</button>
                        </a>
                    </div>
                </div>
            </div>
            <div class="theme-info-right">
            </div>
        </div>

    </div>
    <div class="container theme-func">
        <p class="description-title-big">主题功能</p>

        <div class="theme-js-plane">
            <div>
                <img src="<?php echo file_get_img_url('corepress/corepress_01.webp') ?>" alt="">
            </div>
            <div class="theme-js-text">
                <p class="theme-js-text-title">现代化外观界面</p>
                <p class="theme-js-description">作者手写前端代码，不依赖界面库，设计现代化，符合当前用户审美，清爽简约。</p>
            </div>
        </div>
        <div class="theme-js-plane">
            <div class="theme-js-text">
                <p class="theme-js-text-title">丰富配置界面</p>
                <p class="theme-js-description">可视化设置界面，可自定义功能超百项，满足个性化需求，友好提示，上手简单，使用方便。</p>
            </div>
            <div>
                <img src="<?php echo file_get_img_url('corepress/corepress_02.webp') ?>" alt="">
            </div>
        </div>
        <div class="theme-js-plane">
            <div>
                <img src="<?php echo file_get_img_url('corepress/corepress_03.webp') ?>" alt="">
            </div>
            <div class="theme-js-text">
                <p class="theme-js-text-title">前端用户中心</p>
                <p class="theme-js-description">内置用户中心，修改用户信息，登录注册，皆在前端完成，不进WordPress后台。</p>
            </div>

        </div>
        <div class="theme-js-plane">
            <div class="theme-js-text">
                <p class="theme-js-text-title">丰富文章组件</p>
                <p class="theme-js-description">代码高亮、密码可见、折叠面板、下载面板等多种丰富样式组件，丰富文章内容</p>
            </div>
            <div>
                <img src="<?php echo file_get_img_url('corepress/corepress_04.webp') ?>" alt="">
            </div>
        </div>
    </div>
    <div class="theme-feature">
        <div class="container">
            <p class="description-title-big">主题特色</p>
            <div class="theme-feature-plane">
                <div class="theme-feature-item">
                    <div class="theme-feature-body">
                        <img src="<?php echo file_get_img_url('corepress\tiji.svg'); ?>" alt="">
                        <p class="theme-feature-item-title">超小体积</p>
                        <p class="theme-feature-item-direction">体积只有2M不到，代码精，功能全，颜值高，兼容好</p>
                    </div>
                </div>
                <div class="theme-feature-item">
                    <div class="theme-feature-body">
                        <img src="<?php echo file_get_img_url('corepress\kj.svg'); ?>" alt="">
                        <p class="theme-feature-item-title">无框架设计</p>
                        <p class="theme-feature-item-direction">主题无前端界面库框架，代码为作者手撸，体积小，兼容好</p>
                    </div>
                </div>
                <div class="theme-feature-item">
                    <div class="theme-feature-body">
                        <img src="<?php echo file_get_img_url('corepress\sd.svg'); ?>" alt="">
                        <p class="theme-feature-item-title">大量优化功能</p>
                        <p class="theme-feature-item-direction">
                            深度优化WordPress，干掉没有卵用的函数，替换国内镜像，让后台访问更快，再也不用莫名其妙的等待好多秒了</p>
                    </div>
                </div>
                <div class="theme-feature-item">
                    <div class="theme-feature-body">
                        <img src="<?php echo file_get_img_url('corepress\xys.svg'); ?>" alt="">
                        <p class="theme-feature-item-title">响应式设计</p>
                        <p class="theme-feature-item-direction">主题采用响应式设计，完美兼容PC端、手机端和平板等各类设备访问</p>
                    </div>
                </div>
                <div class="theme-feature-item">
                    <div class="theme-feature-body">
                        <img src="<?php echo file_get_img_url('corepress\gxhsz.svg'); ?>" alt="">
                        <p class="theme-feature-item-title">主题设置</p>
                        <p class="theme-feature-item-direction">主题提供可视化设置面板，可自定义配置百项</p>
                    </div>
                </div>
                <div class="theme-feature-item">
                    <div class="theme-feature-body">
                        <img src="<?php echo file_get_img_url('corepress\seo.svg'); ?>" alt="">
                        <p class="theme-feature-item-title">强大SEO</p>
                        <p class="theme-feature-item-direction">
                            自动截取描述，单篇文章、页面SEO自定义、分类目录SEO</p>
                    </div>
                </div>
                <div class="theme-feature-item">
                    <div class="theme-feature-body">
                        <img src="<?php echo file_get_img_url('corepress\bjq.svg'); ?>" alt="">
                        <p class="theme-feature-item-title">编辑器增强</p>
                        <p class="theme-feature-item-direction">自带多种功能短代码，让文章撰写更方便。自带编辑器增强面板，方便快捷插入与编辑代码</p>
                    </div>
                </div>
                <div class="theme-feature-item">
                    <div class="theme-feature-body">
                        <img src="<?php echo file_get_img_url('corepress\xgj.svg'); ?>" alt="">
                        <p class="theme-feature-item-title">多个小工具</p>
                        <p class="theme-feature-item-direction">主题自带多种小工具，最新评论，作者信息，热门文章</p>
                    </div>
                </div>
                <div class="theme-feature-item">
                    <div class="theme-feature-body">
                        <img src="<?php echo file_get_img_url('corepress\yhzx.svg'); ?>" alt="">
                        <p class="theme-feature-item-title">前端用户中心</p>
                        <p class="theme-feature-item-direction">
                            开启用户中心，接管WordPress自带登录页面，注册页面，找回密码页面，同时自定义个人中心设置页面，支持修改昵称，签名，修改密码，绑定账号</p>
                    </div>
                </div>

                <div class="theme-feature-item">
                    <div class="theme-feature-body">
                        <div class="theme-feature-item">
                            <img src="<?php echo file_get_img_url('corepress\mk.svg'); ?>" alt="">
                            <p class="theme-feature-item-title">功能模块</p>
                            <p class="theme-feature-item-direction">防红模块，禁止文章复制，WordPress邮件配置，图片灯箱，无需安装多余插件即可实现</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="container theme-version-plane">
            <p class="description-title-big">更新日志</p>
            <div class="theme-version-note-plane">
                <?php
                $note = corepress_getSubstr($post_content, '[new]', '[/new]');
                print_r(do_shortcode($note));
                ?>
            </div>
        </div>
        <div class="container">
            <p class="description-title-big">更多信息</p>
            <div class="theme-more-info">
                <div class="theme-more-info-item">
                    <div class="theme-more-info-item-title">
                        <p>运行环境</p>
                    </div>
                    <div class="theme-more-info-item-body">
                        <p>WordPress 4+</p>
                        <p>PHP 5.6+，兼容PHP 7/8，推荐PHP 7+</p>
                        <p> MySQL 5.0+</p>
                        <p>推荐使用宝塔服务器面板</p>
                    </div>
                </div>
            </div>
            <div class="theme-more-info">
                <div class="theme-more-info-item">
                    <div class="theme-more-info-item-title">
                        <p>主题授权</p>
                    </div>
                    <div class="theme-more-info-item-body">
                        <p>Free版本免费使用，并长期维护，不过需要保留底部CorePress标识版权</p>
                        <p>Pro版本还在酝酿中</p>
                    </div>
                </div>
            </div>
            <div class="theme-more-info">
                <div class="theme-more-info-item">
                    <div class="theme-more-info-item-title">
                        <p>售后支持</p>
                    </div>
                    <div class="theme-more-info-item-body">
                        <p>免费主题，大部分问题可以通过阅读文档解决</p>
                        <p>有问题或者建议可以加群提问，或者在线反馈</p>
                        <p>修改底部版权，视为放弃一切技术支持，出问题自理</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <footer>
        Copyright © 2021 <?php bloginfo('name'); ?>
        <span class="theme-copyright"><a href="https://www.lovestu.com/corepress.html" target="_blank">CorePress</a>
            <div class="footer-info">
                    <?php
                    global $set;
                    if ($set['routine']['icp'] != null) {
                        echo '<span class="footer-icp"><img class="ipc-icon" src="' . file_get_img_url('icp.svg') . '" alt=""><a href="https://beian.miit.gov.cn/" target="_blank">' . $set['routine']['icp'] . '</a></span>';
                    }
                    if ($set['routine']['police'] != null) {
                        echo '<span class="footer-icp"><img class="ipc-icon" src="' . file_get_img_url('police.svg') . '" alt=""><a href="http://www.beian.gov.cn/portal/registerSystemInfo/" target="_blank">' . $set['routine']['police'] . '</a></span>';
                    }
                    ?>
                </div>
    </footer>
</div>
</body>
</html>
