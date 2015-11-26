<?php

namespace CuteNinja\ParabolaBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
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
    protected $fieldList = ['page', 'itemPerPage', 'context', 'orderBy'];

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(
            [
                'csrf_protection' => false,
                'fieldList'       => $this->fieldList,
                'allowedContext'  => []
            ]
        );
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
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
                $event->getForm()->add('_format', 'text', ['mapped' => false]);
            }
        );

        $this->dynamicBuildForm($builder, $options);
    }

    /**
     * @param FormBuilderInterface $builder
     *
     * @return void
     */
    protected function addPageField(FormBuilderInterface $builder)
    {
        $builder->add('page', 'integer');
    }

    /**
     * @param FormBuilderInterface $builder
     *
     * @return void
     */
    protected function addItemPerPageField(FormBuilderInterface $builder)
    {
        $builder->add('itemPerPage', 'integer');
    }

    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     *
     * @return void
     */
    protected function addContextField(FormBuilderInterface $builder, array $options)
    {
        $builder->add(
            'context',
            'choice',
            [
                'required' => false,
                'multiple' => true,
                'choices'  => $this->getAllowedContexts($options),
            ]
        );
    }

    /**
     * @param FormBuilderInterface $builder
     *
     * @return void
     */
    protected function addOrderByField(FormBuilderInterface $builder)
    {
        $builder->add('orderBy', 'text');
    }

    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     *
     * @return void
     * @throws \Exception
     */
    protected function dynamicBuildForm(FormBuilderInterface $builder, array $options)
    {
        foreach ($options['fieldList'] as $field) {
            if ($field === '_format') {
                continue;
            }

            if (!in_array($field, $this->fieldList)) {
                throw new \Exception('Unknown field: '.$field.' in class '.get_class($this));
            }

            $method = 'add'.ucfirst($field).'Field';
            if (!method_exists($this, $method)) {
                throw new \Exception('Missing method to add '.$field.' form field in class '.get_class($this));
            }

            $this->$method($builder, $options);
        }
    }

    /**
     * @param array $options
     *
     * @return array
     */
    protected function getAllowedContexts(array $options)
    {
        return array_key_exists('allowedContext', $options) ? $options['allowedContext'] : [];
    }
}
