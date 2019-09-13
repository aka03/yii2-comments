<?php

namespace aka03\comments\tests;

use aka03\comments\tests\_fixtures\CommentFixture;
use aka03\comments\tests\_fixtures\UserFixture;
use aka03\comments\tests\AcceptanceTester;

class CommentCest
{
    public function _fixtures()
    {
        return [
            'users' => UserFixture::className(),
            'comments' => CommentFixture::className(),
        ];
    }

    // tests
    public function updateCancel(AcceptanceTester $I)
    {
        $I->login('user11', 'user11');
        $I->amOnPage('/test-page');

        $I->see('Comments (2)', 'h1.mt-3');
        $I->see('Edit');
        $I->click('Edit');

        $I->see('Cancel');
        $I->see('Send');

        $I->seeInField('.media-body .message-block textarea', 'Test Message 1');
        $I->fillField('.media-body .message-block textarea', 'Test Message 123');
        $I->executeJS('$(".cancel-comment").click()');

        $I->see('Test Message 1', '.media-body .message-block .message-text');
    }

    public function updateSave(AcceptanceTester $I)
    {
        $I->login('user11', 'user11');
        $I->amOnPage('/test-page');
        $I->see('Comments (2)', 'h1.mt-3');

        $I->see('Edit');
        $I->click('Edit');

        $I->see('Cancel');
        $I->see('Send');

        $I->seeInField('.media-body .message-block textarea', 'Test Message 1');
        $I->fillField('.media-body .message-block textarea', 'Test Message 123');
        $I->executeJS('$(".save-comment").click()');

        $I->see('Test Message 123', '.media-body .message-block .message-text');
    }

    public function delete(AcceptanceTester $I)
    {
        $I->login('user11', 'user11');
        $I->amOnPage('/test-page');
        $I->see('Comments (2)', 'h1.mt-3');

        $I->see('Edit');
        $I->seeElement('.comment-block', ['data-id' => '1']);

        $I->moveMouseOver('.message-block');
        $I->see('×');

        $I->clickAndConfirm('click', ['×']);
        $I->wait(1);

        $I->see('Comments (1)', 'h1.mt-3');
        $I->dontSeeElement('.comment-block', ['data-id' => '1']);
        $I->dontSeeRecord('aka03\comments\models\Comment', ['id' => 1]);
    }
}
