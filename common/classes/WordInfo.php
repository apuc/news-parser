<?php


namespace common\classes;


class WordInfo
{
    protected $word;
    protected $count;
    protected $color;

    public function __construct($word, $count)
    {
        self::setWord($word);
        self::setCount($count);
    }

    public function setWord($word)
    {
        $this->word = $word;
    }
    public function setCount($count)
    {
        $this->count = $count;
    }

    public function getWord()
    {
        return $this->word;
    }

    public function getCount()
    {
        return $this->count;
    }
}