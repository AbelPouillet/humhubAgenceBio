<?php

use humhub\modules\producteursImport\Events;
use humhub\widgets\TopMenu;
use humhub\modules\admin\widgets\AdminMenu;

return [
	'id' => 'producteursImport',
	'class' => 'humhub\modules\producteursImport\Module',
	'namespace' => 'humhub\modules\producteursImport',
	'events' => [
        [TopMenu::class, TopMenu::EVENT_INIT, [Events::class, 'onTopMenuInit']],

        #Lien dans le AdminMenu
        [AdminMenu::class, AdminMenu::EVENT_INIT, [Events::class, 'onAdminMenuInit']]
	],
];
