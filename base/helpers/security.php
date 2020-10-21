<?php
// Clean GET query
function input_get($key, $default = false)
{
    $request = Yii::$app->request;

    if (isset($_GET[$key])) {
        $query = $request->get($key);

        if (is_array($query) && $query) {
            $output = clean_array($query);
        } else {
            $output = clean_str($query);
        }

        return $output;
    }

    return $default;
}

// Clean POST query
function input_post($key, $default = false)
{
    $request = Yii::$app->request;

    if (isset($_POST[$key])) {
        $post = $request->post($key);

        if (is_array($post) && $post) {
            $output = clean_array($post);
        } else {
            $output = clean_str($post);
        }

        return $output;
    }

    return $default;
}

// CSRF input
function csrf_input($as_string = false)
{
    $request = Yii::$app->request;

    $input = '<input type="hidden" name="' . $request->csrfParam . '" value="' . $request->getCsrfToken() . '" />';

    if ($as_string) {
        return $input;
    }

    echo $input;
}

// Clean array
function clean_array($array = array())
{
    $output = array();

    if (is_array($array) && $array) {
        foreach ($array as $key => $value) {
            $clear_key = clean_str($key);

            if (is_array($value) && $value) {
                $clear_value = clean_array($value);
            } else {
                $clear_value = clean_str($value);
            }

            $output[$clear_key] = $clear_value;
        }
    }

    return $output;
}

// Strip string
function clean_str($string)
{
    $output = false;

    if ($string) {
        $output = \yii\helpers\Html::encode(strip_tags($string));
    }

    return $output;
}

// Get OS
function getOS($user_agent = null)
{
    if (!isset($user_agent) && isset($_SERVER['HTTP_USER_AGENT'])) {
        $user_agent = $_SERVER['HTTP_USER_AGENT'];
    }

    $os_array = [
        'windows nt 10' => 'Windows 10',
        'windows nt 6.3' => 'Windows 8.1',
        'windows nt 6.2' => 'Windows 8',
        'windows nt 6.1|windows nt 7.0' => 'Windows 7',
        'windows nt 6.0' => 'Windows Vista',
        'windows nt 5.2' => 'Windows Server 2003/XP x64',
        'windows nt 5.1' => 'Windows XP',
        'windows xp' => 'Windows XP',
        'windows nt 5.0|windows nt5.1|windows 2000' => 'Windows 2000',
        'windows me' => 'Windows ME',
        'windows nt 4.0|winnt4.0' => 'Windows NT',
        'windows ce' => 'Windows CE',
        'windows 98|win98' => 'Windows 98',
        'windows 95|win95' => 'Windows 95',
        'win16' => 'Windows 3.11',
        'mac os x 10.1[^0-9]' => 'Mac OS X Puma',
        'macintosh|mac os x' => 'Mac OS X',
        'mac_powerpc' => 'Mac OS 9',
        'linux' => 'Linux',
        'ubuntu' => 'Linux - Ubuntu',
        'iphone' => 'iPhone',
        'ipod' => 'iPod',
        'ipad' => 'iPad',
        'android' => 'Android',
        'blackberry' => 'BlackBerry',
        'webos' => 'Mobile',
        '(media center pc).([0-9]{1,2}\.[0-9]{1,2})' => 'Windows Media Center',
        '(win)([0-9]{1,2}\.[0-9x]{1,2})' => 'Windows',
        '(win)([0-9]{2})' => 'Windows',
        '(windows)([0-9x]{2})' => 'Windows',
        'Win 9x 4.90' => 'Windows ME',
        '(windows)([0-9]{1,2}\.[0-9]{1,2})' => 'Windows',
        'win32' => 'Windows',
        '(java)([0-9]{1,2}\.[0-9]{1,2}\.[0-9]{1,2})' => 'Java',
        '(Solaris)([0-9]{1,2}\.[0-9x]{1,2}){0,1}' => 'Solaris',
        'dos x86' => 'DOS',
        'Mac OS X' => 'Mac OS X',
        'Mac_PowerPC' => 'Macintosh PowerPC',
        '(mac|Macintosh)' => 'Mac OS',
        '(sunos)([0-9]{1,2}\.[0-9]{1,2}){0,1}' => 'SunOS',
        '(beos)([0-9]{1,2}\.[0-9]{1,2}){0,1}' => 'BeOS',
        '(risc os)([0-9]{1,2}\.[0-9]{1,2})' => 'RISC OS',
        'unix' => 'Unix',
        'os/2' => 'OS/2',
        'freebsd' => 'FreeBSD',
        'openbsd' => 'OpenBSD',
        'netbsd' => 'NetBSD',
        'irix' => 'IRIX',
        'plan9' => 'Plan9',
        'osf' => 'OSF',
        'aix' => 'AIX',
        'GNU Hurd' => 'GNU Hurd',
        '(fedora)' => 'Linux - Fedora',
        '(kubuntu)' => 'Linux - Kubuntu',
        '(ubuntu)' => 'Linux - Ubuntu',
        '(debian)' => 'Linux - Debian',
        '(CentOS)' => 'Linux - CentOS',
        '(Mandriva).([0-9]{1,3}(\.[0-9]{1,3})?(\.[0-9]{1,3})?)' => 'Linux - Mandriva',
        '(SUSE).([0-9]{1,3}(\.[0-9]{1,3})?(\.[0-9]{1,3})?)' => 'Linux - SUSE',
        '(Dropline)' => 'Linux - Slackware (Dropline GNOME)',
        '(ASPLinux)' => 'Linux - ASPLinux',
        '(Red Hat)' => 'Linux - Red Hat',
        'X11' => 'Unix',
        '(linux)' => 'Linux',
        '(amigaos)([0-9]{1,2}\.[0-9]{1,2})' => 'AmigaOS',
        'amiga-aweb' => 'AmigaOS',
        'amiga' => 'Amiga',
        'AvantGo' => 'PalmOS',
        '[0-9]{1,2}\.[0-9]{1,2}\.[0-9]{1,3})' => 'Linux',
        '(webtv)/([0-9]{1,2}\.[0-9]{1,2})' => 'WebTV',
        'Dreamcast' => 'Dreamcast OS',
        'GetRight' => 'Windows',
        'go!zilla' => 'Windows',
        'gozilla' => 'Windows',
        'gulliver' => 'Windows',
        'ia archiver' => 'Windows',
        'NetPositive' => 'Windows',
        'mass downloader' => 'Windows',
        'microsoft' => 'Windows',
        'offline explorer' => 'Windows',
        'teleport' => 'Windows',
        'web downloader' => 'Windows',
        'webcapture' => 'Windows',
        'webcollage' => 'Windows',
        'webcopier' => 'Windows',
        'webstripper' => 'Windows',
        'webzip' => 'Windows',
        'wget' => 'Windows',
        'Java' => 'Unknown',
        'flashget' => 'Windows',
        'MS FrontPage' => 'Windows',
        '(msproxy)/([0-9]{1,2}.[0-9]{1,2})' => 'Windows',
        '(msie)([0-9]{1,2}.[0-9]{1,2})' => 'Windows',
        'libwww-perl' => 'Unix',
        'UP.Browser' => 'Windows CE',
        'NetAnts' => 'Windows',
    ];

    $arch_regex = '/\b(x86_64|x86-64|Win64|WOW64|x64|ia64|amd64|ppc64|sparc64|IRIX64)\b/ix';
    $arch = preg_match($arch_regex, $user_agent) ? '64' : '32';

    foreach ($os_array as $regex => $value) {
        if (preg_match('{\b(' . $regex . ')\b}i', $user_agent)) {
            return $value . ' x' . $arch;
        }
    }

    return 'Unknown';
}

// Get browser
function getBrowser()
{
    $user_agent = $_SERVER['HTTP_USER_AGENT'];
    $browser_name = 'Unknown Browser';
    $platform = 'Unknown OS';
    $version = "";

    // First get the platform
    $os_array = array(
        '/windows nt 10/i' => 'Windows 10',
        '/windows nt 6.3/i' => 'Windows 8.1',
        '/windows nt 6.2/i' => 'Windows 8',
        '/windows nt 6.1/i' => 'Windows 7',
        '/windows nt 6.0/i' => 'Windows Vista',
        '/windows nt 5.2/i' => 'Windows Server 2003/XP x64',
        '/windows nt 5.1/i' => 'Windows XP',
        '/windows xp/i' => 'Windows XP',
        '/windows nt 5.0/i' => 'Windows 2000',
        '/windows me/i' => 'Windows ME',
        '/win98/i' => 'Windows 98',
        '/win95/i' => 'Windows 95',
        '/win16/i' => 'Windows 3.11',
        '/macintosh|mac os x/i' => 'Mac OS X',
        '/mac_powerpc/i' => 'Mac OS 9',
        '/linux/i' => 'Linux',
        '/ubuntu/i' => 'Ubuntu',
        '/iphone/i' => 'iPhone',
        '/ipod/i' => 'iPod',
        '/ipad/i' => 'iPad',
        '/android/i' => 'Android',
        '/blackberry/i' => 'BlackBerry',
        '/webos/i' => 'Mobile',
    );

    foreach ($os_array as $regex => $value) {
        if (preg_match($regex, $user_agent)) {
            $platform = $value;
        }
    }

    // Next get the name of the useragent yes seperately and for good reason
    if (preg_match('/MSIE/i', $user_agent) && !preg_match('/Opera/i', $user_agent)) {
        $browser_name = 'Internet Explorer';
        $ub = "MSIE";
    } elseif (preg_match('/Firefox/i', $user_agent)) {
        $browser_name = 'Mozilla Firefox';
        $ub = "Firefox";
    } elseif (preg_match('/OPR/i', $user_agent)) {
        $browser_name = 'Opera';
        $ub = "Opera";
    } elseif (preg_match('/Chrome/i', $user_agent) && !preg_match('/Edge/i', $user_agent)) {
        $browser_name = 'Google Chrome';
        $ub = "Chrome";
    } elseif (preg_match('/Safari/i', $user_agent) && !preg_match('/Edge/i', $user_agent)) {
        $browser_name = 'Apple Safari';
        $ub = "Safari";
    } elseif (preg_match('/Netscape/i', $user_agent)) {
        $browser_name = 'Netscape';
        $ub = "Netscape";
    } elseif (preg_match('/Edge/i', $user_agent)) {
        $browser_name = 'Edge';
        $ub = "Edge";
    } elseif (preg_match('/Trident/i', $user_agent)) {
        $browser_name = 'Internet Explorer';
        $ub = "MSIE";
    }

    // Finally get the correct browser version number
    $known = array('Version', $ub, 'other');
    $pattern = '#(?<browser>' . join('|', $known) . ')[/ ]+(?<version>[0-9.|a-zA-Z.]*)#';
    preg_match_all($pattern, $user_agent, $matches);

    // see how many we have
    $i = count($matches['browser']);
    if ($i != 1) {
        if (strripos($user_agent, "Version") < strripos($user_agent, $ub)) {
            $version = $matches['version'][0];
        } else {
            $version = $matches['version'][1];
        }
    } else {
        $version = $matches['version'][0];
    }

    // check if we have a number
    if ($version == null || $version == "") {
        $version = "?";
    }

    return array(
        'user_agent' => $user_agent,
        'browser_name' => $browser_name,
        'browser_version' => $version,
        'platform' => $platform,
        'session' => "{$browser_name} {$version} / {$platform}",
    );
}
