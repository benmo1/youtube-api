<?php

namespace MorrisPhp\YouTubeApi\Repository;

use DateTime;
use MorrisPhp\YouTubeApi\Model\Video;
use PDO;

class VideoRepository
{
    const DATE_FORMAT = 'Y-m-d';
    const TITLE_MAX_WIDTH = 100;

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
     * @param Video $video
     * @return bool
     */
    public function add(Video $video)
    {
        $statement = $this->pdo->prepare('
            INSERT INTO videos (title, `date`)
                 VALUES (:title, :published_at)
        ');

        return $statement->execute([
            'title' => substr($video->getTitle(), 0, self::TITLE_MAX_WIDTH),
            'published_at' => $video->date()->format(self::DATE_FORMAT)
        ]);
    }

    /**
     * @return array<Video>
     */
    public function getAll()
    {
        $videos = [];
        $statement = $this->pdo->query('SELECT * FROM videos');

        foreach ($statement->fetchAll() as $record) {
            $videos[] = new Video(
                $record['title'],
                new DateTime($record['date']),
                (int) $record['id']
            );
        }

        return $videos;
    }
}
