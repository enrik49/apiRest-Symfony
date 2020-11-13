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

        return new JsonResponse(['status'=> 'Image created'], Response::HTTP_CREATED);

    }
    /**
     * @Route("image/{id}", name="get_one_image", methods={"GET"})
     */
    public function get($id): JsonResponse
    {
        $image = $this->imageRepository->findOneBy(['id' => $id]);
        $data = $this->setData($image);

        return new JsonResponse($data, Response::HTTP_OK);
    }

    /**
     * @Route("image", name="get_all_images", methods={"GET"})
     */
    public function getAll(): JsonResponse
    {
        $images = $this->imageRepository->findAll();
        $data = [];

        foreach ($images as $image) {
            $data[] = $this->setData($image);
        }

        return new JsonResponse($data, Response::HTTP_OK);
    }


    /**
     * @Route("image/{id}", name="delete_image", methods={"DELETE"})
     */
    public function delete($id): JsonResponse
    {
        $image = $this->imageRepository->findOneBy(['id' => $id]);

        $this->imageRepository->removeImage($image);

        return new JsonResponse(['status' => 'Image deleted'], Response::HTTP_OK);
    }

    private function setData($image){
        $data = [
            'id' => $image->getId(),
            'type' => $image->getType(),
            'url' => $image->getUrl(),
        ];
        return $data;
    }
}