<?php


namespace common\classes;


use http\Exception;
use TrueBV\Punycode;

class AuditService
{
    public static function getTitle($domain)
    {
        try {
            $Punycode = new Punycode();
            $page_content = file_get_contents('http://' . $Punycode->encode($domain));
            preg_match_all( "|<title>(.*)</title>|sUSi", $page_content, $titles);
            if(count($titles[1]))
                return $titles[1][0];
            else return '';
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

}