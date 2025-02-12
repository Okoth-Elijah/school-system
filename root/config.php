<?php
ob_start();
session_start(); 
error_reporting(0);
date_default_timezone_set('Africa/Kampala');
$dtime = date("Y-m-d H:i:s A", time());
$now = date("Y-m-d H:i:s", time());
$strtime = date("d-m-Y h:i:s A", time());
$today = date("Y-m-d");
require_once('mailer.php');

defined ("APP_DIR") or define("APP_DIR","");
defined ("DB_URL") or define("DB_URL", $_SERVER['HTTP_HOST']);
defined ("DS") or define("DS", DIRECTORY_SEPARATOR);
defined ("BASE_URL") or define("BASE_URL", $_SERVER['REQUEST_SCHEME'].'://'.$_SERVER['SERVER_NAME']);

switch(DB_URL){
	case 'localhost':
		defined ("DB_SERVER") or define("DB_SERVER", 'localhost');
		defined ("DB_USER") or define("DB_USER", "root");
		defined ("DB_PASS") or define("DB_PASS", "");
		defined ("DB_NAME") or define("DB_NAME", "schoolsystem");
		defined ("SITE_URL") or define("SITE_URL", 'http://localhost/managehubpro.com');
		defined ("HOME_URL") or define("HOME_URL", 'http://localhost/managehubpro.com/users');
	break;

	case 'https://www.managehubpro.com': 
		defined ("DB_SERVER") or define("DB_SERVER", "localhost");
		defined ("DB_USER") or define("DB_USER", "");
		defined ("DB_PASS") or define("DB_PASS", "");
		defined ("DB_NAME") or define("DB_NAME", "");
		defined ("SITE_URL") or define("SITE_URL", "https://schoolsystem.com");
		defined ("HOME_URL") or define("HOME_URL", "https://schoolsystem.com/users");
	break;

	default: 
		defined ("DB_SERVER") or define("DB_SERVER", 'localhost');
		defined ("DB_USER") or define("DB_USER", "root");
		defined ("DB_PASS") or define("DB_PASS", "");
		defined ("DB_NAME") or define("DB_NAME", "schoolsystem");
		defined ("SITE_URL") or define("SITE_URL", 'http://localhost/managehubpro.com');
		defined ("HOME_URL") or define("HOME_URL", 'http://localhost/managehubpro.com/users');
	}
 try{
	$dbh = new PDO("mysql:host=".DB_SERVER.";dbname=".DB_NAME, DB_USER, DB_PASS, array(PDO::ATTR_PERSISTENT => true)); 
	$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
	}

catch(PDOException $e){
	echo $e->getMessage(); 
}

function getUploadUrl($file){
	return "uploads/".$file;
}

function redirect_page($url)
{
	header("Location: {$url}");
	exit;
}

function log_message($msg=NULL){
	if(!empty($msg)){
		$_SESSION['msg'] = $msg;
	}else{
		$val = $_SESSION['msg'];
		$_SESSION['msg'] = '';
		return $val;
	}
}

function Batch($numAlpha=8,$numNonAlpha=2)
{
   $listAlpha = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
   return str_shuffle(
      substr(str_shuffle($listAlpha),0,$numAlpha)
    );
}
function getCode(){

	//$st = Batch($num=5,$alt=2);
	$st = rand(1000000,99999999);

	return $st;

}

function process_curl($data){
	global $api_url;
	$curl = curl_init();
	curl_setopt_array($curl, array(
	  CURLOPT_URL => $api_url,
	  CURLOPT_RETURNTRANSFER => true,
	  CURLOPT_ENCODING => '',
	  CURLOPT_MAXREDIRS => 10,
	  CURLOPT_TIMEOUT => 0,
	  CURLOPT_FOLLOWLOCATION => true,
	  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
	  CURLOPT_CUSTOMREQUEST => 'POST',
	  CURLOPT_POSTFIELDS => json_encode($data),
	  CURLOPT_HTTPHEADER => array('Content-Type: application/json'),
	));

	$response = curl_exec($curl);
	curl_close($curl);
	return $response;
}

function getThisWeek() {
    $startOfWeek = date('Y-m-d', strtotime('monday this week'));
    $endOfWeek = date('Y-m-d', strtotime('sunday this week'));
    return [$startOfWeek, $endOfWeek];
}

function getWeek(){
	$result = date('Y-m-d',strtotime("-7 days"));
	return $result;
}

function monthly(){
	$result = date('Y-m-d',strtotime("-30 days"));
	return $result;
}

// get monthy dates 
function getMonth(){
	$result = date('Y-m-d',strtotime("+30 days"));
	return $result;
}

// calcuate extra days 

function getExtra(){
	$result = date('Y-m-d',strtotime("+33 days"));
	return $result;
}

// calcuate new date 
function get_next($day){
	$result = date('Y-m-d', strtotime("+$day days"));
	return $result;

}

function convert_date($date){
	$result = date('d-m-Y', strtotime($date));
	return $result;
}

function calcDays($start, $end){
	$start_date = strtotime($start); 
	$end_date = strtotime($end); 
	return ($end_date - $start_date)/60/60/24;

}

function dbDelete ($tbl='',$field='',$id='')
{
	global $dbh;
	if($tbl!='' && $field!='' && $id!=''){
		$sql = 'DELETE FROM '.$tbl.' WHERE '.$field.' = '.$id. '';
		return $dbh->exec($sql);
	} else {
		return NULL;
	}
}

function dbCreate($sql='')

{
	global $dbh;

	if($sql ==''){

		return -9;
	}else {
		$q = $dbh->prepare($sql);
		return  $q->execute();
	}
}

function dbSQL($q='')
{
	global $dbh;
	if(empty($q)) return FALSE;
	$r = $dbh->prepare($q);
	$r->execute();
	$results = array();
	while($row = $r->fetch(PDO::FETCH_OBJ)){
		$results[] = $row;
	}
	return $results;

}

function dbRow($query='')
{
	global $dbh;
	$r = $dbh->prepare($query);
	$r->execute();
	return $r->fetch(PDO::FETCH_OBJ);
}

function dbOne($query='', $field='')
{
	global $dbh;
	$r = dbRow($query);
	return $r? $r->$field:NULL;
}

function get_url(){
	$current = substr($_SERVER["SCRIPT_NAME"],strrpos($_SERVER["SCRIPT_NAME"],"/")+1);  
    $result = explode('.', $current)[0];
	return $result;
}

function convert_number_to_words($number) {

    $hyphen      = '-';

    $conjunction = ' and ';

    $separator   = ', ';

    $negative    = 'negative ';

    $decimal     = ' point ';

    $dictionary  = array(

        0                   => 'Zero',

        1                   => 'One',

        2                   => 'Two',

        3                   => 'Three',

        4                   => 'Four',

        5                   => 'Five',

        6                   => 'Six',

        7                   => 'Seven',

        8                   => 'Eight',

        9                   => 'Nine',

        10                  => 'Ten',

        11                  => 'Eleven',

        12                  => 'Twelve',

        13                  => 'Thirteen',

        14                  => 'Fourteen',

        15                  => 'Fifteen',

        16                  => 'Sixteen',

        17                  => 'Seventeen',

        18                  => 'Eighteen',

        19                  => 'Nineteen',

        20                  => 'Twenty',

        30                  => 'Thirty',

        40                  => 'Fourty',

        50                  => 'Fifty',

        60                  => 'Sixty',

        70                  => 'Seventy',

        80                  => 'Eighty',

        90                  => 'Ninety',

        100                 => 'Hundred',

        1000                => 'Thousand',

        1000000             => 'Million',

        1000000000          => 'Billion',

        1000000000000       => 'Trillion',

        1000000000000000    => 'Quadrillion',

        1000000000000000000 => 'Quintillion'

    );

    if (!is_numeric($number)) {

        return false;

    }

    if (($number >= 0 && (int) $number < 0) || (int) $number < 0 - PHP_INT_MAX) {

        // overflow

        trigger_error(

            'convert_number_to_words only accepts numbers between -' . PHP_INT_MAX . ' and ' . PHP_INT_MAX,

            E_USER_WARNING

        );

        return false;

    }

    if ($number < 0) {

        return $negative . convert_number_to_words(abs($number));

    }

    $string = $fraction = null;

    if (strpos($number, '.') !== false) {

        list($number, $fraction) = explode('.', $number);

    }

    switch (true) {

        case $number < 21:

            $string = $dictionary[$number];

            break;

        case $number < 100:

            $tens   = ((int) ($number / 10)) * 10;

            $units  = $number % 10;

            $string = $dictionary[$tens];

            if ($units) {

                $string .= $hyphen . $dictionary[$units];

            }

            break;

        case $number < 1000:

            $hundreds  = $number / 100;

            $remainder = $number % 100;

            $string = $dictionary[$hundreds] . ' ' . $dictionary[100];

            if ($remainder) {

                $string .= $conjunction . convert_number_to_words($remainder);

            }

            break;

        default:

            $baseUnit = pow(1000, floor(log($number, 1000)));

            $numBaseUnits = (int) ($number / $baseUnit);

            $remainder = $number % $baseUnit;

            $string = convert_number_to_words($numBaseUnits) . ' ' . $dictionary[$baseUnit];

            if ($remainder) {

                $string .= $remainder < 100 ? $conjunction : $separator;

                $string .= convert_number_to_words($remainder);

            }

            break;

    }

    if (null !== $fraction && is_numeric($fraction)) {
        $string .= $decimal;
        $words = array();
        foreach (str_split((string) $fraction) as $number) {
            $words[] = $dictionary[$number];
        }
        $string .= implode(' ', $words);
    }
    return $string;
}

$countries = array
(
	'AF' => 'Afghanistan',
	'AX' => 'Aland Islands',
	'AL' => 'Albania',
	'DZ' => 'Algeria',
	'AS' => 'American Samoa',
	'AD' => 'Andorra',
	'AO' => 'Angola',
	'AI' => 'Anguilla',
	'AQ' => 'Antarctica',
	'AG' => 'Antigua And Barbuda',
	'AR' => 'Argentina',
	'AM' => 'Armenia',
	'AW' => 'Aruba',
	'AU' => 'Australia',
	'AT' => 'Austria',
	'AZ' => 'Azerbaijan',
	'BS' => 'Bahamas',
	'BH' => 'Bahrain',
	'BD' => 'Bangladesh',
	'BB' => 'Barbados',
	'BY' => 'Belarus',
	'BE' => 'Belgium',
	'BZ' => 'Belize',
	'BJ' => 'Benin',
	'BM' => 'Bermuda',
	'BT' => 'Bhutan',
	'BO' => 'Bolivia',
	'BA' => 'Bosnia And Herzegovina',
	'BW' => 'Botswana',
	'BV' => 'Bouvet Island',
	'BR' => 'Brazil',
	'IO' => 'British Indian Ocean Territory',
	'BN' => 'Brunei Darussalam',
	'BG' => 'Bulgaria',
	'BF' => 'Burkina Faso',
	'BI' => 'Burundi',
	'KH' => 'Cambodia',
	'CM' => 'Cameroon',
	'CA' => 'Canada',
	'CV' => 'Cape Verde',
	'KY' => 'Cayman Islands',
	'CF' => 'Central African Republic',
	'TD' => 'Chad',
	'CL' => 'Chile',
	'CN' => 'China',
	'CX' => 'Christmas Island',
	'CC' => 'Cocos (Keeling) Islands',
	'CO' => 'Colombia',
	'KM' => 'Comoros',
	'CG' => 'Congo',
	'CD' => 'Congo, Democratic Republic',
	'CK' => 'Cook Islands',
	'CR' => 'Costa Rica',
	'CI' => 'Cote D\'Ivoire',
	'HR' => 'Croatia',
	'CU' => 'Cuba',
	'CY' => 'Cyprus',
	'CZ' => 'Czech Republic',
	'DK' => 'Denmark',
	'DJ' => 'Djibouti',
	'DM' => 'Dominica',
	'DO' => 'Dominican Republic',
	'EC' => 'Ecuador',
	'EG' => 'Egypt',
	'SV' => 'El Salvador',
	'GQ' => 'Equatorial Guinea',
	'ER' => 'Eritrea',
	'EE' => 'Estonia',
	'ET' => 'Ethiopia',
	'FK' => 'Falkland Islands (Malvinas)',
	'FO' => 'Faroe Islands',
	'FJ' => 'Fiji',
	'FI' => 'Finland',
	'FR' => 'France',
	'GF' => 'French Guiana',
	'PF' => 'French Polynesia',
	'TF' => 'French Southern Territories',
	'GA' => 'Gabon',
	'GM' => 'Gambia',
	'GE' => 'Georgia',
	'DE' => 'Germany',
	'GH' => 'Ghana',
	'GI' => 'Gibraltar',
	'GR' => 'Greece',
	'GL' => 'Greenland',
	'GD' => 'Grenada',
	'GP' => 'Guadeloupe',
	'GU' => 'Guam',
	'GT' => 'Guatemala',
	'GG' => 'Guernsey',
	'GN' => 'Guinea',
	'GW' => 'Guinea-Bissau',
	'GY' => 'Guyana',
	'HT' => 'Haiti',
	'HM' => 'Heard Island & Mcdonald Islands',
	'VA' => 'Holy See (Vatican City State)',
	'HN' => 'Honduras',
	'HK' => 'Hong Kong',
	'HU' => 'Hungary',
	'IS' => 'Iceland',
	'IN' => 'India',
	'ID' => 'Indonesia',
	'IR' => 'Iran, Islamic Republic Of',
	'IQ' => 'Iraq',
	'IE' => 'Ireland',
	'IM' => 'Isle Of Man',
	'IL' => 'Israel',
	'IT' => 'Italy',
	'JM' => 'Jamaica',
	'JP' => 'Japan',
	'JE' => 'Jersey',
	'JO' => 'Jordan',
	'KZ' => 'Kazakhstan',
	'KE' => 'Kenya',
	'KI' => 'Kiribati',
	'KR' => 'Korea',
	'KW' => 'Kuwait',
	'KG' => 'Kyrgyzstan',
	'LA' => 'Lao People\'s Democratic Republic',
	'LV' => 'Latvia',
	'LB' => 'Lebanon',
	'LS' => 'Lesotho',
	'LR' => 'Liberia',
	'LY' => 'Libyan Arab Jamahiriya',
	'LI' => 'Liechtenstein',
	'LT' => 'Lithuania',
	'LU' => 'Luxembourg',
	'MO' => 'Macao',
	'MK' => 'Macedonia',
	'MG' => 'Madagascar',
	'MW' => 'Malawi',
	'MY' => 'Malaysia',
	'MV' => 'Maldives',
	'ML' => 'Mali',
	'MT' => 'Malta',
	'MH' => 'Marshall Islands',
	'MQ' => 'Martinique',
	'MR' => 'Mauritania',
	'MU' => 'Mauritius',
	'YT' => 'Mayotte',
	'MX' => 'Mexico',
	'FM' => 'Micronesia, Federated States Of',
	'MD' => 'Moldova',
	'MC' => 'Monaco',
	'MN' => 'Mongolia',
	'ME' => 'Montenegro',
	'MS' => 'Montserrat',
	'MA' => 'Morocco',
	'MZ' => 'Mozambique',
	'MM' => 'Myanmar',
	'NA' => 'Namibia',
	'NR' => 'Nauru',
	'NP' => 'Nepal',
	'NL' => 'Netherlands',
	'AN' => 'Netherlands Antilles',
	'NC' => 'New Caledonia',
	'NZ' => 'New Zealand',
	'NI' => 'Nicaragua',
	'NE' => 'Niger',
	'NG' => 'Nigeria',
	'NU' => 'Niue',
	'NF' => 'Norfolk Island',
	'MP' => 'Northern Mariana Islands',
	'NO' => 'Norway',
	'OM' => 'Oman',
	'PK' => 'Pakistan',
	'PW' => 'Palau',
	'PS' => 'Palestinian Territory, Occupied',
	'PA' => 'Panama',
	'PG' => 'Papua New Guinea',
	'PY' => 'Paraguay',
	'PE' => 'Peru',
	'PH' => 'Philippines',
	'PN' => 'Pitcairn',
	'PL' => 'Poland',
	'PT' => 'Portugal',
	'PR' => 'Puerto Rico',
	'QA' => 'Qatar',
	'RE' => 'Reunion',
	'RO' => 'Romania',
	'RU' => 'Russian Federation',
	'RW' => 'Rwanda',
	'BL' => 'Saint Barthelemy',
	'SH' => 'Saint Helena',
	'KN' => 'Saint Kitts And Nevis',
	'LC' => 'Saint Lucia',
	'MF' => 'Saint Martin',
	'PM' => 'Saint Pierre And Miquelon',
	'VC' => 'Saint Vincent And Grenadines',
	'WS' => 'Samoa',
	'SM' => 'San Marino',
	'ST' => 'Sao Tome And Principe',
	'SA' => 'Saudi Arabia',
	'SN' => 'Senegal',
	'RS' => 'Serbia',
	'SC' => 'Seychelles',
	'SL' => 'Sierra Leone',
	'SG' => 'Singapore',
	'SK' => 'Slovakia',
	'SI' => 'Slovenia',
	'SB' => 'Solomon Islands',
	'SO' => 'Somalia',
	'ZA' => 'South Africa',
	'GS' => 'South Georgia And Sandwich Isl.',
	'ES' => 'Spain',
	'LK' => 'Sri Lanka',
	'SD' => 'Sudan',
	'SR' => 'Suriname',
	'SJ' => 'Svalbard And Jan Mayen',
	'SZ' => 'Swaziland',
	'SE' => 'Sweden',
	'CH' => 'Switzerland',
	'SY' => 'Syrian Arab Republic',
	'TW' => 'Taiwan',
	'TJ' => 'Tajikistan',
	'TZ' => 'Tanzania',
	'TH' => 'Thailand',
	'TL' => 'Timor-Leste',
	'TG' => 'Togo',
	'TK' => 'Tokelau',
	'TO' => 'Tonga',
	'TT' => 'Trinidad And Tobago',
	'TN' => 'Tunisia',
	'TR' => 'Turkey',
	'TM' => 'Turkmenistan',
	'TC' => 'Turks And Caicos Islands',
	'TV' => 'Tuvalu',
	'UG' => 'Uganda',
	'UA' => 'Ukraine',
	'AE' => 'United Arab Emirates',
	'GB' => 'United Kingdom',
	'US' => 'United States',
	'UM' => 'United States Outlying Islands',
	'UY' => 'Uruguay',
	'UZ' => 'Uzbekistan',
	'VU' => 'Vanuatu',
	'VE' => 'Venezuela',
	'VN' => 'Viet Nam',
	'VG' => 'Virgin Islands, British',
	'VI' => 'Virgin Islands, U.S.',
	'WF' => 'Wallis And Futuna',
	'EH' => 'Western Sahara',
	'YE' => 'Yemen',
	'ZM' => 'Zambia',
	'ZW' => 'Zimbabwe',
);

function get_countries($countries){
	$arr = array();
	foreach($countries as $k => $value){
		array_push($arr, $value);
	}
	return $arr;
}
function truncate($text, $chars = 60) {
    $text = $text." ";
    $text = substr($text,0,$chars);
    $text = substr($text,0,strrpos($text,' '));
    $text = $text."..."; // Si no se desea tener tres puntos suspensivos se comenta esta línea.
    return $text;
}

function phone_code($code, $phone){
  if ($phone[0] == "0") {
    return $code.ltrim($phone, $phone[0]);
  }else{
    return $code.$phone;
  }
}

function test_input($input)
{
    $input = trim($input);
    $input = stripslashes($input);
    $input = htmlspecialchars($input);
    return $input;
}

function get_time_difference_php($created_time){
    date_default_timezone_set('Africa/Kampala'); //Change as per your default time
    $str = strtotime($created_time);
    $today = strtotime(date('Y-m-d H:i:s'));

    // It returns the time difference in Seconds...
    $time_differnce = $today-$str;

    // To Calculate the time difference in Years...
    $years = 60*60*24*365;

    // To Calculate the time difference in Months...
    $months = 60*60*24*30;

    // To Calculate the time difference in Days...
    $days = 60*60*24;

    // To Calculate the time difference in Hours...
    $hours = 60*60;

    // To Calculate the time difference in Minutes...
    $minutes = 60;

    if(intval($time_differnce/$years) > 1)
    {
        return intval($time_differnce/$years)." years ago";
    }else if(intval($time_differnce/$years) > 0)
    {
        return intval($time_differnce/$years)." year ago";
    }else if(intval($time_differnce/$months) > 1)
    {
        return intval($time_differnce/$months)." months ago";
    }else if(intval(($time_differnce/$months)) > 0)
    {
        return intval(($time_differnce/$months))." month ago";
    }else if(intval(($time_differnce/$days)) > 1)
    {
        return intval(($time_differnce/$days))." days ago";
    }else if (intval(($time_differnce/$days)) > 0) 
    {
        return intval(($time_differnce/$days))." day ago";
    }else if (intval(($time_differnce/$hours)) > 1) 
    {
        return intval(($time_differnce/$hours))." hours ago";
    }else if (intval(($time_differnce/$hours)) > 0) 
    {
        return intval(($time_differnce/$hours))." hour ago";
    }else if (intval(($time_differnce/$minutes)) > 1) 
    {
        return intval(($time_differnce/$minutes))." minutes ago";
    }else if (intval(($time_differnce/$minutes)) > 0) 
    {
        return intval(($time_differnce/$minutes))." minute ago";
    }else if (intval(($time_differnce)) > 1) 
    {
        return intval(($time_differnce))." seconds ago";
    }else
    {
        return "few seconds ago";
    }
  }


function getIp() {
    $ip = $_SERVER['REMOTE_ADDR'];
 
    if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
        $ip = $_SERVER['HTTP_CLIENT_IP'];
    } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
    }
 
    return $ip;
}

function ip_api($user_ip){
	$curl = curl_init();
	curl_setopt_array($curl, array(
	CURLOPT_URL => 'http://ip-api.com/json/'.$user_ip.'?fields=status%2Cmessage%2Ccontinent%2CcontinentCode%2Ccountry%2CcountryCode%2Cregion%2CregionName%2Ccity%2Cdistrict%2Czip%2Clat%2Clon%2Ctimezone%2Coffset%2Ccurrency%2Cisp%2Corg%2Cas%2Cquery%2Cproxy',
	  CURLOPT_RETURNTRANSFER => true,
	  CURLOPT_ENCODING => '',
	  CURLOPT_MAXREDIRS => 10,
	  CURLOPT_TIMEOUT => 0,
	  CURLOPT_FOLLOWLOCATION => true,
	  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
	  CURLOPT_CUSTOMREQUEST => 'GET',
	));
	$response = curl_exec($curl);
	curl_close($curl);
	return json_decode($response);
}

function agg($mark){

	$D1 = 1; $D2 = 2; $C3 = 3; $C4 = 4; $C5 = 5; $C6 = 6; $P7 = 7;
	$P8 = 8; $F9 = 9;

	if ($mark >79 && $mark <= 100) {
		return $D1;
	}else if ($mark >74 && $mark <= 79) {
		return $D2;
	}elseif ($mark >69 && $mark <= 74) {
		return $C3;
	}elseif ($mark >64 && $mark <= 69) {
		return $C4;
	}elseif ($mark >59 && $mark <= 64) {
		return $C5;
	}elseif ($mark >54 && $mark <= 59) {
		return $C6;
	}elseif ($mark >49 && $mark <= 54) {
		return $P7;
	}elseif ($mark >39 && $mark <= 49) {
		return $P8;
	}else{
		return $F9;
	}
}

function htr_comment($mark){
	if ($mark > 79) {
		echo "Excellent performance, keep it up";
	}elseif ($mark > 70 && $mark <= 79) {
		echo "Very Good performance";
	}elseif ($mark > 60 && $mark <= 69) {
		echo "Good performance";
	}elseif ($mark > 50 && $mark <= 59) {
		echo "Fairly Good result. Double your Effort";
	}elseif ($mark < 51) {
		echo "Concentrate for better result";
	}
}

function send_sms_yoola_api($phone, $message){
	$arr = array(
	"api_key" => "MVci9U5Bm4vRn4GrF7ATEfHOE7pWUA3fBPP6nW897meCkWHF872t0T5L0h28r0H5",
    "phone" => $phone,
    "message" => $message
	);
	
	$curl = curl_init();
	curl_setopt_array($curl, array(
	  CURLOPT_URL => 'https://yoolasms.com/api/v1/send',
	  CURLOPT_RETURNTRANSFER => true,
	  CURLOPT_ENCODING => '',
	  CURLOPT_MAXREDIRS => 10,
	  CURLOPT_TIMEOUT => 0,
	  CURLOPT_FOLLOWLOCATION => true,
	  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
	  CURLOPT_CUSTOMREQUEST => 'POST',
	  CURLOPT_POSTFIELDS => json_encode($arr),
	  CURLOPT_HTTPHEADER => array(
	    'Content-Type: application/json',
	    'Cookie: PHPSESSID=98ee89b975fbb39aafef5960529f53e2'
	  ),
	));

	$response = curl_exec($curl);
	curl_close($curl);
	return $response;
}


// Function to find the difference  
// between two dates. 
function dateDiffInDays($date1, $date2) {  
    // Calculating the difference in timestamps 
    $diff = strtotime($date2) - strtotime($date1); 
    // 1 day = 24 hours 
    // 24 * 60 * 60 = 86400 seconds 
    return abs(round($diff / 86400)); 
} 
// // Start date 
// $date1 = "17-09-2018"; 
// // End date 
// $date2 = "31-09-2018"; 
// // Function call to find date difference 
// $dateDiff = dateDiffInDays($date1, $date2); 
// // Display the result 
// printf("Difference between two dates: "
//      . $dateDiff . " Days "); 




function update_days(){
	global $dbh;
	$res = dbSQL("SELECT * FROM loans ORDER BY loan_id");
	foreach($res as $val){
		$days = $val->loan_installments;
		$bef = date_updated($val->loan_date, $val->loan_installments-3);
		$aft = date_updated($val->loan_date, $val->loan_installments+3);
		$dbh->query("UPDATE loans SET dyzbefore='{$bef}', dyzafter='{$aft}' WHERE loan_id='{$val->loan_id}' ");
	}
return;
}

// update_days();

function get_dates_before(){
	global $today, $api_key;
	$res  = dbSQL("SELECT * FROM loans INNER JOIN clients ON loans.cid=clients.cid WHERE loans.dyzbefore='$today' ");
	if(sizeof($res) > 0){
		foreach($res as $val){
			$phone = $val->cphone;
			$message = "OBUMU KABUMBI SACCO: Hello ".$val->fname." ".$val->lname.", you have 3 days left to complete your loan";
		   echo send_sms_yoola_api($api_key, $phone, $message);
		}
	}
	return true;
}

function get_dates_after(){
	global $today, $api_key;
	$res  = dbSQL("SELECT * FROM loans INNER JOIN clients ON loans.cid=clients.cid WHERE loans.dyzafter='$today' ");
	if(sizeof($res) > 0){
		foreach($res as $val){
			$phone = $val->cphone;
			$message = "OBUMU KABUMBI SACCO: Hello ".$val->fname." ".$val->lname.", your loan exceeded 3 days of repayment";
		   echo send_sms_yoola_api($api_key, $phone, $message);
		}
	}
	return;
}

function make_loan_automatic_renewal() {
    global $dbh, $api_key, $today;
    // Calculate 30 days ago from the current date
    $thirtyDaysAgo = date('Y-m-d', strtotime('-30 days'));
    // Query to fetch records where the loan date is 30 days ago
    $res = $dbh->query("SELECT * FROM loans l INNER JOIN clients c ON c.cid = l.cid WHERE DATE(l.loan_date) = '$thirtyDaysAgo'");
    while ($val = $res->fetch(PDO::FETCH_OBJ)) {
        $fname = $val->fname . ' ' . $val->lname . '<br>';
        $phone = $val->cphone . '<br>';
        echo $fname . ' ' . $phone . '<br>';
        // Calculate the interest
        $interest = ($val->loan_amount * $val->interest_rate) / 100;
        // Fetch all the payment history records for the current client
        $paymentHistory = $dbh->query("SELECT deposit FROM payment_history WHERE cid = '" . $val->cid . "' ");
        $amountPaid = 0;
        while ($row = $paymentHistory->fetch(PDO::FETCH_OBJ)) {
            $amountPaid += $row->deposit;
        }
        // Calculate the remaining balance
        $balance = $val->loan_amount + $interest + 10000 - $amountPaid;
        // Update the loan record
        $dyzbefore = get_next($val->loan_installments - 3);
        $dyzafter = get_next($val->loan_installments + 3);
        $result = $dbh->query("UPDATE loans SET loan_amount = '$balance', dyzbefore = '$dyzbefore', dyzafter = '$dyzafter', loan_date = '$today' WHERE loan_id = '" . $val->loan_id . "' ");
        if ($result) {
            if ($val->cgender == "Male") {
                $phone = $val->cphone;
                $message = "OBUMU KABUMBI SACCO: Hello Mr. " . $val->fname . ", your loan has been renewed for more 30 days at rate of " . $val->interest_rate . "%, Pls come to the Office for confirmation. Hello Ssebo " . $val->fname . ", Loan yo edizibwa bujja okumala enaku endala Asaatu, osabibwa okuuja Ku-Office Yaffe Okumanja ebisingawo";
                echo send_sms_yoola_api($api_key, $phone, $message);
            } else {
                $phone = $val->cphone;
                $message = "OBUMU KABUMBI SACCO: Hello Mrs/Ms. " . $val->fname . ", your loan has been renewed for more 30 days at rate of " . $val->interest_rate . "%, Pls come to the Office for confirmation. Hello Nyabo " . $val->fname . ", Loan yo edizibwa bujja okumala enaku endala Asaatu, osabibwa okuuja Ku-Office Yaffe Okumanja ebisingawo";
                echo send_sms_yoola_api($api_key, $phone, $message);
            }
        }
    }
    return;
}

function getNextAccountNumber($dbh) {
    $nextNumber = 1; // Start at 1
    while (true) {
        // Format the account number
        $accountNumber = sprintf("K%03d", $nextNumber);
        
        // Check if the account number already exists
        $query = $dbh->prepare("SELECT COUNT(*) FROM customer_accounts WHERE account_number = ?");
        $query->execute([$accountNumber]);
        $count = $query->fetchColumn();
        
        // If it doesn't exist, return this account number
        if ($count == 0) {
            return $accountNumber;
        }
        
        // Increment the number for the next iteration
        $nextNumber++;
    }
}

function getNextAccountNumberWithoutUnderscore($dbh) {
    $nextNumber = 1; // Start at 1
    while (true) {
        // Format the account number without underscore
        $accountNumber = sprintf("K%03d", $nextNumber);
        
        // Check if the account number already exists
        $query = $dbh->prepare("SELECT COUNT(*) FROM customer_accounts WHERE account_number = ?");
        $query->execute([$accountNumber]);
        $count = $query->fetchColumn();
        
        // If it doesn't exist, return this account number
        if ($count == 0) {
            return $accountNumber;
        }
        
        // Increment the number for the next iteration
        $nextNumber++;
    }
}

?>