<?php

namespace aka03\comments\modules\testPage;

use yii\base\BootstrapInterface;

class Bootstrap implements BootstrapInterface
{
    /**
     * @inheritdoc
     */
    public function bootstrap($app)
    {
        $app->getUrlManager()->addRules(
            [
                'test-page' => 'testPage/default',
                'test-page/<action>' => 'testPage/default/<action>'
            ]
        );
    }
}
