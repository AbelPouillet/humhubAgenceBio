<?php

namespace humhub\modules\cet_type\widgets;

use humhub\components\Widget;
use humhub\modules\content\components\ContentContainerController;
use humhub\modules\cet_type\assets\TypeChooserAsset;
use humhub\modules\space\models\Membership;
use humhub\modules\cet_type\models\CetType;
use humhub\modules\cet_type\permissions\SpaceDirectoryAccess;

use Yii;
use yii\db\Query;
use yii\helpers\Html;
use yii\helpers\Url;

/**
 * Class Chooser
 * @package humhub\modules\type\widgets
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
    public $viewName = '@cet_type/widgets/views/typeChooser';

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
        TypeChooserAsset::register($this->view);
        $this->view->registerJsConfig('type.chooser', $this->getJsConfigParams());
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
            'remoteSearchUrl' => Url::to(['/cet_type/browse/search']),
            'lazySearchUrl' => Url::to(['/cet_type/browse/search-lazy']),
            'text' => [
                'info.remoteAtLeastInput' => "Pour chercher un autre type taper ses 2 premiers caractaires",
                'info.emptyOwnResult' => "Pas de type correspondant trouvée",
                'info.emptyResult' => "Pas de résultat pour les filtres donnés",
            ],
        ];
    }

    /**
     * @return string
     */
    protected function getNoSpaceHtml()
    {
        $html = '<i class="fa fa-dot-circle-o"></i><br>' . "Mes types" . '<b class="caret"></b>';
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
            $result = TypeChooserItem::widget([
                'space' => $membership->space, 'updateCount' => $membership->countNewItems(), 'isMember' => true
            ]);

            $output = $this->attachItem($output, $result);
        }

        // render follow spaces
        foreach ($this->getFollowSpaces() as $space) {
            $result = TypeChooserItem::widget(['space' => $space, 'isFollowing' => true]);
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

        if ((Yii::$app->controller->contentContainer ?? null) instanceof CetType) {
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
     * @param CetType $type
     * @param bool $withChooserItem
     * @param array $itemOptions
     * @return array
     * @throws \Exception
     */
    public static function getSpaceResult($type, $withChooserItem = true, $itemOptions = [])
    {
        $typeInfo = [
            'id' => $type->id, 'title' => $type->type . ' ' . $type->sous_type,
            'image' => Image::widget(['type' => $type, 'width' => 24])
        ];

        if ($withChooserItem) {
            $options = array_merge(['type' => $type], $itemOptions);
            $typeInfo['output'] = TypeChooserItem::widget($options);
        }

        return $typeInfo;
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
