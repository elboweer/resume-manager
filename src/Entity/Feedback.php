<?php

namespace App\Entity;

use DateTimeInterface;
use Doctrine\ORM\Mapping as ORM;
use Exception;
use Ramsey\Uuid\Uuid;

/**
 * @ORM\Entity(repositoryClass="App\Repository\FeedbackRepository")
 */
class Feedback
{
    /**
     * @var string
     *
     * @ORM\Id()
     * @ORM\Column(type="string", length=36)
     * @ORM\GeneratedValue(strategy="NONE")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Company")
     * @ORM\JoinColumn(nullable=false, onDelete="CASCADE")
     */
    private $company;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Resume", inversedBy="feedBacks")
     * @ORM\JoinColumn(nullable=false, onDelete="CASCADE")
     */
    private $resume;

    /**
     * @ORM\Column(type="datetime")
     */
    private $sendAt;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $decision;

    /**
     * @throws Exception
     */
    public function __construct()
    {
        $this->id = Uuid::uuid4()->toString();
    }

    /**
     * @return string|null
     */
    public function getId(): ?string
    {
        return $this->id;
    }

    /**
     * @return Company|null
     */
    public function getCompany(): ?Company
    {
        return $this->company;
    }

    /**
     * @param Company $company
     */
    public function setCompany(Company $company): void
    {
        $this->company = $company;
    }

    /**
     * @return Resume|null
     */
    public function getResume(): ?Resume
    {
        return $this->resume;
    }

    /**
     * @param Resume $resume
     */
    public function setResume(Resume $resume): void
    {
        $this->resume = $resume;
    }

    /**
     * @return DateTimeInterface|null
     */
    public function getSendAt(): ?DateTimeInterface
    {
        return $this->sendAt;
    }

    /**
     * @param DateTimeInterface $sendAt
     */
    public function setSendAt(DateTimeInterface $sendAt): void
    {
        $this->sendAt = $sendAt;
    }

    /**
     * @return string|null
     */
    public function getDecision(): ?string
    {
        return $this->decision;
    }

    /**
     * @param string $decision
     */
    public function setDecision(string $decision): void
    {
        $this->decision = $decision;
    }
}
