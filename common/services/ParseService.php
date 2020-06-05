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

                $this->parse($source->domain,
                    Formatting::cutDomain(Formatting::cutUrl($source->domain)),
                    $parent->links_rule, $parent->title_rule, $parent->article_rule, $source->id, $parent->parse_type, $parent->regex);
            } else {
                $this->parse($source->domain,
                    Formatting::cutDomain(Formatting::cutUrl($source->domain)),
                    $source->links_rule, $source->title_rule, $source->article_rule, $source->id, $source->parse_type, $source->regex);
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

    public function getTitle($doc, $rule)
    {
        $title = $doc->find($rule)->get();

        return $title[0]->textContent;
    }

    public function getArticle($doc, $rule, $parse_type, $regex)
    {
        $article_text = $doc->find($rule)->get();
        $regex = Regex::find()->all();
        $text = '';

//        if($parse_type == 0) {
//            foreach ($article_text as $block) {
//                if($block->textContent)
//                    $text .= '<p>' . $block->textContent . '</p> ';
//                elseif ($block->nodeValue)
//                    $text .= '<p>' . $block->nodeValue . '</p> ';
//            }
//        } elseif($parse_type == 1) {
            foreach ($article_text as $block) {
                if($block->textContent)
                    $_text = $block->textContent;
                elseif ($block->nodeValue)
                    $_text = $block->nodeValue;
                else $_text = '';

                foreach ($regex as $item)
                    try {
                        $_text = preg_replace($item->regex, '', $_text);
                    } catch(\Exception $e) {
                        echo $e."\n";
                    }

                $text .= '<p>' . $_text . '</p> ';
            }
        //}

        return $text;
    }

    public function parse($link, $domain, $links_rule, $title_rule, $article_rule, $source_id, $parse_type, $regex)
    {
        $links = $this->getLinks($link, $links_rule);

        $urls = $this->getExistedUrls();

        foreach ($links as $link) {
            $link_attrs = parse_url($link->getAttribute('href'));

            try {
                if (isset($link_attrs['host']) && !in_array($link_attrs['path'], $urls)) {
                    $document = $this->getDocument($link_attrs['scheme'] . '://' . $link_attrs['host']
                        . $link_attrs['path']);

                    $article = new Article();
                    $article->save_parse($this->getTitle($document, $title_rule),
                        $this->getArticle($document, $article_rule, $parse_type, $regex), $link_attrs['path'], $source_id);
                } elseif (isset($link_attrs['path']) && $link_attrs['path'] && !in_array($link_attrs['path'], $urls)) {
                    $document = $this->getDocument('https://' . $domain . $link_attrs['path']);

                    $article = new Article();
                    $article->save_parse($this->getTitle($document, $title_rule),
                        $this->getArticle($document, $article_rule, $parse_type, $regex), $link_attrs['path'], $source_id);
                }
            } catch (\Exception $e) { }
        }
    }

    public function clean($id)
    {
        $article = Article::findOne($id);
        $text = $article->text;
        $text = str_replace(['$', '});', '(adsbygoogle = window.adsbygoogle || []).push({});', '(adsbygoogle =',
            'document.write(VK.Share.button(false,{type: "round", text: "Опубликовать"}));', '<!--', '-->'], '', $text);

        $article->text = $text;
        $article->save();
    }
}