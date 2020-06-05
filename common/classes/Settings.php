<?php


namespace common\classes;


class Settings
{
    public $title;
    public $keywords;
    public $description;
    public $theme;

    public function __construct($title, $keywords, $description, $theme)
    {
        $this->title = $title;
        $this->keywords = $keywords;
        $this->description = $description;
        $this->theme = $theme;
    }
}