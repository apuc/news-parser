<?php

namespace common\services;


use common\models\Article;
use phpQuery;

class ParseService
{
    public function parse()
    {
        // select one link from queue
        // get domain from link
        // select parse rules for current domain
        // parse (done)

        $link = 'https://topwar.ru/armament/space/';
        $domain = 'topwar.ru';
        //$links_rule = 'a';
        $links_rule = 'a.post__title_link';
        $title_rule = 'h1';
        $article_rule = 'article';

        $html = file_get_contents($link);
        $document = phpQuery::newDocument($html);
        $links = $document->find($links_rule)->get();

        $existed = Article::find()->select('url')->asArray()->all();
        $urls = array();
        foreach ($existed as $value)
            array_push($urls, $value['url']);

        foreach ($links as $link) {
            $data = parse_url($link->getAttribute('href'));
            print_r($data);
            if (isset($data['host']) && $data['host'] == $domain && !in_array($data['path'], $urls)) {
                $html = file_get_contents($data['scheme'] . '://' . $data['host'] . $data['path']);
                $document = phpQuery::newDocument($html);
                $title = $document->find($title_rule)->get();
                $article = $document->find($article_rule)->get();

                $text = '';
                foreach ($article as $block)
                    $text .= $block->textContent . ' ';

                $article = new Article();
                $article->name = $title[0]->textContent;
                $article->text = $text;
                $article->source_type = 4;
                $article->source_id = 5;
                $article->url = $data['path'];
                $article->title = $title[0]->textContent;

                $article->save();
            }
        }
    }
}