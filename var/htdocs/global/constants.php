<?php
    error_reporting(E_ALL);
    define('APNSCP_INSTALL_PATH', '/var/www/html/apnscptmp/');
    define('WEB_SERVER_NAME',     'www.testsite.com');
    define('FTP_SERVER_NAME',     'ftp.testsite.com');
    define('MAIL_SERVER_NAME',    'mail.testsite.com');
    define('DOMAIN_NAME',         'testsite.com');
    define('USERNAME',            'foobar');
    define('IP_ADDRESS',          '127.0.0.1');
    define('USER_COUNT',          10);
    define('USER_MAX',            500);
    define('BANDWIDTH_USED',      8000);
    define('BANDWIDTH_FREE',      5000);
    define('DISK_USED',           1024);
    define('DISK_FREE',           2048);
    define('LOCALE',              'en_US');
    define('APNSCP_VERSION',      'apnscp v 1.5');
    define('PAGE_SHORTCUTS',      0x0001);
    define('PAGE_TOPBAR',         0x0002);
    define('PAGE_NAVIGATION',     0x0004);
    define('PAGE_MODULE',         0x0008);
    define('USER_ADMIN',          0x0016);
    define('USER_RESELLER',       0x0032);
    define('USER_SITE',           0x0064);
    define('USER_USER',           0x0128);
    
    /* options */
    define('PREFER_SSL',          true);
    define('APNSCP_PORT',         50015);
    /*
    *  Graphing class constants
    *  0x100N = graph types
    */
    define('GRAPH_CONTINUOUS',    0xA000);
    define('GRAPH_DISCRETE',      0xA001);
    define('GRAPH_PIE',           0xA002);
    define('GRAPH_PIE_3D',        0xA003);

    /*
    *  formatting constants
    *  part of graph class
    *  0x101N = graph options
    */
    define('OPTION_ANTIALIASED',  0x1001);
    define('OPTION_OUTLINE',      0x1002);
?>