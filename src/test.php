<?php

$featureName = "";

$env = new \ug\client\ClientEnv();
$env->appName = "";

\ug\client\Features::init($env);

\ug\client\Features::isEnable($featureName);