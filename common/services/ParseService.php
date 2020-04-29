<?php

namespace common\services;

use common\classes\Debug;
use phpQuery;

class ParseService
{
    public function parse()
    {
        //    $document = new Document('https://topwar.ru/armament/space/', true);
        //    $links = $document->find('a::attr(href)');
        //    foreach($links as $link)
        //        Debug::prn($link);

        $html = file_get_contents('https://topwar.ru/armament/space/');
        $document = phpQuery::newDocument($html);
        $links = $document->find('a.post__title_link')->get();
        foreach ($links as $link) {
            $data = parse_url($link->getAttribute('href'));
            if (isset($data['host']) && $data['host'] == 'topwar.ru') {
                $html = file_get_contents($data['scheme'] . '://' . $data['host'] . $data['path']);
                $document = phpQuery::newDocument($html);
                $title = $document->find('h1')->get();
                $article = $document->find('article')->get();

                echo 'Заголовок: ' . $title[0]->textContent . "\n";

                $text = 'Текст: ';
                foreach ($article as $block)
                    $text .= $block->textContent;

                echo $text;
                Debug::dd('stop');
            }
        }
    }
}