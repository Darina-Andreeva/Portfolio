<?php

/*
 * Name: nbbAgentDetect
 * URI: http://berry.ninja/
 * Description: detect browser
 * Version: 2.0 
 * Author: Ninja Berries
 * Author URI: http://berry.ninja/
 */

class nbbAgentDetect {

    const VAR_USER_AGENT = 'HTTP_USER_AGENT';
    const DEVICE_DESKTOP = 'desktop';
    const DEVICE_TABLET = 'tablet';
    const DEVICE_PHONE = 'phone';
    const DEVICE_SEARCH_MOBILE = 'mobile';
    const DEVICE_SEARCH_ANDROID = 'android';
    const DEVICE_SEARCH_PHONE = 'phone';
    const DEVICE_SEARCH_IPAD = 'ipad';
    const BROWSER_CHROME = 'chrome';
    const BROWSER_FIREFOX = 'firefox';
    const BROWSER_IE = 'msie';
    const BROWSER_IE_NEW = 'trident';
    const BROWSER_IE_NAME = 'internet explorer';
    const BROWSER_SAFARI = 'safari';
    const BROWSER_OPERA = 'opr';
    const BROWSER_OPERA_NAME = 'opera';
    const UNKNOWN = 'unknown';
    const OS_ANDROID = 'android';
    const OS_IOS_IPHONE = 'iPhone';
    const OS_IOS_IPAD = 'iPad';
    const OS_IOS = 'ios';
    const OS_LINUX = 'linux';
    const OS_MAC = 'macintosh';
    const OS_WIN = 'windows';

    public $agent;
    public $device;
    public $browser;
    public $os;

    /* get user agent, set device, set browser & set os */

    public function __construct() {
        $this->agent = $_SERVER[self::VAR_USER_AGENT];
        $this->setDevice();
        $this->setBrowser();
        $this->setOs();
    }

    /* search in user agent */

    public function searchAgent($for) {
        return strstr(strtolower($this->agent), $for);
    }

    /* match class variable with value */

    public function isParam($name, $field, $fieldSecond = false) {
        if ($fieldSecond)
            return strtolower($name) == $this->{$field}[$fieldSecond];
        else
            return strtolower($name) == $this->{$field};
    }

    /* set device name */

    public function setDevice() {
        if ($this->searchIpad() || $this->searchAndroidTablet())
            $this->device = self::DEVICE_TABLET;
        if ($this->searchIphone() || $this->searchAndroid() || $this->searchWindowsPhone())
            $this->device = self::DEVICE_PHONE;
        else
            $this->device = self::DEVICE_DESKTOP;
    }

    /* check is iphone */

    public function searchIphone() {
        return $this->searchAgent(self::DEVICE_SEARCH_MOBILE);
    }

    /* check is ipad */

    public function searchIpad() {
        return $this->searchAgent(self::DEVICE_SEARCH_IPAD);
    }

    /* check is android */

    public function searchAndroid() {
        return $this->searchAgent(self::DEVICE_SEARCH_ANDROID);
    }

    /* check is android tablet */

    public function searchAndroidTablet() {
        return $this->searchAgent(self::DEVICE_SEARCH_ANDROID) && !$this->searchAgent(self::DEVICE_SEARCH_MOBILE);
    }

    /* check is windows phone */

    public function searchWindowsPhone() {
        return $this->searchAgent(self::DEVICE_SEARCH_PHONE);
    }

    /* check by device name */

    public function isDevice($name) {
        return $this->isParam($name, 'device');
    }

    /* set browser['name'] & browser['version'] */

    public function setBrowser() {
        $this->setBrowserName();
        $this->setBrowserVersion();
    }

    /* set browser name */

    public function setBrowserName() {
        if ($this->searchChrome())
            $this->browser['name'] = self::BROWSER_CHROME;
        elseif ($this->searchFirefox())
            $this->browser['name'] = self::BROWSER_FIREFOX;
        elseif ($this->searchIE())
            $this->browser['name'] = self::BROWSER_IE_NAME;
        elseif ($this->searchSafari())
            $this->browser['name'] = self::BROWSER_SAFARI;
        elseif ($this->searchOpera())
            $this->browser['name'] = self::BROWSER_OPERA_NAME;
        else
            $this->browser['name'] = self::UNKNOWN;
    }

    /* check is chrome */

    public function searchChrome() {
        return $this->searchAgent(self::BROWSER_CHROME . DIRECTORY_SEPARATOR) &&
                $this->searchAgent(self::BROWSER_SAFARI . DIRECTORY_SEPARATOR) &&
                !$this->searchAgent(self::BROWSER_OPERA . DIRECTORY_SEPARATOR);
    }

    /* check is firefox */

    public function searchFirefox() {
        return $this->searchAgent(self::BROWSER_FIREFOX . DIRECTORY_SEPARATOR);
    }

    /* check is internet explorer */

    public function searchIE() {
        return $this->searchAgent(self::BROWSER_IE) || $this->searchAgent(self::BROWSER_IE_NEW);
    }

    /* check is internet explorer < 10 */

    public function searchIEold() {
        return $this->searchAgent(self::BROWSER_IE);
    }

    /* check is internet explorer > 9 */

    public function searchIEnew() {
        return $this->searchAgent(self::BROWSER_IE_NEW);
    }

    /* check is safari */

    public function searchSafari() {
        return $this->searchAgent(self::BROWSER_SAFARI . DIRECTORY_SEPARATOR) &&
                !$this->searchAgent(self::BROWSER_OPERA . DIRECTORY_SEPARATOR) &&
                !$this->searchAgent(self::BROWSER_CHROME . DIRECTORY_SEPARATOR);
    }

    /* check is opera */

    public function searchOpera() {
        return $this->searchAgent(self::BROWSER_OPERA . DIRECTORY_SEPARATOR) &&
                $this->searchAgent(self::BROWSER_SAFARI . DIRECTORY_SEPARATOR);
    }

    /* check by browser name */

    public function isBrowser($name) {
        return $this->isParam($name, 'browser', 'name');
    }

    /* set browser version */

    public function setBrowserVersion() {
        $this->browser['version'] = $this->browserVersion();
    }

    /* useer browser name for version search */

    public function userBrowserName() {
        $ub = ucfirst($this->browser['name']);

        if ($this->searchOpera())
            $ub = strtoupper(self::BROWSER_OPERA);
        elseif ($this->searchIEold()) {
            $ub = strtoupper(self::BROWSER_IE);
        } elseif ($this->searchIEnew()) {
            $ub = ucfirst(self::BROWSER_IE_NEW);
        }
        return $ub;
    }

    /* get browser version */

    public function browserVersion() {

        $known = array('Version', $this->userBrowserName(), 'other');
        $pattern = '#(?<browser>' . join('|', $known) .
                ')[/ ]+(?<version>[0-9.|a-zA-Z.]*)#';
        if (!preg_match_all($pattern, $this->agent, $matches)) {
            return self::UNKNOWN;
        }
        $i = count($matches['browser']);
        if ($i != 1) {
            if (strripos($this->agent, "Version") < strripos($this->agent, $this->userBrowserName)) {
                $version = $matches['version'][0];
            } else {
                $version = $matches['version'][1];
            }
        } else {
            $version = $matches['version'][0];
        }
        if ($version == null || $version == "") {
            $version = "?";
        }
        return $version;
    }

    /* check is mac */

    public function searchMac() {
        return $this->searchAgent(self::OS_MAC);
    }

    /* check is linux */

    public function searchLinux() {
        return $this->searchAgent(self::OS_LINUX);
    }

    /* check is windows */

    public function searchWin() {
        return $this->searchAgent(self::OS_WIN);
    }

    /* set os name */

    public function setOs() {
        if ($this->searchAndroid() || $this->searchAndroidTablet())
            $this->os = self::OS_ANDROID;
        elseif ($this->searchIpad() || $this->searchIphone())
            $this->os = self::OS_IOS;
        elseif ($this->searchLinux())
            $this->os = self::OS_LINUX;
        elseif ($this->searchMac())
            $this->os = self::OS_MAC;
        elseif ($this->searchWin() || $this->searchWindowsPhone())
            $this->os = self::OS_WIN;
    }

    /* check by os name */

    public function isOs($name) {
        return $this->isParam($name, 'os');
    }

    /* full checking info */

    public function info() {
        return '
            user agent:<br> ' . $this->agent . '<br><br>
            browser[name]: ' . $this->browser['name'] . '<br>
            browser[version]: ' . $this->browser['version'] . '<br><br>
            isBrowser[chrome]: ' . (int) $this->isBrowser(self::BROWSER_CHROME) . '<br>
            isBrowser[firefox]: ' . (int) $this->isBrowser(self::BROWSER_FIREFOX) . '<br>
            isBrowser[safari]: ' . (int) $this->isBrowser(self::BROWSER_SAFARI) . '<br>
            isBrowser[opera]: ' . (int) $this->isBrowser(self::BROWSER_OPERA) . '<br>
            isBrowser[internet explorer]: ' . (int) $this->searchIE() . '<br><br>
            device: ' . $this->device . '<br>
            device[desktop]: ' . (int) $this->isDevice(self::DEVICE_DESKTOP) . '<br>
            device[phone]: ' . (int) $this->isDevice(self::DEVICE_PHONE) . '<br>
            device[tablet]: ' . (int) $this->isDevice(self::DEVICE_TABLET) . '<br><br>
            os: ' . $this->os . '<br><br>
            isOs[android]: ' . (int) $this->isOs(self::OS_ANDROID) . '<br>
            isOs[android tablet]: ' . (int) $this->searchAndroidTablet() . '<br>
            isOs[ipad]: ' . (int) $this->searchIpad() . '<br>
            isOs[iphone]: ' . (int) $this->searchIphone() . '<br>
            isOs[linux]: ' . (int) $this->isOs(self::OS_LINUX) . '<br>
            isOs[mac]: ' . (int) $this->isOs(self::OS_MAC) . '<br>
            isOs[windows]: ' . (int) $this->isOs(self::OS_WIN);
    }

}
