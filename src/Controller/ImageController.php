<?php

namespace App\Controller;
use App\Repository\ImageRepository;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class ImageController
 * @package App\Controller
 *
 * @Route(path="/api/")
 */
class ImageController{

    private $imageRepository;

    public function __construct(ImageRepository $imageRepository){
        $this->imageRepository = $imageRepository;
    }

    /**
     * @Route("image", name="add_image", methods={"POST"})
     */
    public function add(Request $request): JsonResponse{
        $data = json_decode($request->getContent(), true);

        $url = $data['url'];
        $type = $data['type'];

        if(empty($url) || empty($type)) {
            throw new NotFoundHttpException('Expecting..');
        }

        $this->imageRepository->saveImage($type, $url);

        return new JsonResponse(['status'=> 'Machine created'], Response::HTTP_CREATED);

    }
}