<?php

namespace App\Entity;

use DateTime;
use DateTimeInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Exception;
use Ramsey\Uuid\Uuid;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\SummaryRepository")
 * @ORM\EntityListeners({"App\EventListener\Entity\SummaryListener"})
 */
class Summary
{
    /**
     * @var string
     * @ORM\Id()
     * @ORM\Column(type="string", length=36)
     * @ORM\GeneratedValue(strategy="NONE")
     */
    private $id;

    /**
     * @var string
     * @Assert\NotBlank
     * @ORM\Column(type="string", length=255)
     */
    private $position;

    /**
     * @var string
     * @Assert\NotBlank
     * @ORM\Column(type="text", nullable=true)
     */
    private $body;

    /**
     * @var DateTime
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @var DateTime
     * @ORM\Column(type="datetime")
     */
    private $updatedAt;

    /**
     * @var Feedback[]
     * @ORM\OneToMany(targetEntity="App\Entity\Feedback", mappedBy="summary")
     */
    private $feedBacks;

    /**
     * @throws Exception
     */
    public function __construct()
    {
        $this->reset();
    }

    /**
     * @throws Exception
     */
    public function __clone()
    {
        $this->reset();
    }

    /**
     * @return string|null
     */
    public function getId(): ?string
    {
        return $this->id;
    }

    /**
     * @return string|null
     */
    public function getPosition(): ?string
    {
        return $this->position;
    }

    /**
     * @param string $position
     */
    public function setPosition(string $position): void
    {
        $this->position = $position;
    }

    /**
     * @return string|null
     */
    public function getBody(): ?string
    {
        return $this->body;
    }

    /**
     * @param string|null $body
     */
    public function setBody(?string $body): void
    {
        $this->body = $body;
    }

    /**
     * @return DateTimeInterface|null
     */
    public function getCreatedAt(): ?DateTimeInterface
    {
        return $this->createdAt;
    }

    /**
     * @param DateTimeInterface $createdAt
     */
    public function setCreatedAt(DateTimeInterface $createdAt): void
    {
        $this->createdAt = $createdAt;
    }

    /**
     * @return DateTimeInterface|null
     */
    public function getUpdatedAt(): ?DateTimeInterface
    {
        return $this->updatedAt;
    }

    /**
     * @param DateTimeInterface $updatedAt
     */
    public function setUpdatedAt(DateTimeInterface $updatedAt): void
    {
        $this->updatedAt = $updatedAt;
    }

    /**
     * @return Feedback[]|null
     */
    public function getFeedBacks(): ?array
    {
        return $this->feedBacks;
    }

    /**
     * @param Feedback $feedBacks
     */
    public function addFeedBack(Feedback $feedBacks): void
    {
        $this->feedBacks->add($feedBacks);
    }

    /**
     * @throws Exception
     */
    protected function reset()
    {
        $this->id = Uuid::uuid4()->toString();
        $this->feedBacks = new ArrayCollection();
        $this->createdAt = new DateTime('now');
        $this->updatedAt = $this->createdAt;
    }
}
