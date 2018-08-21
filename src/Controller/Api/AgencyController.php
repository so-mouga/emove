<?php
/**
 * @author Kevin Mougammadaly <kevin.mougammadaly@ekino.com>
 */
namespace App\Controller\Api;

use App\Entity\Agency;
use App\Form\AgencyType;
use App\Repository\AgencyRepository;
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

class AgencyController extends FOSRestBundle
{
    use ApiErrorsTrait;

    /**
     * @var AgencyRepository
     */
    private $agencyRepository;

    /**
     * @var FormFactory
     */
    private $formFactory;

    /**
     * @var EntityManagerInterface
     */
    private $doctrine;

    public function __construct(
        AgencyRepository $agencyRepository,
        FormFactoryInterface $formFactory,
        EntityManagerInterface $doctrine
    )
    {
        $this->agencyRepository = $agencyRepository;
        $this->formFactory = $formFactory;
        $this->doctrine = $doctrine;
    }

    /**
     * @Rest\Post("/agencies")
     * @Rest\View(statusCode=Response::HTTP_CREATED)
     *
     * @SWG\Post(
     *     summary="Create an agency",
     *     tags={"Agencies"},
     *     consumes={"application/json"},
     *     produces={"application/json"},
     *     @SWG\Parameter(
     *         name="agency",
     *         in="body",
     *         required=true,
     *         @Model(type=Agency::class, groups={Agency::API_POST})
     *     ),
     *     @SWG\Response(
     *          response=201,
     *          description="Agency created with success"
     *     ),
     *     @SWG\Response(
     *          response=422,
     *          description="An error occurred on agency creation"
     *     )
     * )
     *
     * @param Request $request
     */
    public function createAgency(Request $request)
    {
        $agency = new Agency();
        return $this->handleAgency($agency, $request);
    }

    /**
     * @param Agency    $agency
     * @param Request $request
     * @param bool    $clearMissing
     *
     * @return Agency|JsonResponse
     */
    private function handleAgency(Agency $agency, Request $request, bool $clearMissing = true)
    {

        $form = $this->formFactory->create(AgencyType::class, $agency);
        $form->submit($request->request->all(), $clearMissing);

        if (!$form->isValid()) {
            $readableErrors = $this->getFormErrors($form);

            return new JsonResponse(['message' => 'Invalid data sent', 'errors' => $readableErrors], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $this->doctrine->persist($agency);
        $this->doctrine->flush();

        return $agency;
    }

    /**
     * @Rest\Get("/agencies")
     * @Rest\View(statusCode=Response::HTTP_OK)
     *
     * @SWG\Get(
     *     summary="Get agencies",
     *     tags={"Agencies"},
     *     consumes={"application/json"},
     *     produces={"application/json"},

     *     @SWG\Response(
     *          response=200,
     *          description="Agencies retrieved"
     *     ),
     *     @SWG\Response(
     *          response=422,
     *          description="An error occurred"
     *     )
     * )
     *
     */
    public function getAgencies()
    {
        return $this->agencyRepository->findAll();
    }

    /**
     * @Rest\Get("/agency/{id}")
     * @Rest\View(statusCode=Response::HTTP_OK)
     *
     * @SWG\Get(
     *     summary="Get an agency",
     *     tags={"Agencies"},
     *     consumes={"application/json"},
     *     produces={"application/json"},

     *     @SWG\Response(
     *          response=200,
     *          description="Agency retrieved"
     *     ),
     *     @SWG\Response(
     *          response=422,
     *          description="An error occurred"
     *     )
     * )
     * @param int id
     */
    public function getAgency($id)
    {
        return $this->agencyRepository->findOneById($id);
    }
}
