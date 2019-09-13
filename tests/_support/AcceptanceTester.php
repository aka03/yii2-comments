<?php
namespace aka03\comments\tests;

use Yii;
/**
 * Inherited Methods
 * @method void wantToTest($text)
 * @method void wantTo($text)
 * @method void execute($callable)
 * @method void expectTo($prediction)
 * @method void expect($prediction)
 * @method void amGoingTo($argumentation)
 * @method void am($role)
 * @method void lookForwardTo($achieveValue)
 * @method void comment($description)
 * @method \Codeception\Lib\Friend haveFriend($name, $actorClass = NULL)
 *
 * @SuppressWarnings(PHPMD)
*/
class AcceptanceTester extends \Codeception\Actor
{
    use _generated\AcceptanceTesterActions;

    public function login($username, $password)
    {
        $I = $this;

        if ($I->loadSessionSnapshot('login')) {
            return;
        }

        $I->amOnPage('site/login');
        $I->seeInTitle('Login');

        $I->submitForm('#login-form', [
            'LoginForm[username]' => $username,
            'LoginForm[password]' => $password
        ]);

        $I->wait(1);

        $I->saveSessionSnapshot('login');
    }

    public function clickAndConfirm($functionName, $params)
    {
        global $argv;
        $isCoverage = false;
        foreach ($argv as $key => $arg) {
            if (strpos($arg, 'coverage') !== false) {
                $isCoverage = true;
                break;
            }
        }
        if ($isCoverage) {
            $this->executeJS('
                var realConfirm=window.confirm;
                window.confirm=function(){
                    window.confirm=realConfirm;
                    return true;
                };');
            call_user_func_array(array($this, $functionName), $params);
        }
        else {
            call_user_func_array(array($this, $functionName), $params);
            $this->acceptPopup();
        }
    }
}
