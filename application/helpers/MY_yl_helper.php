<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/* Initiate DB Tables */
define("TBL_ITEMS", "items");
define("TBL_PHOTOS", "photos");
define("TBL_USERS", "users");
define("TBL_CONTACT_US", "contact_us");
define("TBL_SLIDERS", "sliders");
define("TBL_CATEGORIES", "categories");
define("TBL_ITEMS_CATEGORIES", "items_categories");
define("TBL_BLOG", "blog");
define("TBL_CONTACT_US_EMAIL_SEND", "contact_us_email_send");
define("TBL_URL", "url");

$global_keywords = 'indonesia antique jewellery,indonesia antique store,bali antique shop,papua antique shop,sumba antique shop,art shop,antique jewellery,antique furniture,antique bracelete,antique necklace,primitive collection';
define("GLOBAL_KEYWORDS", $global_keywords);
$global_description = "Antique and Art Bali store sells sculputure,stone and wooden carving, necklace, household furnishings, home accessories, traditional weapons and many more. Our antique collections are made from all over Indonesia (e.g. Sumba, Papua, Java, Lombok, Sumatra and so on). Our stores are located in Bali, island of Gods - Indonesia.";
define("GLOBAL_DESCRIPTION", $global_description);

//define("FB_APP_ID", "596562860370613");
//define("FB_APP_SECRET", "0666fd6c41455d437bb31f813f4db6aa");
//define("CAPTCHA_PUBLIC_KEY", "6LeWH9wSAAAAAPqA--hNtky_2GLl-rUW8FNOQfzT");
//define("CAPTCHA_PRIVATE_KEY", "6LeWH9wSAAAAAMLeBPovqzF3zMhBwAvdpRC6aESA");

//define("ASSETS_JS", base_url()."assets/js/");
//define("ASSETS_CSS", base_url()."assets/styles/");

function pre($array) {
    echo '<pre>';
    print_r($array);
    echo '</pre>';
    echo '<hr />';
}

function urlSeo($url) {
   return $friendlyUrl = strtolower(str_replace(array('  ', ' '), '-', preg_replace('/[^a-zA-Z0-9 s]/', '', trim($url))));
}

/*get last query used*/
function l_query() {
    $ci->database =& get_instance();
    pre($ci->database->db->last_query());
}

function parse_form($post_data, $pref='input', $char="_") {
    foreach($post_data as $key => $data):
        $xplode = explode($char, $key);
        if( $xplode[0] == $pref ) {
            $res[$xplode[1]][str_replace($xplode[0].$char.$xplode[1].$char, "", $key)] = $data;
    }
    endforeach;
    return $res;
}

function alertMsg($code, $msg="") {
    if($msg === "") { /*checking the error message come from. send by yudhi or system*/
        switch($code):
            case 0:
                $res = '<center><b><i>-- Data not found --</i></b></center>';
                $class = '';
                break;
            case 1:
                $res = 'Insert data success';
                $class = 'success';
                break;
            case 2:
                $res = 'Insert data failed';
                $class = 'error';
                break;
            case 3:
                $res = 'Update data success';
                $class = 'success';
                break;
            case 4:
                $res = 'Update data failed';
                $class = 'error';
                break;
            case 5:
                $res = 'Delete data success';
                $class = 'success';
                break;
            case 6:
                $res = 'Delete data failed';
                $class = 'error';
                break;
            default:
                $res = 'No Error provided';
                $class = 'error';
                break;
            
            endswitch;
    }else {
        /*checking if throw a $msg (custome message) for failed or success process*/
        if($code !== 0) $class = 'success'; /* 0 = failed, true otherwise */
        else $class = 'error';
        $res = $msg;
    }
    $data['message'] = $res;
    $data['class'] = $class;
    return $data;
}