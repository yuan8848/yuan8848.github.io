<?php

class options
{
    private static $_instance = null;
    private $data = null;
    private $set = null;

    public static function getInstance()
    {
        if (self::$_instance == null) {
            self::$_instance = new options();
        }
        return self::$_instance;
    }

    private function __construct()
    {
        error_reporting(0);
        if (get_option(THEME_NAME . '_option') == false) {
            update_option(THEME_NAME . '_option', '5LFS8nUIIEVWTwiElEEWhnDcDPkSUnjngKDJr4DEaNkSXnG8ZKkhrnFw3N1CMwW8ZFkmmzjEdQ1GMnSETEEWizjEcPkS-sW8ZIUi4nVkHFVGU228ZFkep1EAzEF6KrjImKiKI4FodHR6UslQlKByp1DcaCF6KrjIbITKM11wHQxuWsl%3DhKTK84EEHN16KrjDmIy68zjEZQ0672D3hLyJrn1k4HV-L2C0YKDKqzjEaNlO-sW8ZKh6I41oHDVSXwSEjITJnn1k2PkSB1TzhFC6qzjEdN0WVsW8ZFkep1EAzEF6KrjInKR2q30DiHU671WgTEEep1F4DQ0672UofITJj20AzEBGXnG8ZLyKa21oHHS-UnWAmKkep1DccPkS75UknFjCIskocPkS-sW8ZLyKa21oHHSSUnkIcKkaA4Vo3AFSKrjDmIy671TY0CBCEwEI3Iy673kAzEUiUnSzgHB2I3kIHFRuMwko0KR2q4VscPkSB228ZEFW%3D5TcECUiM228ZFyGp1FriN0aMwjIYKkdr4lnjFVuWslQmKUep1DcaDF6KrjInKR6An1o3N1WWsSElITOW4FnjGUeKrjDmFD6qzjEdEUOMnVQkIRyp1DccPkSKrjEjIy681EEHL1uUwlwWKh2a4VvjGRCVsk4TEEWh5zQ2PkSVnVQbITK811scPkSB2WwTEEie4EI3HR-KrjDmFC6qzjEeCVGVnkoTEEWh4jQ2PkSUnkofITO8zjEaNlKYvmATEEiA5FwH-ESVnG8ZFkW33kAzEVKUnjXgIB1r4Fw3HVCWsW8ZFkmmzjEeGRyV2C0WKiK42UIGAFKUsj4lITGp1DcaDRS-sW8ZIUhr4Fw2PkSB228ZKUhrzjEZQ0672ToYIR2e4EHhPkSB228ZIDKi1102PkS-sW8ZKSJr10I3EUOV228ZFkW33kAzEUWWxzIlIDJj20AzEBGKrjIbITKM11wHQxuKrjHpFyGp1FkH%3DEaMx1ATEEWiokAzEVWWnVQnITO83lkIFRuKrjDmHhxi3kAzEVKUnjXgIB245EI2PkSB22wUFyGp1Fs3AFWWsjYYKkiE3lkH%3DEeU2U4kIEiI5EAzEBGArmATEEiq31odP1WKrjDmFD6qzjEdQ1uU2GwqIx2e1lrhPkSB228ZFCGp1DQ2PkSUslQlKB6A30DiAFCKrjDmFC6qzjEdQ1uU2GwqISKI5UDjEVuL2E4TEEWizjEcPkS-sW8ZLyK41E%3DiN0aVnG8ZFkep1EAzEF6KrjIYKiO03l0HQ1uU2GwTEEWizjEcPkSYvmATEEhr4lw3N1-Tx2gYLyKe4VocPkSB2WwTEEm821oHAB2Mx0IcKkmA31ni%3DE671VcoFyGp1FsdHV-UnkIcISJn5Vs4EUeM2E3gIB2azjEaNlO-sW8ZIDOIn1niHVCM2FPkITKEn1kIGV6MwW8ZFkW33kAzEVSMwikmL0iI3FriAFCKrjDmFD6qzjEeEUeUwiDiITKM20IHGU671VcoFyGp1FsdHV-UnkIcKTKIn0EGPkSB1T0jIy685EIH-FGW2E3jKiK83lniFV2KrjDmFD6qzjEdFV6UnjYcKkiI5Vw2PkSB1T0jIy681Vo3AFWMx04nISK4n0IGPkSB1T0jIy681Vo3AFWMwk4kKR2i30AzEBG%3DvmATEEiW5EEIIUOWsj4pKh2en0IGPkSB228ZIR2I21jhPkS-sW8ZKDKA4VodIVGU2UoaISJnzjEaO0671mgqGSKI3lkIIVSKrjEjIy681Vo3AFWMwlvhLyKI4EEdHVSMnG8ZFkW33kAzEUSLwi0gKTKW5EIIFVGUt0IgKUiWzjEaNlO-sW8ZLCJj3lseCUWKrjDmFD6qzjEdEUOU2EHhKUep1DceP0672UopIDJn5Vo3DRuTwiElKhxr11s3N0671VcoFyGp1FvjCUGLnVAcIB2m0Vs3M1KKnkIcKkmA31ni%3DE671VcoFyGp1FvjCUGLnVAcIB2m0UEeEVGWnjYcKkdrnUIIEVWTwiElIy67oTUI-16KrjIlKR6E30IdN0WLx0ogKR1n0VsdHUmKnU4kIDKe3kAzEBG%3DvmATEEhn4Vw3N0iTwjYYLyKe4VocAEWTsj4lIR2I4lviGUOU2EokIDKe3k%3DiHV-LwlQjIy67oTUDQ0672TIcL0ie5VkHAFCVnCDgKRxr3UIHHVKKrjDmFDNi3kAzEUWUnUocIy67oVzhPkSTsk4YISKA4UI3HU671WgTEEep1DQ2PkSM2CEmLyKA4UI3HU671WgTEEep1DQ2PkSLwmAgIUm84VoeGU671WgTEEep1DQ2PkSLnjYqIy67oUAzEU672SgjIy685UIHAE671WfnIy681UEIGVWMwiETEEWh4jQ2PkSUnjocKUmA21nhPkSB1TkjIy6831odGUeXt0ogLyKq20AzEBGKrjITEESqzjEdP0eXx1wmKkiEzjEaO067228ZFyGp1EI3HVWLnjIgKiOE31ni%3DE671WgTEEep1DQ2PkSWslPgKSKI5Vw4N16MwW8ZFkep1FriNxuMwSDgKDOE3kIGPkS-sW8ZLyKen1o3HUGMsk4jKDJj31w3HVSKrjDmIy670jQDCU672SgjIy6831odIVGKrjDmLByp1Fw3M0eUwk3hKiKE11w3HU671VcoFyGp1FodHR6W2E4pKh2e4Vod%3DEOUwk4TEEWizjEaHFCAwW8ZFyGp1FodHR6W2E4pKh2e4VocPkSB1UzkFyGp1EI3AB6U2U4pKSGp1DccPkSTt0ngKiO%3DoUA2Q06-nGATIy5rnlvjKlCUsiDiITOAn1wD%3DEWUnSkTEEli3kAzEVKUnjXgIy67oVzhPkSTwikeKki41lkIHVWKrjDmFC6qzjEdN1-MnjYfIDKE4VvhPkSB1T0jIy681kIHIUOWwm%3DgIB24n0EHQ1GMnG8ZFkWz3kAzEUWUnjnlKkie2Vk4GUGVnVAmLxyp1DcaDF6KrjIaKR60oFsdN0mTt0oTEEWi4FwHQ16-sW8ZKkiInkEIEUa%3DwW8ZFkep1EAzEF6KrjIpITOW11sdGFSKrjDmIy68zjEZQ0672TIcKSKInUEH%3DEWMxzojIDJn20AzEBG%3DxygjIy681Vni-F-MwizgIy67oVzhPkSM2D4aITGp1DcaDF6KrjIcKUiA4VoH-EeU2UoTEEWh514DQ0672U4qITO8zjEaOxKKrjHhKh2I5EDiHVCWsk4pIy67oTUzQ0672U4qITO81UIH%3DBuMxzHhKkiqzjEaO067228ZFyGp1FwIFUeV2U4pKSGp1DccPkSKrjEjIy683lniL1uU2ToYIR2IzjEaNlK-sW8ZKSKW4VkH%3DFKLwlwcLzO83kAzEBGKrjITEESqzjEcIUeV2FQdKDKA11w3N1GU1jYmISKIzjEaNlO-sW8ZKCKe1kIHQ1GMnVQlIEmE4EAzEBG%3DrmATEEiq2VniN1CVsj4eITKe40HhPkSB228ZIy673kAzEVSMwlwnIDKW20AzEBG%3DrmATEEm820HjCUOMnU3hKkiqzjEaO1CWwmAjFyGp1FsdHUmVsj4eITGM21sdN0iTwjYYLyKe4VobFVGMsk4TEEWh4jQ2PkSV2E4eKiK42UIHN1-MnG8ZFkhnnFo3Pl6KrjIpITKW11s4CVSUnkIcISGp1DccPkSUwj4gKSK44ls4EVGW2E4bIy673kAzEVSMxzoYKh6AnlnjEUaKrjDmFC6qzjEeEUeVsj4qKh6W4VsdGUGLwkokKDJnzjEaNlK-sW8ZLzO03lniDUaKnT3iIDOE11scPkSB1TkjIy685EIICUOVnjXjKR681lwIEV6KrjDmIy68zjEZQ0672TIcKiK45VrjL1GV2EogKTKWzjEaO1CWwmAjFyGp1Fw3M1uV2EonIDO8n10GAF6UnVwgKUep1DcaCF6KrjHgKCKe5EI4CUOV2UnlIx2q4UHiN1CKnj4oIy67oVzhPkSUnjocKUep1DcaDF6KrjIYKiO030I2PkSB228ZFD-z5zYEIB-%3DszjhIy673kAzEUOVtzoiITOezjEaO0671UIaIUWL5EEdGBCM2DTgFC-W2DUaIFSA1VrhFj-V5TTiFUW%3D5TjjFEWZo0AzERS-sW8ZKkiInFriHVSVt1wbIy67oUAzEUWUnjIcKiO821rjFU672SgjIy6841niGRyUsk4TEEWiokAzEUqTwlwfKSKe2Vk4GU671VcoFyGp1Fk3N0mTsmAgIR2an1w3M0eUwk4TEEWh5zQ2PkSTwikeKSK4oV0HQ1GLwkoTEEWh5zQ2PkSTwikeKSKe2Vk4GUSUnlATEEWh5zQ2PkSVnSjgKiGp1DcaCF6KrjIqKTOE4lwIFUeV228ZFkhnnFo3Pl6KrjIqKTOE4ls4L0aKrjDmKUmI3lozQ0672TYkLyO04EEH-EeKrjDmKUmI3lozQ0672TYkLyO02lnjFRuKrjDmKUmI3lozQ0672UocKh6E40EHN16KrjDmKUmI3lozQ0672TYkLyO04lnjERuKrjDmIy675DYGPkS-sW8ZKh1jn1s3HVCLnjHlKiOEn10ICUeKrjDmIy684FnhPkS-sW8ZKkiI4lsdN1CWsW8ZFkmmzjEdAFKMwi0TEEWh4jQ2PkSLnSEnLDKq21odAFKMwi0TEEWh4jQ2PkSLnSEnLDKq21ocPkSB1T0nFyGp1FoIFUmKrjDmIy68zkA4HByBwzobIyGqnDYEEFWA22ATLz-L5DUECU6Kt0zhFEWe2EA2QxyM2EEnIByqzlwEM0iA2DYTIyOHo0IaL0aKsW%3DhFiK82DXhQ06Ww0odISKEzkA4HB6Aw0zlIyGqnDYaKlSLnGATLz-W10I0N06Kt0zlFSKM20A2QxyA1TYYFTGp1DQ2PkSLwkobLzO83kAzEBG%3DtygjIy684lsdHR2MwizgKkiI1kAzEBG%3DtygjIy6810I2PkSB2WwTEEie4EI3HR-K5T4TEEWi4FwHQ16-sW8ZKDJn1kIIM0G%3DwSEnKCJr4EIGPkSB2CzhKSKp3kAzEVuU2EocLCFq5EAzEBGU2U4jKS6qzjEdN1CMsk3kI1W80Vs3M1GU2E4TEEWi4FwHQ16-sW8ZKDJn1kIIM0G%3DnG8ZFkhnnFo3Pl6KrjIgKUiE2102A1WKnjofKR1n20AzEBGU2U4jKS6qzjEeCVGVnkoWFDGp1Dcd%3DByUsm8jIy684lnjFRuK5T4WKiKa4VodHU671WglLzKq3jQ2PkSVsiEqLyFq5EAzEBGU2U4jKS6qzjEeCVGVnkoWFEdr4lk3AFCMwW8ZFkhnnFo3Pl6KrjInKR6An0AqFU671WglLzKq3jQ2PkSVsiEqLyFq5U%3DjCUqUnS0cIy67oVoeHV6UrmATEEm04VrjGUGAsW8ZFkhnnFo3Pl6KrjInKR6An0AqGUGVslAmKUiIzjEaO1CWwmAjFyGp1Fs3AFWWsS%3DhIy67oVoeHV6UrmATEEm04VrjGUGAwSEnKCJr4EIGPkSB2CzhKSKqpF4DERRx');
        }

        $set = json_decode(base64_decode(self::unlock(get_option(THEME_NAME . '_option'))));
        if ($set == false) {
            $set = json_decode(self::unlock(get_option(THEME_NAME . '_option')));
        }
        $set = json_decode($set->option, true);

        $data['routine']['logo'] = $set['routine']['logo'];
        $data['routine']['favicon'] = $set['routine']['favicon'];
        $data['routine']['opennewlink'] = $set['routine']['opennewlink'] === null ? 1 : $set['routine']['opennewlink'];

        $data['routine']['defaultthumbnail'] = $set['routine']['defaultthumbnail'] == null ? THEME_IMG_PATH . '/thumbnail.png' : $set['routine']['defaultthumbnail'];
        $data['routine']['autothumbnail'] = $set['routine']['autothumbnail'] === null ? 0 : $set['routine']['autothumbnail'];
        $data['routine']['summary_lenth'] = $set['routine']['summary_lenth'] === null ? 150 : $set['routine']['summary_lenth'];
        $data['routine']['icp'] = $set['routine']['icp'];
        $data['routine']['police'] = $set['routine']['police'];

        $data['theme']['themeColor'] = $set['theme']['themeColor'] === null ? '#409EFF' : $set['theme']['themeColor'];
        $data['theme']['themeHoverColor'] = $set['theme']['themeHoverColor'] === null ? '#409EFF' : $set['theme']['themeHoverColor'];
        $data['theme']['fontSelectedColor'] = $set['theme']['fontSelectedColor'] === null ? '#3390ff' : $set['theme']['fontSelectedColor'];
        $data['theme']['sidebar_position'] = $set['theme']['sidebar_position'] === null ? 1 : $set['theme']['sidebar_position'];
        $data['theme']['postlist_newnote'] = $set['theme']['postlist_newnote'] === null ? 1 : $set['theme']['postlist_newnote'];
        $data['theme']['bagimg'] = $set['theme']['bagimg'];
        $data['theme']['bagimg_showtype'] = $set['theme']['bagimg_showtype'] === null ? 1 : $set['theme']['bagimg_showtype'];
        $data['theme']['sidebar']['index'] = $set['theme']['sidebar']['index'] === null ? 0 : $set['theme']['sidebar']['index'];
        $data['theme']['sidebar']['post'] = $set['theme']['sidebar']['post'] === null ? 0 : $set['theme']['sidebar']['post'];
        $data['theme']['sidebar']['other'] = $set['theme']['sidebar']['other'] === null ? 0 : $set['theme']['sidebar']['other'];
        $data['theme']['crumbs'] = $set['theme']['crumbs'] === null ? 1 : $set['theme']['crumbs'];

        if (!isset($set['theme']['postcontent'])) {
            $set['theme']['postcontent'] = array();
        }
        $data['theme']['postcontent']['turn_page_plane'] = $set['theme']['postcontent']['turn_page_plane'] === null ? 1 : $set['theme']['postcontent']['turn_page_plane'];
        $data['theme']['font'] = $set['theme']['font'] === null ? 'no' : $set['theme']['font'];
        $data['theme']['paging'] = $set['theme']['paging'] === null ? 'ajax' : $set['theme']['paging'];
        $data['theme']['loadbar'] = $set['theme']['loadbar'] === null ? 1 : $set['theme']['loadbar'];

        $data['theme']['curname'] = $set['theme']['curname'] === null ? 'default' : $set['theme']['curname'];

        $data['index']['swiperlist'] = $set['index']['swiperlist'] == null ? array() : $set['index']['swiperlist'];
        $data['index']['postcard'] = $set['index']['postcard'] == null ? array() : $set['index']['postcard'];
        $data['index']['postcardlinenumber'] = $set['index']['postcardlinenumber'] == null ? 4 : $set['index']['postcardlinenumber'];

        $data['index']['links'] = $set['index']['links'] == null ? 0 : $set['index']['links'];
        $data['index']['links_ids'] = $set['index']['links_ids'] == null ? 0 : $set['index']['links_ids'];

        $data['index']['linksicon'] = $set['index']['linksicon'] == null ? 0 : $set['index']['linksicon'];

        $data['index']['linksdescribe'] = $set['index']['linksdescribe'];
        $data['index']['tab_ids'] = $set['index']['tab_ids'];


        $data['index']['applylink'] = $set['index']['applylink'];
        $data['optimization']['removeversion'] = $set['optimization']['removeversion'] === null ? 1 : $set['optimization']['removeversion'];

        if (!isset($set['optimization']['removednsprefetch'])) {
            $set['optimization']['removednsprefetch'] = null;
        }
        if (!isset($set['optimization']['autoenfixedtitle'])) {
            $set['optimization']['autoenfixedtitle'] = null;
        }
        $data['optimization']['removednsprefetch'] = $set['optimization']['removednsprefetch'] === null ? 1 : $set['optimization']['removednsprefetch'];
        $data['optimization']['autoenfixedtitle'] = $set['optimization']['autoenfixedtitle'] === null ? 0 : $set['optimization']['autoenfixedtitle'];

        $data['optimization']['removejson'] = $set['optimization']['removejson'] === null ? 1 : $set['optimization']['removejson'];
        $data['optimization']['removefeed'] = $set['optimization']['removefeed'] === null ? 1 : $set['optimization']['removefeed'];
        $data['optimization']['removemeta'] = $set['optimization']['removemeta'] === null ? 1 : $set['optimization']['removemeta'];
        $data['optimization']['removewpblock'] = $set['optimization']['removewpblock'] === null ? 1 : $set['optimization']['removewpblock'];
        $data['optimization']['closerest'] = $set['optimization']['closerest'] === null ? 1 : $set['optimization']['closerest'];
        $data['optimization']['closeupdate'] = $set['optimization']['closeupdate'] === null ? 1 : $set['optimization']['closeupdate'];
        $data['optimization']['closeemoji'] = $set['optimization']['closeemoji'] === null ? 1 : $set['optimization']['closeemoji'];
        $data['optimization']['gravatarsite'] = $set['optimization']['gravatarsite'] === null ? 'cn' : $set['optimization']['gravatarsite'];
        $data['optimization']['iconfontcdn'] = $set['optimization']['iconfontcdn'] === null ? 'no' : $set['optimization']['iconfontcdn'];

        $data['optimization']['closegutenberg'] = $set['optimization']['closegutenberg'] === null ? 1 : $set['optimization']['closegutenberg'];
        $data['optimization']['banimgresolving'] = $set['optimization']['banimgresolving'] === null ? 1 : $set['optimization']['banimgresolving'];
        $data['optimization']['xmlrpc'] = $set['optimization']['xmlrpc'] === null ? 1 : $set['optimization']['xmlrpc'];

        if (!isset($set['optimization']['banfun'])) {
            $set['optimization']['banfun'] = array('translations_api' => 1);
        }
        $data['optimization']['banfun']['translations_api'] = $set['optimization']['banfun']['translations_api'] === null ? 1 : $set['optimization']['banfun']['translations_api'];
        $data['optimization']['banfun']['wp_check_php_version'] = $set['optimization']['banfun']['wp_check_php_version'] === null ? 1 : $set['optimization']['banfun']['wp_check_php_version'];
        $data['optimization']['banfun']['wp_check_browser_version'] = $set['optimization']['banfun']['wp_check_browser_version'] === null ? 1 : $set['optimization']['banfun']['wp_check_browser_version'];
        $data['optimization']['banfun']['current_screen'] = $set['optimization']['banfun']['current_screen'] === null ? 0 : $set['optimization']['banfun']['current_screen'];

        if (!isset($set['optimization']['notification_reg_email'])) {
            $set['optimization']['notification_reg_email'] = 1;
        }
        if (!isset($set['optimization']['notification_changepwdandmail_email'])) {
            $set['optimization']['notification_changepwdandmail_email'] = 1;
        }
        if (!isset($set['optimization']['themecdnurl'])) {
            $set['optimization']['themecdnurl'] = '';
        } else {
            $data['optimization']['themecdnurl'] = $set['optimization']['themecdnurl'] === null ? '' : $set['optimization']['themecdnurl'];
        }

        $data['optimization']['notification_reg_email'] = $set['optimization']['notification_reg_email'] === null ? 1 : $set['optimization']['notification_reg_email'];
        $data['optimization']['notification_changepwdandmail_email'] = $set['optimization']['notification_changepwdandmail_email'] === null ? 1 : $set['optimization']['notification_changepwdandmail_email'];

        $data['optimization']['revisions_to_keep'] = $set['optimization']['revisions_to_keep'] === null ? 1 : $set['optimization']['revisions_to_keep'];

        $data['code']['headcode'] = $set['code']['headcode'];
        $data['code']['footcode'] = $set['code']['footcode'];
        $data['code']['alifront'] = $set['code']['alifront'];

        $data['code']['css'] = $set['code']['css'];
        $data['seo']['catseo'] = $set['seo']['catseo'];
        $data['seo']['openseo'] = $set['seo']['openseo'];
        $data['seo']['indextitle'] = $set['seo']['indextitle'];
        $data['seo']['keyword'] = $set['seo']['keyword'];
        $data['seo']['description'] = $set['seo']['description'];
        $data['seo']['titlestyle'] = $set['seo']['titlestyle'] === null ? 'site_title' : $set['seo']['titlestyle'];
        $data['seo']['title_delimiter'] = $set['seo']['title_delimiter'] == null ? ' - ' : $set['seo']['title_delimiter'];
        $data['info']['themeupdate'] = $set['info']['themeupdate'] === null ? 1 : $set['info']['themeupdate'];

        $data['info']['newversionname'] = $set['info']['newversionname'] === null ? '未查询' : $set['info']['newversionname'];
        $data['info']['newversion'] = $set['info']['newversion'] === null ? THEME_VERSION : $set['info']['newversion'];

        $data['info']['downurl'] = $set['info']['downurl'] === null ? 'https://www.lovestu.com' : $set['info']['downurl'];
        $data['post']['imgradius'] = $set['post']['imgradius'] === null ? 1 : $set['post']['imgradius'];
        $data['post']['imgshadow'] = $set['post']['imgshadow'] === null ? 1 : $set['post']['imgshadow'];
        $data['post']['defaultcatalog'] = $set['post']['defaultcatalog'] === null ? 0 : $set['post']['defaultcatalog'];
        $data['post']['closethumbnail'] = $set['post']['closethumbnail'] === null ? 0 : $set['post']['closethumbnail'];


        $data['post']['copyright_show'] = $set['post']['copyright_show'] === null ? 1 : $set['post']['copyright_show'];
        $data['post']['copyright'] = $set['post']['copyright'];
        $data['post']['reward1'] = $set['post']['reward1'] === null ? '' : $set['post']['reward1'];
        $data['post']['reward2'] = $set['post']['reward2'] === null ? '' : $set['post']['reward2'];

        $data['post']['relevanceplane'] = $set['post']['relevanceplane'] === null ? 1 : $set['post']['relevanceplane'];

        $data['comment']['open'] = $set['comment']['open'] === null ? 1 : $set['comment']['open'];

        $data['comment']['face'] = $set['comment']['face'] === null ? 1 : $set['comment']['face'];
        $data['comment']['encomment'] = $set['comment']['encomment'] === null ? 1 : $set['comment']['encomment'];

        $data['user']['usercenter'] = $set['user']['usercenter'] === null ? 0 : $set['user']['usercenter'];
        $data['user']['usercenterurl'] = $set['user']['usercenterurl'] === null ? '' : $set['user']['usercenterurl'];
        $data['user']['userurl'] = $set['user']['userurl'] === null ? '' : $set['user']['userurl'];


        $data['user']['loginpage'] = $set['user']['loginpage'] === null ? 0 : $set['user']['loginpage'];
        $data['user']['lgoinpageurl'] = $set['user']['lgoinpageurl'];
        $data['user']['VerificationCode'] = $set['user']['VerificationCode'] === null ? 0 : $set['user']['VerificationCode'];
        $data['user']['hideloginbtn'] = $set['user']['hideloginbtn'] === null ? 0 : $set['user']['hideloginbtn'];
        $data['user']['lgoinpageimg'] = $set['user']['lgoinpageimg'];

        $data['user']['regpage'] = $set['user']['regpage'] === null ? 0 : $set['user']['regpage'];
        $data['user']['regpageurl'] = $set['user']['regpageurl'];
        $data['user']['regpageVerificationCode'] = $set['user']['regpageVerificationCode'] === null ? 0 : $set['user']['regpageVerificationCode'];
        $data['user']['regpageimg'] = $set['user']['regpageimg'];
        $data['user']['regapproved'] = $set['user']['regapproved'];
        $data['user']['regapproved'] = $set['user']['regapproved'] === null ? 'manualapprov' : $set['user']['regapproved'];

        $data['user']['repassword'] = $set['user']['repassword'] === null ? 0 : $set['user']['repassword'];
        $data['user']['repassword_admin'] = $set['user']['repassword_admin'] === null ? 0 : $set['user']['repassword_admin'];

        $data['user']['upload_avatar'] = $set['user']['upload_avatar'] === null ? 0 : $set['user']['upload_avatar'];
        $data['user']['repasswordurl'] = $set['user']['repasswordurl'];
        $data['user']['repasswordimg'] = $set['user']['repasswordimg'];

        $data['user']['thirdparty_login'] = $set['user']['thirdparty_login'] === null ? 0 : $set['user']['thirdparty_login'];
        $data['user']['thirdparty_login_qq']['open'] = $set['user']['thirdparty_login_qq']['open'] === null ? 0 : $set['user']['thirdparty_login_qq']['open'];
        $data['user']['thirdparty_login_qq']['appid'] = $set['user']['thirdparty_login_qq']['appid'];
        $data['user']['thirdparty_login_qq']['appkey'] = $set['user']['thirdparty_login_qq']['appkey'];


        $data['user']['reuserpwd'] = $set['user']['reuserpwd'] === null ? 'corepress' : $set['user']['reuserpwd'];


        $data['module']['highlight'] = $set['module']['highlight'] === null ? 1 : $set['module']['highlight'];
        $data['module']['highlighttheme'] = $set['module']['highlighttheme'] === null ? 1 : $set['module']['highlighttheme'];

        $data['module']['imglazyload'] = $set['module']['imglazyload'] === null ? 0 : $set['module']['imglazyload'];
        $data['module']['imglightbox'] = $set['module']['imglightbox'] === null ? 1 : $set['module']['imglightbox'];

        $data['module']['smtp'] = $set['module']['smtp'] === null ? 0 : $set['module']['smtp'];
        $data['module']['smtpuser'] = $set['module']['smtpuser'];
        $data['module']['smtppwd'] = $set['module']['smtppwd'];
        $data['module']['smtpname'] = $set['module']['smtpname'];
        $data['module']['smtphost'] = $set['module']['smtphost'];
        $data['module']['testmail'] = $set['module']['testmail'];

        $data['module']['smtpport'] = $set['module']['smtpport'] === null ? '25' : $set['module']['smtpport'];
        $data['module']['smtpencrypttype'] = $set['module']['smtpencrypttype'] === null ? 'no' : $set['module']['smtpencrypttype'];

        $data['module']['reprint']['open'] = $set['module']['reprint']['open'] === null ? 0 : $set['module']['reprint']['open'];
        $data['module']['reprint']['copylenopen'] = $set['module']['reprint']['copylenopen'] === null ? 0 : $set['module']['reprint']['copylenopen'];
        $data['module']['reprint']['copylen'] = $set['module']['reprint']['copylen'] === null ? 10 : $set['module']['reprint']['copylen'];
        $data['module']['reprint']['msg'] = $set['module']['reprint']['msg'] === null ? '复制成功，转载请保留本站链接' : $set['module']['reprint']['msg'];
        $data['module']['reprint']['addurl'] = $set['module']['reprint']['addurl'] === null ? 0 : $set['module']['reprint']['addurl'];
        $data['module']['preventred'] = $set['module']['preventred'] === null ? 0 : $set['module']['preventred'];
        if (!isset($set['module']['plyr_js'])) {
            $set['module']['plyr_js'] = 1;
        } else {
            $data['module']['plyr_js'] = $set['module']['plyr_js'] === null ? 1 : $set['module']['plyr_js'];
        }


        $data['ad']['index_1'] = $set['ad']['index_1'];
        $data['ad']['index_1_phone'] = $set['ad']['index_1_phone'];

        $data['ad']['index_2'] = $set['ad']['index_2'];
        $data['ad']['index_2_phone'] = $set['ad']['index_2_phone'];

        $data['ad']['index_3'] = $set['ad']['index_3'];
        $data['ad']['index_3_phone'] = $set['ad']['index_3_phone'];

        $data['ad']['post_1'] = $set['ad']['post_1'];
        $data['ad']['post_1_phone'] = $set['ad']['post_1_phone'];
        $data['ad']['post_2'] = $set['ad']['post_2'];
        $data['ad']['post_2_phone'] = $set['ad']['post_2_phone'];
        $data['ad']['post_3'] = $set['ad']['post_3'];
        $data['ad']['post_3_phone'] = $set['ad']['post_3_phone'];
        $data['ad']['post_4'] = $set['ad']['post_4'];
        $data['ad']['post_4_phone'] = $set['ad']['post_4_phone'];
        $data['ad']['post_5'] = $set['ad']['post_5'];
        $data['ad']['post_5_phone'] = $set['ad']['post_5_phone'];
        $this->data = $data;
    }

    public function getdata()
    {
        $foot_file_data = file_get_contents(THEME_PATH . '/footer.php');
        if (strstr($foot_file_data, base64_decode('aHR0cHM6Ly93d3cubG92ZXN0dS5jb20vY29yZXByZXNzLmh0bWw=')) == false) {
            die('');
        }
        return $this->data;
    }

    static function lock($txt, $key = 'www.lovestu.com')
    {
        $chars = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789-=+";
        $nh = rand(0, 64);
        $ch = $chars[$nh];
        $mdKey = md5($key . $ch);
        $mdKey = substr($mdKey, $nh % 8, $nh % 8 + 7);
        $txt = base64_encode($txt);
        $tmp = '';
        $i = 0;
        $j = 0;
        $k = 0;
        for ($i = 0; $i < strlen($txt); $i++) {
            $k = $k == strlen($mdKey) ? 0 : $k;
            $j = ($nh + strpos($chars, $txt[$i]) + ord($mdKey[$k++])) % 64;
            $tmp .= $chars[$j];
        }
        return urlencode($ch . $tmp);
    }

    static function unlock($txt, $key = 'www.lovestu.com')
    {
        $txt = urldecode($txt);
        $chars = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789-=+";
        $ch = $txt[0];
        $nh = strpos($chars, $ch);
        $mdKey = md5($key . $ch);
        $mdKey = substr($mdKey, $nh % 8, $nh % 8 + 7);
        $txt = substr($txt, 1);
        $tmp = '';
        $i = 0;
        $j = 0;
        $k = 0;
        for ($i = 0; $i < strlen($txt); $i++) {
            $k = $k == strlen($mdKey) ? 0 : $k;
            $j = strpos($chars, $txt[$i]) - $nh - ord($mdKey[$k++]);
            while ($j < 0) $j += 64;
            $tmp .= $chars[$j];
        }
        return base64_decode($tmp);
    }

    public static function saveData($set)
    {
        $set = self::lock(base64_encode(json_encode($set)));
        return update_option(THEME_NAME . '_option', $set);
    }

    public static function getLoginData()
    {
        global $set;
        $data['logo'] = $set['routine']['logo'] === null ? null : $set['routine']['logo'];
        return $data;
    }
}