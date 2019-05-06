<?php

declare(strict_types=1);

/*
 * This file is part of the "LuxDe School" package.
 * (c) Gopkalo Vitaliy <trndogv@gmail.com>
 */

namespace App\Repository;

use App\Entity\Settings;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method null|Settings find($id, $lockMode = null, $lockVersion = null)
 * @method null|Settings findOneBy(array $criteria, array $orderBy = null)
 * @method Settings[]    findAll()
 * @method Settings[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SettingsRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Settings::class);
    }

}
