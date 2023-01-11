<?php
/**
 * User Location Map
 *
 * @package humhub.modules.cetcalModule
 * @author KeudellCoding
 */

namespace humhub\modules\cetcalModule\controllers;

use Yii;
use humhub\components\Controller;

class IndexController extends Controller {
    public function actionIndex() {
        ini_set('memory_limit', '-1');
        $settings = Yii::$app->getModule('cetcalModule')->settings;

        return $this->render('index', [
            'mapWidgetLocation' => $settings->get('map_widget_location')
        ]);
    }
}
