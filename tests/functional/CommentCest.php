<?php

namespace aka03\comments\tests\functional;

use aka03\comments\tests\FunctionalTester;
use aka03\comments\tests\_fixtures\UserFixture;
use aka03\comments\tests\_fixtures\CommentFixture;

class CommentCest
{
    public function _fixtures()
    {
        return [
            'users' => UserFixture::className(),
            'comments' => CommentFixture::className(),
        ];
    }

    public function _before(FunctionalTester $I)
    {
    }

    protected function formParams($username, $message)
    {
        return [
            'Comment[guest_name]' => $username,
            'Comment[message]' => $message,
        ];
    }

    public function addValidCommentOnUserIsGuest(FunctionalTester $I)
    {
        $I->amOnRoute('test-page');
        $I->submitForm('#comment-form', $this->formParams('Test User', 'Test Message'));

        $I->see('Test User', '.media-body .mb-1 .text-primary');
        $I->see('Test Message', '.media-body .message-block .message-text');
    }

    public function addValidCommentOnLoggedUser(FunctionalTester $I)
    {
        $I->amLoggedInAs(1);
        $I->amOnRoute('test-page');
        $I->submitForm('#comment-form', $this->formParams(null, 'Test Message'));

        $I->see('Test Message', '.media-body .message-block .message-text');
    }
}
