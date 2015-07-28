<?php

namespace Jeancsil\Bundle\BankBundle\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Jeancsil\Bundle\BankBundle\Entity\Account;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

/**
 * @author Jean Carlos <jeancsil@gmail.com>
 * @Route("/accounts")
 */
class AccountController extends RestController
{
    /**
     * @Route("/", name="accounts")
     * @Method("GET")
     */
    public function listAction()
    {
        $accounts = $this->get('jeancsil_bank.account.repository')->findActive();

        return $this->returnSuccessResponse(['accounts' => $accounts]);
    }

    /**
     * @Route("/new")
     * @Method("POST")
     */
    public function createAction()
    {
        try {
            $request = $this->getRequestBodyAsJson();

            if (!isset($request['number']) || !is_numeric($request['number'])) {
                throw new BadRequestHttpException('The number is mandatory');
            }

            if (!isset($request['client_id'])) {
                throw new BadRequestHttpException('The client_id is mandatory');
            }

            $account = new Account();
            $account->setNumber($request['number']);
            $account->setOwner($this->get('jeancsil_bank.client.repository')->findOneById($request['client_id']));

            $this->getEntityManager()->beginTransaction();
            $this->getEntityManager()->persist($account);
            $this->getEntityManager()->flush($account);
            $this->getEntityManager()->commit();

            return $this->returnSuccessResponse(['account' => $account], 201);
        } catch (\Exception $e) {
            $this->getEntityManager()->rollback();
            return $this->returnFailedResponse(sprintf('Could not create account. Rolling back...'));
        }
    }

    /**
     * @Route("/{number}/deactivate", requirements={"number": "\d+"})
     * @Method("PATCH")
     *
     * @param $number
     * @return JsonResponse
     */
    public function deactivateAction($number)
    {
        try {
            $this->getEntityManager()->beginTransaction();
            $this->get('jeancsil_bank.account.repository')->deactivateByNumber($number);
            $this->getEntityManager()->commit();

            return $this->returnSuccessResponse([]);
        } catch (\Exception $e) {
            $this->getEntityManager()->rollback();
            return $this->returnFailedResponse(sprintf('Could not create account. Rolling back...'));
        }
    }
}
