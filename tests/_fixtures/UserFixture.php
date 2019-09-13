<?php

namespace aka03\comments\tests\_fixtures;

use yii\test\ActiveFixture;

class UserFixture extends ActiveFixture
{
    public $modelClass = 'common\models\User';
    public $dataFile = '@aka03/comments/tests/_fixtures/data/user.php';
}
