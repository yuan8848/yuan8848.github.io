<?php
/**
 *
 * 插件管理设置
 *
 * @package    WBOLT
 * @author     WBOLT
 * @since      2.1.4
 * @license    GPL-2.0+
 * @copyright  Copyright (c) 2019, WBOLT
 */

class BSL_Admin
{
    public static $name = 'bsl_pack';
    public static $optionName = 'bsl_option';
    public static $debug = false;

    public function __construct(){

    }

    public static function init(){

        self::upgrade();

        register_activation_hook(BSL_BASE_FILE, array(__CLASS__,'plugin_activate'));
        register_deactivation_hook(BSL_BASE_FILE, array(__CLASS__,'plugin_deactivate'));

        if(is_admin()){


            add_action( 'admin_menu', array(__CLASS__,'admin_menu') );
            add_filter( 'plugin_action_links', array(__CLASS__,'actionLinks'), 10, 2 );
            //add_action( 'admin_init', array(__CLASS__,'admin_init') );

            add_action('admin_enqueue_scripts',array(__CLASS__,'admin_enqueue_scripts'),1);

            add_filter('plugin_row_meta', array(__CLASS__, 'plugin_row_meta'), 10, 2);

            add_action('parse_query',array(__CLASS__,'admin_parse_query'));
            //add_filter('post_row_actions',array(__CLASS__,'post_row_actions'),99,2);
            add_action('restrict_manage_posts', array(__CLASS__,'restrict_manage_posts'), 10, 2);

            add_action('wp_ajax_wb_baidu_push_url',array(__CLASS__,'wp_ajax_wb_baidu_push_url'));

            add_action( 'add_meta_boxes', array(__CLASS__,'add_meta_box'));

            add_action( 'save_post', array(__CLASS__,'save_post_meta'));


            $post_type = WB_BSL_Conf::cnf('post_type');
            if($post_type && is_array($post_type))foreach($post_type as $type){
                add_filter('bulk_actions-edit-'.$type,array(__CLASS__,'bulk_actions'),90);
            }

        }

        add_action('bsl_check_all_404_url',[__CLASS__,'bsl_check_all_404_url'],10,3);


        WB_BSL_Daily::init();

        WB_BSL_Site::init();
        WB_BSL_Inexnow::init();
        WB_BSL_Yandex::init();

        WB_BSL_Bing::init();

        WB_BSL_Google::init();

        //定时任务
        WB_BSL_Cron::init();


        add_action('parse_request', array(__CLASS__, 'parse_request'));
        add_action( 'admin_notices', array(__CLASS__, 'admin_notices' ) );

        add_action('wb_bsl_add_push_log',array('WB_BSL_Stats','action_add_push_log'));
    }

    public static function admin_notices()
    {
        global $current_screen;
        if ( ! current_user_can( 'update_plugins' ) ) {
            return;
        }
        if(!preg_match('#wb_bsl#',$current_screen->parent_base)){
            return;
        }
        $current         = get_site_transient( 'update_plugins' );
        if(!$current){
            return;
        }
        $plugin_file = plugin_basename(BSL_BASE_FILE);
        if(!isset( $current->response[ $plugin_file ] )){
            return;
        }
        $all_plugins     = get_plugins();
        if(!$all_plugins || !isset($all_plugins[$plugin_file])){
            return;
        }
        $plugin_data = $all_plugins[$plugin_file];
        $update = $current->response[ $plugin_file ];

        //print_r($update);
        $update_url = wp_nonce_url( self_admin_url( 'update.php?action=upgrade-plugin&plugin=' ) . $plugin_file, 'upgrade-plugin_' . $plugin_file );

        $html = '<div class="update-message notice inline notice-warning notice-alt"><p>'.$plugin_data['Name'].'有新版本可用。';
        $html .= '<a href="'.$update->url.'" target="_blank" aria-label="查看'.$plugin_data['Name'].'版本'.$update->new_version.'详情">查看版本'.$update->new_version.'详情</a>';
        $html .= '或<a href="'.$update_url.'" class="update-link" aria-label="现在更新 '.$plugin_data['Name'].'">现在更新</a>。</p></div>';
        echo $html;

    }

    public static function  array_sanitize_text_field($value)
    {
        if(is_array($value)){
            foreach($value as $k=>$v){
                $value[$k] = self::array_sanitize_text_field($v);
            }
            return $value;
        }else{
            return sanitize_text_field($value);
        }
    }

    public static function parse_request(){
        $uri = isset($_SERVER['REQUEST_URI'])?$_SERVER['REQUEST_URI']:'';
        if(preg_match('#^/404-list(-(\d+))*.txt#',$uri,$match)){
            $page = isset($match[2])?$match[2]:1;
            $num = 1000;
            $offset = max(0,($page-1)) * $num;
            $data = WB_BSL_Stats::spider_404($num,$offset);
            $list = $data['list'];
            //$url = array();
            if($list)foreach($list as $r){
                echo home_url($r->url)."\n";
            }
            exit();
        }

    }

    public static function add_meta_box()
    {
        if(!get_option('wb_bsl_ver',0)){
            return;
        }

        $daily_active = WB_BSL_Conf::cnf('daily_active');
        if(!$daily_active){
            return;
        }

        add_meta_box(
            'wbolt_meta_box_bslv2',
            '百度推送设置',
            array(__CLASS__,'render_meta_box'),
            null,
            'side','high'
        );



    }

    public static function render_meta_box($post)
    {

        $meta_val = get_post_meta($post->ID,'wb_bsl_daily_push',true);

        $html = '<div class="sc-body mt">
        <table class="wbs-form-table">
            <tbody>
            <tr>
                <td class="info">
                <input type="hidden" name="wb_bsl_meta" value="1">
                    <label>
                        <input class="wb-switch" type="checkbox"'.($meta_val?' checked':'').' name="wb_bsl_daily_push">
                        <span class="description mt">不执行快速收录推送</span>
                    </label>
                </td>
            </tr>
            </tbody>
        </table></div>';

        echo $html;

    }

    public static function save_post_meta($post_id)
    {
        if(isset($_POST['wb_bsl_meta'])){
            $daily_push = isset($_POST['wb_bsl_daily_push'])?1:0;
            update_post_meta($post_id,'wb_bsl_daily_push',$daily_push);
        }
    }

    public static function upgrade(){

        $bsl_ver = get_option('bsl_version','1.0.0');

        /*if(version_compare($bsl_ver,'3.0.0')<0){
            if(get_option('wb_bsl_ver',0)){
                WB_BSL_Conf::upgrade_v3_conf();
            }
        }
        if(version_compare($bsl_ver,'3.4.9')<0){
            WB_BSL_Stats::upgrade_stats_log();
        }*/

        if(version_compare($bsl_ver,BSL_VERSION)<0){
            update_option('bsl_version',BSL_VERSION);
        }

        WB_BSL_Conf::update_db_13();
        WB_BSL_Conf::update_db_14();

    }




    public static function bsl_check_all_404_url($page,$num,$name)
    {
        global $wpdb;
        WB_BSL_Utils::run_log('开始404URL('.$num.'个)重新检测','定时任务');
        //error_log(print_r(func_get_args(),1)."\n",3,__DIR__.'/check_log.txt');
        //error_log(current_time('mysql').'-start-'.$page.'-'.$num."\n",3,__DIR__.'/check_log.txt');
        $offset = $page * $num;
        $data = WB_BSL_Stats::spider_404($num,$offset);
        if(!$data['list']){
            return;
        }
        WB_BSL_Stats::check_404_url($data['list']);
        //error_log(current_time('mysql').'-end-'.$page.'-'.$num."\n",3,__DIR__.'/check_log.txt');
        WB_BSL_Utils::run_log('完成404URL('.$num.'个)重新检测','定时任务');
    }


    /**
     * 获取推送数据结果
     */
    public static function wp_ajax_wb_baidu_push_url(){

        if (!current_user_can('manage_options')) {
            exit();
        }
        global $wpdb;

        $op = isset($_REQUEST['op']) && $_REQUEST['op'] ? sanitize_text_field($_REQUEST['op']) : null;

        switch ($op){

            case 'zz-set-url':
                $zz_cnf = [
                    'so'=>5,
                    'sogou'=>20,
                    'toutiao'=>100
                ];
                $type = trim(sanitize_text_field($_POST['type'] ?? ''));
                $ret = ['code'=>0,'desc'=>'success'];
                do{
                    if(!$type || !in_array($type,array_keys($zz_cnf))){
                        break;
                    }
                    if(!get_option('wb_bsl_ver',0)){
                        break;
                    }
                    $num = $zz_cnf[$type];
                    $opt_key = 'bsl-zz-'.$type.'-url';
                    $conf = get_option($opt_key);
                    if(!$conf || !is_array($conf) || !isset($conf['time']) || !$conf['time']){
                        break;
                    }
                    if(!isset($conf['state'])){
                        $conf['state'] = 0;
                    }
                    if($conf['state']){
                        break;
                    }
                    $conf['state'] = 1;
                    $conf['paged'] += 1;
                    update_option($opt_key,$conf,false);

                    $ret['conf'] = $conf;
                }while (0);
                /*header('Access-Control-Allow-Origin:'.(isset($_SERVER['HTTP_ORIGIN'])?$_SERVER['HTTP_ORIGIN']:'*'));
                header('Access-Control-Allow-Methods:GET,POST');
                header('Access-Control-Allow-Credentials:true');
                header('content-type:text/json;charset=utf-8');*/
                echo json_encode($ret);
                exit();

                break;
            case 'zz-get-url':
                $zz_cnf = [
                    'so'=>5,
                    'sogou'=>20,
                    'toutiao'=>100
                ];
                $type = trim(sanitize_text_field($_POST['type'] ?? ''));
                $ret = ['code'=>0,'data'=>[]];
                do{
                    if(!$type || !in_array($type,array_keys($zz_cnf))){
                        break;
                    }
                    if(!get_option('wb_bsl_ver',0)){
                        break;
                    }
                    $num = $zz_cnf[$type];
                    $opt_key = 'bsl-zz-'.$type.'-url';
                    $conf = get_option($opt_key);
                    //近7天url
                    $time = strtotime(date('Y-m-d')) - 7 * 86400;
                    if(!$conf || !is_array($conf) || !isset($conf['time']) || !$conf['time']){
                        $conf = [
                            'time' => $time,
                            'total' => 0,
                            'paged' => 1
                        ];
                    }else{
                        $conf['time'] = max($conf['time'],$time);
                    }
                    $post_types = WB_BSL_Conf::cnf('post_type',array('post'));
                    if(empty($post_types))$post_types = array('post');

                    if(!isset($conf['paged'])){
                        $conf['paged'] = 1;
                    }
                    //$conf['paged'] += 1;

                    $offset = (max(1,$conf['paged']) - 1) * $num;

                    $post_types = "'".implode("','",$post_types)."'";
                    $date = date('Y-m-d H:i:s',$conf['time']);
                    $sql = "SELECT SQL_CALC_FOUND_ROWS * FROM $wpdb->posts 
                                WHERE post_status='publish' AND post_type IN($post_types) AND post_date>'$date'
                                ORDER BY post_date ASC LIMIT $offset,$num";

                    $list = $wpdb->get_results($sql);
                    $total = $wpdb->get_var("SELECT FOUND_ROWS()");
                    $conf['total'] = $total;
                    if(empty($list)){
                        $conf['time'] = current_time('U');
                        $conf['paged'] = 0;
                        $conf['page'] = 0;
                        $conf['total'] = 0;
                    }else{
                        foreach ($list as $post){
                            $ret['data'][] = get_permalink($post);
                        }
                    }
                    $conf['state'] = 0;
                    //$ret['conf'] = $conf;
                    update_option($opt_key,$conf,false);
                }while (0);
                /*header('Access-Control-Allow-Origin:'.(isset($_SERVER['HTTP_ORIGIN'])?$_SERVER['HTTP_ORIGIN']:'*'));
                header('Access-Control-Allow-Methods:GET,POST');
                header('Access-Control-Allow-Credentials:true');
                header('content-type:text/json;charset=utf-8');*/
                echo json_encode($ret);
                exit();
                break;

            case 'update_setting':

                WB_BSL_Conf::update_cnf();

                $ret = array('code'=>0,'desc'=>'success');
                header('Content-type:text/json;');
                echo json_encode($ret);
                exit();
                break;

            case 'chk_ver':
                $http = wp_remote_get('https://www.wbolt.com/wb-api/v1/themes/checkver?code=bsl-pro&ver='.BSL_VERSION.'&chk=1',array('sslverify' => false,'headers'=>array('referer'=>home_url()),));

                if(wp_remote_retrieve_response_code($http) == 200){
                    echo wp_remote_retrieve_body($http);
                }

                exit();
                break;
            case 'promote':

                $ret = ['code'=>0,'desc'=>'success','data'=>''];
                $data = [];
                $expired = 0;
                $update_cache = false;
                do{
                    $option = get_option('wb_bsl_promote',null);
                    do{
                        if(!$option || !is_array($option)){
                            break;
                        }

                        if(!isset($option['expired']) || empty($option['expired'])){
                            break;
                        }

                        $expired = intval($option['expired']);
                        if($expired < current_time('U')){
                            $expired = 0;
                            break;
                        }

                        if(!isset($option['data']) || empty($option['data'])){
                            break;
                        }

                        $data = $option['data'];
                    }while(0);

                    if($data){
                        $ret['data'] = $data;
                        break;
                    }
                    if($expired){
                        break;
                    }

                    $update_cache = true;
                    $param = ['c'=>'bsl','h'=>$_SERVER['HTTP_HOST']];
                    $http = wp_remote_post('https://www.wbolt.com/wb-api/v1/promote',array('sslverify'=>false,'body'=>$param,'headers'=>array('referer'=>home_url()),));

                    if(is_wp_error($http)){
                        $ret['error'] = $http->get_error_message();
                        break;
                    }
                    if(wp_remote_retrieve_response_code($http) !== 200){
                        $ret['error-code'] = '201';
                        break;
                    }
                    $body = trim(wp_remote_retrieve_body($http));
                    if(!$body){
                        $ret['empty'] = 1;
                        break;
                    }
                    $data = json_decode($body,true);
                    if(!$data){
                        $ret['json-error'] = 1;
                        $ret['body'] = $body;
                        break;
                    }
                    //data = [title=>'',image=>'','expired'=>'2021-05-12','url=>'']
                    $ret['data'] = $data;
                    if(isset($data['expired']) && $data['expired'] && preg_match('#^\d{4}-\d{2}-\d{2}$#',$data['expired'])){
                        $expired = strtotime($data['expired'].' 23:50:00');
                    }

                }while(0);
                if($update_cache){
                    if(!$expired){
                        $expired = current_time('U') + 21600 ;
                    }
                    update_option('wb_bsl_promote',['data'=>$ret['data'],'expired'=>$expired],false);
                }

                header('content-type:text/json;charset=utf-8');
                echo json_encode($ret);
                exit();
                break;
            case 'clear_log':
                $type = isset($_POST['type']) ? intval($_POST['type']) : '';
                if($type == 2){
                    $log = self::run_log_error(1);
                }else {
                    $log = self::run_log_info(1);
                }
                header('content-type:text/json;');

                echo json_encode($log);

                break;

            case 'clean_log':
                $type = isset($_POST['type'])?intval(sanitize_text_field($_POST['type'])):0;
                if( $type ){
                    WB_BSL_Utils::clean_log($type);
                }

                header('content-type:text/json;');

                echo json_encode(array('success'=>1));

                break;

            case 'reload_log':
                $type = isset($_GET['type']) ? intval($_GET['type']) : '';
                if($type == 2){
                    $log = self::run_log_error();
                }else{
                    $log = self::run_log_info();
                }

                header('content-type:text/json;');

                echo json_encode($log);
                exit();
                break;
            case 'check_all_post':

                $param = array('page'=>0,'Ym'=>current_time('Ym'));
                update_option('wb_bsl_check_all',$param,false);


                exit();
                break;
            case 'batch_bd':
                $ret = ['code'=>-1,'desc'=>'fail'];
                if(isset($_POST['post_id']) && $_POST['post_id']){
                    $post_id = sanitize_text_field($_POST['post_id']);
                    $id_list = wp_parse_id_list(explode(',',$post_id));
                    $ret = WB_BSL_Site::baidu_manual_push($id_list);
                }
                header('content-type:text/json;');

                echo json_encode($ret);
                break;
            case 'update_index_data':
                WB_BSL_Utils::run_log('手动更新','收录概况');
                WB_BSL_Cron::baidu_index(1);
                exit();
                break;

            case 'spider_history':
                $ret = array('code'=>0,'data'=>array(),'desc'=>'success');
                $post_id = isset($_POST['post_id'])?absint(sanitize_text_field($_POST['post_id'])):0;
                $list = array();

                do{
                    if(!$post_id){
                        break;
                    }
                    $url = get_permalink($post_id);
                    $url = str_replace(home_url(),'',$url);
                    $url_md5 = md5($url);
                    $list = WB_BSL_Stats::url_spider($url_md5,0);

                }while(0);

                include BSL_PATH.'/inc/url_spider.php';

                exit();

                break;

            case 'check_sitemap':
                $ret = array('code'=>0,'desc'=>'success');


                $site_map_exists = '';

                //print_r($http);
            $res_code = [];
                do{
                    $site_map = home_url('/sitemap.xml');
                    $http = wp_remote_head($site_map);
                    $code = wp_remote_retrieve_response_code($http);
                    $res_code[] = $code;
                    if($code === 200){
                        $site_map_exists = $site_map;
                        break;
                    }

                    $site_map = home_url('/sitemaps.xml');
                    $http = wp_remote_head($site_map);
                    $code = wp_remote_retrieve_response_code($http);
                    $res_code[] = $code;
                    if($code === 200){
                        $site_map_exists = $site_map;
                        break;
                    }
                    $site_map = home_url('/sitemap_index.xml');
                    $http = wp_remote_head($site_map);
                    $code = wp_remote_retrieve_response_code($http);
                    $res_code[] = $code;
                    if($code === 200){
                        $site_map_exists = $site_map;
                        break;
                    }

                    $site_map = home_url('/wp-sitemap.xml');
                    $http = wp_remote_head($site_map);
                    $code = wp_remote_retrieve_response_code($http);
                    $res_code[] = $code;
                    if($code === 200){
                        $site_map_exists = $site_map;
                        break;
                    }

                }while(0);

                $ret['res_code'] = $res_code;
                if(!$site_map_exists){
                    $ret['code'] = 1;
                    $ret['desc'] = '404';
                }else{
                    $ret['desc'] = '200';
                    $ret['data'] = $site_map_exists;
                }

                header('content-type:text/json;');

                echo json_encode($ret);

                exit();

                break;

            case 'down_404_url':
                $data = WB_BSL_Stats::spider_404(0,0);
                $list = $data['list'];
                $filename = '404-url.txt';
                header('Content-Type: application/application/octet-stream	');
                header('Content-Disposition: attachment;filename="'.$filename.'"');
                header('Cache-Control: max-age=0');
                header('Cache-Control: max-age=1');
                header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
                header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified
                header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
                header ('Pragma: public'); // HTTP/1.0
                $fileHandle = fopen('php://output', 'wb+');
                foreach($list as $r){
                    fwrite($fileHandle,home_url($r->url)."\n");
                }
                fclose($fileHandle);
                exit();
                break;

            case 'del_404_url':


                try{
                    if(isset($_POST['url']) && is_array($_POST['url'])){
                        $url_list = self::array_sanitize_text_field($_POST['url']);
                        foreach($url_list as $url){
                            if(!$url)continue;
                            $wpdb->delete($wpdb->prefix.'wb_spider_log',['code'=>404,'spider'=>'Baiduspider','url_md5'=>$url]);
                        }
                    }else{
                        $url = sanitize_text_field($_REQUEST['url']);

                        $wpdb->delete($wpdb->prefix.'wb_spider_log',['code'=>404,'spider'=>'Baiduspider','url_md5'=>$url]);
                    }

                }catch (Exception $ex){

                }
                header('content-type:text/json');
                echo json_encode(array('code'=>0,'desc'=>'success'));
                break;

            case 'check_404_url':
                //$url_list = [];
                $id_list = [];
                $batch = 0;
                $all = 0;
                if(isset($_POST['id']) && is_array($_POST['id'])){
                    $id_list = self::array_sanitize_text_field($_POST['id']);
                    $batch = 1;
                }else if(isset($_REQUEST['id']) && $_REQUEST['id']){
                    $id_list[] = intval(sanitize_text_field($_REQUEST['id']));
                }else if(isset($_POST['all']) && $_POST['all']){
                    $all = 1;
                    $ret = ['code' => 0,'desc' => '检测任务提交成功'];
                    $total = isset($_POST['total'])?absint($_POST['total']):1;
                    $num = 50;
                    $mx = ceil($total/$num);
                    wp_clear_scheduled_hook('bsl_check_all_404_url');
                    for($page=1;$page<=$mx;$page++){
                        wp_schedule_single_event(current_time('U',1)+(5*$page),'bsl_check_all_404_url',['page'=>$page,'num'=>$num,'name'=>'bsl_check_all_404_url']);
                    }
                    /*$page = -1;
                    do{
                        $page++;

                        $num = 1000;
                        $offset = $page * $num;
                        $data = WB_BSL_Stats::spider_404($num,$offset);
                        if(!$data['list']){
                            break;
                        }
                        WB_BSL_Stats::check_404_url($data['list']);

                    }while(1);*/




                    header('content-type:text/json');
                    echo json_encode($ret);

                    break;
                }

                $t = $wpdb->prefix.'wb_spider_log';
                $log_list = $wpdb->get_results("SELECT * FROM $t WHERE id IN(".implode(',',$id_list).")");
                $ret = ['code'=>-1,'desc'=>'error'];
                $result = WB_BSL_Stats::check_404_url($log_list);
                if($batch){
                    $ret['code'] = 0;
                    $ret['desc'] = '检测完成';
                    $ret['result'] = $result;
                }else if($result){
                    $ret = $result[0];
                }


                header('content-type:text/json');
                echo json_encode($ret);

                break;

            case 'sp_404_url':
                $num = 10;
                if(isset($_POST['num']) && $_POST['num']){
                    $num = intval(sanitize_text_field($_POST['num']));
                    $num = $num?$num:10;
                }
                $page = 1;
                if(isset($_POST['page'])){
                    $page = absint(sanitize_text_field($_POST['page']));
                }

                $offset = max(0,($page-1) * $num);


                $data = WB_BSL_Stats::spider_404($num,$offset);
                header('content-type:text/json;');

                $ret = array(
                    'num'=>$num,
                    'offset'=>$offset,
                    'page'=>$page,
                    'total'=>$data['total'],
                    'code'=>0,
                    'data'=>$data['list'],
                );
                echo json_encode($ret);
                break;

            case 'push_log':
                $type = 1;
                if(isset($_POST['type'])){
                    $type = intval(sanitize_text_field($_POST['type']));
                }
                $num = 10;
                if(isset($_POST['num']) && $_POST['num']){
                    $num = intval(sanitize_text_field($_POST['num']));
                    $num = $num?$num:10;
                }
                $page = 1;
                if(isset($_POST['page'])){
                    $page = absint(sanitize_text_field($_POST['page']));
                }

                $offset = max(0,($page-1) * $num);


                $data = WB_BSL_Stats::push_log($type,$num,$offset);
                header('content-type:text/json;');
                $ret = array(
                    'num'=>$num,
                    'offset'=>$offset,
                    'page'=>$page,
                    'total'=>$data['total'],
                    'code'=>0,
                    'data'=>$data['list'],
                );
                echo json_encode($ret);
                break;

            case 'post_overview':
                //data[全站收录,文章收录,未收录文章,文章收录占比]
                $ret = ['code'=>0,'data'=>[0,0,0,0]];
                $t = $wpdb->prefix.'wb_bsl_day';
                $now = current_time('Y-m-d');
                $row = $wpdb->get_row("SELECT * FROM $t WHERE ymd='$now' AND `type`=1");
                if($row){
                    $ret['data'][0] = $row->all_in;
                    $ret['data'][1] = $row->day_in;
                    $ret['data'][2] = $row->not_in;
                    $num = $row->day_in + $row->not_in;
                    if($num>0){
                        $ret['data'][3] = round($row->day_in / $num * 100,1);
                    }

                }

                header('content-type:text/json;');
                echo json_encode($ret);
                break;

            case 'post_category':
                $ret = ['code'=>0,'cat_list1'=>[],'cat_list2'=>[],'data'=>[]];

                $pid = isset($_POST['pid']) && $_POST['pid'] ? intval(sanitize_text_field($_POST['pid'])):0;

                $cache_key = 'wb_bsl_post_chart_data_'.$pid;

                $data = get_option($cache_key,array());
                if(isset($data['ret']) && $data['ret'] && isset($data['expired']) && $data['expired']>time()){
                    header('content-type:text/json;');
                    echo json_encode($data['ret']);
                    break;

                }
                set_time_limit(0);

                //$ret['childs'] = $childs;
                $sql = "SELECT a.term_taxonomy_id,a.term_id,b.name,a.parent FROM $wpdb->term_taxonomy a,$wpdb->terms b";
                $sql .= " WHERE a.term_id=b.term_id AND a.`taxonomy`='category' ";
                $sql .= "AND a.parent IN(SELECT term_id FROM $wpdb->term_taxonomy c WHERE c.parent = $pid)";
                $result = $wpdb->get_results($sql);
                if($result){
                    $data_list = [];
                    foreach($result as $r){
                        if(!isset($data_list[$r->parent])){
                            $data_list[$r->parent] = array();
                        }
                        $data_list[$r->parent][] = $r;
                    }
                    //wp_parse_id_list(array_keys($data_list));
                    $sql = "SELECT a.term_taxonomy_id,a.term_id,b.name FROM $wpdb->term_taxonomy a,$wpdb->terms b ";
                    $sql .= " WHERE a.term_id=b.term_id AND b.term_id IN(".implode(',',array_keys($data_list)).')';
                    //$ret['parent_sql'] = $sql;
                    $sub_list = $wpdb->get_results($sql);
                    if($pid>0){
                        $ret['cat_list2'] = $sub_list;
                    }else{
                        $ret['cat_list1'] = $sub_list;
                    }
                }

                $data_x = [];
                $data_y = [];
                $sql = "SELECT a.term_taxonomy_id,a.term_id,b.name FROM $wpdb->term_taxonomy a,$wpdb->terms b ";
                $sql .= " WHERE a.term_id=b.term_id AND a.`taxonomy`='category' AND a.parent=".$pid;
                //$ret['parent_sql'] = $sql;
                $parent_list = $wpdb->get_results($sql);
                $sql_list = [];
                foreach($parent_list as $r){

                    $child = get_term_children($r->term_id,'category');
                    $child[] = $r->term_id;

                    $num_sql = "SELECT COUNT(DISTINCT a.post_id) FROM $wpdb->postmeta a,$wpdb->term_relationships b,$wpdb->term_taxonomy c ";
                    $num_sql .= " WHERE a.post_id=b.object_id AND b.term_taxonomy_id = c.term_taxonomy_id AND a.meta_key='url_in_baidu' AND a.meta_value='1'";
                    $num_sql .= " AND c.term_id IN(".implode(',',$child).")";
                    $num = $wpdb->get_var($num_sql);
                    $data_y[] = $num?$num:0;
                    //$sql_list[] = $num_sql;
                    //$data_y[] = mt_rand(50,100);
                    $data_x[] = $r->name;
                }
                $ret['data'] = ['x'=>$data_x,'y'=>$data_y];


                $ret['sql_list'] = $sql_list;

                update_option($cache_key,array('ret'=>$ret,'expired'=>time() + 7200),false);
                header('content-type:text/json;');
                echo json_encode($ret);
                break;

            case 'baidu_log':
                $type = 1;
                if(isset($_POST['type'])){
                    $type = intval(sanitize_text_field($_POST['type']));
                }
                $num = 10;
                if(isset($_POST['num']) && $_POST['num']){
                    $num = intval(sanitize_text_field($_POST['num']));
                    $num = $num?$num:10;
                }

                $page = 1;
                if(isset($_POST['page'])){
                    $page = absint(sanitize_text_field($_POST['page']));
                }

                $offset = max(0,($page-1) * $num);


                $data = WB_BSL_Stats::baidu_log($type,$num,$offset);
                header('content-type:text/json;');

                $ret = array(
                    'num'=>$num,
                    'offset'=>$offset,
                    'page'=>$page,
                    'total'=>$data['total'],
                    'code'=>0,
                    'data'=>$data['list'],
                );
                echo json_encode($ret);
                break;

            case 'mark':
                if(isset($_POST['post_id']) && is_array($_POST['post_id'])){
                    $post_id = wp_parse_id_list($_POST['post_id']);
                    foreach($post_id as $id){
                        update_post_meta($id,'url_in_baidu',1);
                        //update_post_meta($id,'url_in_baidu_ymd',current_time('mysql'));
                    }
                }
                header('content-type:text/json;');
                $ret = array(
                    'code'=>0,
                    'desc'=>'success'
                );
                echo json_encode($ret);
                break;
            case 'force':
                $desc = 'success';
                $code = 0;
                if(isset($_POST['post_id']) && is_array($_POST['post_id'])){
                    $post_id = wp_parse_id_list($_POST['post_id']);

                    foreach($post_id as $id){
                        $err = '';
                        //update_post_meta($id,'url_in_baidu',1);
                        //update_post_meta($id,'url_in_baidu_ymd',current_time('mysql'));
                        WB_BSL_Site::force_push($id,get_post($id),$err);
                        if($err == 'success'){
                            update_post_meta($id,'url_in_baidu',3);
                        }else{
                            $code = 1;
                            $desc = $err;
                        }
                    }
                }
                header('content-type:text/json;');
                $ret = array(
                    'code'=>$code,
                    'desc'=>$desc
                );
                echo json_encode($ret);
                break;
            case 'index_stat':
                $day = 7;
                $query_day = isset($_GET['day']) && $_GET['day'] ? intval(sanitize_text_field($_GET['day'])):0;
                if($query_day == 30){
                    $day = 30;
                }
                $ret = WB_BSL_Stats::index_data($day);
                $data = array(array_values($ret['all_in']),array_values($ret['new_in']),array_values($ret['not_in']),array_values($ret['day_in']));

                header('content-type:text/json;');

                echo json_encode(array('code'=>0,'data'=>$data,'day'=>$day));
                break;

            case 'bing_push_manual':

                if(isset($_POST['url']) && $_POST['url']){
                    $urls = sanitize_textarea_field($_POST['url']);
                    $ret = WB_BSL_Bing::push_batch_url($urls);
                    header('content-type:text/json;');

                    echo json_encode($ret);
                }


                exit();

                break;
            case 'bing_quota':
                $ret = array('code'=>1);
                $quota = WB_BSL_Bing::get_quota($ret);
                header('content-type:text/json;');

                echo json_encode($ret);
                break;
            case 'bing_summary':
                $data = WB_BSL_Bing::summary();
                header('content-type:text/json;');

                echo json_encode(array('code'=>0,'data'=>$data));
                break;
            case 'bing_stat':
                $day = 7;
                $query_day = isset($_GET['day']) && $_GET['day'] ? intval(sanitize_text_field($_GET['day'])):0;
                if($query_day == 30){
                    $day = 30;
                }
                $ret = WB_BSL_Stats::bing_data($day);
                $data = array(array_values($ret['auto']),array_values($ret['manual']),array_values($ret['remain']));

                header('content-type:text/json;');

                echo json_encode(array('code'=>0,'data'=>$data));
                break;
            case 'google_stat':
                $day = 7;
                $query_day = isset($_GET['day']) && $_GET['day'] ? intval(sanitize_text_field($_GET['day'])):0;
                if($query_day == 30){
                    $day = 30;
                }
                $ret = WB_BSL_Stats::google_data($day);
                $data = array(array_values($ret['update']),array_values($ret['delete']));

                header('content-type:text/json;');

                echo json_encode(array('code'=>0,'data'=>$data));
                break;
            case 'qh_stat':
                $day = 7;
                $query_day = isset($_GET['day']) && $_GET['day'] ? intval(sanitize_text_field($_GET['day'])):0;
                if($query_day == 30){
                    $day = 30;
                }
                $cnf = WB_BSL_Conf::cnf(null);
                $empty = WB_BSL_Stats::push_stat_empty($day);
                $ret = [
                    '360' => $empty,
                    'sm' => $empty,
                    'byte' => $empty,
                    'indexnow' => $empty,
                    'yandex' => $empty,
                ];
                if($cnf['qh_active']){
                    $ret['360'] = WB_BSL_Stats::push_stat_data(20,$day);
                }
                if($cnf['sm_active']) {
                    $ret['sm'] = WB_BSL_Stats::push_stat_data(21, $day);
                }
                if($cnf['byte_active']) {
                    $ret['byte'] = WB_BSL_Stats::push_stat_data(22, $day);
                }
                if($cnf['indexnow']) {
                    $ret['indexnow'] = WB_BSL_Stats::push_stat_data(32,$day);
                }
                if($cnf['yandex']) {
                    $ret['yandex'] = WB_BSL_Stats::push_stat_data(33, $day);
                }
                $data = array(array_values($ret['360']),array_values($ret['sm']),array_values($ret['byte']),array_values($ret['indexnow']),array_values($ret['yandex']));

                header('content-type:text/json;');

                echo json_encode(array('code'=>0,'data'=>$data));
                break;
            case 'push_stat':

                $day = 7;
                $query_day = isset($_GET['day']) && $_GET['day'] ? intval(sanitize_text_field($_GET['day'])):0;
                if($query_day == 30){
                    $day = 30;
                }
                $ret = WB_BSL_Stats::pc_stat_data($day);

                header('content-type:text/json;');

                echo json_encode(array('code'=>0,'data'=>$ret));

                //exit();
                break;

            case 'day_push_stat':

                $day = 7;
                $query_day = isset($_GET['day']) && $_GET['day'] ? intval(sanitize_text_field($_GET['day'])):0;
                if($query_day == 30){
                    $day = 30;
                }

                $ret = WB_BSL_Stats::day_push_data($day);


                header('content-type:text/json;');

                echo json_encode(array('code'=>0,'data'=>$ret));

                //exit();

                break;

            case 'daily_push_stat':

                $day = 7;
                $query_day = isset($_POST['day']) && $_POST['day'] ? sanitize_text_field($_POST['day']):0;
                if($query_day == 30){
                    $day = 30;
                }

                $ret = WB_BSL_Stats::daily_push_data($day);


                header('content-type:text/json;');

                echo json_encode(array('code'=>0,'data'=>$ret));


                break;

            case 'verify':
                if(!wp_verify_nonce(sanitize_text_field($_POST['_ajax_nonce']), 'wp_ajax_wb_baidu_push_url')){

                    echo json_encode(array('code'=>1,'data'=>'非法操作'));
                    exit(0);
                }
                if(!current_user_can('manage_options')){
                    echo json_encode(array('code'=>1,'data'=>'没有权限'));
                    exit(0);
                }

                $param = array(
                    'code'=>sanitize_text_field(trim($_POST['key'])),
                    'host'=>sanitize_text_field(trim($_POST['host'])),
                    'ver'=>'bsl-pro',
                );
                $err = '';
                do{
                    $http = wp_remote_post('https://www.wbolt.com/wb-api/v1/verify',array('sslverify'=>false,'body'=>$param,'headers'=>array('referer'=>home_url()),));
                    if(is_wp_error($http)){
                        $err = '校验失败，请稍后再试（错误代码001['.$http->get_error_message().'])';
                        break;
                    }

                    if($http['response']['code']!=200){
                        $err = '校验失败，请稍后再试（错误代码001['.$http['response']['code'].'])';
                        break;
                    }

                    $body = $http['body'];

                    if(empty($body)){
                        $err = '发生异常错误，联系<a href="https://www.wbolt.com/?wb=member#/contact" target="_blank">技术支持</a>（错误代码 010）';
                        break;
                    }

                    $data = json_decode($body,true);

                    if(empty($data)){
                        $err = '发生异常错误，联系<a href="https://www.wbolt.com/?wb=member#/contact" target="_blank">技术支持</a>（错误代码011）';
                        break;
                    }
                    if(empty($data['data'])){
                        $err = '校验失败，请稍后再试（错误代码004)';
                        break;
                    }
                    if($data['code']){
                        $err_code = $data['data'];
                        switch ($err_code){
                            case 100:
                            case 101:
                            case 102:
                            case 103:
                                $err = '插件配置参数错误，联系<a href="https://www.wbolt.com/?wb=member#/contact" target="_blank">技术支持</a>（错误代码'.$err_code.'）';
                                break;
                            case 200:
                                $err = '输入key无效，请输入正确key（错误代码200）';
                                break;
                            case 201:
                                $err = 'key使用次数超出限制范围（错误代码201）';
                                break;
                            case 202:
                            case 203:
                            case 204:
                                $err = '校验服务器异常，联系<a href="https://www.wbolt.com/?wb=member#/contact" target="_blank">技术支持</a>（错误代码'.$err_code.'）';
                                break;
                            default:
                                $err = '发生异常错误，联系<a href="https://www.wbolt.com/?wb=member#/contact" target="_blank">技术支持</a>（错误代码'.$err_code.'）';
                        }

                        break;
                    }

                    update_option('wb_bsl_ver',$data['v'],true);
                    update_option('wb_bsl_cnf_'.$data['v'],$data['data'],false);


                    echo json_encode(array('code'=>0,'data'=>'success'));
                    exit(0);
                }while(false);
                echo json_encode(array('code'=>1,'data'=>$err));
                //exit(0);
                break;

            case 'options':
                if(!current_user_can('manage_options') || !wp_verify_nonce(sanitize_text_field($_GET['_ajax_nonce']), 'wp_ajax_wb_baidu_push_url')){
                    echo json_encode(array('o'=>''));
                    exit(0);
                }

                $ver = get_option('wb_bsl_ver',0);
                $cnf = '';
                if($ver){
                    $cnf = get_option('wb_bsl_cnf_'.$ver,'');
                }
                $list = array('o'=>$cnf);
                header('content-type:text/json;charset=utf-8');
                echo json_encode($list);
                //exit();
                break;

	        case 'get_stats':
		        $ret = array('code'=>0,'desc'=>'success');

		        $ret_data = array();
		        $row = WB_BSL_Stats::day_index();
		        $data = array(
			        array('name'=>'收录总数','value'=>$row->all_in),
			        array('name'=>'近7天收录','value'=>$row->week_in),
			        array('name'=>'近30天收录','value'=>$row->month_in),
		        );
		        $ret_data['base_overview'] = $data;

		        $query_times = get_option('wb_bsl_query_times','');
		        if(!$query_times || !is_array($query_times)){
			        $query_times = array('time'=>0,'times'=>0);
		        }

		        if($query_times['time']<current_time('U',1)){
			        $query_times = array('time'=>current_time('U',1)+86400,'times'=>$query_times['times']);
			        $data = WB_BSL_Cron::wb_idx(1);
			        if($data && isset($data['query_times'])){
				        $query_times['times'] = $data['query_times'];
			        }
			        update_option('wb_bsl_query_times',$query_times,false);
		        }

		        $last_check_date = $wpdb->get_var("SELECT max(meta_value) FROM $wpdb->postmeta WHERE meta_key='url_in_baidu_ymd'");
		        $last_check_date = sprintf("%s",$last_check_date);
		        $ret_data['last_check_date'] = $last_check_date == "-" ? '':$last_check_date;
		        $ret_data['last_query_times'] = sprintf("%s",$query_times['times']);
		        $wb_bsl_check_all = get_option('wb_bsl_check_all',0);
		        $ret_data['baidu_check_all'] = ($wb_bsl_check_all?1:0);

		        $ret_data['wb_idx_data_updated'] = get_option('wb_idx_data_updated',0);

		        $ret['data'] = $ret_data;

		        header('content-type:text/json;');
		        echo json_encode($ret);

		        exit();
                break;
            case 'chk_ver_ce':

                $http = wp_remote_get('https://www.wbolt.com/wb-api/v1/extension/ver?code=bsl-pro&ver=',array('sslverify' => false,'headers'=>array('referer'=>home_url()),));

                if(wp_remote_retrieve_response_code($http) == 200){
                    echo wp_remote_retrieve_body($http);
                }

                exit();
                break;
	        case 'get_setting_cnf':
		        $ret = array('code'=>0,'desc'=>'success');
		        $ret['data'] = self::get_bsl_cnf();

		        header('content-type:text/json;');
		        echo json_encode($ret);
		        break;
        }

        exit();


    }


    public static function bulk_actions($actions){
        static $has_bulk_inline_js = false;
        if(current_user_can('administrator')){

            $pc_active = WB_BSL_Conf::cnf('pc_active2');
            if(!$pc_active){
                return $actions;
            }
            $actions['bsl_bd_batch'] = '推送至百度';
            if(!$has_bulk_inline_js){
                $has_bulk_inline_js = true;
                $js = array();
                $fun_js = array();
                $fun_js[] = "var ckb = h('.check-column :checkbox:checked');";
                $fun_js[] = "if(ckb.length<1){return false;}";
                $fun_js[] = "var id = [];ckb.each(function(idx,el){if(/^\d+$/.test(el.value)){id.push(el.value);}});";
                $fun_js[] = "h.post(ajaxurl,{action:'wb_baidu_push_url','op':'batch_bd',post_id:id.join(',')},function(ret){alert('推送成功');});";
                $js[] = "(function(h){";
                $js[] = "h('#doaction2,#doaction').on('click',function(e){";
                $js[] = "var btn = h(this);var op = btn.prev().val();";
                $js[] = "if(op=='bsl_bd_batch'){".implode('',$fun_js)."e.preventDefault();return false;}";
                $js[] = "});";
                $js[] = "})(jQuery);";

                wp_add_inline_script('wp-auth-check',implode('',$js));
            }

        }

        return $actions;
    }

    public static function parse_vue_assets($content)
    {
        $link_match = [];
        $script_match = [];
        if(preg_match_all('#<link[^>]+>#is',$content,$match)){
            foreach($match[0] as $html){
                $r = [];
                if(preg_match_all('#([a-z]+)+="([^"]+)"#is',$html,$m)){
                    //print_r($m);
                    foreach($m[1] as $k=>$v){
                        $r[$v] = $m[2][$k];
                    }
                }
                if($r){
                    $link_match[] = $r;
                }
            }

        }
        if(preg_match_all('#<script([^>]*)>(.*?)</script>#is',$content,$match)){
            //print_r($match);
            foreach($match[0] as $i=>$html){
                $r = [];
                if(!preg_match('#src=.+#',$match[1][$i])){
                    $in_line_js = trim($match[2][$i]);
                    $r['src'] = '';
                    $r['in_line'] = $in_line_js;
                    $script_match[] = $r;
                    continue;
                }
                $html2 = $html = $match[1][$i];
                //str_replace(['<script','>'],'',$html);
                if(preg_match_all('#([a-z]+)+="([^"]+)"#is',$html,$m)){
                    //print_r($m);
                    foreach($m[1] as $k=>$v){
                        $r[$v] = $m[2][$k];
                        $html2 = str_replace($m[0][$k],'',$html2);
                    }
                }
                if($r){
                    $html2 = trim($html2);
                    if($html2){
                        $r['attr'] = $html2;
                    }
                    $script_match[] = $r;
                }
            }
        }
        $css = [];
        $js = [];

        foreach($link_match as $k=>$r){
            if(!$r['href']){
                continue;
            }
            $src = preg_replace('#.*?assets/#','',$r['href']);
            $src = 'tpl/assets/'.$src;
            unset($r['href']);
            $handle = 'wb-bsl-link-'.$k;
            $arg = http_build_query($r);
            $css[] = ['handle'=>$handle,'src'=>$src,'dep'=>[],'args'=>'vue-'.$arg];
        }
        $handle_list = [];
        foreach($script_match as $k=>$r){
            if(!$r['src']){
                if($r['in_line']){
                    $handle = 'wb-bsl-vue-inline-js-'.$k;
                    $before_handle = $handle_list[$k-1];
                    $js[] = ['handle'=>$handle,'src'=>null,'in_line'=>$r['in_line'],'dep'=>[$before_handle]];
                    $handle_list[$k] = $handle;
                }
                continue;
            }
            $src = preg_replace('#.*?assets/#','',$r['src']);
            $src = 'tpl/assets/'.$src;
            unset($r['src']);
            if($r){
                $src = $src.'?'.http_build_query($r);
            }
            $handle = 'wb-bsl-vue-js-'.$k;
            $handle_list[$k] = $handle;
            $dep = [];
            $js[] = ['handle'=>$handle,'src'=>$src,'in_line'=>null,'dep'=>$dep];
        }

        return ['css'=>$css,'js'=>$js];
    }

    public static function cache_vue_assets($assets = null)
    {
        $cache = __DIR__.'/plugins_assets.php';
        if(null === $assets){
            return include $cache;
        }
        $data = '<'.'?php'."\n".'return '.var_export($assets,true).';';
        file_put_contents($cache,$data);
    }

    public static function vue_assets()
    {

        $assets = [];
        $vue_pack = BSL_PATH . '/tpl/index.html';
        do{
            if(!file_exists($vue_pack)) {
                break;
            }
            $content = file_get_contents($vue_pack);
            if (empty($content)) {
                break;
            }
            $assets = self::parse_vue_assets($content);
            self::cache_vue_assets($assets);
        }while(0);

        if(empty($assets)){
            $assets = self::cache_vue_assets();
        }

        if(!$assets || !is_array($assets)){
            return;
        }

        $wp_styles = wp_styles();
        if(isset($assets['css']) && is_array($assets['css']))foreach($assets['css'] as $r){
            $wp_styles->add( $r['handle'], BSL_URL.$r['src'], $r['dep'], null, $r['args']);
            $wp_styles->enqueue( $r['handle'] );//.'?v=1'
        }
        if(isset($assets['js']) && is_array($assets['js']))foreach($assets['js'] as $r){
            if(!$r['src'] && $r['in_line']){
                wp_register_script( $r['handle'], false, $r['dep'], false ,true);
                wp_enqueue_script( $r['handle'] );
                wp_add_inline_script($r['handle'],$r['in_line'],'after');
            }else if($r['src']){
                wp_enqueue_script($r['handle'],BSL_URL.$r['src'],$r['dep'],null,true);
            }
        }


    }

	public static function render_views()
	{
		if (!current_user_can('manage_options')) {
			wp_die(__('You do not have sufficient permissions to access this page.'));
		}
        echo '<div id="app"></div>';
		//include BSL_PATH.'/tpl/index.html';
	}


	/**
	 * 获取初始配置字段
	 * @return array
	 */
    public static function get_bsl_cnf()
    {
        global  $wp_post_types;
        $init_data = array(
        	'spider_install'=>1,
			'spider_setup_url'=>admin_url('plugin-install.php?s=Wbolt+Spider+Analyser&tab=search&type=term'),
			'spider_active'=>1,
			'spider_active_url'=>admin_url('plugin-install.php?s=Wbolt+Spider+Analyser&tab=search&type=term'),
			'post_types'=>array(),
			'log_day'=>array(1=>'24小时',3=>'3天',7=>'7天（默认）'),
			'sitemap_exists'=>0,
			'sitemap_url'=>'',
	        );

        //post_types
        if($wp_post_types && is_array($wp_post_types))foreach($wp_post_types as $type) {
            if ($type->public) {
                $init_data['post_types'][$type->name] = $type->labels->name;
            }
        }

        return $init_data;
    }

    public static function run_log_info($clear = 0)
    {
        $log_info = array();



        $log_file = __DIR__.'/#log/running.log';
        if(!file_exists($log_file)){
            //echo file_get_contents($log_file);
            file_put_contents($log_file,'');
        }
        if($clear){
            file_put_contents($log_file,'');
        }else{
            $file = file($log_file);
            if(count($file)>1000){
                $file = array_slice($file,-1000);
                file_put_contents($log_file,implode('',$file));
            }

            foreach($file as $r){
                $r = trim($r);
                $type = '';
                $time = '';
                if(preg_match_all('#\[([^\]]+)\]#',$r,$m)){
                    $time = $m[1][0];
                    if(isset($m[1][1])){
                        $type = $m[1][1];
                    }
                }


                $msg = $r;
                if($time){
                    $msg = str_replace('['.$time.']','',$msg);
                }
                if($type){
                    $msg = str_replace('['.$type.']','',$msg);
                }

                $msg = trim($msg);

                $log_info[] = array('time'=>$time,'type'=>$type,'msg'=>$msg);
            }
            //rsort($file);
            //$log_info = implode('',$file);
            //$log_info = $file;
        }


        return $log_info;
    }

    public static function run_log_error($clear = 0)
    {
        $log_info = array();



        $log_file = __DIR__.'/#log/error.log';
        if(!file_exists($log_file)){
            //echo file_get_contents($log_file);
            file_put_contents($log_file,'');
        }
        if($clear){
            file_put_contents($log_file,'');
        }else{
            $file = file($log_file);
            if(count($file)>1000){
                $file = array_slice($file,-1000);
                file_put_contents($log_file,implode('',$file));
            }
            $help_list = [
                "Missing attribute. 'url' attribute is required." => '用户未在其请求中设置网址。<a href="https://www.wbolt.com/indexing-api-core-errors.html" target="_blank">Google Index API常见错误码</a>',
                "Invalid attribute. 'url' is not in standard URL format" => '用户设置的网址看起来不像网址，例如“abcd”。<a href="https://www.wbolt.com/indexing-api-core-errors.html" target="_blank">Google Index API常见错误码</a>',
                "Unknown type. 'type' attribute is required and must be 'URL_REMOVED' or 'URL_UPDATED'." => '用户未设置通知类型。<a href="https://www.wbolt.com/indexing-api-core-errors.html" target="_blank">Google Index API常见错误码</a>',
                "Invalid value at 'url_notification.type' (TYPE_ENUM)" => '用户将通知类型设置为 URL_REMOVED 或 URL_UPDATED 以外的其他值。<a href="https://www.wbolt.com/indexing-api-core-errors.html" target="_blank">Google Index API常见错误码</a>',
                "Permission denied. Failed to verify the URL ownership." => '用户未完成所有权验证流程或正在尝试更新不归其所有的网址。参考<a href="https://www.wbolt.com/google-indexing-api-setting.html" target="_blank">Google Index API申请配置教程</a>',
                "Insufficient tokens for quota 'indexing.googleapis.com/default_requests'" => '用户已超出其 Indexing API 配额。<a href="https://www.wbolt.com/indexing-api-core-errors.html" target="_blank">Google Index API常见错误码</a>',
            ];
            foreach($file as $r){
                $r = trim($r);
                $type = '';
                $time = '';
                if(preg_match_all('#\[([^\]]+)\]#',$r,$m)){
                    $time = $m[1][0];
                    if(isset($m[1][1])){
                        $type = $m[1][1];
                    }
                }

                $msg = $r;
                if($time){
                    $msg = str_replace('['.$time.']','',$msg);
                }
                if($type){
                    $msg = str_replace('['.$type.']','',$msg);
                }

                $msg = trim($msg);
                $help = '';

                if($type == '谷歌推送'){
                    foreach($help_list as $k=>$v){
                        if(strpos($msg,$k)){
                            $help = $v;
                            break;
                        }
                    }
                }

                $log_info[] = array('time'=>$time,'type'=>$type,'msg'=>$msg,'help'=>$help);
            }
            //rsort($file);
            //$log_info = implode('',$file);
            //$log_info = $file;
        }


        return $log_info;
    }

    public static function admin_menu(){

        global $wb_settings_page_hook_theme,$submenu;
        $wb_settings_page_hook_theme = add_menu_page(
            '多合一搜索自动推送管理插件',
            '搜索推送',
            'administrator',
            'wb_bsl' ,
            array(__CLASS__,'render_views'),
            plugin_dir_url(BSL_BASE_FILE). 'assets/icon_for_menu.svg'
        );
        add_submenu_page('wb_bsl','数据统计 - 搜索推送', '数据统计', 'administrator','wb_bsl#/stats-base' , array(__CLASS__,'render_views'));
        add_submenu_page('wb_bsl','推送日志 - 搜索推送', '推送日志', 'administrator','wb_bsl#/log' , array(__CLASS__,'render_views'));
        add_submenu_page('wb_bsl','插件设置 - 搜索推送', '插件设置', 'administrator','wb_bsl#/setting' , array(__CLASS__,'render_views'));
        //add_submenu_page('wb_bsl','Pro版本 - 搜索推送', 'Pro版本', 'administrator','wb_bsl#/pro' , array(__CLASS__,'render_views'));
        if(!get_option('wb_bsl_ver',0)){
            add_submenu_page('wb_bsl','升至Pro版', '<span style="color: #FCB214;">升至Pro版</span>', 'administrator',"https://www.wbolt.com/plugins/bsl-pro' target='_blank'"  );
        }
        unset($submenu['wb_bsl'][0]);
    }

    public static function actionLinks( $links, $file ) {

        if ( $file != plugin_basename(BSL_BASE_FILE) )
            return $links;

        if(!get_option('wb_bsl_ver',0)) {
            $a_link = '<a href="https://www.wbolt.com/plugins/bsl-pro" target="_blank"><span style="color: #FCB214;">升至Pro版</span></a>';
            array_unshift($links, $a_link);
        }
        $a_link = '<a href="'.menu_page_url('wb_bsl',false).'#/setting-base">设置</a>';
        array_unshift( $links, $a_link );

        return $links;
    }

    public static function admin_init(){
        register_setting(  WB_BSL_Conf::$optionName,WB_BSL_Conf::$optionName );
    }

    public static function admin_enqueue_scripts($hook){
	    global $current_user;

        //print_r([urldecode($hook)]);
        if(!preg_match('#wb_bsl#i',$hook)){
            return;
        }

        add_filter('style_loader_tag',function($tag, $handle, $href, $media){
            if(!preg_match('#^vue-#',$media)){
                return $tag;
            }

            $media = htmlspecialchars_decode($media);
            $r = [];
            parse_str(str_replace('vue-','',$media),$r);
            $rel = '';
            $attr = [];
            if($r && is_array($r)){
                if(isset($r['rel'])){
                    $rel = $r['rel'];
                    unset($r['rel']);
                }
                foreach($r as $attr_k=>$attr_v){
                    $attr[] = sprintf('%s="%s"',$attr_k,esc_attr($attr_v));
                }
            }

            $tag = sprintf(
                '<link href="%s" rel="%s" %s/>'."\n",
                $href,
                $rel,
                implode(" ",$attr)
            );
            return $tag;
        },10,4);
        add_filter('script_loader_tag',function($tag, $handle, $src){
            if(!preg_match('#-vue-script-#',$handle)){
                return $tag;
            }
            $parts = explode('?',$src,2);
            $src = $parts[0];
            $type = '';
            $attr = '';
            if(isset($parts[1])){
                $r = [];
                parse_str(htmlspecialchars_decode($parts[1]),$r);
                //print_r($r);
                if($r){
                    if(isset($r['type'])){
                        $type = sprintf(' type="%s"',esc_attr($r['type']));
                        unset($r['type']);
                    }
                    $attr_txt = '';
                    if(isset($r['attr'])){
                        $attr_txt = $r['attr'];
                        unset($r['attr']);
                    }
                    foreach($r as $k=>$v){
                        $attr .= sprintf(' %s="%s"',$k,esc_attr($v));
                    }
                    if($attr_txt){
                        $attr .= sprintf(' %s',esc_attr($attr_txt));
                    }
                }

            }
            //print_r([$handle,$src]);

            $tag = sprintf( '<script%s src="%s"%s id="%s-js"></script>'."\n", $type, $src, $attr, $handle );
            return $tag;
        },10,3);

	    wp_register_script( 'wbs-inline-js', false, null, false );
	    wp_enqueue_script( 'wbs-inline-js' );

	    $wb_ajax_nonce = wp_create_nonce('wp_ajax_wb_baidu_push_url');
	    $in_line_js = array();

	    $in_line_js['wb_bsl_init'] = 0;
	    $in_line_js['wb_bsl_cnf'] = '{}';
	    $in_line_js['_wb_bsl_ajax_nonce'] = sprintf("'%s'",$wb_ajax_nonce);
	    $in_line_js['pd_code'] = sprintf("'%s'",self::$optionName);

	    $init_data = array(
		    'spider_install'=>1,
		    'spider_setup_url'=>admin_url('plugin-install.php?s=Wbolt+Spider+Analyser&tab=search&type=term'),
		    'spider_active'=>1,
		    'spider_active_url'=>admin_url('plugin-install.php?s=Wbolt+Spider+Analyser&tab=search&type=term'),
	    );

	    //check wb spider
	    $init_data['spider_install'] = file_exists(WP_CONTENT_DIR.'/plugins/spider-analyser/index.php');
	    if($init_data['spider_install']){
		    $init_data['spider_active'] = class_exists('WP_Spider_Analyser');
	    }

//	    $in_line_js['bsl_data'] = json_encode($init_data,JSON_UNESCAPED_UNICODE);

	    $js = [];
	    foreach($in_line_js as $var=>$value){
		    $js[] = $var.' = '.$value;
	    }

	    $is_pro =  get_option('wb_bsl_ver',0);
	    $wb_cnf = array(
		    'base_url'=> admin_url(),
		    'home_url'=> home_url(),
		    'ajax_url'=> admin_url('admin-ajax.php'),
		    'dir_url'=> BSL_URL,
		    'pd_code'=> $is_pro ? "bsl-pro" : "bsl",
		    'doc_url'=> "https://www.wbolt.com/bsl-plugin-documentation.html",
		    'pd_title'=> '多合一搜索自动推送管理插件',
		    'pd_version'=> BSL_VERSION,
		    'is_pro'=> get_option('wb_bsl_ver',0),
		    'action'=> array(
			    'act'=>'wb_baidu_push_url',
			    'fetch'=>'options',
			    'push'=>'set_setting'
		    ),
		    'bsl_data'=>$init_data,
		    'uid'=>$current_user->ID,
            'yandex_callback'=>esc_url( admin_url( 'admin.php?page=wb_bsl' ) ),
            'yandex_token' => get_option('bsl_yandex_token',[]),
            'yandex_error' => get_option('bsl_yandex_error',''),
	    );
	    if($wb_cnf['yandex_token']){
	        $token = $wb_cnf['yandex_token'];
	        if(!isset($token['expires_in'])){
                $token['expires_in'] = 0;
            }else if(isset($token['expires_in']) && current_time('U') > $token['expires_in']){
	            $token['expires_in'] = 1;
                $wb_cnf['yandex_error'] = 'token 已过期'.($wb_cnf['yandex_error'] ? '、'.$wb_cnf['yandex_error']:'');
            }else {
                $wb_cnf['yandex_error'] = 'token 过期时间：'.date('Y-m-d H:i:s',$token['expires_in']).''.($wb_cnf['yandex_error'] ? '、'.$wb_cnf['yandex_error']:'');
            }
	        $wb_cnf['yandex_token'] = $token;
        }else{
	        $wb_cnf['yandex_token'] = ['expires_in'=>0];
        }
	    $bsl_opt = WB_BSL_Conf::cnf(null);
	    $js[] = 'bsl_opt = '.json_encode($bsl_opt);
	    $js[] = 'wb_cnf = '.json_encode($wb_cnf,JSON_UNESCAPED_UNICODE);

	    wp_add_inline_script('wbs-inline-js',' var '.implode(",\n",$js).';window.wb_vue_path="'.BSL_URL.'tpl/";','before');

	    self::vue_assets();
    }

    public static function plugin_row_meta($links,$file){

        $base = plugin_basename(BSL_BASE_FILE);
        if($file == $base) {
            $links[] = '<a href="https://www.wbolt.com/plugins/bsl?utm_source=bsl_setting&utm_medium=link&utm_campaign=plugins_list" target="_blank">插件主页</a>';
            $links[] = '<a href="https://www.wbolt.com/bsl-plugin-documentation.html?utm_source=bsl_setting&utm_medium=link&utm_campaign=plugins_list" target="_blank">FAQ</a>';
            $links[] = '<a href="https://wordpress.org/support/plugin/baidu-submit-link/" target="_blank">反馈</a>';
        }
        return $links;
    }

    public static function restrict_manage_posts($post_type, $which){
        if(current_user_can('administrator') && get_option('wb_bsl_ver',0)) {

            if(!WB_BSL_Conf::cnf('in_bd_active')){
                return;
            }
            $in_bd = isset($_GET['in_bd']) && $_GET['in_bd'] ? intval(sanitize_text_field($_GET['in_bd'])) : 0;
            echo '<select name="in_bd"><option value="">百度收录情况</option>';
            foreach (array(1=>'未收录',2=>'已收录') as $k=>$v) {
                echo '<option value="' . $k . '" ' . ($in_bd == $k ? 'selected' : '') . '>' . $v . '</option>';
            }
            echo '</select>';

        }
    }

    public static function post_row_actions($actions, $post){
        if(current_user_can('administrator') && $post->post_status=='publish' && get_option('wb_bsl_ver',0)){
            if(!WB_BSL_Conf::cnf('in_bd_active')){
                return $actions;
            }
            $in_baidu = get_post_meta($post->ID,'url_in_baidu',true);
            if($in_baidu == '1') {
                $action_url2 = '';
                $action_url = 'https://www.baidu.com/s?ie=utf-8&f=8&rsv_bp=1&ch=&tn=baiduerr&bar=&wd=' . urlencode(get_permalink($post));
                $action_name = '百度已收录';
            }else if($in_baidu == '2'){
                $action_url = 'https://www.baidu.com/s?ie=utf-8&f=8&rsv_bp=1&ch=&tn=baiduerr&bar=&wd='.urlencode(get_permalink($post));
                $action_name = '<span style="color:#f00">百度未收录</span>';
                $action_url2 = 'https://ziyuan.baidu.com/linksubmit/url?sitename='.urlencode(get_permalink($post));
                $action_name2 = '提交百度';
            }else{
                $action_url2 = '';
                $action_url = 'https://www.baidu.com/s?ie=utf-8&f=8&rsv_bp=1&ch=&tn=baiduerr&bar=&wd=' . urlencode(get_permalink($post));
                $action_name = '收录检测中';
            }

            $actions['post_in_baidu'] = '<a class="post_in_baidu" target="_blank" href="'.$action_url.'" >'.$action_name.'</a>';
            if($action_url2){
                $actions['post_baidu_tj'] = '<a class="post_baidu_tj" target="_blank" href="'.$action_url2.'" >'.$action_name2.'</a>';
            }

        }
        return $actions;
    }

    public static function admin_parse_query($obj){
        global $wpdb, $current_user;
        if (is_admin()) {
            $in_bd = isset($_GET['in_bd']) && $_GET['in_bd'] ? intval(sanitize_text_field($_GET['in_bd'])) : 0;
            if ($current_user && $current_user->has_cap('administrator') && $in_bd && get_option('wb_bsl_ver',0)) {

                if($in_bd == 2){
                    $obj->query_vars['meta_key'] = 'url_in_baidu';
                    $obj->query_vars['meta_value'] = '1';
                    $obj->query_vars['post_status'] = 'publish';
                }else if($in_bd) {
                    $obj->query_vars['post_status'] = 'publish';
                    if(!isset($obj->query_vars['meta_query'])){
                        $obj->query_vars['meta_query'] = array();
                    }
                    $obj->query_vars['meta_query'][] = array(
                        'relation'=>'OR',
                        array('key'=>'url_in_baidu','compare'=>'NOT EXISTS'),
                        array('key'=>'url_in_baidu','value'=>'2'),
                    );
                }
            }
            return;
        }
    }

    public static function plugin_activate(){

        WB_BSL_Conf::setup_db();
    }
    public static function plugin_deactivate(){
        wp_clear_scheduled_hook('baidu_push_url_cron_action_v3');
    }

}