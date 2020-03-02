<?php


namespace common\classes;


class TextHandler
{
    protected $source_text;
    protected $text;
    protected $count;
    protected $unique;
    protected $words = array();
    protected $colored_text;
    protected $colors;
    protected $amount;

    public function __construct($text)
    {
        self::setSourceText($text);
    }

    public function setText($text)
    {
        $this->text = $text;
    }
    public function setCount($count)
    {
        $this->count = $count;
    }
    public function setUnique($unique)
    {
        $this->unique = $unique;
    }
    public function setWords($word)
    {
        array_push($this->words, $word);
    }
    public function setColoredText($colored_text)
    {
        $this->colored_text = $colored_text;
    }
    public function setSourceText($source_text)
    {
        $this->source_text = $source_text;
    }
    public function setColors($colors)
    {
        $this->colors = $colors;
    }
    public function setAmount($amount)
    {
        $this->amount = $amount;
    }

    public function getText()
    {
        return $this->text;
    }
    public function getWords()
    {
        return $this->words;
    }
    public function getCount()
    {
        return $this->count;
    }
    public function getUnique()
    {
        return $this->unique;
    }
    public function getColoredText()
    {
        return $this->colored_text;
    }
    public function getSourceText()
    {
        return $this->source_text;
    }
    public function getColors()
    {
        return $this->colors;
    }
    public function getAmount()
    {
        return $this->amount;
    }

    public function handle()
    {
        $text = strip_tags(self::getSourceText());
        $text = str_replace('&nbsp;', ' ', $text);
        $text = strtolower($text);
        self::setText($text);

        $words_array = str_word_count($text, 1, "АаБбВвГгДдЕеЁёЖжЗзИиЙйКкЛлМмНнОоПпРрСсТтУуФфХхЦцЧчШшЩщЪъЫыЬьЭэЮюЯя");
        natcasesort($words_array);

        $count_array = array_count_values($words_array);

        $keys_array = array_keys($count_array);
        $value_array = array();

        foreach ($count_array as $value)
            array_push($value_array, $value);

        $count = 0;
        for($i = 0; $i < count($value_array); $i++) {
            $word_info = new WordInfo($keys_array[$i], $value_array[$i]);
            array_push($this->words, $word_info);
            $count += $value_array[$i];
        }
        self::setCount($count);

        $unique = count($value_array);
        self::setUnique($unique);

        usort($this->words, function($a, $b) {
            return ($a->getCount() > $b->getCount());
        });

        $count_unique_array = array_count_values($value_array);

        $amount_array = array_keys($count_unique_array);
        usort($amount_array, function($a, $b) {
            return ($a > $b);
        });

        self::setAmount($amount_array);

        $count_unique = 0;
        foreach ($count_unique_array as $value)
            $count_unique++;

        self::setColoredText(self::getSourceText());

        $x = 0;
        $colors_array = array();
        if(self::getUnique() > 1) {
            $amount_per_color = ceil($count_unique / 255);
            $step_count_unique = ceil($count_unique / $amount_per_color);
            $step = ceil(255 / ($step_count_unique - 1));
            $i = 0; $j = 0;
            $last = 1;
            foreach ($this->words as $word) {
                $current = $word->getCount();
                if($current > $last) {
                    $j++;
                    $last = $current;
                }
                if($j >= $amount_per_color) {
                    array_push($colors_array, $x);
                    $i++; $j = 0;
                }
                $x = 255 - $i * $step;
                if($x < 0) $x = 0;
                $word->setColor($x);
                self::setColoredText(preg_replace('/\b'.$word->getWord().'\b/iu', '<span style="background-color: rgb('. $word->getColor() .', 196, 0)">'.$word->getWord().'</span>', self::getColoredText()));
            }
            array_push($colors_array, $x);
            self::setColors($colors_array);
        }
    }
}