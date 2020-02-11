<?php


namespace common\classes;


use yii\base\Model;

/**
 * @property string $site
 * @property boolean $isSiteExist
 * @property integer $site_id
 * @property boolean $isLinkExist
 */

class DataInfo extends Model
{
    private $site;
    private $isSiteExist = 0;
    private $site_id;
    private $isLinkExist = 0;

    public function setSite($data)
    {
        $this->site = $data;
    }

    public function getSite()
    {
        return $this->site;
    }

    public function setSiteId($data)
    {
        $this->site_id = $data;
    }

    public function getSiteId()
    {
        return $this->site_id;
    }

    public function setSiteExist($data)
    {
        $this->isSiteExist = $data;
    }

    public function isSiteExist()
    {
        return ($this->isSiteExist) ? true : false;
    }

    public function setLinkExist($data)
    {
        $this->isLinkExist = $data;
    }

    public function isLinkExist()
    {
        return ($this->isLinkExist) ? true : false;
    }
}