<?php

namespace App\Controllers;

use App\Services\RankingService;

class RankingController
{
    private RankingService $rankingService;

    public function __construct()
    {
        $this->rankingService = new RankingService();
    }

    /**
     * Handle GET /ranking/{movement}
     *
     * @param string $movement
     * @return string JSON response
     */
    public function show(string $movement): string
    {
        try {
            $data = $this->rankingService->getRanking($movement);
            header('Content-Type: application/json');
            return json_encode($data, JSON_PRETTY_PRINT);
        } catch (\Exception $e) {
            http_response_code(500);
            return json_encode([
                'error' => $e->getMessage() . ', file: ' . $e->getFile() . "line: " . $e->getLine()
            ]);
        }
    }
}
