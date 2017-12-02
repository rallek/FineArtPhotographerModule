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

namespace RK\FineArtPhotographerModule\Helper\Base;

use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Routing\RouterInterface;
use Zikula\Common\Translator\TranslatorInterface;
use Zikula\Common\Translator\TranslatorTrait;
use Zikula\Component\SortableColumns\SortableColumns;
use Zikula\Core\RouteUrl;
use Zikula\ExtensionsModule\Api\ApiInterface\VariableApiInterface;
use RK\FineArtPhotographerModule\Entity\Factory\EntityFactory;
use RK\FineArtPhotographerModule\Helper\CollectionFilterHelper;
use RK\FineArtPhotographerModule\Helper\FeatureActivationHelper;
use RK\FineArtPhotographerModule\Helper\ImageHelper;
use RK\FineArtPhotographerModule\Helper\ModelHelper;

/**
 * Helper base class for controller layer methods.
 */
abstract class AbstractControllerHelper
{
    use TranslatorTrait;

    /**
     * @var Request
     */
    protected $request;

    /**
     * @var RouterInterface
     */
    protected $router;

    /**
     * @var FormFactoryInterface
     */
    protected $formFactory;

    /**
     * @var VariableApiInterface
     */
    protected $variableApi;

    /**
     * @var EntityFactory
     */
    protected $entityFactory;

    /**
     * @var CollectionFilterHelper
     */
    protected $collectionFilterHelper;

    /**
     * @var ModelHelper
     */
    protected $modelHelper;

    /**
     * @var ImageHelper
     */
    protected $imageHelper;

    /**
     * @var FeatureActivationHelper
     */
    protected $featureActivationHelper;

    /**
     * ControllerHelper constructor.
     *
     * @param TranslatorInterface $translator      Translator service instance
     * @param RequestStack        $requestStack    RequestStack service instance
     * @param Routerinterface     $router          Router service instance
     * @param FormFactoryInterface $formFactory    FormFactory service instance
     * @param VariableApiInterface $variableApi     VariableApi service instance
     * @param EntityFactory       $entityFactory   EntityFactory service instance
     * @param CollectionFilterHelper $collectionFilterHelper CollectionFilterHelper service instance
     * @param ModelHelper         $modelHelper     ModelHelper service instance
     * @param ImageHelper         $imageHelper     ImageHelper service instance
     * @param FeatureActivationHelper $featureActivationHelper FeatureActivationHelper service instance
     */
    public function __construct(
        TranslatorInterface $translator,
        RequestStack $requestStack,
        RouterInterface $router,
        FormFactoryInterface $formFactory,
        VariableApiInterface $variableApi,
        EntityFactory $entityFactory,
        CollectionFilterHelper $collectionFilterHelper,
        ModelHelper $modelHelper,
        ImageHelper $imageHelper,
        FeatureActivationHelper $featureActivationHelper
    ) {
        $this->setTranslator($translator);
        $this->request = $requestStack->getCurrentRequest();
        $this->router = $router;
        $this->formFactory = $formFactory;
        $this->variableApi = $variableApi;
        $this->entityFactory = $entityFactory;
        $this->collectionFilterHelper = $collectionFilterHelper;
        $this->modelHelper = $modelHelper;
        $this->imageHelper = $imageHelper;
        $this->featureActivationHelper = $featureActivationHelper;
    }

    /**
     * Sets the translator.
     *
     * @param TranslatorInterface $translator Translator service instance
     */
    public function setTranslator(/*TranslatorInterface */$translator)
    {
        $this->translator = $translator;
    }

    /**
     * Returns an array of all allowed object types in RKFineArtPhotographerModule.
     *
     * @param string $context Usage context (allowed values: controllerAction, api, helper, actionHandler, block, contentType, util)
     * @param array  $args    Additional arguments
     *
     * @return string[] List of allowed object types
     */
    public function getObjectTypes($context = '', array $args = [])
    {
        if (!in_array($context, ['controllerAction', 'api', 'helper', 'actionHandler', 'block', 'contentType', 'util'])) {
            $context = 'controllerAction';
        }
    
        $allowedObjectTypes = [];
        $allowedObjectTypes[] = 'album';
        $allowedObjectTypes[] = 'albumItem';
    
        return $allowedObjectTypes;
    }

    /**
     * Returns the default object type in RKFineArtPhotographerModule.
     *
     * @param string $context Usage context (allowed values: controllerAction, api, helper, actionHandler, block, contentType, util)
     * @param array  $args    Additional arguments
     *
     * @return string The name of the default object type
     */
    public function getDefaultObjectType($context = '', array $args = [])
    {
        if (!in_array($context, ['controllerAction', 'api', 'helper', 'actionHandler', 'block', 'contentType', 'util'])) {
            $context = 'controllerAction';
        }
    
        return 'album';
    }

    /**
     * Processes the parameters for a view action.
     * This includes handling pagination, quick navigation forms and other aspects.
     *
     * @param string          $objectType         Name of treated entity type
     * @param SortableColumns $sortableColumns    Used SortableColumns instance
     * @param array           $templateParameters Template data
     * @param boolean         $hasHookSubscriber  Whether hook subscribers are supported or not
     *
     * @return array Enriched template parameters used for creating the response
     */
    public function processViewActionParameters($objectType, SortableColumns $sortableColumns, array $templateParameters = [], $hasHookSubscriber = false)
    {
        $contextArgs = ['controller' => $objectType, 'action' => 'view'];
        if (!in_array($objectType, $this->getObjectTypes('controllerAction', $contextArgs))) {
            throw new \Exception($this->__('Error! Invalid object type received.'));
        }
    
        $request = $this->request;
        $repository = $this->entityFactory->getRepository($objectType);
    
        // parameter for used sorting field
        $sort = $request->query->get('sort', '');
        if (empty($sort) || !in_array($sort, $repository->getAllowedSortingFields())) {
            $sort = $repository->getDefaultSortingField();
            $request->query->set('sort', $sort);
            // set default sorting in route parameters (e.g. for the pager)
            $routeParams = $request->attributes->get('_route_params');
            $routeParams['sort'] = $sort;
            $request->attributes->set('_route_params', $routeParams);
        }
        $sortdir = $request->query->get('sortdir', 'ASC');
        $templateParameters['sort'] = $sort;
        $templateParameters['sortdir'] = strtolower($sortdir);
    
        $templateParameters['all'] = 'csv' == $request->getRequestFormat() ? 1 : $request->query->getInt('all', 0);
        $templateParameters['own'] = $request->query->getInt('own', $this->variableApi->get('RKFineArtPhotographerModule', 'showOnlyOwnEntries', 0));
    
        $resultsPerPage = 0;
        if ($templateParameters['all'] != 1) {
            // the number of items displayed on a page for pagination
            $resultsPerPage = $request->query->getInt('num', 0);
            if (in_array($resultsPerPage, [0, 10])) {
                $resultsPerPage = $this->variableApi->get('RKFineArtPhotographerModule', $objectType . 'EntriesPerPage', 10);
            }
        }
        $templateParameters['num'] = $resultsPerPage;
        $templateParameters['tpl'] = $request->query->getAlnum('tpl', '');
    
        $templateParameters = $this->addTemplateParameters($objectType, $templateParameters, 'controllerAction', $contextArgs);
    
        $quickNavForm = $this->formFactory->create('RK\FineArtPhotographerModule\Form\Type\QuickNavigation\\' . ucfirst($objectType) . 'QuickNavType', $templateParameters);
        if ($quickNavForm->handleRequest($request) && $quickNavForm->isSubmitted()) {
            $quickNavData = $quickNavForm->getData();
            foreach ($quickNavData as $fieldName => $fieldValue) {
                if ($fieldName == 'routeArea') {
                    continue;
                }
                if (in_array($fieldName, ['all', 'own', 'num'])) {
                    $templateParameters[$fieldName] = $fieldValue;
                } elseif ($fieldName == 'sort' && !empty($fieldValue)) {
                    $sort = $fieldValue;
                } elseif ($fieldName == 'sortdir' && !empty($fieldValue)) {
                    $sortdir = $fieldValue;
                } elseif (false === stripos($fieldName, 'thumbRuntimeOptions')) {
                    // set filter as query argument, fetched inside repository
                    $request->query->set($fieldName, $fieldValue);
                }
            }
        }
        $sortableColumns->setOrderBy($sortableColumns->getColumn($sort), strtoupper($sortdir));
        $resultsPerPage = $templateParameters['num'];
        $request->query->set('own', $templateParameters['own']);
    
        $urlParameters = $templateParameters;
        foreach ($urlParameters as $parameterName => $parameterValue) {
            if (false === stripos($parameterName, 'thumbRuntimeOptions')) {
                continue;
            }
            unset($urlParameters[$parameterName]);
        }
    
        $sort = $sortableColumns->getSortColumn()->getName();
        $sortdir = $sortableColumns->getSortDirection();
        $sortableColumns->setAdditionalUrlParameters($urlParameters);
    
        $where = '';
        if ($templateParameters['all'] == 1) {
            // retrieve item list without pagination
            $entities = $repository->selectWhere($where, $sort . ' ' . $sortdir);
        } else {
            // the current offset which is used to calculate the pagination
            $currentPage = $request->query->getInt('pos', 1);
    
            // retrieve item list with pagination
            list($entities, $objectCount) = $repository->selectWherePaginated($where, $sort . ' ' . $sortdir, $currentPage, $resultsPerPage);
    
            $templateParameters['currentPage'] = $currentPage;
            $templateParameters['pager'] = [
                'amountOfItems' => $objectCount,
                'itemsPerPage' => $resultsPerPage
            ];
        }
    
        $templateParameters['sort'] = $sort;
        $templateParameters['sortdir'] = $sortdir;
        $templateParameters['items'] = $entities;
    
        if (true === $hasHookSubscriber) {
            // build RouteUrl instance for display hooks
            $urlParameters['_locale'] = $request->getLocale();
            $templateParameters['currentUrlObject'] = new RouteUrl('rkfineartphotographermodule_' . strtolower($objectType) . '_view', $urlParameters);
        }
    
        $templateParameters['sort'] = $sortableColumns->generateSortableColumns();
        $templateParameters['quickNavForm'] = $quickNavForm->createView();
    
        $templateParameters['canBeCreated'] = $this->modelHelper->canBeCreated($objectType);
    
        return $templateParameters;
    }

    /**
     * Processes the parameters for a display action.
     *
     * @param string  $objectType         Name of treated entity type
     * @param array   $templateParameters Template data
     * @param boolean $hasHookSubscriber  Whether hook subscribers are supported or not
     *
     * @return array Enriched template parameters used for creating the response
     */
    public function processDisplayActionParameters($objectType, array $templateParameters = [], $hasHookSubscriber = false)
    {
        $contextArgs = ['controller' => $objectType, 'action' => 'display'];
        if (!in_array($objectType, $this->getObjectTypes('controllerAction', $contextArgs))) {
            throw new \Exception($this->__('Error! Invalid object type received.'));
        }
    
        if (true === $hasHookSubscriber) {
            // build RouteUrl instance for display hooks
            $entity = $templateParameters[$objectType];
            $urlParameters = $entity->createUrlArgs();
            $urlParameters['_locale'] = $this->request->getLocale();
            $templateParameters['currentUrlObject'] = new RouteUrl('rkfineartphotographermodule_' . strtolower($objectType) . '_display', $urlParameters);
        }
    
        if (in_array($objectType, ['album'])) {
            $qb = $this->entityFactory->getObjectManager()->createQueryBuilder();
            $qb->select('tbl')
               ->from('RK\FineArtPhotographerModule\Entity\HookAssignmentEntity', 'tbl')
               ->where('tbl.assignedEntity = :objectType')
               ->setParameter('objectType', $objectType)
               ->andWhere('tbl.assignedId = :entityId')
               ->setParameter('entityId', $entity->getKey())
               ->add('orderBy', 'tbl.updatedDate DESC');
    
            $query = $qb->getQuery();
            $hookAssignments = $query->getResult();
    
            $assignments = [];
            foreach ($hookAssignments as $assignment) {
                $url = 'javascript:void(0);';
                $subscriberUrl = $assignment->getSubscriberUrl();
                if (null !== $subscriberUrl && !empty($subscriberUrl)) {
                    $url = $this->router->generate($subscriberUrl['route'], $subscriberUrl['args']);
                    $fragment = $subscriberUrl['fragment'];
                    if (!empty($fragment)) {
                        if ($fragment[0] != '#') {
                            $fragment = '#' . $fragment;
                    	}
                        $url .= $fragment;
                    }
                }
                $assignments[] = [
                    'url' => $url,
                    'text' => $assignment->getSubscriberOwner(),
                    'date' => $assignment->getUpdatedDate()
                ];
            }
            $templateParameters['hookAssignments'] = $assignments;
        }
    
        return $this->addTemplateParameters($objectType, $templateParameters, 'controllerAction', $contextArgs);
    }

    /**
     * Processes the parameters for an edit action.
     *
     * @param string  $objectType         Name of treated entity type
     * @param array   $templateParameters Template data
     *
     * @return array Enriched template parameters used for creating the response
     */
    public function processEditActionParameters($objectType, array $templateParameters = [])
    {
        $contextArgs = ['controller' => $objectType, 'action' => 'edit'];
        if (!in_array($objectType, $this->getObjectTypes('controllerAction', $contextArgs))) {
            throw new \Exception($this->__('Error! Invalid object type received.'));
        }
    
        return $this->addTemplateParameters($objectType, $templateParameters, 'controllerAction', $contextArgs);
    }

    /**
     * Processes the parameters for a delete action.
     *
     * @param string  $objectType         Name of treated entity type
     * @param array   $templateParameters Template data
     * @param boolean $hasHookSubscriber  Whether hook subscribers are supported or not
     *
     * @return array Enriched template parameters used for creating the response
     */
    public function processDeleteActionParameters($objectType, array $templateParameters = [], $hasHookSubscriber = false)
    {
        $contextArgs = ['controller' => $objectType, 'action' => 'delete'];
        if (!in_array($objectType, $this->getObjectTypes('controllerAction', $contextArgs))) {
            throw new \Exception($this->__('Error! Invalid object type received.'));
        }
    
        return $this->addTemplateParameters($objectType, $templateParameters, 'controllerAction', $contextArgs);
    }

    /**
     * Returns an array of additional template variables which are specific to the object type.
     *
     * @param string $objectType Name of treated entity type
     * @param array  $parameters Given parameters to enrich
     * @param string $context    Usage context (allowed values: controllerAction, api, actionHandler, block, contentType)
     * @param array  $args       Additional arguments
     *
     * @return array List of template variables to be assigned
     */
    public function addTemplateParameters($objectType = '', array $parameters = [], $context = '', array $args = [])
    {
        if (!in_array($context, ['controllerAction', 'api', 'actionHandler', 'block', 'contentType', 'mailz'])) {
            $context = 'controllerAction';
        }
    
        if ($context == 'controllerAction') {
            if (!isset($args['action'])) {
                $routeName = $this->request->get('_route');
                $routeNameParts = explode('_', $routeName);
                $args['action'] = end($routeNameParts);
            }
            if (in_array($args['action'], ['index', 'view'])) {
                $parameters = array_merge($parameters, $this->collectionFilterHelper->getViewQuickNavParameters($objectType, $context, $args));
            }
    
            // initialise Imagine runtime options
            if ($objectType == 'album') {
                $thumbRuntimeOptions = [];
                $thumbRuntimeOptions[$objectType . 'TitleImage'] = $this->imageHelper->getRuntimeOptions($objectType, 'titleImage', $context, $args);
                $parameters['thumbRuntimeOptions'] = $thumbRuntimeOptions;
            }
            if ($objectType == 'albumItem') {
                $thumbRuntimeOptions = [];
                $thumbRuntimeOptions[$objectType . 'Image'] = $this->imageHelper->getRuntimeOptions($objectType, 'image', $context, $args);
                $parameters['thumbRuntimeOptions'] = $thumbRuntimeOptions;
            }
            if (in_array($args['action'], ['display', 'edit', 'view'])) {
                // use separate preset for images in related items
                $parameters['relationThumbRuntimeOptions'] = $this->imageHelper->getCustomRuntimeOptions('', '', 'RKFineArtPhotographerModule_relateditem', $context, $args);
            }
        }
    
        $parameters['featureActivationHelper'] = $this->featureActivationHelper;
    
        return $parameters;
    }
}
