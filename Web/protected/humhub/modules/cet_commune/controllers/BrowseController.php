<?php

/**
 * @link https://www.humhub.org/
 * @copyright Copyright (c) 2018 HumHub GmbH & Co. KG
 * @license https://www.humhub.com/licences
 */

namespace humhub\modules\cet_commune\controllers;

use humhub\components\Controller;
use humhub\components\behaviors\AccessControl;
use humhub\modules\content\widgets\ContainerTagPicker;
use humhub\modules\cet_commune\models\CetCommune;
use humhub\modules\cet_commune\widgets\Chooser;
use Yii;
use yii\data\Pagination;

/**
 * BrowseController
 *
 * @author Luke
 * @package humhub.modules_core.cet_commune.controllers
 * @since 0.5
 */
class BrowseController extends Controller
{

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'acl' => [
                'class' => AccessControl::class,
                'guestAllowedActions' => ['search']
            ]
        ];
    }


    /**
     * Returns a workspace list by json
     *
     * It can be filtered by by keyword.
     */
    public function actionSearch()
    {

        Yii::$app->response->format = 'json';

        $query = CetCommune::find()->where(['like', 'commune', '%' . Yii::$app->request->get('keyword') . '%', false]);

        $countQuery = clone $query;
        $pagination = new Pagination(['totalCount' => $countQuery->count(), 'pageSizeParam' => 'limit']);

        $query->offset($pagination->offset)->limit($pagination->limit);

        return $this->asJson($this->prepareResult($query->all()));
    }

    /**
     * @return \yii\web\Response
     * @throws \Throwable
     */
    public function actionSearchLazy()
    {
        return $this->asJson(Chooser::getLazyLoadResult());
    }

    /**
     * Returns space tags list in JSON format filtered by keyword
     */
    public function actionSearchTagsJson()
    {
        $keyword = Yii::$app->request->get('keyword');
        $pickerTags = ContainerTagPicker::searchTagsByContainerClass(Space::class, $keyword);

        return $this->asJson($pickerTags);
    }

    /**
     * @param $spaces Space[] array of spaces
     * @return array
     */
    protected function prepareResult($communes)
    {
        $target = Yii::$app->request->get('target');

        $json = [];
        $withChooserItem = ($target === 'chooser');
        foreach ($communes as $commune) {
            $json[] = Chooser::getSpaceResult($commune, $withChooserItem);
        }

        return $json;
    }
}
