<?php
declare(strict_types=1);

namespace App\Service;

use App\Entity\CustomerProduct;
use Doctrine\ORM\EntityManagerInterface;

class CustomerProductService
{
    private EntityManagerInterface $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public function persist(CustomerProduct $customerProduct): void
    {
        $this->em->persist($customerProduct);
        $this->em->flush();
    }
}
