<?php

namespace MorrisPhp\YouTubeApi\Repository;

use MorrisPhp\YouTubeApi\Model\Channel;
use PDO;

class ChannelRepository
{
    /**
     * @var PDO
     */
    private $pdo;

    /**
     * Repository constructor.
     * @param PDO $pdo
     */
    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    /**
     * @return array<Channel>
     */
    public function getAll(): array
    {
        $channels = [];
        $statement = $this->pdo->query('SELECT * FROM channels');

        foreach ($statement->fetchAll() as $record) {
            $channels[] = new Channel(
                $record['id'],
                $record['channel_name']
            );
        }

        return $channels;
    }
}
