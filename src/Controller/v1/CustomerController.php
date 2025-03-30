<?php
namespace App\Controller\v1;

use App\Controller\ApiController;
use App\Entity\Customer;
use App\Repository\CustomerRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/api/v1")
 */
class CustomerController extends ApiController
{
    /**
    * @Route("/customers", methods="GET")
    */
    public function getCustomers(CustomerRepository $customerRepository)
    {
        $customers = $customerRepository->transformAll();

        return $this->respond($customers);
    }

    /**
    * @Route("/customers/{id}", methods="GET")
    */
    public function getCustomer($id, CustomerRepository $customerRepository, EntityManagerInterface $em)
    {
        $customer  = $customerRepository->find($id);

        if (!$customer) {
            return $this->respondNotFound();
        }

        $em->persist($customer);
        $em->flush();

        return $this->respondCreated($customerRepository->transform($customer));
    }

    /**
    * @Route("/customers", methods="POST")
    */
    public function createCustomer(Request $request, EntityManagerInterface $em)
    {
        $request = $this->transformJsonBody($request);

        if (! $request) {
            return $this->respondValidationError('Please provide a valid request!');
        }

        // validate the first name
        if (! $request->get('first_name')) {
            return $this->respondValidationError('Please provide a First Name!');
        }

        // validate the last name
        if (! $request->get('last_name')) {
            return $this->respondValidationError('Please provide a Last Name!');
        }

        $customer = new Customer;
        $customer->setFirstName($request->get('first_name'));
        $customer->setLastName($request->get('last_name'));
        $em->persist($customer);
        $em->flush();

        return $this->respondOK();
    }

    /**
    * @Route("/customers/{id}", methods="PUT")
    */
    public function updateCustomer(Request $request,$id, CustomerRepository $customerRepository, EntityManagerInterface $em)
    {
        $request = $this->transformJsonBody($request);

        if (! $request) {
            return $this->respondValidationError('Please provide a valid request!');
        }

        // validate the first name
        if (! $request->get('first_name')) {
            return $this->respondValidationError('Please provide a First Name!');
        }

        // validate the last name
        if (! $request->get('last_name')) {
            return $this->respondValidationError('Please provide a Last Name!');
        }

        $customer  = $customerRepository->find($id);

        if (!$customer) {
            return $this->respondNotFound();
        }

        $customer->setFirstName($request->get('first_name'));
        $customer->setLastName($request->get('last_name'));
        $em->persist($customer);
        $em->flush();

        return $this->respondCreated($customerRepository->transform($customer));
    }

    /**
    * @Route("/customers/{id}", methods="DELETE")
    */
    public function deleteCustomer($id, CustomerRepository $customerRepository, EntityManagerInterface $em)
    {
        $customer  = $customerRepository->find($id);

        if (!$customer) {
            return $this->respondNotFound();
        }

        $em->remove($customer);
        $em->flush();

        return $this->respondOK();
    }
}
?>