<?php

namespace app\tests\unit\models;

use app\models\User;
use app\tests\unit\fixtures\UserFixture;
use Yii;

class UserTest extends \Codeception\Test\Unit
{
    /**
     * @var \UnitTester
     */
    protected $tester;

    public function _before(): void
    {
        Yii::$app->params[ 'JwtTokenSecret' ] = 'xFj8MFpGFQCC1JwRVCmF';
    }

    public function _fixtures(): array
    {
        return [ 'users' => UserFixture::class ];
    }

    public function testJwt(): void
    {
        $jwtToken = \app\models\User::createJwtToken(42, ['data' => 'test me']);
        $jwtDecode = \app\models\User::decodeJwtToken($jwtToken);

        $this->assertEquals($jwtDecode['payload']['data'], 'test me');
        $this->assertEquals($jwtDecode['payload']['jti'], 42);
    }

    public function testPassword(): void
    {
        $password = 'qwerty';
        $modelUser = new \app\models\User();
        $modelUser->setPassword($password);

        $this->assertTrue($modelUser->validatePassword($password));
    }

    public function testAuthKey(): void
    {
        $authKey = '8xUvEuWcNQk8jLzxuHVG';
        $modelUser = new \app\models\User();
        $modelUser->auth_key = $authKey;

        $this->assertTrue($modelUser->validateAuthKey($authKey));
    }

    public function testFindIdentityByAccessToken(): void
    {
        // jti (id) = 42
        $token = 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJkYXRhIjoidGVzdCBtZSIsImp0aSI6NDIsImlhdCI6MTUyNjI0MjUwNH0.1iKBEnG9XUQbXqx9PatQiZiqGWfZb2UaQ4PA5DeoryY';
        $modelUser = User::findIdentityByAccessToken($token);
        $modelNotFound = User::findIdentityByAccessToken('not found');

        $this->assertInstanceOf(User::class, $modelUser);
        $this->assertNull($modelNotFound);
    }

    public function testFindByUsername(): void
    {
        $username = 'test@test.com';
        $modelUser = User::findByUsername($username);
        $modelNotFound = User::findByUsername('not@found.com');

        $this->assertInstanceOf(User::class, $modelUser);
        $this->assertNull($modelNotFound);
    }
}
