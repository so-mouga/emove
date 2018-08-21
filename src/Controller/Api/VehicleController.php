<?php
/**
 * Created by PhpStorm.
 * User: kevinmouga
 * Date: 04/07/2018
 * Time: 09:43
 */
namespace App\Controller\Api;

use App\Entity\Vehicle;
use FOS\RestBundle\FOSRestBundle;
use App\Repository\VehicleRepository;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\HttpFoundation\Request;
use Swagger\Annotations as SWG;
use FOS\RestBundle\Controller\Annotations\QueryParam;
use Nelmio\ApiDocBundle\Annotation\Model;
use FOS\RestBundle\Request\ParamFetcher;

class VehicleController extends FOSRestBundle
{
    /**
     * @var VehiculeRepository
     */
    private $vehicleRepository;

    public function __construct(VehicleRepository $vehicleRepository)
    {
        $this->vehicleRepository = $vehicleRepository;
    }

    /**
     * @Rest\Get("/cars")
     * @Rest\View()
     * @SWG\Get(
     *     summary="Get list vehicle",
     *     tags={"Vehicle"},
     *     produces={"application/json"},
     *     @SWG\Parameter(
     *          name="type",
     *          in="query",
     *          required=false,
     *          type="string",
     *          description="Type of the vehicles. Allowed value: car or scooter",
     *      ),
     *     @SWG\Response(
     *          response=200,
     *          description="Return an array of vehicle",
     *      ),
     *     @SWG\Response(
     *          response=404,
     *          description="Vehicule not found with your parameters",
     *      ),
     *
     *      @SWG\Response(
     *          response=400,
     *          description="Parameter not allowed",
     *      ),
     * )
     * @QueryParam(name="type", strict=true, nullable=true)
     * @QueryParam(name="agency", strict=true, nullable=true)
     */
    public function getListVehicle(ParamFetcher $paramFetcher)
    {
        $criteria = [
            'type' => $paramFetcher->get('type'),
            'agency' => $paramFetcher->get('agency')
            ];

        $criteria = array_filter($criteria, function ($criterion) {
            return null != $criterion;
        });
        $vehicles = $this->vehicleRepository->findBy($criteria);

        return $vehicles;
    }
    /**
     * @Rest\Get("/cars/{id}")
     * @Rest\View()
     * @SWG\Get(
     *     summary="Get one vehicle",
     *     tags={"Vehicle"},
     *     produces={"application/json"},
     *     @SWG\Response(
     *          response=201,
     *          description="one vehicle"
     *     ),
     *     @SWG\Response(
     *          response=404,
     *          description="An error occurred on the vehicle"
     *     )
     * )
     *  @param int $id
     *  @return Vehicle|JsonResponse
     */
    public function getOneVehicle(int $id)
    {
        $vehicle = $this->vehicleRepository->findOneById($id);

        return $vehicle;
    }
}
