<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;
use yii\db\Expression;
use yii\web\IdentityInterface;
use yii\web\BadRequestHttpException;
use yii\base\InvalidCallException;
use yii\helpers\ArrayHelper;
use Firebase\JWT\JWT;
use Firebase\JWT\BeforeValidException;
use Firebase\JWT\ExpiredException;
use Firebase\JWT\SignatureInvalidException;

/**
 * This is the model class for table "{{%user}}".
 *
 * @property integer $id
 * @property string $email
 * @property string $password
 * @property string $auth_key
 * @property string $created_at
 * @property string $updated_at
 */
class User extends ActiveRecord implements IdentityInterface
{
    /**
     * @inheritdoc
     */
    public static function tableName(): string
    {
        return '{{%user}}';
    }

    /**
     * @inheritdoc
     */
    public function rules(): array
    {
        return [];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels(): array
    {
        return [
            'id' => '#',
            'email' => 'Email',
            'password' => 'Пароль',
            'auth_key' => 'Auth Key',
            'created_at' => 'Дата создания',
            'updated_at' => 'Дата обновления',
        ];
    }

    /**
     * @inheritdoc
     */
    public function beforeSave($insert): bool
    {
        if (!parent::beforeSave($insert)) {
            return false;
        }

        if ($this->isNewRecord) {
            $this->created_at = new Expression('NOW()');
            $this->setPassword($this->password);
            $this->auth_key = Yii::$app->security->generateRandomString();
        }

        $this->updated_at = new Expression('NOW()');

        return true;
    }

    /**
     * @inheritdoc
     */
    public static function findIdentity($id)
    {
        return self::findOne($id);
    }

    /**
     * @inheritdoc
     */
    public static function findIdentityByAccessToken($token, $type = null): ?self
    {
        try {
            $result = self::decodeJwtToken($token);
        } catch (\Exception $e) {
            // Что-то не так, говорим типа нет такого пользователя
            return null;
        }

        $id = $result[ 'payload' ][ 'jti' ];
        return self::findOne($id);
    }

    /**
     * @param $username
     * @return User|null
     */
    public static function findByUsername(string $username): ?self
    {
        return self::find()->where([ 'email' => $username ])->one();
    }

    /**
     * @inheritdoc
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @inheritdoc
     */
    public function getAuthKey(): string
    {
        return $this->auth_key;
    }

    /**
     * @inheritdoc
     */
    public function validateAuthKey($authKey): bool
    {
        return $this->auth_key === $authKey;
    }

    /**
     * @param string $password
     * @return boolean
     */
    public function validatePassword(string $password): bool
    {
        try {
            return Yii::$app->security->validatePassword($password, $this->password);
        } catch (\Exception $e) {
            return false;
        }
    }

    /**
     * Устанавливает пароль.
     * @param string $password
     * @throws \yii\base\Exception
     */
    public function setPassword(string $password): void
    {
        if (!$password) {
            return;
        }

        $this->password = Yii::$app->security->generatePasswordHash($password);
    }

    /**
     * @param integer $id
     * @param array $payload
     * @param string $algorithm
     * @return string
     * @throws \yii\base\InvalidCallException
     */
    public static function createJwtToken(int $id, array $payload = [], string $algorithm = 'HS256'): string
    {
        $allowedAlgorithms = array_keys(JWT::$supported_algs);
        if (!in_array($algorithm, $allowedAlgorithms)) {
            throw new InvalidCallException("The algorithm '{$algorithm}' is not allowed");
        }

        $payload = ArrayHelper::merge($payload, [
            'jti' => $id,
            'iat' => time(),
        ]);

        return JWT::encode($payload, Yii::$app->params[ 'JwtTokenSecret' ], $algorithm);
    }

    /**
     * @param string $token
     * @return array
     * @throws BadRequestHttpException
     */
    public static function decodeJwtToken($token): array
    {
        try {
            $payload = JWT::decode($token, Yii::$app->params[ 'JwtTokenSecret' ], array_keys(JWT::$supported_algs));
            // Токен ок
            list($headBase64) = explode('.', $token);
            $header = JWT::jsonDecode(JWT::urlsafeB64Decode($headBase64));
        } catch (SignatureInvalidException $e) {
            // Подпись не верна
            throw new BadRequestHttpException('Jwt token signature is invalid');
        } catch (BeforeValidException $e) {
            // Пока токен не верен, но потом будет
            throw new BadRequestHttpException('Jwt token is not yet valid');
        } catch (ExpiredException $e) {
            // Пока токен не верен, но потом будет
            throw new BadRequestHttpException('Jwt token is expired');
        } catch (\UnexpectedValueException $e) {
            // Фигня какая-то случилась
            throw new BadRequestHttpException($e->getMessage());
        }

        return [ 'header' => ArrayHelper::toArray($header), 'payload' => ArrayHelper::toArray($payload) ];
    }
}
