<?php

namespace App\Controller;
use App\Repository\ImageRepository;
use App\Repository\MachineRepository;
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
    private $machineRepository;

    public function __construct(ImageRepository $imageRepository, MachineRepository $machineRepository){
        $this->imageRepository = $imageRepository;
        $this->machineRepository = $machineRepository;
    }

    /**
     * @Route("image", name="add_image", methods={"POST"})
     */
    public function add(Request $request): JsonResponse{
        $data = json_decode($request->getContent(), true);

        $url = $data['url'];
        $type = $data['type'];
        $id_machine = $data['id_machine'];
        $machine = $this->machineRepository->findOneBy(['id' => $id_machine]);

        if(empty($url) || empty($type)) {
            throw new NotFoundHttpException('Expecting..');
        }
        
        $image = $this->imageRepository->saveImage($type, $url,$machine);

        return new JsonResponse(['status'=> 'Image created'], Response::HTTP_CREATED);

    }
    /**
     * @Route("image/{id}", name="get_one_image", methods={"GET"})
     */
    public function get($id): JsonResponse
    {
        $image = $this->imageRepository->findOneBy(['id' => $id]);
        $data = $image->setData();

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
            $data[] = $image->setData();
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
}