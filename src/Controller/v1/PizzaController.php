<?php
namespace App\Controller\v1;

use App\Controller\ApiController;
use App\Repository\PizzaIngredientRepository;
use App\Repository\IngredientTypeRepository;
use App\Repository\PizzaCombinationRepository;
use App\Entity\PizzaCombination;
use App\Repository\PizzaOrderRepository;
use App\Repository\PizzaSizeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/api/v1")
 */
class PizzaController extends ApiController
{
    /**************************************************************************
    * Begin Pizza Combinations                                                *
    **************************************************************************/
    /**
    * @Route("/pizzas/combinations", methods="GET")
    */
    public function getPizzaCombinations(PizzaCombinationRepository $pizzaCombinationRepository)
    {
        $pizzaCombinations = $pizzaCombinationRepository->transformAll();

        return $this->respond($pizzaCombinations);
    }

    /**
    * @Route("/pizzas/combinations/{id}", methods="GET")
    */
    public function getPizzaCombination($id, PizzaCombinationRepository $pizzaCombinationRepository, EntityManagerInterface $em)
    {
        $pizzaCombination  = $pizzaCombinationRepository->find($id);

        if (!$pizzaCombination) {
            return $this->respondNotFound();
        }

        $em->persist($pizzaCombination);
        $em->flush();

        return $this->respondCreated($pizzaCombinationRepository->transform($pizzaCombination));
    }

    /**
    * @Route("/pizzas/combinations/", methods="POST")
    */
    public function createPizzaCombination(Request $request, PizzaOrderRepository $pizzaOrderRepository, PizzaSizeRepository $pizzaSizeRepository, PizzaCombinationRepository $pizzaCombinationRepository, PizzaIngredientRepository $pizzaIngredientRepository, EntityManagerInterface $em)
    {
        $request = $this->transformJsonBody($request);


        if (! $request) {
            return $this->respondValidationError('Please provide a valid request!');
        }

        if (! $request->get('section_count')) {
            return $this->respondValidationError('Please provide the number of sections of the pizza!');
        } 

        if (! $request->get('ingredient_data')) {
            return $this->respondValidationError('Please provide the ingredient data of sections of the pizza!');
        } 

        $pizzaSectionCount = $request->get('section_count');
        $pizzaIngredientData = $request->get('ingredient_data');

        foreach($pizzaIngredientData as $section){
            foreach($section as $key => $ingredientIds){
                if($key == "ingredient_id"){
                    $section_number = 0;
                    $lastId = $pizzaCombinationRepository->getLastIdValue();

                    if($lastId != null){
                        $nextId = ++$lastId;
                    } else {
                        $nextId = 1;
                    }

                    foreach($ingredientIds as $ingredientId)
                    {
                       $section_number += 1;
                        $pizzaIngredient  = $pizzaIngredientRepository->find($ingredientId);
                            
                       if (!$pizzaIngredient) {
                            return $this->respondValidationError('Please provide a valid Pizza Ingredient ID');
                        }

                        $priceDollar = intval(floor($pizzaIngredient->getPriceDollar() / $pizzaSectionCount));
                        $priceDollarRemainder = intval(ceil((($pizzaIngredient->getPriceDollar() % $pizzaSectionCount) / $pizzaSectionCount) * 100));
                        $priceCent = $pizzaIngredient->getPriceCent() + $priceDollarRemainder;

                        if($priceCent > 99){
                            $dollarsFromCent = intval(floor($priceCent / 100));
                            $priceDollar += $dollarsFromCent; 
                            $priceCent = $priceCent % 100;
                        }

                        $pizzaCombination = new PizzaCombination;
                        $pizzaCombination->setPizzaId($nextId);
                        $pizzaCombination->setIngredientId($ingredientId);
                        $pizzaCombination->setSectionNumber($section_number);
                        $pizzaCombination->setPriceDollar($priceDollar);
                        $pizzaCombination->setPriceCent($priceCent);
                        $em->persist($pizzaCombination);
                        $em->flush();
                    }

                }
            }
        }

        return $this->respondOK();
    }

    /**
    * @Route("/pizzas/combinations/", methods="PUT")
    */
    public function updatePizzaCombination(Request $request, PizzaOrderRepository $pizzaOrderRepository, PizzaSizeRepository $pizzaSizeRepository, PizzaCombinationRepository $pizzaCombinationRepository, PizzaIngredientRepository $pizzaIngredientRepository, EntityManagerInterface $em)
    {
        $request = $this->transformJsonBody($request);


        if (! $request) {
            return $this->respondValidationError('Please provide a valid request!');
        }

        if (! $request->get('combination_id')) {
            return $this->respondValidationError('Please provide a Combination ID!');
        }

        if (! $request->get('partition_section')) {
            return $this->respondValidationError('Please provide a Partition Section!');
        }

        if (! $request->get('ingredient_id_old')) {
            return $this->respondValidationError('Please provide a Old Ingredient ID!');
        } else {
            $pizzaIngredient  = $pizzaIngredientRepository->find($request->get('ingredient_id_old'));

            if (!$pizzaIngredient) {
                return $this->respondValidationError('Please provide a valid Old Ingredient ID');
            }
        }

        if (! $request->get('ingredient_id_new')) {
            return $this->respondValidationError('Please provide a New Ingredient ID!');
        } else {
            $pizzaIngredient  = $pizzaIngredientRepository->find($request->get('ingredient_id_new'));

            if (!$pizzaIngredient) {
                return $this->respondValidationError('Please provide a valid New Ingredient ID');
            }
        }

        $pizzaCombination = $pizzaIngredientRepository->getPizzaCombination($request->get('combination_id'),$request->get('partition_section'),$request->get('ingredient_id_old'));

        if (!$pizzaCombination) {
            return $this->respondValidationError('Please provide a valid Pizza Combination ID and a valid Partition Section');
        }

        $pizzaCombination->setIngredientId($request->get('ingredient_id_new'));

        $em->persist($pizzaCombination);
        $em->flush();

        return $this->respondCreated($pizzaOrderRepository->transform($pizzaCombination));
    }

    /**
    * @Route("/pizzas/combinations/", methods="DELETE")
    */
    public function deletePizzaOrderLine($id, PizzaCombinationRepository $pizzaCombinationRepository, EntityManagerInterface $em)
    {
        $pizzaCombination  = $pizzaCombinationRepository->find($id);

        if (!$pizzaCombination) {
            return $this->respondNotFound();
        }

        $em->remove($pizzaCombination);
        $em->flush();

        return $this->respondOK();
    }

    /**************************************************************************
    * End Pizza Combinations                                                  *
    **************************************************************************/

    /**************************************************************************
    * Begin Pizza Sizes                                                       *
    **************************************************************************/

    /**
    * @Route("/pizzas/sizes", methods="GET")
    */
    public function getPizzaSizes(PizzaSizeRepository $pizzaSizesRepository)
    {
        $pizzaSizes = $pizzaSizesRepository->transformAll();

        return $this->respond($pizzaSizes);
    }

    /**
    * @Route("/pizzas/sizes/{id}", methods="GET")
    */
    public function getPizzaSize($id, PizzaSizeRepository $pizzaSizesRepository, EntityManagerInterface $em)
    {
        $pizzaSize  = $pizzaSizesRepository->find($id);

        if (!$pizzaSize) {
            return $this->respondNotFound();
        }

        $em->persist($pizzaSize);
        $em->flush();

        return $this->respondCreated($pizzaSizesRepository->transform($pizzaSize));
    }

    /**************************************************************************
    * End Pizza Sizes                                                         *
    **************************************************************************/

    /**************************************************************************
    * Begin Pizza Ingredients                                                 *
    **************************************************************************/

    /**
    * @Route("/pizzas/ingredients", methods="GET")
    */
    public function getPizzaIngredients(PizzaIngredientRepository $pizzaIngredientRepository)
    {
        $pizzaIngredients = $pizzaIngredientRepository->transformAll();

        return $this->respond($pizzaIngredients);
    }

    /**
    * @Route("/pizzas/ingredients/{id}", methods="GET")
    */
    public function getPizzaIngredient($id, PizzaIngredientRepository $pizzaIngredientRepository, EntityManagerInterface $em)
    {
        $pizzaIngredient  = $pizzaIngredientRepository->find($id);

        if (!$pizzaIngredient) {
            return $this->respondNotFound();
        }

        $em->persist($pizzaIngredient);
        $em->flush();

        return $this->respondCreated($pizzaIngredientRepository->transform($pizzaIngredient));
    }

    /**************************************************************************
    * End Pizza Ingredients                                                   *
    **************************************************************************/

    /**************************************************************************
    * Begin Pizza Ingredient Type                                             *
    **************************************************************************/

   /**
    * @Route("/pizzas/ingredienttypes", methods="GET")
    */
    public function getPizzaIngredientTypes(IngredientTypeRepository $ingredientTypeRepository)
    {
        $ingredientTypes = $ingredientTypeRepository->transformAll();

        return $this->respond($ingredientTypes);
    }

    /**
    * @Route("/pizzas/ingredienttypes/{id}", methods="GET")
    */
    public function getPizzaIngredientType($id, IngredientTypeRepository $ingredientTypeRepository, EntityManagerInterface $em)
    {
        $ingredientType  = $ingredientTypeRepository->find($id);

        if (!$ingredientType) {
            return $this->respondNotFound();
        }

        $em->persist($ingredientType);
        $em->flush();

        return $this->respondCreated($ingredientTypeRepository->transform($ingredientType));
    }

    /**************************************************************************
    * End Pizza Ingredient Type                                               *
    **************************************************************************/
}
?>