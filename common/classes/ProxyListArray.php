<?php


namespace common\classes;


class ProxyListArray
{
    public static $proxyList = [
        'socks4://196.22.222.177:51692',
        'socks4://202.159.121.225:443',
        'socks4://103.200.135.229:4145',
        'socks4://181.57.98.228:4145',
        'socks4://85.252.123.110:42767',
        'socks4://192.166.128.1:4145',
        'socks4://103.138.5.69:4145',
        'socks4://103.86.195.190:4145',
        'socks4://114.69.243.65:4145',
        'socks4://168.181.128.134:4145',
    ];

    public static function getRandom()
    {
        return static::$proxyList[rand(0,count(static::$proxyList)-1)];
    }
}