<?php

namespace MorrisPhp\YouTubeApi\Model;

use DateTime;
use InvalidArgumentException;
use JsonSerializable;

class Video implements JsonSerializable
{
    const DATE_FORMAT = 'Y-m-d';

    /**
     * @var ?int
     */
    private $id;

    /**
     * @var ?string
     */
    private $title;

    /**
     * @var ?DateTime
     */
    private $date;

    /**
     * Video constructor.
     * @param array $props
     * @throws \Exception
     */
    public function __construct(array $props)
    {
        $this->setId($props['id'] ?? $this->id);
        $this->setTitle($props['title'] ?? $this->title);
        $this->setDate($props['date'] ?? $this->date);
    }

    /**
     * @return mixed
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id): void
    {
        $this->id = (int)$id;
    }

    /**
     * @return mixed
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param mixed $title
     */
    public function setTitle($title): void
    {
        $this->title = $title;
    }

    /**
     * @return array
     */
    public function jsonSerialize(): array
    {
        return array_filter([
            'id' => $this->id,
            'title' => $this->title,
            'date' => $this->getDate() ? $this->getDate()->format(self::DATE_FORMAT) : null
        ]);
    }

    /**
     * @return mixed
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * @param $date
     * @throws \Exception
     */
    public function setDate($date): void
    {
        if ($date instanceof DateTime) {
            $this->date = $date;
        } else {
            if (is_string($date)) {
                $this->date = new DateTime($date);
            } else {
                if (empty($date)) {
                    $this->date = null;
                } else {
                    throw new InvalidArgumentException();
                }
            }
        }
    }
}
