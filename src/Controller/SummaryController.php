<?php


namespace App\Controller;

use App\Entity\Summary;
use App\Form\SummaryType;
use App\Repository\SummaryRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\NonUniqueResultException;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;

class SummaryController extends AbstractController
{
    /**
     * @var SummaryRepository
     */
    private $summaryRepository;

    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    public function __construct(
        SummaryRepository $summaryRepository,
        EntityManagerInterface $entityManager)
    {
        $this->summaryRepository = $summaryRepository;
        $this->entityManager = $entityManager;
    }

    /**
     * @Route("/summaries", name="index_summary")
     */
    public function summaryIndex()
    {
        $summaries = $this->summaryRepository->getAll();

        return $this->render('summary/index.html.twig', [
            'summaries' => $summaries
        ]);
    }

    /**
     * @Route("/summaries/create", name="create_summary")
     * @param Request $request
     * @return RedirectResponse|Response
     * @throws Exception
     */
    public function summaryCreate(Request $request)
    {
        $summary = new Summary();

        $form = $this->createForm(SummaryType::class, $summary);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->persistAndFlush($summary);
            $this->addFlash('success', 'action.flush.create');

            return $this->redirectToRoute('index_summary');
        }

        return $this->render('summary/summary.html.twig', [
            'form' => $form->createView(),
            'summary' => $summary,
            'action' => 'create'
        ]);
    }

    /**
     * @Route("/summaries/{summaryID}/edit", name="edit_summary")
     * @param Request $request
     * @param $summaryID
     * @return RedirectResponse|Response
     * @throws NonUniqueResultException
     */
    public function summaryEdit(Request $request, $summaryID)
    {
        if (!$summary = $this->summaryRepository->getByID($summaryID)) {
            throw new NotFoundHttpException();
        }

        $form = $this->createForm(SummaryType::class, $summary);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->persistAndFlush($summary);
            $this->addFlash('success', 'action.flush.edit');

            return $this->redirectToRoute('index_summary');
        }

        return $this->render('summary/summary.html.twig', [
            'form' => $form->createView(),
            'summary' => $summary,
            'action' => 'update'
        ]);
    }

    /**
     * @Route("/summaries/{summaryID}/clone", name="clone_summary")
     * @param Request $request
     * @param $summaryID
     * @return RedirectResponse|Response
     * @throws NonUniqueResultException
     */
    public function summaryClone(Request $request, $summaryID)
    {
        if (!$summary = $this->summaryRepository->getByID($summaryID)) {
            throw new NotFoundHttpException();
        }

        $summary = clone $summary;
        $form = $this->createForm(SummaryType::class, $summary);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->persistAndFlush($summary);
            $this->addFlash('success', 'action.flush.edit');

            return $this->redirectToRoute('index_summary');
        }

        return $this->render('summary/summary.html.twig', [
            'form' => $form->createView(),
            'summary' => $summary,
        ]);
    }

    /**
     * @Route("/summaries/{summaryID}/delete", name="delete_summary")
     * @param $summaryID
     * @return RedirectResponse
     * @throws NonUniqueResultException
     */
    public function summaryDelete($summaryID)
    {
        if (!$summary = $this->summaryRepository->getByID($summaryID)) {
            throw new NotFoundHttpException();
        }

        $this->entityManager->remove($summary);
        $this->entityManager->flush();

        return $this->redirectToRoute('index_summary');
    }

    /**
     * @param Summary $summary
     */
    protected function persistAndFlush(Summary $summary): void
    {
        $this->entityManager->persist($summary);
        $this->entityManager->flush();
    }
}