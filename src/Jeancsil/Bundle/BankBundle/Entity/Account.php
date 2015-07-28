<?php

namespace Jeancsil\Bundle\BankBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="account")
 * @ORM\Entity(repositoryClass="Jeancsil\Bundle\BankBundle\Repository\AccountRepository")
 */
class Account implements \JsonSerializable
{
    use ModificationTimeTrait;

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var integer
     *
     * @ORM\Column(name="number", type="integer")
     */
    private $number;

    /**
     * @var Client
     *
     * @ORM\ManyToOne(targetEntity="Jeancsil\Bundle\BankBundle\Entity\Client")
     * @ORM\JoinColumn(name="client_id", referencedColumnName="id", nullable=false)
     */
    private $owner;

    /**
     * @var boolean
     *
     * @ORM\Column(name="activated", type="boolean")
     */
    private $activated;

    public function __construct()
    {
        $this->createdAt = new \DateTime();
        $this->updatedAt = new \DateTime();
        $this->activated = true;
    }

    /**
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param integer $number
     * @return Account
     */
    public function setNumber($number)
    {
        $this->number = $number;

        return $this;
    }

    /**
     * @return integer
     */
    public function getNumber()
    {
        return $this->number;
    }

    /**
     * @param \stdClass $owner
     * @return Account
     */
    public function setOwner($owner)
    {
        $this->owner = $owner;

        return $this;
    }

    /**
     * @return \stdClass
     */
    public function getOwner()
    {
        return $this->owner;
    }

    /**
     * @param boolean $activated
     * @return Account
     */
    public function setActivated($activated)
    {
        $this->activated = $activated;

        return $this;
    }

    /**
     * @return boolean
     */
    public function getActivated()
    {
        return $this->activated;
    }

    public function jsonSerialize()
    {
        return [
            'number' => $this->number,
            'owner' => $this->owner->getName(),
            'activated' => (bool) $this->activated
        ];
    }
}
