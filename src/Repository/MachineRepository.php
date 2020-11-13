<?php

namespace App\Repository;

use App\Entity\Machine;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\ORM\EntityManagerInterface;

/**
 * @method Machine|null find($id, $lockMode = null, $lockVersion = null)
 * @method Machine|null findOneBy(array $criteria, array $orderBy = null)
 * @method Machine[]    findAll()
 * @method Machine[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MachineRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry, EntityManagerInterface $manager)
    {
        parent::__construct($registry, Machine::class);
        $this->manager = $manager;
    }

    public function saveMachine($brand, $model, $manufacturer, $price){
        $newMachine = new Machine();
        $newMachine
                ->setBrand($brand)
                ->setModel($model)
                ->setManufacturer($manufacturer)
                ->setPrice($price);

        $this->manager->persist($newMachine);
        $this->manager->flush();
    }

    public function updateMachine(Machine $machine): Machine{
        $this->manager->persist($machine);
        $this->manager->flush();

        return $machine;
    }
    public function removeMachine(Machine $machine){
        $this->manager->remove($machine);
        $this->manager->flush();
    }
    
}
