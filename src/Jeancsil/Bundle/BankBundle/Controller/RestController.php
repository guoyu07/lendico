<?php
namespace Jeancsil\Bundle\BankBundle\Controller;

use Doctrine\ORM\EntityManager;
use Jeancsil\Bundle\BankBundle\Exception\JsonParseException;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;

class RestController extends Controller
{
    /**
     * @var EntityManager
     */
    private $entityManager;

    /**
     * @return array
     * @throws JsonParseException
     */
    protected function getRequestBodyAsJson()
    {
        $jsonBody = json_decode($this->container->get('request_stack')->getCurrentRequest()->getContent(), true);

        if (json_last_error() != JSON_ERROR_NONE) {
            throw new JsonParseException('The received JSON is invalid.', json_last_error());
        }

        return $jsonBody;
    }

    /**
     * @param $data
     * @param int $httpCode
     * @return JsonResponse
     */
    protected function returnSuccessResponse($data, $httpCode = 200)
    {
        return new JsonResponse($data, $httpCode, ['Content-Type' => 'application/json']);
    }

    /**
     * @param $data
     * @param int $httpCode
     * @return JsonResponse
     */
    protected function returnFailedResponse($data, $httpCode = 400)
    {
        return new JsonResponse(['error' => $data], $httpCode, ['Content-Type' => 'application/json']);
    }

    /**
     * @return \Doctrine\ORM\EntityManager
     */
    protected function getEntityManager()
    {
        if (!$this->entityManager) {
            $this->entityManager = $this->container->get('doctrine.orm.entity_manager');
        }

        return $this->entityManager;
    }
}
