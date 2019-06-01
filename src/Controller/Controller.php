<?php

namespace MorrisPhp\YouTubeApi\Controller;

use MorrisPhp\YouTubeApi\Repository\Repository;
use MorrisPhp\YouTubeApi\YouTube\Service as YoutubeServiceWrapper;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class Controller
{
    /**
     * @var YouTubeYoutubeServiceWrapper
     */
    private $service;

    /**
     * @var Repository
     */
    private $repository;

    /**
     * Controller constructor.
     * @param YouTubeYoutubeServiceWrapper $service
     * @param Repository $repository
     */
    public function __construct(YoutubeServiceWrapper $service, Repository $repository)
    {
        $this->service = $service;
        $this->repository = $repository;
    }

    public function create(ServerRequestInterface $request, ResponseInterface $response, array $args)
    {
        $id = $this->service->getIdForChannel('globalmtb');

        $videos = $this->service->getVideosForChannel($id);

        foreach ($videos as $video) {
            $this->repository->add($video);
        }

        return $response->withStatus(200);
    }
}
