<?php

namespace frontend\modules\destination\models;


use common\classes\Formatting;
use common\models\DestinationUser;
use Yii;

class Destination extends \common\models\Destination
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
                $destination_id = self::addSite($data);
                self::addLink($destination_id);
            } elseif ($data->isSiteExist() && !$data->isLinkExist()) {
                self::addLink($data->getSiteId());
            }
        }
        return true;
    }

    public static function formData($domains)
    {
        $all_sites = Destination::find()->all();
        $user_sites = Destination::find()
            ->where(['destination_user.user_id' => Yii::$app->user->identity->id])
            ->innerJoin('destination_user', 'destination.id = destination_user.destination_id')
            ->all();

        return Formatting::formData($domains, $all_sites, $user_sites);
    }

    public static function addSite($data)
    {
        $destination = new Destination();
        $destination->domain = $data->getSite();
        $destination->save();

        return $destination->id;
    }

    public static function addLink($destination_id)
    {
        $destination_user = new DestinationUser();
        $destination_user->destination_id = $destination_id;
        $destination_user->user_id = Yii::$app->user->identity->id;
        $destination_user->save();
    }
}