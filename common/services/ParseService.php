<?php

namespace common\services;


use common\classes\Formatting;
use common\models\Article;
use common\models\Source;
use phpQuery;

class ParseService
{
    public function parse_handler()
    {
        $sources = Source::find()->all();
        if($sources)
            foreach ($sources as $source)
                if($source->parent_id) {
                    $parent = Source::findOne($source->parent_id);
                    
                    $this->parse($source->domain,
                        Formatting::cutDomain(Formatting::cutUrl($source->domain)),
                        $parent->links_rule, $parent->title_rule, $parent->article_rule, $source->id);
                } else
                    $this->parse($source->domain,
                        Formatting::cutDomain(Formatting::cutUrl($source->domain)),
                        $source->links_rule, $source->title_rule, $source->article_rule, $source->id);
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

    public function getArticle($doc, $rule)
    {
        $article_text = $doc->find($rule)->get();
        $text = '';
        foreach ($article_text as $block)
            $text .= $block->textContent . ' ';

        return $text;
    }

    public function parse($link, $domain, $links_rule, $title_rule, $article_rule, $source_id)
    {
        echo $domain . "\n";

        $links = $this->getLinks($link, $links_rule);

        $urls = $this->getExistedUrls();

        foreach ($links as $link) {
            $link_attrs = parse_url($link->getAttribute('href'));

            try {
                if (isset($link_attrs['host']) && !in_array($link_attrs['path'], $urls)) {
                    print_r($link_attrs);

                    $document = $this->getDocument($link_attrs['scheme'] . '://' . $link_attrs['host']
                        . $link_attrs['path']);

                    $article = new Article();
                    $article->save_parse($this->getTitle($document, $title_rule),
                        $this->getArticle($document, $article_rule), $link_attrs['path'], $source_id);
                } elseif (isset($link_attrs['path']) && $link_attrs['path']  && !in_array($link_attrs['path'], $urls)) {
                    print_r($link_attrs);

                    $document = $this->getDocument('https://' . $domain . $link_attrs['path']);

                    $article = new Article();
                    $article->save_parse($this->getTitle($document, $title_rule),
                        $this->getArticle($document, $article_rule), $link_attrs['path'], $source_id);
                }
            } catch (\Exception $e) {
                echo "Something went wrong..\n";
            }
        }
    }
}