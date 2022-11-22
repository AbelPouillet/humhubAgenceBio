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
    public $page = 1;
    public $limitSpaceGuids = [];
    public $limitTypesIds = [];

    public $limitCommunesIds = [];

    public $distanceRecherche = 10;

    public $isCertifier = false;
    public $startDatetime = '';

    public $endDatetime = '';

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
            [['keyword', 'scope', 'page', 'limitSpaceGuids', 'limitTypesIds', 'limitCommunesIds', 'distanceRecherche', 'isCertifier', 'startDatetime', 'endDatetime'], 'safe']
        ];
    }

    public function getTotals($keyword, $options)
    {
        $totals = [];

        // Unset unnecessary search options
        unset($options['model'], $options['type'], $options['page'], $options['pageSize']);

        $searchResultSetCount = Yii::$app->search->find($keyword, array_merge($options, ['model' => User::class]));
        $totals[self::SCOPE_USER] = $searchResultSetCount->total;
        $searchResultSetCount = Yii::$app->search->find($keyword, array_merge($options, ['model' => Space::class]));
        $totals[self::SCOPE_SPACE] = $searchResultSetCount->total;
        // Recherche d'event
        $searchResultSetCount = Yii::$app->search->find($keyword, array_merge($options, ['model' => CalendarEntry::class]));
        $totals[self::SCOPE_EVENT] = $searchResultSetCount->total;

        $searchResultSetCount = Yii::$app->search->find($keyword, array_merge($options, ['type' => Search::DOCUMENT_TYPE_CONTENT]));
        $totals[self::SCOPE_CONTENT] = $searchResultSetCount->total;
        // TODO: Recherches Cetcal

        $searchResultSetCount = Yii::$app->search->find($keyword, array_merge($options, ['model' => Entite::class]));
        $totals[self::SCOPE_CET_ENTITE] = $searchResultSetCount->total;

        $totals[self::SCOPE_ALL] = $totals[self::SCOPE_CONTENT] + $totals[self::SCOPE_SPACE] + $totals[self::SCOPE_USER] + $totals[self::SCOPE_CET_ENTITE] + $totals[self::SCOPE_EVENT];

        return $totals;
    }
}
