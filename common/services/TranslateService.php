<?php

namespace common\services;


use common\classes\GoogleTranslate;
use common\classes\ProxyListArray;;

class TranslateService
{
    protected $source;
    protected $target;
    protected $text;
    protected $translate;
    protected $tr;

    public function __construct($type)
    {
        if($type == 'google') {
            $this->tr = new GoogleTranslate('', '', [
                'proxy' => [
                    'http'  => ProxyListArray::getRandom(),
                    'https' => ProxyListArray::getRandom()
                ],
            ]);
            $this->tr->setUrlParamsClient('gtx');
        }
    }


    public function setLocales($source, $target)
    {
        $this->source = $source;
        $this->target = $target;

        $this->tr->setSource($this->source);
        $this->tr->setTarget($this->target);
    }

    public function setSource($source)
    {
        $this->source = $source;

        $this->tr->setSource($this->source);
    }

    public function setTarget($target)
    {
        $this->target = $target;

        $this->tr->setTarget($this->target);
    }

    public function setSText($text)
    {
        $this->text = $text;
    }

    public function setTranslate($translate)
    {
        $this->translate = $translate;
    }

    public function getSource()
    {
        return $this->source;
    }

    public function getTarget()
    {
        return $this->target;
    }

    public function getText()
    {
        return $this->text;
    }

    public function getTranslate()
    {
        return $this->translate;
    }

    public function translate($type, $text = '')
    {
        if($type == 'google')
            try {
                ($text) ? $this->translate = $this->tr->translate($text) : $this->translate = $this->tr->translate($this->text);
            } catch (\ErrorException $e) {
                echo $e . "\n";
            }

        return $this->translate;
    }
}