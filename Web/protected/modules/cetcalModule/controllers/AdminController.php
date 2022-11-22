<?php
/**
 * User Location Map
 *
 * @package humhub.modules.cetcalModule
 * @author KeudellCoding
 */

namespace humhub\modules\cetcalModule\controllers;

use Yii;
use yii\helpers\Url;
use humhub\components\Response;
use humhub\modules\admin\components\Controller;
use humhub\modules\cetcalModule\models\admin\EditForm;

class AdminController extends Controller {
    public function actionIndex() {
        Yii::$app->response->format = Response::FORMAT_HTML;

        $form = new EditForm();

        if ($form->load(Yii::$app->request->post()) && $form->validate() && $form->save()) {
            $this->view->saved();
            return $this->redirect(Url::to(['/cetcalModule/admin/index']));
        }

        $errorCacheKey = 'cetcalModule.error.cache.lasterrors';
        $lastError = Yii::$app->cache->get($errorCacheKey);

        return $this->render('index', ['model' => $form, 'last_error' => $lastError]);
    }
}
