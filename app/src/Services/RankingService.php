<?php

namespace App\Services;

use App\Repositories\MovementRepository;
use Doctrine\DBAL\Exception;

class RankingService
{
    private MovementRepository $movementRepo;

    public function __construct()
    {
        $this->movementRepo = new MovementRepository();
    }

    /**
     * Main public method to get ranking for a movement.
     *
     * @param string $movementInput
     * @return array
     * @throws Exception
     */
    public function getRanking(string $movementInput): array
    {
        $movement = $this->movementRepo->findMovement($movementInput);
        
        if (!$movement) {
            http_response_code(404);
            return ['error' => 'Movement not found.'];
        }

        $records = $this->movementRepo->fetchPersonalRecords($movement['id']);
        $ranking = $this->calculateRanking($records);

        return [
            'movement' => $movement['name'],
            'ranking' => $ranking,
        ];
    }

    private function calculateRanking(array $records): array
    {
        $ranking = [];
        $position = 1;
        $lastValue = null;
        
        foreach ($records as $record) {
            if ($record['value'] < $lastValue) {
                $position++;
            }

            $lastValue = $record['value'];

            $ranking[] = [
                'user'     => $record['user_name'],
                'record'   => $record['value'],
                'position' => $position,
                'date' => date('Y-m-d', strtotime($record['date'])),
            ];
        }

        return $ranking;
    }
}
