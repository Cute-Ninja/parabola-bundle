<?php

namespace CuteNinja\ParabolaBundle\Form\Type;

use Exception;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class AbstractListFilterType
 */
class AbstractListFilterType extends AbstractType
{
    /**
     * @var string[] List of default fields
     */
    protected $fieldList = ['page', 'itemPerPage', 'orderBy'];

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(
            [
                'csrf_protection' => false,
                'fieldList'       => $this->fieldList,
            ]
        );
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return '';
    }

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->addEventListener(
            FormEvents::PRE_SUBMIT,
            function (FormEvent $event) {
                $event->getForm()->add('_format', TextType::class, ['mapped' => false]);
            }
        );

        $this->dynamicBuildForm($builder, $options);
    }

    /**
     * @param FormBuilderInterface $builder
     */
    protected function addPageField(FormBuilderInterface $builder)
    {
        $builder->add('page', IntegerType::class);
    }

    /**
     * @param FormBuilderInterface $builder
     */
    protected function addItemPerPageField(FormBuilderInterface $builder)
    {
        $builder->add('itemPerPage', IntegerType::class);
    }

    /**
     * @param FormBuilderInterface $builder
     */
    protected function addOrderByField(FormBuilderInterface $builder)
    {
        $builder->add('orderBy', TextType::class);
    }

    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     *
     * @throws Exception
     */
    protected function dynamicBuildForm(FormBuilderInterface $builder, array $options)
    {
        foreach ($options['fieldList'] as $field) {
            if ($field === '_format') {
                continue;
            }

            if (!in_array($field, $this->fieldList)) {
                throw new Exception('Unknown field: '.$field.' in class '.get_class($this));
            }

            $method = 'add'.ucfirst($field).'Field';
            if (!method_exists($this, $method)) {
                throw new Exception('Missing method to add '.$field.' form field in class '.get_class($this));
            }

            $this->$method($builder, $options);
        }
    }
}
