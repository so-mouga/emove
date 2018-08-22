<?php
/**
 * @author Kevin Mougammadaly <kevin.mougammadaly@ekino.com>
 */
namespace App\Controller\Api;

use App\Entity\Type;
use App\Entity\Vehicle;
use App\Form\VehicleType;
use App\Repository\VehicleRepository;
use App\Repository\TypeRepository;
use Doctrine\ORM\EntityManagerInterface;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\FOSRestBundle;
use FOS\RestBundle\View\View;
use Nelmio\ApiDocBundle\Annotation\Model;
use Symfony\Component\Form\FormFactory;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use FOS\RestBundle\Request\ParamFetcher;
use FOS\RestBundle\Controller\Annotations\QueryParam;
use Symfony\Component\HttpFoundation\Response;
use Swagger\Annotations as SWG;

class ScooterController extends FOSRestBundle
{
    use ApiErrorsTrait;

    /**
     * @var VehicleRepository
     */
    private $vehicleRepository;

    /**
     * @var FormFactory
     */
    private $formFactory;

    /**
     * @var EntityManagerInterface
     */
    private $doctrine;

    public function __construct(
        TypeRepository $typeRepository,
        VehicleRepository $vehicleRepository,
        FormFactoryInterface $formFactory,
        EntityManagerInterface $doctrine
    )
    {
        $this->typeRepository = $typeRepository;
        $this->vehicleRepository = $vehicleRepository;
        $this->formFactory = $formFactory;
        $this->doctrine = $doctrine;
    }

    /**
     * @Rest\Post("/scooter")
     * @Rest\View(statusCode=Response::HTTP_CREATED)
     *
     * @SWG\Post(
     *     summary="Create a scooter",
     *     tags={"Scooters"},
     *     consumes={"application/json"},
     *     produces={"application/json"},
     *     @SWG\Parameter(
     *         name="vehicle",
     *         in="body",
     *         required=true,
     *         @Model(type=Vehicle::class, groups={Vehicle::API_POST})
     *     ),
     *     @SWG\Response(
     *          response=201,
     *          description="Scooter created with success"
     *     ),
     *     @SWG\Response(
     *          response=422,
     *          description="An error occurred on scooter creation"
     *     )
     * )
     *
     * @param Request $request
     */

    //CA MARCHE PUTAIN, quand t'envoies les données 
    /*public function createScooter(Request $request)
    {
        $scooter = new Vehicle();
        //$type = $this->typeRepository->findOneById(5);

        //$scooter->setType(new Type());
        return $this->handleVehicle($scooter, $request);
    }*/

    /**
     * @param Vehicle $vehicle
     * @param Request $request
     * @param bool    $clearMissing
     *
     * @return Vehicle|JsonResponse
     */
    private function handleVehicle(Vehicle $vehicle, Request $request, bool $clearMissing = true)
    {

        $form = $this->formFactory->create(VehicleType::class, $vehicle);
        $form->submit($request->request->all(), $clearMissing);

        if (!$form->isValid()) {
            $readableErrors = $this->getFormErrors($form);

            return new JsonResponse(['message' => 'Invalid data sent', 'errors' => $readableErrors], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $this->doctrine->persist($vehicle);
        $this->doctrine->flush();

        return $vehicle;
    }

    /**
     * @Rest\Get("/scooters")
     * @Rest\View(statusCode=Response::HTTP_OK)
     *
     * @SWG\Get(
     *     summary="Get scooters",
     *     tags={"Scooters"},
     *     consumes={"application/json"},
     *     produces={"application/json"},

     *     @SWG\Response(
     *          response=200,
     *          description="Scooters retrieved"
     *     ),
     *     @SWG\Response(
     *          response=422,
     *          description="An error occurred"
     *     )
     * )
     *
     */
    public function getScooters()
    {
        return $this->vehicleRepository->findAllScooters();
    }

    /**
     * @Rest\Get("/scooter/{id}")
     * @Rest\View(statusCode=Response::HTTP_OK)
     *
     * @SWG\Get(
     *     summary="Get a scooter",
     *     tags={"Scooters"},
     *     consumes={"application/json"},
     *     produces={"application/json"},

     *     @SWG\Response(
     *          response=200,
     *          description="Scooter retrieved"
     *     ),
     *     @SWG\Response(
     *          response=422,
     *          description="An error occurred"
     *     )
     * )
     * @param int id
     */
    public function getScooter($id)
    {
        return $this->vehicleRepository->findOneScooterById($id);
    }
}
