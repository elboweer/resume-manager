<?php


namespace App\EventListener\Entity;

use App\Entity\Summary;
use DateTime;
use Doctrine\Common\Persistence\Event\LifecycleEventArgs;
use Doctrine\ORM\Mapping as ORM;
use Exception;

class SummaryListener
{
    /**
     * @ORM\PreUpdate
     * @param Summary $summary
     * @param LifecycleEventArgs $event
     * @throws Exception
     */
    public function postRemoveHandler(Summary $summary, LifecycleEventArgs $event)
    {
        $summary->setUpdatedAt(new DateTime('now'));
    }
}