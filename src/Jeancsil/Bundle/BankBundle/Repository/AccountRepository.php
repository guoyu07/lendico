<?php
namespace Jeancsil\Bundle\BankBundle\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * @author Jean Carlos <jeancsil@gmail.com>
 */
class AccountRepository extends EntityRepository
{
    /**
     * @param $limit
     * @return array
     */
    public function findActive($limit = 10)
    {
        $query = $this->createQueryBuilder('a')
            ->select('a.number, c.name')
            ->andWhere('a.deletedAt is null')
            ->andWhere('a.activated = 1')
            ->innerJoin('a.owner', 'c')
            ->setMaxResults($limit)
            ->getQuery();

        return $query
            ->useQueryCache(false)//In Production must be true
            ->useResultCache(false)//In Production should be true
            ->getArrayResult();
    }

    /**
     * @param $number
     */
    public function deactivateByNumber($number)
    {
        try {
            $this->getEntityManager()->beginTransaction();
            $this->createQueryBuilder('a')
                ->update()
                ->set('a.activated', 'false')
                ->where('a.number = :number')->setParameter('number', $number)
                ->getQuery()
                ->execute();

           $this->getEntityManager()->commit();
        } catch (\Exception $e) {
            $this->getEntityManager()->rollback();
        }
    }
}
