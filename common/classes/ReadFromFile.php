<?php


namespace common\classes;


class ReadFromFile
{
    private $title;
    private $article;

    function __construct($filename)
    {
        if (($handle = fopen('docs/' . $filename, 'r')) !== FALSE) {
            while (($data = fgetcsv($handle, 0, ',','"')) !== FALSE) {
                $this->title = $data[0];
                $this->article = $data[1];
            }
            fclose($handle);
        }
    }

    public function getTitle()
    {
        return $this->title;
    }

    public function getArticle()
    {
        return $this->article;
    }
}