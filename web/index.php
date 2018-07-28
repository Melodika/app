<?php // phpcs:ignore

require __DIR__ . '/../vendor/autoload.php';

$dotenv = new Dotenv\Dotenv(dirname(__DIR__));
$dotenv->load();

define('YII_ENV', getenv('APPLICATION_ENV') ?: 'prod');
define('YII_DEBUG', (bool) getenv('APPLICATION_DEBUG') ?: false);

if (YII_DEBUG === true) {
    ini_set('display_errors', 'on');
    error_reporting(E_ALL);
} else {
    ini_set('display_errors', 'off');
    error_reporting(0);
}

require __DIR__ . '/../vendor/yiisoft/yii2/Yii.php';
$config = require __DIR__ . '/../config/web.php';

(new yii\web\Application($config))->run();
