<?php


namespace common\classes;


class TextHandler
{
    protected $source_text;
    protected $text;
    protected $colored_text;

    protected $word_count;
    protected $unique_words;
    protected $words = array();

    protected $number_of_quantity_groups;
    protected $colors = array();
    protected $amount;

    public function __construct($text)
    {
        self::setSourceText($text);
        self::setText();
        self::setColoredText(self::getSourceText());

        $words_array = str_word_count(self::getText(), 1, "АаБбВвГгДдЕеЁёЖжЗзИиЙйКкЛлМмНнОоПпРрСсТтУуФфХхЦцЧчШшЩщЪъЫыЬьЭэЮюЯя");
        natcasesort($words_array);

        $count_array = array_count_values($words_array);

        $keys_array = array_keys($count_array);

        $value_array = array();
        foreach ($count_array as $value)
            array_push($value_array, $value);

        for($i = 0; $i < count($value_array); $i++) {
            $word_info = new WordInfo($keys_array[$i], $value_array[$i]);
            self::setWord($word_info);
        }

        usort($this->words, function($a, $b) {
            return ($a->getCount() > $b->getCount());
        });

        $count_unique_array = array_count_values($value_array);

        $amount_array = array_keys($count_unique_array);
        usort($amount_array, function($a, $b) {
            return ($a > $b);
        });

        self::setWordCount(count($words_array));
        self::setUniqueWords(count(self::getWords()));
        self::setAmount($amount_array);
        self::setNumberOfQuantityGroups(count($count_unique_array));
        self::setColors();
    }

    protected function setSourceText($source_text)
    {
        $this->source_text = $source_text;
    }

    protected function setText()
    {
        $text = strip_tags(self::getSourceText());
        $text = str_replace('&nbsp;', ' ', $text);
        $text = mb_strtolower($text);

        $this->text = $text;
    }

    protected function setWordCount($word_count)
    {
        $this->word_count = $word_count;
    }

    protected function setUniqueWords($unique_words)
    {
        $this->unique_words = $unique_words;
    }

    protected function setWord($word)
    {
        array_push($this->words, $word);
    }

    protected function setAmount($amount)
    {
        $this->amount = $amount;
    }

    protected function setNumberOfQuantityGroups($number_of_quantity_groups)
    {
        $this->number_of_quantity_groups = $number_of_quantity_groups;
    }

    protected function setWordsColors($colors)
    {
        array_push($this->colors, $colors);
    }

    protected function setColoredText($colored_text)
    {
        $this->colored_text = $colored_text;
    }

    protected function setColors()
    {
        $x = 0;
        if(self::getUniqueWords() > 2) {
            $amount_per_color = ceil(self::getNumberOfQuantityGroups() / 255);
            $step_count_unique = ceil(self::getNumberOfQuantityGroups() / $amount_per_color);
            if($step_count_unique > 2) {
                $step = ceil(255 / ($step_count_unique - 1));
                $i = 0; $j = 0;
                $last = 1;
                foreach (self::getWords() as $word) {
                    $current = $word->getCount();
                    if($current > $last) {
                        $j++;
                        $last = $current;
                    }
                    if($j >= $amount_per_color) {
                        self::setWordsColors($x);
                        $i++; $j = 0;
                    }
                    $x = 255 - $i * $step;
                    if($x < 0) $x = 0;
                    $word->setColor($x);
                    self::setColoredText(preg_replace('/\b'.$word->getWord().'\b/iu', '<span style="background-color: rgb('. $word->getColor() .', 196, 0)">'.$word->getWord().'</span>', self::getColoredText()));
                }
                self::setWordsColors($x);
            }
        }
        else self::setWordsColors($x);
    }

    /** public methods */

    public function getText()
    {
        return $this->text;
    }

    public function getWords()
    {
        return $this->words;
    }

    public function getWordCount()
    {
        return $this->word_count;
    }

    public function getUniqueWords()
    {
        return $this->unique_words;
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

    public function getColor($i)
    {
        return $this->colors[$i];
    }

    public function getAmount()
    {
        return $this->amount;
    }

    public function getOneAmount($i)
    {
        return $this->amount[$i];
    }

    public function getNumberOfQuantityGroups()
    {
        return $this->number_of_quantity_groups;
    }

    public function showInfo()
    {
        echo '<h3>Статистика текста:</h3>';
        echo 'Количество символов: '.iconv_strlen(self::getText()).'<br>';
        echo 'Количество слов: '.self::getWordCount().'<br>';
        echo 'Кол-во уникальных слов: '.self::getUniqueWords().'<br>';
    }

    public function showWordInfo()
    {
        echo '<h3>Семантическое ядро:</h3>';
        echo '<table class="table table-striped custom-table">';
        echo '<thead class="thead-dark"><tr><th scope="col">#</th><th scope="col">Слово</th><th scope="col">Количество</th></tr></thead>';

        $i = 0;
        foreach (self::getWords() as $word) {
            echo '<tr><th scope="row">'.$i.'</th><td>'.$word->getWord().'</td><td>'.$word->getCount().'</td></tr>';
            $i++;
        }
        echo '</table>';
    }

    public function showText()
    {
        try {
            $step_count_unique = ceil(self::getNumberOfQuantityGroups() / ceil(self::getNumberOfQuantityGroups() / 255));
            echo '<h3>Текст:</h3>';
            if(self::getUniqueWords() > 2 && $step_count_unique > 2) {
                echo 'Значение цветов: ';
                for($i = 0; $i < count(self::getAmount()); $i++)
                    echo '<span style="background-color: rgb('. self::getColor($i) .', 196, 0)">Частота: ' . self::getOneAmount($i) . ' </span>';
                echo '<br><br>';
            }

            echo '<pre style="background: lightgray; border: 1px solid lightgray; padding: 2px">';
            echo self::getColoredText();
            echo '</pre>';
        } catch (\Exception $e) {
            echo '<pre style="background: lightgray; border: 1px solid lightgray; padding: 2px">';
            echo self::getText();
            echo '</pre>';
        }
    }
}