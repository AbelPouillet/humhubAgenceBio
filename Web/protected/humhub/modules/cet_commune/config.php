<?php
use humhub\modules\cet_commune\Module;


return [
    'id' => 'cet_commune',
    'class' => Module::class,
    'isCoreModule' => true,
    'modules' => [
        'manage' => [
            'class' => 'humhub\modules\cet_commune\modules\manage\Module'
        ],
    ]
];
