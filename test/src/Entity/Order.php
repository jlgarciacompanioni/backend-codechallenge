<?php

namespace App\Entity;



use Doctrine\ORM\Mapping as ORM;


/**
 * @ORM\Entity(repositoryClass="App\Repository\OrderRepository")
 * @ORM\Table(name="test.order")
 */
class Order implements \JsonSerializable
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $orderAddress;

    /**
     * @ORM\Column(type="date")
     */
    private $deliveryDate;

    /**
     * @ORM\Column(type="time")
     */
    private $deliveryHour;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Driver",inversedBy="order", cascade={"persist"})
     * @ORM\JoinColumn(name="driver_id", referencedColumnName="id")
     */
    private $driver;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Client", cascade={"persist"})
     * @ORM\JoinColumn(name="client_id",referencedColumnName="id",nullable=false)
     */
    private $client;



    public function getId()
    {
        return $this->id;
    }

    public function getOrderAddress(): ?string
    {
        return $this->orderAddress;
    }

    public function setOrderAddress(string $orderAddress): self
    {
        $this->orderAddress = $orderAddress;

        return $this;
    }

    public function getDeliveryDate(): ?\DateTimeInterface
    {
        return $this->deliveryDate;
    }

    public function setDeliveryDate(\DateTimeInterface $deliveryDate): self
    {
        $this->deliveryDate = $deliveryDate;

        return $this;
    }

    public function getDeliveryHour(): ?\DateTimeInterface
    {
        return $this->deliveryHour;
    }

    public function setDeliveryHour(\DateTimeInterface $deliveryHour): self
    {
        $this->deliveryHour = $deliveryHour;

        return $this;
    }

    public function getDriver(): ?Driver
    {
        return $this->driver;
    }

    public function setDriver(?Driver $driver): self
    {
        $this->driver = $driver;

        return $this;
    }

    public function getClient(): ?Client
    {
        return $this->client;
    }

    public function setClient(?Client $client): self
    {
        $this->client = $client;

        return $this;
    }

    public function jsonSerialize()
    {
        return
        [  'id'=>$this->id,
            'drivers' => $this->getDriver(),
            'client' => $this->getClient()->jsonSerialize(),
            'deliveryDate' => $this->deliveryDate,
            'deliveryHour' => $this->deliveryHour,
            'orderAddress' =>$this->orderAddress
        ]
        ;


    }
}
