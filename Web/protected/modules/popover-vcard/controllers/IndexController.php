<?php
/**
 * @link https://www.humhub.org/
 * @copyright Copyright (c) 2018 HumHub GmbH & Co. KG
 * @license https://www.humhub.com/licences
 */

namespace humhub\modules\popovervcard\controllers;

use humhub\components\Controller;
use humhub\modules\content\models\ContentContainer;
use humhub\modules\popovervcard\widgets\VCardSpace;
use humhub\modules\popovervcard\widgets\VCardUser;
use humhub\modules\space\models\Space;
use humhub\modules\user\models\User;
use Yii;
use yii\web\HttpException;


/**
 * Class IndexController
 * @package humhub\modules\popovervcard\controllers
 */
class IndexController extends Controller
{
    public function actionIndex()
    {
        return $this->render('index');
    }

    /**
     * @return string|HttpException
     * @throws HttpException
     * @throws \yii\db\IntegrityException
     */
    public function actionLoad()
    {
        $contentContainerId = Yii::$app->request->post('id');
        $contentContainerGuid = Yii::$app->request->post('guid');


        if($contentContainerId !== null) {
            $contentContainer = ContentContainer::findOne(['id' => $contentContainerId]);
        } elseif ($contentContainerGuid !== null) {
            $contentContainer = ContentContainer::findOne(['guid' => $contentContainerGuid]);
        } else {
            throw new HttpException(400, 'No container provided');
        }

        if ($contentContainer === null) {
            return new HttpException(404, 'Could not find container!');
        }

        $instance = $contentContainer->getPolymorphicRelation();

        /** @var Module $module */
        $module = Yii::$app->getModule('popover-vcard');

        if ($instance instanceof User) {
            if (empty($module->getConfiguration()->userEnabled)) {
                return '';
            }

            return $this->renderAjaxContent(VCardUser::widget(['user' => $instance]));
        } elseif ($instance instanceof Space) {
            if (empty($module->getConfiguration()->spaceEnabled)) {
                return '';
            }

            return $this->renderAjaxContent(VCardSpace::widget(['space' => $instance]));
        }

        return '';
    }

}