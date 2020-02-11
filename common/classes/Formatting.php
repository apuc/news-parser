<?php


namespace common\classes;


class Formatting
{
    public static function formattingData($domains)
    {
        $domains = str_replace(array("\r\n", "\r", "\n"), ",", $domains);
        $domains = self::cutUrl($domains);
        $domains = self::cutDomain($domains);
        $domains = explode(",", $domains);

        $formatting = array();
        foreach ($domains as $domain) {
            $trim = trim($domain);
            if ($trim)
                array_push($formatting, $trim);
        }
        return $formatting;
    }

    public static function cutUrl($domain)
    {
        return str_replace(array("http://", "https://", "www."), "", $domain);
    }

    public static function cutDomain($domain)
    {
        return (strripos($domain, '/')) ? stristr($domain, '/', true) : $domain;
    }

    public static function formData($domains, $all_sites, $user_sites)
    {
        $data_array = array();
        $user_sites_array = array();
        foreach ($user_sites as $value)
            array_push($user_sites_array, $value->domain);

        $formatting = Formatting::formattingData($domains);
        foreach ($formatting as $value) {
            $data = new DataInfo();
            $data->setSite($value);
            foreach ($all_sites as $site)
                if ($site->domain == $data->getSite()) {
                    $data->setSiteExist(1);
                    $data->setSiteId($site->id);
                    if(in_array($data->getSite(), $user_sites_array))
                        $data->setLinkExist(1);
                }
            array_push($data_array, $data);
        }
        return $data_array;
    }
}