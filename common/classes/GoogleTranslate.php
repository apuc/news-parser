<?php


namespace common\classes;


class GoogleTranslate extends \Stichoza\GoogleTranslate\GoogleTranslate
{
    public function setUrlParamsClient($client)
    {
        $this->urlParams['client'] = $client;
    }
}