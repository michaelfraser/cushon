<?php
declare(strict_types=1);

namespace App\Controller;

use App\Entity\CustomerProduct;
use App\Form\Type\CustomerProductFormType;
use App\Repository\CustomerRepository;
use App\Service\CustomerProductService;
use InvalidArgumentException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class Controller extends AbstractController
{
    private CustomerProductService $customerProductService;
    private CustomerRepository $customerRepository;

    public function __construct(
        CustomerProductService $customerProductService,
        CustomerRepository $customerRepository,
        SessionInterface $session
    ) {
        $this->customerProductService = $customerProductService;
        $this->customerRepository = $customerRepository;

        // this would normally end up in the session via a customer login area.
        $session->set('customer_id', 2);
    }

    public function index(Request $request): Response
    {
        $customerId = $this->getCustomerIdFromSession($request);

        $customerProduct = new CustomerProduct();

        $form = $this->createForm(CustomerProductFormType::class, $customerProduct);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            /** @var CustomerProduct $customerProduct */
            $customerProduct = $form->getData();
            $customerProduct->setCustomerId($customerId);

            $this->customerProductService->persist($customerProduct);

            $this->addFlash('success', 'Customer product saved');

            return $this->redirectToRoute('index');
        }

        $customer = $this->customerRepository->find($customerId);

        return $this->render('index.html.twig', [
                'name' => $customer->getName(),
                'last_name' => $customer->getLastname(),
                'form' => $form->createView(),
        ]);
    }

    private function getCustomerIdFromSession(Request $request): int
    {
        $customerId = $request->getSession()->get('customer_id');

        if ($customerId) {
            return $customerId;
        }

        throw new InvalidArgumentException('Invalid customer.  Please try logging in again.');
    }
}
