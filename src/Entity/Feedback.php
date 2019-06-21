<?php

namespace App\Entity;

use DateTime;
use DateTimeInterface;
use Doctrine\ORM\Mapping as ORM;
use Exception;
use Ramsey\Uuid\Uuid;

/**
 * @ORM\Entity(repositoryClass="App\Repository\FeedbackRepository")
 */
class Feedback
{
    const DECISION_ACCEPTED = 'accepted';
    const DECISION_DECLINED = 'declined';

    /**
     * @var array
     */
    private static $decisions = [
        self::DECISION_ACCEPTED => 'entity.decision.accepted',
        self::DECISION_DECLINED => 'entity.decision.declined'
    ];

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
     * @ORM\ManyToOne(targetEntity="App\Entity\Summary", inversedBy="feedBacks")
     * @ORM\JoinColumn(nullable=false, onDelete="CASCADE")
     */
    private $summary;

    /**
     * @ORM\Column(type="datetime")
     */
    private $sendAt;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $decision;

    /**
     * @param Summary $summary
     * @throws Exception
     */
    public function __construct(Summary $summary)
    {
        $this->id = Uuid::uuid4()->toString();
        $this->summary = $summary;
        $this->sendAt = new DateTime('now');
        $this->decision = array_rand(self::$decisions);
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
     * @return Summary|null
     */
    public function getSummary(): ?Summary
    {
        return $this->summary;
    }

    /**
     * @param Summary $summary
     */
    public function setSummary(Summary $summary): void
    {
        $this->summary = $summary;
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

    /**
     * @return array
     */
    public static function getDecisions()
    {
        return self::$decisions;
    }
}
