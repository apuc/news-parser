<?php

namespace common\classes;

use DateTime;
use Yii;

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

    public static function dateTime($delay = 0)
    {
        $date = new DateTime();
        date_add($date, date_interval_create_from_date_string($delay . ' minutes'));

        return $date->getTimestamp();
    }

    public static function proxy($i)
    {
        $current_time = self::dateTime();
        $available_time = file_get_contents(Yii::getAlias('@frontend/web/') . 'time.txt');

        if($current_time > $available_time) {
            file_put_contents(Yii::getAlias('@frontend/web/') . 'proxy.txt', file_get_contents('https://proxybroker.craft-group.xyz/'));
            file_put_contents(Yii::getAlias('@frontend/web/') . 'time.txt', self::dateTime(60));
        }
        $proxy = json_decode(file_get_contents(Yii::getAlias('@frontend/web/') . 'proxy.txt'));

        return 'socks4://'.$proxy[$i]->host.':'.$proxy[$i]->port;
    }
}