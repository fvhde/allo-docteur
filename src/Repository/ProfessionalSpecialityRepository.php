<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\Professional;
use App\Entity\Professional\ProfessionalSpeciality;
use App\Entity\Speciality;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<ProfessionalSpeciality>
 *
 * @method ProfessionalSpeciality|null find($id, $lockMode = null, $lockVersion = null)
 * @method ProfessionalSpeciality|null findOneBy(array $criteria, array $orderBy = null)
 * @method ProfessionalSpeciality[]    findAll()
 * @method ProfessionalSpeciality[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProfessionalSpecialityRepository  extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ProfessionalSpeciality::class);
    }

    public function getDuration(Professional $professional, Speciality $speciality): ?int
    {
        return $this->createQueryBuilder('ps')
            ->select('ps.duration')
            ->where('ps.professional = :professional')
            ->andWhere('ps.speciality = :speciality')
            ->setParameters([
                'professional' => $professional,
                'speciality' => $speciality
            ])
            ->getQuery()
            ->getFirstResult()
        ;
    }
}