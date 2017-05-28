<?php
require_once __DIR__. '/../vendor/autoload.php';

$featureName = "feature-comment";
$env = new \aversion\ClientEnv();
$env->platform = "android";
$env->appVersion = "2.0.1";

\aversion\Features::init($env);
$result = \aversion\Features::isEnable($featureName);

var_dump($result);
