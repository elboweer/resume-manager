<?php


namespace App\Controller;


use App\Entity\Feedback;
use App\Form\widget\FeedbackWidgetType;
use App\Repository\FeedbackRepository;
use App\Repository\SummaryRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;

class FeedbackController extends AbstractController
{
    /**
     * @var SummaryRepository
     */
    private $summaryRepository;

    /**
     * @var FeedbackRepository
     */
    private $feedbackRepository;

    /**
     * @var EntityManager
     */
    private $entityManager;

    public function __construct(
        SummaryRepository $summaryRepository,
        EntityManagerInterface $entityManager,
        FeedbackRepository $feedbackRepository)
    {
        $this->summaryRepository = $summaryRepository;
        $this->feedbackRepository = $feedbackRepository;
        $this->entityManager = $entityManager;
    }

    /**
     * @Route("/feedback/create/{summaryID}", name="feedback_create")
     * @param Request $request
     * @param $summaryID
     * @return RedirectResponse|Response
     * @throws NonUniqueResultException
     * @throws ORMException
     * @throws OptimisticLockException
     * @throws Exception
     */
    public function feedbackWidget(Request $request, $summaryID)
    {
        if (!$summary = $this->summaryRepository->getByID($summaryID)) {
            throw new NotFoundHttpException();
        }

        $feedback = new Feedback($summary);
        $form = $this->createForm(FeedbackWidgetType::class, null, [
            'action' => $this->generateUrl('feedback_create', [
                'summaryID' => $summaryID
            ]),
            'summary' => $summary
        ]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $company = $form->getData()['company'];
            $feedback->setCompany($company);
            $this->entityManager->persist($feedback);
            $this->entityManager->flush($feedback);
            $this->addFlash('success', 'action.flush.feedback_request');

            return $this->redirectToRoute('edit_summary', [
                'summaryID' => $summaryID,
            ]);
        }

        return $this->render('feedback/widget/feedback_widget.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/feedbacks", name="feedback_index")
     * @return Response
     */
    public function feedbackIndex()
    {
        $feedbacks = $this->feedbackRepository->getAll();

        return $this->render('feedback/index.html.twig', [
            'feedbacks' => $feedbacks,
        ]);
    }

    /**
     * @Route("/feedbacks/statistics", name="feedback_stat")
     * @return Response
     */
    public function feedbackStatistics()
    {
        $summaries = $this->summaryRepository->getAll();

        return $this->render('feedback/statistics.html.twig', [
            'summaries' => $summaries,
        ]);
    }
}