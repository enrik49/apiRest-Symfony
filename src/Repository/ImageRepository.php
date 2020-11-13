<?php

namespace App\Repository;

use App\Entity\Image;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\ORM\EntityManagerInterface;

/**
 * @method Image|null find($id, $lockMode = null, $lockVersion = null)
 * @method Image|null findOneBy(array $criteria, array $orderBy = null)
 * @method Image[]    findAll()
 * @method Image[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ImageRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry, EntityManagerInterface $manager)
    {
        parent::__construct($registry, Image::class);
        $this->manager = $manager;
    }

    public function saveImage($type, $url){
        $newImage = new Image();
        $newImage
                ->setType($type)
                ->setUrl($url);

        $this->manager->persist($newImage);
        $this->manager->flush();
    }

    public function removeImage(Image $image){
        $this->manager->remove($image);
        $this->manager->flush();
    }
    
}
