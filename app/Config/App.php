<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;

class App extends BaseConfig
{
    /**
     * Base Site URL
     *
     * @var string
     */
    public $baseURL = 'http://localhost/';

    /**
     * Index File
     *
     * Typically this will be your index.php file, unless you've renamed it to
     * something else. If you are using mod_rewrite to remove the page set this
     * variable so that it is blank.
     *
     * @var string
     */
    public $indexPage = '';

    /**
     * URI PROTOCOL
     *
     * This item determines which server global should be used to retrieve the
     * URI string. The default setting of 'REQUEST_URI' works for most servers.
     * If your links do not seem to work, try one of the other delicious flavors:
     * 'QUERY_STRING', 'PATH_INFO', or 'ORIG_PATH_INFO'.
     *
     * @var string
     */
    public $uriProtocol = 'REQUEST_URI';

    /**
     * Default Locale
     *
     * @var string
     */
    public $defaultLocale = 'en';

    /**
     * Supported Locales
     *
     * @var string[]
     */
    public $supportedLocales = ['en'];

    /**
     * Locale Negotiation
     *
     * @var bool
     */
    public $negotiateLocale = false;

    /**
     * Application Timezone
     *
     * @var string
     */
    public $appTimezone = 'UTC';

    /**
     * Default Character Set
     *
     * @var string
     */
    public $charset = 'UTF-8';

    /**
     * Force Global Secure Requests
     *
     * If true, this will force every request made to this application to be
     * made via a secure connection (HTTPS). If the incoming request is not
     * secure, the user will be redirected to a secure version of the page
     * and the HTTP Strict Transport Security header will be set.
     *
     * @var bool
     */
    public $forceGlobalSecureRequests = false;

    /**
     * Reverse Proxy IPs
     *
     * If your server is behind a reverse proxy, you must whitelist the proxy
     * IP addresses from which CodeIgniter should trust the HTTP_X_FORWARDED_*
     * headers in order to properly detect the visitor's IP address. This
     * property can be set as a single IP address or an array of addresses.
     *
     * @var array|string|null
     */
    public $proxyIPs = '';

    /**
     * Content Security Policy
     *
     * @var bool
     */
    public $CSPEnabled = false;

    /**
     * Cookie settings
     *
     * @var string
     */
    public $cookiePrefix = '';

    /**
     * @var string
     */
    public $cookieDomain = '';

    /**
     * @var string
     */
    public $cookiePath = '/';

    /**
     * @var bool
     */
    public $cookieSecure = false;

    /**
     * @var bool
     */
    public $cookieHTTPOnly = false;

    /**
     * @var string
     */
    public $cookieSameSite = 'Lax';
}
