<?php

namespace common\services;

use Stichoza\GoogleTranslate\GoogleTranslate;

class TranslateService
{
    protected $source;
    protected $target;
    protected $text;
    protected $translate;

    public function __construct($source, $target, $text)
    {
        $this->source = $source;
        $this->target = $target;
        $this->text = $text;

        $tr = new GoogleTranslate();
        $tr->setSource($this->source);
        $tr->setTarget($this->target);

        $this->translate = $tr->translate($this->text);
    }

    public function setSource($source)
    {
        $this->source = $source;
    }

    public function setTarget($target)
    {
        $this->target = $target;
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

    public function translate($source = '', $target = '', $text = '')
    {
        $tr = new GoogleTranslate();
        ($source) ? $tr->setSource($source) : $tr->setSource($this->source);
        ($target) ? $tr->setTarget($target) : $tr->setTarget($this->target);
        ($text) ? $this->translate = $tr->translate($text) : $this->translate = $tr->translate($this->text);
    }
}