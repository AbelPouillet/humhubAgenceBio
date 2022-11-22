<?php

use humhub\modules\cetcalModule\Events;
use humhub\widgets\TopMenu;
use humhub\modules\admin\widgets\AdminMenu;

return [
	'id' => 'cetcalModule',
	'class' => 'humhub\modules\cetcalModule\Module',
	'namespace' => 'humhub\modules\cetcalModule',
	'events' => [
        [TopMenu::class, TopMenu::EVENT_INIT, [Events::class, 'onTopMenuInit']],

        #Lien dans le AdminMenu
        [AdminMenu::class, AdminMenu::EVENT_INIT, [Events::class, 'onAdminMenuInit']]
	],
];
