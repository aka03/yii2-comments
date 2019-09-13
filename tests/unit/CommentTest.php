<?php

namespace aka03\comments\tests\unit;

use aka03\comments\models\Comment;
use Yii;
use common\models\User;
use Codeception\Test\Unit;
use aka03\comments\tests\_fixtures\UserFixture;
use aka03\comments\tests\_fixtures\CommentFixture;

class CommentTest extends Unit
{
    /**
     * @var \aka03\comments\tests\UnitTester
     */
    protected $tester;

    protected function _before()
    {
        $this->tester->haveFixtures([
            'users' =>  UserFixture::className(),
            'comments' => CommentFixture::className(),
        ]);
    }

    // tests
    public function testGetUsernameOnLoggedUser()
    {
        $comment = $this->tester->grabFixture('comments', 'comment1');
        expect($comment->getUsername())->equals('user11');
    }

    public function testGetUsernameOnUserIsGuest()
    {
        $comment = $this->tester->grabFixture('comments', 'comment2');
        expect($comment->getUsername())->equals('John');
    }

    public function testCurrentUserIsNotAuthor()
    {
        $comment = $this->tester->grabFixture('comments', 'comment2');
        $identity = User::findOne(['username' => 'user22']);

        Yii::$app->user->login($identity);
        expect($comment->isAuthor())->false();
    }

    public function testCurrentUserIsAuthor()
    {
        $comment = $this->tester->grabFixture('comments', 'comment1');
        $identity = User::findOne(['username' => 'user11']);

        Yii::$app->user->login($identity);
        expect($comment->isAuthor())->true();
    }

    public function testShowCreatedTime()
    {
        $comment = $this->tester->grabFixture('comments', 'comment2');
        $createdAt = Yii::$app->formatter->asRelativeTime($comment->created_at);
        expect($comment->getTime())->equals($createdAt);
    }

    public function testShowUpdatedTime()
    {
        $comment = $this->tester->grabFixture('comments', 'comment1');
        $updatedAt = 'Updated ' . Yii::$app->formatter->asRelativeTime($comment->updated_at);
        expect($comment->getTime())->equals($updatedAt);
    }

    public function testSuccessfullySaveOnUserIsGuest()
    {
        $model = new Comment(['guest_name' => 'anonymous', 'message' => 'Test Message']);
        $model->save();

        $comment = Comment::findOne(['guest_name' => 'anonymous', 'message' => 'Test Message']);
        expect($comment->guest_name)->equals('anonymous');
        expect($comment->message)->equals('Test Message');
    }

    public function testSuccessfullySaveOnLoggedUser()
    {
        $identity = User::findOne(['username' => 'user11']);
        Yii::$app->user->login($identity);

        $model = new Comment(['message' => 'Test Message']);
        $model->user_id = Yii::$app->user->identity->id;
        $model->save();

        $comment = Comment::findOne(['user_id' => 1, 'message' => 'Test Message 1']);
        expect($comment->user_id)->equals(1);
        expect($comment->message)->equals('Test Message 1');
    }
}
