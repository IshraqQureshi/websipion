<?php

use App\Models\EmailTemplate;
use App\Models\Logo;
use Illuminate\Support\Facades\Schema;
use App\Models\Websites;

use function Clue\StreamFilter\fun;

if (!function_exists('theme')) {
    function theme()
    {
        return app(App\Core\Theme::class);
    }
}

if (!function_exists('addHtmlAttribute')) {
    /**
     * Add HTML attributes by scope
     *
     * @param $scope
     * @param $name
     * @param $value
     *
     * @return void
     */
    function addHtmlAttribute($scope, $name, $value)
    {
        theme()->addHtmlAttribute($scope, $name, $value);
    }
}


if (!function_exists('addHtmlAttributes')) {
    /**
     * Add multiple HTML attributes by scope
     *
     * @param $scope
     * @param $attributes
     *
     * @return void
     */
    function addHtmlAttributes($scope, $attributes)
    {
        theme()->addHtmlAttributes($scope, $attributes);
    }
}


if (!function_exists('addHtmlClass')) {
    /**
     * Add HTML class by scope
     *
     * @param $scope
     * @param $value
     *
     * @return void
     */
    function addHtmlClass($scope, $value)
    {
        theme()->addHtmlClass($scope, $value);
    }
}


if (!function_exists('printHtmlAttributes')) {
    /**
     * Print HTML attributes for the HTML template
     *
     * @param $scope
     *
     * @return string
     */
    function printHtmlAttributes($scope)
    {
        return theme()->printHtmlAttributes($scope);
    }
}


if (!function_exists('printHtmlClasses')) {
    /**
     * Print HTML classes for the HTML template
     *
     * @param $scope
     * @param $full
     *
     * @return string
     */
    function printHtmlClasses($scope, $full = true)
    {
        return theme()->printHtmlClasses($scope, $full);
    }
}

if (!function_exists('getGlobalAssets')) {
    /**
     * Get the global assets
     *
     * @param $type
     *
     * @return array
     */
    function getGlobalAssets($type = 'js')
    {
        return theme()->getGlobalAssets($type);
    }
}


if (!function_exists('addVendors')) {
    /**
     * Add multiple vendors to the page by name. Refer to settings THEME_VENDORS
     *
     * @param $vendors
     *
     * @return void
     */
    function addVendors($vendors)
    {
        theme()->addVendors($vendors);
    }
}


if (!function_exists('addVendor')) {
    /**
     * Add single vendor to the page by name. Refer to settings THEME_VENDORS
     *
     * @param $vendor
     *
     * @return void
     */
    function addVendor($vendor)
    {
        theme()->addVendor($vendor);
    }
}


if (!function_exists('addJavascriptFile')) {
    /**
     * Add custom javascript file to the page
     *
     * @param $file
     *
     * @return void
     */
    function addJavascriptFile($file)
    {
        theme()->addJavascriptFile($file);
    }
}


if (!function_exists('addCssFile')) {
    /**
     * Add custom CSS file to the page
     *
     * @param $file
     *
     * @return void
     */
    function addCssFile($file)
    {
        theme()->addCssFile($file);
    }
}


if (!function_exists('getVendors')) {
    /**
     * Get vendor files from settings. Refer to settings THEME_VENDORS
     *
     * @param $type
     *
     * @return array
     */
    function getVendors($type)
    {
        return theme()->getVendors($type);
    }
}


if (!function_exists('getCustomJs')) {
    /**
     * Get custom js files from the settings
     *
     * @return array
     */
    function getCustomJs()
    {
        return theme()->getCustomJs();
    }
}


if (!function_exists('getCustomCss')) {
    /**
     * Get custom css files from the settings
     *
     * @return array
     */
    function getCustomCss()
    {
        return theme()->getCustomCss();
    }
}


if (!function_exists('getHtmlAttribute')) {
    /**
     * Get HTML attribute based on the scope
     *
     * @param $scope
     * @param $attribute
     *
     * @return array
     */
    function getHtmlAttribute($scope, $attribute)
    {
        return theme()->getHtmlAttribute($scope, $attribute);
    }
}

if (!function_exists('isUrl')) {
    /**
     * Get HTML attribute based on the scope
     *
     * @param $url
     *
     * @return mixed
     */
    function isUrl($url)
    {
        return filter_var($url, FILTER_VALIDATE_URL);
    }
}

if (!function_exists('image')) {
    /**
     * Get image url by path
     *
     * @param $path
     *
     * @return string
     */
    function image($path)
    {
        return asset('assets/' . $path);
    }
}



if (!function_exists('LogoGet')) {
    function LogoGet()
    {
        if (Schema::hasTable('logo')) {
            $data = Logo::latest()->first();
            if (!empty($data->logo) && !empty($data->favicon)) {
                return  [
                    'logo' => asset('upload/logo/' . $data->logo),
                    'favicon' => asset('upload/logo/' . $data->favicon),
                    'dark_logo' => asset('upload/logo/' . $data->dark_logo)
                ];
            } else {
                return  [
                    'logo' => asset('logo.png'),
                    'dark_logo' => asset('logo.png'),
                    'favicon' => asset('favicon.png')
                ];
            }
        } else {
            return  [
                'logo' => asset('logo.png'),
                'dark_logo' => asset('logo.png'),
                'favicon' => asset('favicon.png')
            ];
        }
    }
}

function Domainfilter($domainName)
{
    $domainArr = explode('/', str_replace('www.', '', $domainName));
    return $domainArr[0] . '//' . $domainArr[2];
}

function withouthttpsDomain($domainName)
{
    return str_replace("http://", "", str_replace("https://", "", $domainName));
}

function encode($id, $key = "")
{
    $len = 10;
    $md5_key = (!empty($key) ? md5($key) : md5('!7l@S*3h7_s54P-e543lp'));
    $len_jobid = 16;
    $sub_md5key1 = substr($md5_key, 0, $len);
    $sub_md5key2 = substr($md5_key, $len);
    return $sub_md5key1 . $id . $sub_md5key2;
}

function decode($encodeid, $vauletype = 'integer')
{
    $strRet = "";
    $len = 10;
    $sub_md5key1 = substr($encodeid, 0, $len);
    $sub_md5key2 = substr($encodeid, -1 * (32 - $len));
    $strRet = str_replace(array($sub_md5key1, $sub_md5key2), '', $encodeid);
    if ($vauletype == 'integer')
        $strRet = (int) $strRet;
    else
        $strRet = $strRet;

    return $strRet;
}

function frequency()
{
    return [
        'everyMinute' => 'Every Minutes',
        'everyTwoMinutes' => 'Every Two Minutes',
        'everyFiveMinutes' => 'Every Five Minutes',
        'hourly' => 'Hourly',
        'daily' => 'Daily',
    ];
}



function findFrequency($key)
{
    if (array_key_exists($key, frequency())) {
        return frequency()[$key];
    }
}


function DateTimeChange($dateTime)
{
    return date('d-m-Y : h:i:s A',  strtotime($dateTime));
}

function pre($ar)
{
    echo "<pre>";
    print_r($ar);
}

function pageTitle()
{
    return explode('/', $_SERVER['REQUEST_URI']);
}


// if (!function_exists('checkSiteStatus')) {
//     function checkSiteStatus($host)
//     {
//         $headers = @get_headers($host);
//         // echo "<pre>";
//         // print_r($headers);
//         $status = true;
//         if (($headers && strpos($headers[0], '200')) ||  ($headers && strpos($headers[0], '301')) || ($headers && strpos($headers[0], '302'))) {
//             $status = true;
//         } else {
//             $status = false;
//         }
//         return $status;
//     }
// }

if (!function_exists('checkSiteStatus')) {
    function checkSiteStatus($host)
    {
        $headers = @get_headers($host);
        // echo "<pre>";
        // print_r($headers);
        /*$status = true;
        if (($headers && strpos($headers[0], '200')) ||  ($headers && strpos($headers[0], '301')) || ($headers && strpos($headers[0], '302'))) {
            $status = true;
        } else {
            $status = false;
        }
        return $status;*/

        if ($headers === false) {
        	return false;
	}
	$statusLine = $headers[0];
	if (strpos($statusLine, '200') !== false ||
	    strpos($statusLine, '301') !== false ||
	    strpos($statusLine, '302') !== false){
	    return true;
	}
	else if(strpos($statusLine, '500') == true){
	    return false;
	} else if(strpos($statusLine, '504') == true){
        return false;
    }
	else {
	    return false;
	}
    }
}




function emailTemplate()
{
    return EmailTemplate::latest()->first();
}

if(!function_exists('checkUpAndDownCount')) {
    function checkUpAndDownCount($websiteID)
    {
        $website = Websites::find($websiteID);
        return $website;
    }
}
if(!function_exists('updateSiteDownCount')) {
    function updateSiteDownCount($websiteID)
    {
        $website = Websites::find($websiteID);
	$website->sitedown = '1';
	$website->save();
        return $website;
    }
}
if(!function_exists('updateSiteUpCount')) {
    function updateSiteUpCount($websiteID)
    {
        $website = Websites::find($websiteID);
	$website->siteup = '1';
	$website->save();
        return $website;
    }
}
