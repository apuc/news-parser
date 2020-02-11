<?php

namespace frontend\modules\source\models;


use common\classes\Formatting;
use common\models\SourceUser;
use Yii;

class Source extends \common\models\Source
{
    public function init()
    {
        parent::init();
    }

    public static function addData($domains)
    {
        $data_array = self::formData($domains);
        foreach ($data_array as $data) {
            if (!$data->isSiteExist()) {
                $source_id = self::addSite($data);
                self::addLink($source_id);
            } elseif ($data->isSiteExist() && !$data->isLinkExist()) {
                self::addLink($data->getSiteId());
            }
        }
        return true;
    }

    public static function formData($domains)
    {
        $all_sites = Source::find()->all();
        $user_sites = Source::find()
            ->where(['source_user.user_id' => Yii::$app->user->identity->id])
            ->innerJoin('source_user', 'source.id = source_user.source_id')
            ->all();
        return Formatting::formData($domains, $all_sites, $user_sites);
    }

    public static function addSite($data)
    {
        $source = new Source();
        $source->domain = $data->getSite();
        $source->save();

        return $source->id;
    }

    public static function addLink($source_id)
    {
        $source_user = new SourceUser();
        $source_user->source_id = $source_id;
        $source_user->user_id = Yii::$app->user->identity->id;
        $source_user->save();
    }
}