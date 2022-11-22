<?php

use humhub\modules\example\Events;
use humhub\widgets\TopMenu;
use humhub\modules\admin\widgets\AdminMenu;

return [
	'id' => 'example',
	'class' => 'humhub\modules\example\Module',
	'namespace' => 'humhub\modules\example',
	'events' => [
        //array('class' => TopMenu::className(), 'event' => TopMenu::EVENT_INIT, 'callback' => array(Event::class, 'onTopMenuInit')),
        [AdminMenu::class, AdminMenu::EVENT_INIT, [Events::class, 'onAdminMenuInit']]
	],
];
