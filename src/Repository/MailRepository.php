<?php

declare(strict_types=1);

/*
 * This file is part of the "LuxDe School" package.
 * (c) Gopkalo Vitaliy <trndogv@gmail.com>
 */

namespace App\Repository;

use App\Entity\Mail;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method null|Mail find($id, $lockMode = null, $lockVersion = null)
 * @method null|Mail findOneBy(array $criteria, array $orderBy = null)
 * @method Mail[]    findAll()
 * @method Mail[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MailRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Mail::class);
    }
}
