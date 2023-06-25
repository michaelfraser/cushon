<?php
declare(strict_types=1);

namespace App\Tests\Unit\Service;

use App\Entity\CustomerProduct;
use App\Service\CustomerProductService;
use Doctrine\ORM\EntityManagerInterface;
use PHPUnit\Framework\TestCase;

class CustomerProductServiceTest extends TestCase
{
    private EntityManagerInterface $em;
    private CustomerProduct $customerProduct;

    public function setUp(): void
    {
        $this->em = $this->createMock(EntityManagerInterface::class);
        $this->customerProduct = $this->createMock(CustomerProduct::class);
        $this->sut = new CustomerProductService($this->em);
    }

    public function testCustomerProductPersist(): void
    {
        $this->em
            ->expects($this->once())
            ->method('persist')
            ->with($this->customerProduct);

        $this->em
            ->expects($this->once())
            ->method('flush');

        $this->sut->persist(
            $this->customerProduct
        );
    }
}
