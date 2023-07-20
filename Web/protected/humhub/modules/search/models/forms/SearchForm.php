<?php

namespace humhub\modules\search\models\forms;

use humhub\modules\user\models\User;
use humhub\modules\space\models\Space;
use humhub\modules\search\engine\Search;
use humhub\modules\cet_entite\models\Entite;
use humhub\modules\calendar\models\CalendarEntry;
use yii\base\Model;
use Yii;

/**
 * Description of SearchForm
 *
 * @since 1.2
 * @author buddha
 */
class SearchForm extends Model
{
    const SCOPE_ALL = 'all';
    const SCOPE_USER = 'user';
    const SCOPE_SPACE = 'space';
    const SCOPE_CONTENT = 'content';
    const SCOPE_CET_ENTITE = 'cet_entite';

    const SCOPE_EVENT = 'event';
    public $keyword = '';
    public $scope = '';
    public $isnewSearch = false;
    public $page = 1;
    public $limitSpaceGuids = [];
    public $limitActivitesIds = [];
    public $limitCategoriesIds = [];
    public $limitCommunesIds = [];

    public $limitTypesIds = [];
    public $distanceRecherche = 10;

    public $isCertifier = true;
    public $startDatetime = '';

    public $endDatetime = '';

    public $avancee = false;

    public $userlat = null;
    public $userlong = null;

    public function init()
    {
        if (Yii::$app->request->get('page')) {
            $this->page = Yii::$app->request->get('page');
        }
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['keyword' , 'scope' , 'userlat' , 'userlong' , 'isnewSearch', 'page', 'limitSpaceGuids', 'limitTypesIds' ,'limitActivitesIds', 'limitCategoriesIds', 'limitCommunesIds', 'distanceRecherche', 'isCertifier', 'startDatetime', 'endDatetime', 'avancee'], 'safe']
        ];
    }

}
