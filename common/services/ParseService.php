<?php

namespace common\services;


use common\classes\Debug;
use common\classes\Formatting;
use common\models\Article;
use common\models\Regex;
use common\models\Source;
use phpQuery;

class ParseService
{
    public function parse_handler($id)
    {
        $source = Source::findOne($id);
        if ($source)
            if ($source->parent_id) {
                $parent = Source::findOne($source->parent_id);

                $this->parse($source->domain, Formatting::cutDomain(Formatting::cutUrl($source->domain)),
                    $parent->links_rule, $parent->title_rule, $parent->article_rule, $source->id, $parent->parse_type,
                    $parent->regex);
            } else {
                $this->parse($source->domain, Formatting::cutDomain(Formatting::cutUrl($source->domain)),
                    $source->links_rule, $source->title_rule, $source->article_rule, $source->id, $source->parse_type,
                    $source->regex);
            }
    }

    public function parse($link, $domain, $links_rule, $title_rule, $article_rule, $source_id, $parse_type, $regex)
    {
        $new_urls = $this->getNewUrls($link, $links_rule);

        foreach ($new_urls as $url) {
            try {
                $document = $this->getDocument('https://' . $domain . $url);

                $article = new Article();
                $article->save_parse($this->getTitle($document, $title_rule),
                    $this->getArticle($document, $article_rule, $parse_type, $regex), $url, $source_id);
            } catch (\Exception $e) { }
        }
    }

    public function getDocument($link)
    {
        $html = file_get_contents($link);

        return phpQuery::newDocument($html);
    }

    public function getLinks($link, $rule)
    {
        $document = $this->getDocument($link);

        return $document->find($rule)->get();
    }

    public function getExistedUrls()
    {
        $existed = Article::find()->select('url')->asArray()->all();
        $urls = array();
        foreach ($existed as $value)
            array_push($urls, $value['url']);

        return $urls;
    }

    public function getNewUrls($link, $links_rule)
    {
        $links = $this->getLinks($link, $links_rule);
        $new_urls = array();
        foreach ($links as $link) {
            $link_attrs = parse_url($link->getAttribute('href'));
            if (isset($link_attrs['path']) && $link_attrs['path'])
                array_push($new_urls, $link_attrs['path']);
        }
        $new_urls = array_unique($new_urls);
        $new_urls = array_diff($new_urls, $this->getExistedUrls());

        return $new_urls;
    }

    public function getTitle($doc, $rule)
    {
        $title = $doc->find($rule)->get();

        return $title[0]->textContent;
    }

    public function getArticle($doc, $rule, $parse_type, $regex)
    {
//        $article_text = $doc->find($rule)->get();
//        $regex = Regex::find()->all();
//        $text = '';
//
//        foreach ($article_text as $block) {
//            if ($block->textContent)
//                $_text = $block->textContent;
//            elseif ($block->nodeValue)
//                $_text = $block->nodeValue;
//            else $_text = '';
//
//            foreach ($regex as $item)
//                $_text = preg_replace($item->regex, '', $_text);
//
//            $_text = str_replace(['});'], '', $_text);
//            stristr($_text, 'Ctrl Enter', true);
//            $text .= '<p>' . $_text . '</p> ';
//        }

//        return $text;
        preg_match('/<article(.*?)<\/article>/ms', $doc, $matches);
        var_dump($matches);
        return $matches[0];
    }
}