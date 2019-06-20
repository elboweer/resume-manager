<?php


namespace App\Controller;

use App\Entity\Company;
use App\Form\CompanyType;
use App\Repository\CompanyRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\NonUniqueResultException;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;

class CompanyController extends AbstractController
{
    /**
     * @var CompanyRepository
     */
    private $companyRepository;

    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    public function __construct(
        CompanyRepository $companyRepository,
        EntityManagerInterface $entityManager)
    {
        $this->companyRepository = $companyRepository;
        $this->entityManager = $entityManager;
    }

    /**
     * @Route("/companies", name="index_company")
     */
    public function companyIndex()
    {
        $companies = $this->companyRepository->getAll();

        return $this->render('company/index.html.twig', [
            'companies' => $companies
        ]);
    }

    /**
     * @Route("/companies/create", name="create_company")
     * @param Request $request
     * @return RedirectResponse|Response
     * @throws Exception
     */
    public function companyCreate(Request $request)
    {
        $company = new Company();

        $form = $this->createForm(CompanyType::class, $company);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            /** @var Company $company */
            $company = $form->getData();
            $this->entityManager->persist($company);
            $this->entityManager->flush();
            $this->addFlash('success', 'action.flush.create');

            return $this->redirectToRoute('index_company');
        }

        return $this->render('company/company.html.twig', [
            'form' => $form->createView(),
            'company' => $company,
        ]);
    }

    /**
     * @Route("/companies/{companyID}/create", name="edit_company")
     * @param Request $request
     * @param $companyID
     * @return RedirectResponse|Response
     * @throws NonUniqueResultException
     */
    public function companyEdit(Request $request, $companyID)
    {
        if (!$company = $this->companyRepository->getByID($companyID)) {
            throw new NotFoundHttpException();
        }

        $form = $this->createForm(CompanyType::class, $company);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            /** @var Company $company */
            $company = $form->getData();
            $this->entityManager->persist($company);
            $this->entityManager->flush();
            $this->addFlash('success', 'action.flush.edit');

            return $this->redirectToRoute('index_company');
        }

        return $this->render('company/company.html.twig', [
            'form' => $form->createView(),
            'company' => $company,
        ]);
    }

    /**
     * @Route("/companies/{companyID}/delete", name="delete_company")
     * @param $companyID
     * @return RedirectResponse
     * @throws NonUniqueResultException
     */
    public function companyDelete($companyID)
    {
        if (!$company = $this->companyRepository->getByID($companyID)) {
            throw new NotFoundHttpException();
        }

        $this->entityManager->remove($company);
        $this->entityManager->flush();

        return $this->redirectToRoute('index_company');
    }
}