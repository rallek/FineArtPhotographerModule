<?php
/**
 * FineArtPhotographer.
 *
 * @copyright Ralf Koester (RK)
 * @license http://www.gnu.org/licenses/lgpl.html GNU Lesser General Public License
 * @author Ralf Koester <ralf@familie-koester.de>.
 * @link http://k62.de
 * @link http://zikula.org
 * @version Generated by ModuleStudio 1.2.0 (https://modulestudio.de).
 */

namespace RK\FineArtPhotographerModule\Form\Type\Field\Base;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use RK\FineArtPhotographerModule\Form\EventListener\TranslationListener;

/**
 * Translations field type base class.
 */
abstract class AbstractTranslationType extends AbstractType
{
    /**
     * @var TranslationListener
     */
    protected $translationListener;

    /**
     * TranslationsType constructor.
     */
    public function __construct()
    {
        $this->translationListener = new TranslationListener();
    }

    /**
     * @inheritDoc
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->addEventSubscriber($this->translationListener);
    }

    /**
     * @inheritDoc
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver
            ->setDefaults([
                'by_reference' => false,
                'mapped' => false,
                'empty_data' => function (FormInterface $form) {
                    return new \Doctrine\Common\Collections\ArrayCollection();
                },
                'fields' => [],
                'mandatory_fields' => [],
                'values' => []
            ])
            ->setRequired(['fields'])
            ->setDefined(['mandatory_fields', 'values'])
            ->setAllowedTypes('fields', 'array')
            ->setAllowedTypes('mandatory_fields', 'array')
            ->setAllowedTypes('values', 'array')
        ;
    }

    /**
     * @inheritDoc
     */
    public function getBlockPrefix()
    {
        return 'rkfineartphotographermodule_field_translation';
    }
}
