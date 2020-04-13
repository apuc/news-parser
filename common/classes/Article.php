<?php


namespace common\classes;


class Article
{
    public $parent_id;
    public $name;
    public $text;
    public $language;
    public $categories;
    public $image;
    public $title;
    public $description;
    public $keywords;
    public $url;

    public function __construct($parent_id, $name, $text, $language, $categories, $image, $title, $description, $keywords, $url)
    {
        $this->parent_id = $parent_id;
        $this->name = $name;
        $this->text = $text;
        $this->language = $language;
        $this->categories = $categories;
        $this->image = $image;
        $this->title = $title;
        $this->description = $description;
        $this->keywords = $keywords;
        $this->url = $url;
    }
}