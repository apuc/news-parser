<?php


namespace common\classes;


class TextHandler
{
    protected $text;
    protected $words = array();

    public function __construct($text)
    {
        self::setText($text);
    }

    public function setText($text)
    {
        $this->text = $text;
    }
    public function setWords($word)
    {
        array_push($this->words, $word);
    }

    public function getText()
    {
        return $this->text;
    }
    public function getWords()
    {
        return $this->words;
    }

    public function handle()
    {
        $text = strtolower($this->text);
        $words_array = str_word_count($text, 1);
        natcasesort($words_array);
        $count_array = array_count_values($words_array);
        $keys_array = array_keys($count_array);

//        foreach ($count_array as $value)
//            echo $value . '<br>';
//
//        foreach ($keys_array as $val)
//            echo $val . '<br>';
    }
}