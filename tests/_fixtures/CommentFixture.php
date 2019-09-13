<?php

namespace aka03\comments\tests\_fixtures;

use yii\test\ActiveFixture;

class CommentFixture extends ActiveFixture
{
    public $modelClass = 'aka03\comments\models\Comment';
    public $dataFile = '@aka03/comments/tests/_fixtures/data/comment.php';
}
