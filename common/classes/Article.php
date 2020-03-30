<?php


namespace common\classes;


class Article
{
    public $parent_id;
    public $name;
    public $text;
    public $language_id;
    public $categories;
    public $image;

    public function __construct($parent_id, $name, $text, $language_id, $categories, $image)
    {
        $this->parent_id = $parent_id;
        $this->name = $name;
        $this->text = $text;
        $this->language_id = $language_id;
        $this->categories = $categories;
        $this->image = $image;
    }
}