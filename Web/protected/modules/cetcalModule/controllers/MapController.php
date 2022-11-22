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

class MapController extends Controller {
    public function actionIndex() {
        $settings = Yii::$app->getModule('cetcalModule')->settings;

        return $this->render('index', [
            'mapWidgetLocation' => $settings->get('map_widget_location')
        ]);
    }
}
