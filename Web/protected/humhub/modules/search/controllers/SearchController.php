<?php

/**
 * @link https://www.humhub.org/
 * @copyright Copyright (c) 2018 HumHub GmbH & Co. KG
 * @license https://www.humhub.com/licences
 */

namespace humhub\modules\search\controllers;

use humhub\modules\cet_categorie\models\Categorie;
use humhub\modules\user\widgets\Image;
use Yii;
use yii\data\Pagination;
use humhub\components\Controller;
use humhub\modules\cet_activite\models\Activite;
use humhub\modules\space\models\Space;
use humhub\modules\user\models\User;
use humhub\modules\search\models\forms\SearchForm;
use humhub\modules\search\engine\Search;
use humhub\modules\cet_entite\models\Entite;

use humhub\modules\cet_commune\models\CetCommune;
use humhub\modules\cet_type\models\Type;
use yii\helpers\ArrayHelper;

/**
 * Search Controller provides search functions inside the application.
 *
 * @author Luke
 * @since 0.12
 */
class SearchController extends Controller
{
    /**
     * View context used for the search view
     * @see View::$viewContext
     */
    const VIEW_CONTEXT = 'search';

    /**
     * @var string the current search keyword
     */
    public static $keyword = '';

    /**
     * Display map for the search
     *
     */
    public $displayMap;
    /**
     * @inheritdoc
     */
    public $showResults = false;

    public $distanceRecherche = 10;

    public $isCertifier = false;

    public $startDatetime = '';

    public $endDatetime = '';

    public function init()
    {
        $this->appendPageTitle(\Yii::t('SearchModule.base', 'Search'));
        $this->view->setViewContext(static::VIEW_CONTEXT);
        return parent::init();
    }

    /**
     * @inheritdoc
     */
    public function getAccessRules()
    {
        return [
            ['login']
        ];
    }

    public function actionIndex()
    {
        ini_set('max_execution_time', '300');
        $model = new SearchForm();
        $model->load(Yii::$app->request->get());

        $limitSpaces = [];
        if (!empty($model->limitSpaceGuids)) {
            foreach ($model->limitSpaceGuids as $guid) {
                $space = Space::findOne(['guid' => trim($guid)]);
                if ($space !== null) {
                    $limitSpaces[] = $space;
                }
            }
        }
        $dataActivites = [];
        $activites = Activite::find()->select('id, nom')->all();
        $dataActivites = ArrayHelper::map($activites, 'id', 'nom');
        $limitActivites = [];
        $valueActivites = [];
        if (!empty($model->limitActivitesIds)) {
            foreach ($model->limitActivitesIds as $id) {
                $activite = Activite::findOne(['id' => trim($id)]);
                if ($activite !== null) {
                    $limitActivites[] = $activite;
                    $valueActivites[] = [$id => $activite->nom];
                }
            }
            $this->showResults = true;
        }
        $dataCategories = [];
        $categories = Categorie::find()->select('id, nom')->all();
        $dataCategories = ArrayHelper::map($categories, 'id', 'nom');
        $limitCategories = [];
        $valueCategories = [];
        if (!empty($model->limitCategoriesIds)) {
            foreach ($model->limitCategoriesIds as $id) {
                $categorie = Categorie::findOne(['id' => trim($id)]);
                if ($categorie !== null) {
                    $limitCategories[] = $categorie;
                    $valueCategories[] = [$id => $categorie->nom];
                }
            }
            $this->showResults = true;
        }
        $dataTypes = [];
        $types = Type::find()->select('id, nom')->all();
        $dataTypes = ArrayHelper::map($types, 'id', 'nom');

        $limitTypes = [];
        $valueTypes = [];
        if (!empty($model->limitTypesIds)) {
            foreach ($model->limitTypesIds as $id) {
                $type = Type::findOne(['id' => trim($id)]);
                if ($type !== null) {
                    $limitTypes[] = $type;
                    $valueTypes[] = [$id => $type->nom];
                }
            }
            $this->showResults = true;
        }
        $limitCommunes = [];
        $this->distanceRecherche = $model->distanceRecherche;
        if (!empty($model->limitCommunesIds)) {
            foreach ($model->limitCommunesIds as $id) {
                $commune = CetCommune::findOne(['id' => trim($id)]);
                if ($commune !== null) {
                    $limitCommunes[] = $commune;
                }
            }
            $this->showResults = true;
        }
        if (!empty($model->isCertifier)) {
            $this->isCertifier = $model->isCertifier;
            $this->showResults = true;
        }

        if (!empty($model->startDatetime)) {
            $this->startDatetime = $model->startDatetime;
            $this->showResults = true;
        } else {
            $this->startDatetime = date('d-m-Y');
            $model->startDatetime = $this->startDatetime;
            //print ($this->startDatetime);

        }

        if (!empty($model->endDatetime)) {
            $this->endDatetime = $model->endDatetime;
            $this->showResults = true;
        }
        $displayMap = false;
        $displayEvent = false;
        $type = '';
        $modelClass = '';
        $sortField = 'productions';
        if ($model->scope == SearchForm::SCOPE_EVENT) {
            $type = Search::DOCUMENT_TYPE_EVENT;
            $displayEvent = true;
            $sortField = '';
        } elseif ($model->scope == SearchForm::SCOPE_CONTENT) {
            $type = Search::DOCUMENT_TYPE_CONTENT;
        } elseif ($model->scope == SearchForm::SCOPE_SPACE) {
            $modelClass = Space::class;
        } elseif ($model->scope == SearchForm::SCOPE_USER) {
            $modelClass = User::class;
        } elseif ($model->scope == SearchForm::SCOPE_CET_ENTITE) {
            $modelClass = Entite::class;
            $displayMap = true;
        } /*elseif ($model->scope == SearchForm::SCOPE_CET_PRODUIT) {
            $modelClass = CetProduit::class;
        } */ else {
            $model->scope = SearchForm::SCOPE_ALL;
        }

        $options = [
            'model' => $modelClass,
            'type' => $type,
            'page' => $model->page,
            'sortField' => $sortField,
            'pageSize' => Yii::$app->settings->get('paginationSize'),
            'limitSpaces' => $limitSpaces,
            'limitActivites' => $limitActivites,
            'limitCommunes' => $limitCommunes,
            'limitCategories' => $limitCategories,
            'limitTypes' => $limitTypes,
            'distanceRecherche' => $this->distanceRecherche,
            'isCertifier' => $this->isCertifier,
            'startDatetime' => $this->startDatetime,
            'displayEvent' => $displayEvent,
            'endDatetime' => $this->endDatetime,
        ];

        $searchResultSet = Yii::$app->search->find($model->keyword, $options);
        $total = $searchResultSet->total;
        // Store static for use in widgets (e.g. fileList)
        self::$keyword = $model->keyword;

        $pagination = new Pagination;
        $pagination->totalCount = $searchResultSet->total;
        $pagination->pageSize = $searchResultSet->pageSize;

        $resultMap = [];
        if ($displayMap) {
            $searchMapResultSet = $searchResultSet;
            $optionsMap = [
                'page' => 0,
                'sortField' => 'productions',
                'pageSize' => $searchMapResultSet->total,
                'limitSpaces' => $limitSpaces,
                'limitActivites' => $limitActivites,
                'limitCommunes' => $limitCommunes,
                'limitCategories' => $limitCategories,
                'limitTypes' => $limitTypes,
                'distanceRecherche' => $this->distanceRecherche,
                'isCertifier' => $this->isCertifier,
                'displayEvent' => false,
                'model' => $modelClass,
                'type' => $type,
            ];

            $searchMapResultSet =  Yii::$app->search->find($model->keyword, $optionsMap);
            $resultMap = $searchMapResultSet->getResultInstances();
        }
        return $this->render('index', [
            'model' => $model,
            'results' => $searchResultSet->getResultInstances(),
            'resultMap' => $resultMap,
            'pagination' => $pagination,
            'total' => $total,
            'limitSpaces' => $limitSpaces,
            'limitActivites' => $limitActivites,
            'dataActivites' => $dataActivites,
            'valueActivites' => $valueActivites,
            'limitCategories' => $limitCategories,
            'dataCategories' => $dataCategories,
            'valueCategories' => $valueCategories,
            'limitTypes' => $limitTypes,
            'dataTypes' => $dataTypes,
            'valueTypes' => $valueTypes,
            'limitCommunes' => $limitCommunes,
            'distanceRecherche' => $this->distanceRecherche,
            'displayMap' => $displayMap,
            'displayEvent' => $displayEvent,
            'showResults' => $this->showResults,
            'isCertifier' => $this->isCertifier,
            'startDatetime' => $this->startDatetime,
            'endDatetime' => $this->endDatetime,
        ]);
    }
}
