<?php

use FastRoute\RouteCollector;
use App\Controllers\RankingController;

return function(RouteCollector $r) {
    $r->addRoute('GET', '/ranking/{movement}', [RankingController::class, 'show']);
};
