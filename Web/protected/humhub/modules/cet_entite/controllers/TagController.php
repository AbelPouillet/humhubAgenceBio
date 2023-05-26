<?php
/**
 * @link https://www.humhub.org/
 * @copyright Copyright (c) 2017 HumHub GmbH & Co. KG
 * @license https://www.humhub.com/licences
 *
 */

namespace humhub\modules\cet_entite\controllers;


use app\models\cetcal_model\Entite;
use humhub\components\Controller;
use humhub\modules\cet_entite\widgets\EntiteTagPicker;
use Yii;
use yii\web\HttpException;

class TagController extends Controller
{
    /**
     * @var Entite
     */
    public $entite;
    /**
     * @inheritdoc
     */
    public $requireContainer = false;

    /**
     * @inheritdoc
     */
    public function getAccessRules()
    {
        return [
            ['json']
        ];
    }

    public function actionSearch($keyword)
    {
        return $this->entite
            ? EntiteTagPicker::searchByEntite($keyword, $this->entite)
            : EntiteTagPicker::search($keyword);
    }
}
