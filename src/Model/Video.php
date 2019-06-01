<?php

namespace MorrisPhp\YouTubeApi\Model;

use DateTime;
use JsonSerializable;

class Video implements JsonSerializable
{
    const DATE_FORMAT = 'Y-m-d';

    /**
     * @var string
     */
    private $title;

    /**
     * @var DateTime
     */
    private $publishedAt;

    /**
     * Note this may be null if it hasn't
     * been persisted to the db yet
     *
     * @var mixed - int|stringy-int|null
     */
    private $id;

    /**
     * Video constructor.
     * @param int $id
     * @param string $title
     * @param DateTime $publishedAt
     */
    public function __construct(string $title, DateTime $publishedAt, $id = null)
    {
        $this->title = $title;
        $this->publishedAt = $publishedAt;
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @return DateTime
     */
    public function date(): DateTime
    {
        return $this->publishedAt;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return array
     */
    public function jsonSerialize() : array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'date' => $this->date()->format(self::DATE_FORMAT)
        ];
    }

}
