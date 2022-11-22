<?php
use humhub\modules\search\engine\Search;
use humhub\modules\cet_entite\Module;
use humhub\modules\cet_entite\Events;

return [
    'id' => 'cet_entite',
    'class' => Module::class,
    'isCoreModule' => true,
    'modules' => [
        'manage' => [
            'class' => 'humhub\modules\cet_entite\modules\manage\Module'
        ],
    ],
    'events' => [
        [
            Search::class, Search::EVENT_ON_REBUILD, [Events::class, 'onSearchRebuild']
        ]
    ]
];
