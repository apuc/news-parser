<?php


namespace common\classes;


class Article
{
    public $name;
    public $text;
    public $language_id;
    public $categories;
    public $image;

    public function __construct($name, $text, $language_id, $categories, $image)
    {
        $this->name = $name;
        $this->text = $text;
        $this->language_id = $language_id;
        $this->categories = $categories;
        $this->image = $image;
    }
}