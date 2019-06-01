<?php

namespace MorrisPhp\YouTubeApi\Repository;

use DateTime;
use MorrisPhp\YouTubeApi\Exception\NotFoundException;
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
    public function add(Video $video) : bool
    {
        $statement = $this->pdo->prepare('
            INSERT INTO videos (title, `date`)
                 VALUES (:title, :published_at)
        ');

        return $statement->execute([
            'title' => substr($video->getTitle(), 0, self::TITLE_MAX_WIDTH),
            'published_at' => $video->getDate()->format(self::DATE_FORMAT)
        ]);
    }

    /**
     * @return array<Video>
     */
    public function getAll() : array
    {
        $statement = $this->pdo->query('SELECT * FROM videos');

        return array_map(function ($record) {
            return new Video($record);
        }, $statement->fetchAll());
    }

    /**
     * @return array<Video>
     */
    public function getAllByTerm(string $searchTerm) : array
    {
        $statement = $this->pdo->prepare('SELECT * FROM videos WHERE title LIKE :search_term');
        $statement->execute(['search_term' => "%$searchTerm%"]);

        return array_map(function ($record) {
            unset($record['date']);
            return new Video($record);
        }, $statement->fetchAll());
    }

    /**
     * @param int|string $id
     * @return Video
     */
    public function get($id) : Video
    {
        $statement = $this->pdo->prepare('SELECT * FROM videos WHERE id = :id');
        $statement->execute(['id' => $id]);
        $record = $statement->fetch();

        if (!$record) {
            throw new NotFoundException();
        }

        return new Video($record);
    }

    /**
     * @param $id
     * @return bool
     */
    public function delete($id) : bool
    {
        $statement = $this->pdo->prepare('DELETE FROM videos WHERE id = :id');
        $statement->execute(['id' => $id]);
        return (bool) $statement->rowCount();
    }

}
