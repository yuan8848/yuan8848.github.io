<?php
/**
 * Author: wbolt team
 * Author URI: https://www.wbolt.com/
 */

class Smart_SEO_Tool_Url {
	public function __construct(){

	}

	public static function cnf($key,$default=null){
	    return Smart_SEO_Tool_Admin::cnf($key,$default);
    }

	public static function init(){
	    add_action('init',function(){

            $uri = $_SERVER['REQUEST_URI'];
	        if(!$uri || $uri == '/' || $uri == '/index.php'){
	            return;
            }
            $rules = self::rules();
            if(!$rules){
                return;
            }
            //print_r($rules);
            $query = $_SERVER['QUERY_STRING'];
	        $matched = [];
	        $m = [];
	        //print_r([$uri]);
	        foreach($rules as $match=>$r){
                $m = [];
                if(!$match)continue;
                //$match = str_replace('*','.',preg_quote($match,'#'));
                //. \ + * ? [ ^ ] $ ( ) { } = ! < > | : - #
                $match = str_replace(['.','?','#','*'],['\.','\?','\#','.*'],$match);
                //print_r(['#^'.$match.'#i']);
	            if(!preg_match('#^'.$match.'#i',$uri,$m)){
	                continue;
                }
	            $matched = $r;
	            break;
            }
	        //print_r([$matched]);
	        if(empty($matched)){
	            return;
            }
	        $to = $matched['to'];
	        if($m)foreach($m as $k=>$v){
	            $to = str_replace('$'.$k,$v,$to);
            }
	        if($matched['param']){
	            //参数匹配
	            do{
	                if(!isset($matched['param']) || !$query){
	                    break;
                    }
                    $param = $matched['param'];
                    $param_match = isset($param['param']) ? $param['param'] : '';
                    if($param_match == 'match'){
                        if($matched['query'] != $query){
                            return;
                        }
                    }else if($param_match == 'ignore2target'){
                        $to .= (strpos($to,'?') ? '&' : '?').$query;
                    }

                }while(0);

            }
	        wp_redirect(home_url($to),$matched['code']);
	        exit();
        });
    }

    public static function rules()
    {
        global $wpdb;

        $t = $wpdb->prefix.'wb_sst_redirection_url';
        $sql = "SELECT * FROM  $t WHERE status=1  ";
        $list = $wpdb->get_results($sql);
        if(empty($list)){
            return [];
        }
        $data = [];
        foreach($list as $r){
            $url = parse_url($r->url);
            if(!$url)continue;
            //print_r($url);
            $key = $url['path'];
            $data[$key] = [
                'url'=>$r->url,
                'to' => $r->action_data,
                'query'=> isset($url['query']) ? $url['query'] : null,
                'fragment'=> isset($url['fragment']) ? $url['fragment'] : null,
                'code' => $r->action_code,
                'param' => $r->match_data ? json_decode($r->match_data,true) : []
            ];
        }

        return $data;
    }

    public static function cache()
    {

    }

    public static function setRedirectUrlState()
    {
        global $wpdb;

        $ret = ['code'=>0,'desc'=>'success'];
        do {
            if (!current_user_can('manage_options')) {
                $ret['code'] = 403;
                $ret['desc'] = 'fail';
                break;
            }

            $type = isset($_POST['type']) ? sanitize_text_field($_POST['type']) : null;
            $id = isset($_POST['ids']) ? sanitize_text_field($_POST['ids']) : '';
            if(!$id){
                $ret['code'] = 404;
                $ret['desc'] = 'empty param';
                break;
            }
            $id = wp_parse_id_list($id);
            $sid = implode(',',$id);
            $t = $wpdb->prefix.'wb_sst_redirection_url';
            if($type == 'on'){
                //$ret['sql'] = "UPDATE $t SET status=1 WHERE id IN($sid)";
                $wpdb->query("UPDATE $t SET status=1 WHERE id IN($sid)");
            }else if($type == 'off'){
                //$ret['sql'] = "UPDATE $t SET status=2 WHERE id IN($sid)";
                $wpdb->query("UPDATE $t SET status=2 WHERE id IN($sid)");
            }else if($type == 'del'){
                //$ret['sql'] = "DELETE FROM $t WHERE id IN($sid)";
                $wpdb->query("DELETE FROM $t WHERE id IN($sid)");
            }

        }while(0);

        return $ret;

    }

    public static function redirectUrlList()
    {
        global $wpdb;
        $ret = ['code' => 0,'data' => []];
        do{
            if( !current_user_can('manage_options')) {
                break;
            }
            $num = 30;
            if(isset($_POST['num']) && $_POST['num']){
                $num = absint($_POST['num']);
                if(!$num)$num = 30;
            }
            $page = 1;
            if(isset($_POST['page']) && $_POST['page']){
                $page = absint($_POST['page']);
                if(!$page)$page = 1;
            }

            $offset = ($page - 1) * $num;


            $t = $wpdb->prefix.'wb_sst_redirection_url';

            $where = [];

            $q = isset($_POST['q']) && is_array($_POST['q'])?$_POST['q']:[];
            if(isset($q['code']) && $q['code']){
                $where[] = $wpdb->prepare("action_code=%s",sanitize_text_field($q['code']));
            }
            if(isset($q['status']) && $q['status']){
                $where[] = $wpdb->prepare("status=%d",absint($q['status']));
            }
            if(isset($q['q']) && $q['q']){
                $where[] = $wpdb->prepare("CONCAT_WS('',url,action_data) LIKE %s",'%'.sanitize_text_field($q['q']).'%');
            }
            if(empty($where))$where[] = '1=1';

            $sql = "SELECT SQL_CALC_FOUND_ROWS * FROM $t WHERE ".implode(' AND ',$where)." ORDER BY id DESC LIMIT $offset,$num";
            $list = $wpdb->get_results($sql);
            $total = $wpdb->get_var("SELECT FOUND_ROWS()");

            $ret['data'] = $list;
            $ret['total'] = $total;

        }while(0);

        return $ret;
    }


    public static function redirectUrlDetail()
    {
        global $wpdb;

        $ret = ['code'=>0,'desc'=>'success'];
        do{
            if( !current_user_can('manage_options')) {
                $ret['code'] = 403;
                $ret['desc'] = 'fail';
                break;
            }
            $id = isset($_POST['id']) ? absint($_POST['id']):0;
            if(!$id){
                $ret['code'] = 404;
                $ret['desc'] = 'empty param';
                break;
            }

            $t = $wpdb->prefix.'wb_sst_redirection_url';
            $row = $wpdb->get_row($wpdb->prepare("SELECT * FROM $t WHERE id=%d",$id));

            if(!$row){
                $ret['code'] = 404;
                $ret['desc'] = 'not found';
                break;
            }
            $data = [
                'id' => $row->id,
                'code' => $row->action_code,
                'from_url' => $row->url,
                'to_url' => $row->action_data,
                'param' => 'match',
            ];
            if($row->match_data){
                $query = json_decode($row->match_data,true);
                if($query && is_array($query)){
                    foreach(['param'] as $f){
                        if(isset($query[$f])){
                            $data[$f] = $query[$f];
                        }
                    }
                }
            }


            $ret['row'] = $row;

            $ret['data'] = $data;

        }while(0);

        return $ret;
    }

    public static function saveRedirectUrl()
    {
        global $wpdb;

        $ret = ['code'=>0,'desc'=>'success'];
        do{
            if( !current_user_can('manage_options')) {
                $ret['code'] = 403;
                $ret['desc'] = 'fail';
                break;
            }
            $r = isset($_POST['r']) ? $_POST['r']:null;
            if(!$r || !is_array($r)){
                $ret['code'] = 404;
                $ret['desc'] = 'param error';
                break;
            }
            $t = $wpdb->prefix.'wb_sst_redirection_url';
            if(isset($r['id']) && $r['id']){
                $d = [
                    'url' => $r['from_url'],
                    'match_data' => json_encode(['param'=>$r['param']]),
                    'action_code' => $r['code'],
                    'action_data' => $r['to_url'],
                ];
                $wpdb->update($t,$d,['id'=>$r['id']]);
                break;
            }
            $d = [
                'url' => $r['from_url'],
                'match_data' => json_encode(['param'=>$r['param']]),
                'action_code' => $r['code'],
                'action_data' => $r['to_url'],
                'status' => 1,
                'create_date' => current_time('mysql')
            ];

            $wpdb->insert($t,$d);

            $ret['data'] = $wpdb->insert_id;

        }while(0);

        return $ret;
    }


}