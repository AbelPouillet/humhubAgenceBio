<?php

namespace humhub\modules\cet_commune\widgets;

use humhub\components\Widget;
use humhub\modules\content\components\ContentContainerController;
use humhub\modules\cet_commune\assets\CommuneChooserAsset;
use humhub\modules\space\models\Membership;
use humhub\modules\cet_commune\models\CetCommune;
use humhub\modules\cet_commune\permissions\SpaceDirectoryAccess;

use Yii;
use yii\db\Query;
use yii\helpers\Html;
use yii\helpers\Url;

/**
 * Class Chooser
 * @package humhub\modules\commune\widgets
 */
class Chooser extends Widget
{
    /**
     * @var bool
     * @since 1.10
     */
    public $lazyLoad = true;

    /**
     * @var string
     */
    public $viewName = '@cet_commune/widgets/views/communeChooser';

    /**
     * @return bool
     */
    public function beforeRun()
    {
        if (!$this->canRun()) {
            return false;
        }

        $this->configure();
        return parent::beforeRun();
    }

    /**
     * @inheritdoc
     * @throws \Throwable
     * @throws \yii\base\InvalidConfigException
     */
    public function run()
    {
        return $this->render($this->viewName, $this->getViewParams());
    }

    /**
     * @return bool
     */
    protected function canRun()
    {
        return !Yii::$app->user->isGuest;
    }

    /**
     * Configure widget before run, used to register assets and js config
     */
    protected function configure()
    {
        CommuneChooserAsset::register($this->view);
        $this->view->registerJsConfig('commune.chooser', $this->getJsConfigParams());
    }

    /**
     * @return array
     * @throws \Throwable
     * @throws \yii\base\InvalidConfigException
     */
    protected function getViewParams()
    {
        return [
            'currentSpace' => $this->getCurrentSpace(),
            'canCreateSpace' => $this->canCreateSpace(),
            'canAccessDirectory' => Yii::$app->user->can(SpaceDirectoryAccess::class),
            'renderedItems' => $this->renderItems(),
            'noSpaceHtml' => $this->getNoSpaceHtml(),
        ];
    }

    /**
     * @return array
     */
    protected function getJsConfigParams()
    {
        return [
            'lazyLoad' => $this->lazyLoad,
            'noSpace' => $this->getNoSpaceHtml(),
            'remoteSearchUrl' => Url::to(['/cet_commune/browse/search']),
            'lazySearchUrl' => Url::to(['/cet_commune/browse/search-lazy']),
            'text' => [
                'info.remoteAtLeastInput' => "Pour chercher une autre commune taper ses 2 premiers caractaires",
                'info.emptyOwnResult' => "Pas de commune correspondant trouvée",
                'info.emptyResult' => "Pas de résultat pour les filtres donnés",
            ],
        ];
    }

    /**
     * @return string
     */
    protected function getNoSpaceHtml()
    {
        $html = '<i class="fa fa-dot-circle-o"></i><br>' . "Mes communes" . '<b class="caret"></b>';
        return Html::tag('div', $html, ['class' => 'no-space']);
    }

    /**
     * @param string $output
     * @return mixed|string
     * @throws \Throwable
     */
    protected function renderItems($output = '')
    {
        if ($this->lazyLoad) {
            return $output;
        }

        // render membership items
        foreach ($this->getMemberships() as $membership) {
            $result = CommuneChooserItem::widget([
                'space' => $membership->space, 'updateCount' => $membership->countNewItems(), 'isMember' => true
            ]);

            $output = $this->attachItem($output, $result);
        }

        // render follow spaces
        foreach ($this->getFollowSpaces() as $space) {
            $result = CommuneChooserItem::widget(['space' => $space, 'isFollowing' => true]);
            $output = $this->attachItem($output, $result);
        }

        return $output;
    }

    /**
     * If array passed to ouput, it will be added as ['output' => 'string']
     * This is used for passing rendered items as json array to lazy load
     * See getLazyLoadResult of the same class
     *
     * @param $output
     * @param $result
     * @return mixed|string
     */
    protected function attachItem($output, $result)
    {
        if (is_array($output)) {
            $output[] = ['output' => $result];
        } elseif (is_string($output)) {
            $output .= $result;
        }

        return $output;
    }

    /**
     * @return Space[]
     * @throws \Throwable
     */
    protected function getFollowSpaces()
    {
        return [];
    }

    /**
     * @return Membership[]
     * @throws \Throwable
     */
    protected function getMemberships()
    {
        return [];
    }


    /**
     * @return Space | null
     */
    protected function getCurrentSpace()
    {
        if (!Yii::$app->controller instanceof ContentContainerController) {
            return null;
        }

        if ((Yii::$app->controller->contentContainer ?? null) instanceof CetCommune) {
            return Yii::$app->controller->contentContainer;
        }

        return null;
    }

    /**
     * Returns the membership query
     *
     * @return Query
     * @deprecated since version 1.2
     */
    protected function getMembershipQuery()
    {
        $query = Membership::find()->joinWith('space')
            ->where(['space_membership.user_id' => Yii::$app->user->id, 'space_membership.status' => Membership::STATUS_MEMBER]);

        if (Yii::$app->getModule('space')->settings->get('spaceOrder') == 0) {
            $query->orderBy('name ASC');
        } else {
            $query->orderBy('last_visit DESC');
        }

        return $query;
    }

    /**
     * @param CetCommune $commune
     * @param bool $withChooserItem
     * @param array $itemOptions
     * @return array
     * @throws \Exception
     */
    public static function getSpaceResult($commune, $withChooserItem = true, $itemOptions = [])
    {
        $communeInfo = [
            'id' => $commune->id, 'title' => $commune->commune . ' ' . $commune->code_postal,
            'image' => Image::widget(['commune' => $commune, 'width' => 24])
        ];

        if ($withChooserItem) {
            $options = array_merge(['commune' => $commune], $itemOptions);
            $communeInfo['output'] = CommuneChooserItem::widget($options);
        }

        return $communeInfo;
    }

    /**
     * @return mixed|string
     * @throws \Throwable
     */
    public static function getLazyLoadResult()
    {
        $widget = new self(['lazyLoad' => false]);
        return $widget->renderItems([]);
    }
}
