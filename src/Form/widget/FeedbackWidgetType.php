<?php


namespace App\Form\widget;


use App\Entity\Company;
use App\Entity\Summary;
use App\Repository\FeedbackRepository;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class FeedbackWidgetType extends AbstractType
{
    /**
     * @var FeedbackRepository
     */
    private $feedbackRepository;

    public function __construct(FeedbackRepository $feedbackRepository)
    {
        $this->feedbackRepository = $feedbackRepository;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        /** @var Summary $summary */
        $summary = $options['summary'];

        $unavailableIDs = $this->feedbackRepository->getUnavailableCompanyIdsBySummary($summary);

        $builder
            ->add('company', EntityType::class, [
                'label' => 'entity.company.__index',
                'class' => Company::class,
                'choice_label' => 'title',
                'query_builder' => function (EntityRepository $er) use ($unavailableIDs) {
                    return $er->createQueryBuilder('c')
                        ->where('c.id NOT IN (:unavailableIDs)')
                        ->setParameter('unavailableIDs', $unavailableIDs)
                        ->orderBy('c.title', 'ASC');
                },
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver
            ->setDefaults([
                'data_class' => null,
                'summary' => null,
            ]);
    }
}