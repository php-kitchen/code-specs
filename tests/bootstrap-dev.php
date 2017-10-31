<?php
$loader = require_once(dirname(__DIR__) . '/vendor/autoload.php');
$loader= ComposerAutoloaderInit826398540bc0e1f8e19d1044ba80c1ee::getLoader();
error_reporting(E_ALL);
$loader->addPsr4('\\PHPKitchen\\CodeSpecsCore\\', '../../CodeSpecsCore/src');
$loader->addPsr4('\\PHPKitchen\\CodeSpecsCore\\Mixin\\', '../../CodeSpecsCore/src/Mixin');
