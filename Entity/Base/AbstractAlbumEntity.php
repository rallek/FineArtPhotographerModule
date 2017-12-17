<?php
/**
 * FineArtPhotographer.
 *
 * @copyright Ralf Koester (RK)
 * @license http://www.gnu.org/licenses/lgpl.html GNU Lesser General Public License
 * @author Ralf Koester <ralf@familie-koester.de>.
 * @link http://k62.de
 * @link http://zikula.org
 * @version Generated by ModuleStudio 1.3.0 (https://modulestudio.de).
 */

namespace RK\FineArtPhotographerModule\Entity\Base;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Gedmo\Mapping\Annotation as Gedmo;
use Gedmo\Translatable\Translatable;
use Symfony\Component\Validator\Constraints as Assert;
use Zikula\Core\Doctrine\EntityAccess;
use RK\FineArtPhotographerModule\Traits\StandardFieldsTrait;
use RK\FineArtPhotographerModule\Validator\Constraints as FineArtPhotographerAssert;

/**
 * Entity class that defines the entity structure and behaviours.
 *
 * This is the base entity class for album entities.
 * The following annotation marks it as a mapped superclass so subclasses
 * inherit orm properties.
 *
 * @ORM\MappedSuperclass
 */
abstract class AbstractAlbumEntity extends EntityAccess implements Translatable
{
    /**
     * Hook standard fields behaviour embedding createdBy, updatedBy, createdDate, updatedDate fields.
     */
    use StandardFieldsTrait;

    /**
     * @var string The tablename this object maps to
     */
    protected $_objectType = 'album';
    
    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer", unique=true)
     * @var integer $id
     */
    protected $id = 0;
    
    /**
     * the current workflow state
     *
     * @ORM\Column(length=20)
     * @Assert\NotBlank()
     * @FineArtPhotographerAssert\ListEntry(entityName="album", propertyName="workflowState", multiple=false)
     * @var string $workflowState
     */
    protected $workflowState = 'initial';
    
    /**
     * Choose a title for your album. The event name seem to be a good choice. Date and creator name will be automatically included.
     *
     * @Gedmo\Translatable
     * @ORM\Column(length=255)
     * @Assert\NotBlank()
     * @Assert\Length(min="0", max="255")
     * @var string $albumTitle
     */
    protected $albumTitle = '';
    
    /**
     * The date will be included in the headline
     *
     * @ORM\Column(type="date")
     * @Assert\NotBlank()
     * @Assert\Date()
     * @var date $albumDate
     */
    protected $albumDate;
    
    /**
     * This description is used to give a short introduction about the event. It is not mandatory.
     *
     * @Gedmo\Translatable
     * @ORM\Column(type="text", length=2000)
     * @Assert\NotNull()
     * @Assert\Length(min="0", max="2000")
     * @var text $albumDescription
     */
    protected $albumDescription = '';
    
    
    /**
     * Used locale to override Translation listener's locale.
     * this is not a mapped field of entity metadata, just a simple property.
     *
     * @Assert\Locale()
     * @Gedmo\Locale
     * @var string $locale
     */
    protected $locale;
    
    /**
     * @ORM\OneToMany(targetEntity="\RK\FineArtPhotographerModule\Entity\AlbumCategoryEntity", 
     *                mappedBy="entity", cascade={"all"}, 
     *                orphanRemoval=true)
     * @var \RK\FineArtPhotographerModule\Entity\AlbumCategoryEntity
     */
    protected $categories = null;
    
    /**
     * Bidirectional - One album [album] has many albumItems [album items] (INVERSE SIDE).
     *
     * @ORM\OneToMany(targetEntity="RK\FineArtPhotographerModule\Entity\AlbumItemEntity", mappedBy="album")
     * @ORM\JoinTable(name="rk_faph_albumalbumitems")
     * @var \RK\FineArtPhotographerModule\Entity\AlbumItemEntity[] $albumItems
     */
    protected $albumItems = null;
    
    
    /**
     * AlbumEntity constructor.
     *
     * Will not be called by Doctrine and can therefore be used
     * for own implementation purposes. It is also possible to add
     * arbitrary arguments as with every other class method.
     */
    public function __construct()
    {
        $this->albumItems = new ArrayCollection();
        $this->categories = new ArrayCollection();
    }
    
    /**
     * Returns the _object type.
     *
     * @return string
     */
    public function get_objectType()
    {
        return $this->_objectType;
    }
    
    /**
     * Sets the _object type.
     *
     * @param string $_objectType
     *
     * @return void
     */
    public function set_objectType($_objectType)
    {
        if ($this->_objectType != $_objectType) {
            $this->_objectType = $_objectType;
        }
    }
    
    
    /**
     * Returns the id.
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }
    
    /**
     * Sets the id.
     *
     * @param integer $id
     *
     * @return void
     */
    public function setId($id)
    {
        if (intval($this->id) !== intval($id)) {
            $this->id = intval($id);
        }
    }
    
    /**
     * Returns the workflow state.
     *
     * @return string
     */
    public function getWorkflowState()
    {
        return $this->workflowState;
    }
    
    /**
     * Sets the workflow state.
     *
     * @param string $workflowState
     *
     * @return void
     */
    public function setWorkflowState($workflowState)
    {
        if ($this->workflowState !== $workflowState) {
            $this->workflowState = isset($workflowState) ? $workflowState : '';
        }
    }
    
    /**
     * Returns the album title.
     *
     * @return string
     */
    public function getAlbumTitle()
    {
        return $this->albumTitle;
    }
    
    /**
     * Sets the album title.
     *
     * @param string $albumTitle
     *
     * @return void
     */
    public function setAlbumTitle($albumTitle)
    {
        if ($this->albumTitle !== $albumTitle) {
            $this->albumTitle = isset($albumTitle) ? $albumTitle : '';
        }
    }
    
    /**
     * Returns the album date.
     *
     * @return date
     */
    public function getAlbumDate()
    {
        return $this->albumDate;
    }
    
    /**
     * Sets the album date.
     *
     * @param date $albumDate
     *
     * @return void
     */
    public function setAlbumDate($albumDate)
    {
        if ($this->albumDate !== $albumDate) {
            if (!(null == $albumDate && empty($albumDate)) && !(is_object($albumDate) && $albumDate instanceOf \DateTimeInterface)) {
                $albumDate = new \DateTime($albumDate);
            }
            
            if (null === $albumDate || empty($albumDate)) {
                $albumDate = new \DateTime();
            }
            
            if ($this->albumDate != $albumDate) {
                $this->albumDate = $albumDate;
            }
        }
    }
    
    /**
     * Returns the album description.
     *
     * @return text
     */
    public function getAlbumDescription()
    {
        return $this->albumDescription;
    }
    
    /**
     * Sets the album description.
     *
     * @param text $albumDescription
     *
     * @return void
     */
    public function setAlbumDescription($albumDescription)
    {
        if ($this->albumDescription !== $albumDescription) {
            $this->albumDescription = isset($albumDescription) ? $albumDescription : '';
        }
    }
    
    /**
     * Returns the locale.
     *
     * @return string
     */
    public function getLocale()
    {
        return $this->locale;
    }
    
    /**
     * Sets the locale.
     *
     * @param string $locale
     *
     * @return void
     */
    public function setLocale($locale)
    {
        if ($this->locale != $locale) {
            $this->locale = $locale;
        }
    }
    
    /**
     * Returns the categories.
     *
     * @return ArrayCollection[]
     */
    public function getCategories()
    {
        return $this->categories;
    }
    
    
    /**
     * Sets the categories.
     *
     * @param ArrayCollection $categories List of categories
     *
     * @return void
     */
    public function setCategories(ArrayCollection $categories)
    {
        foreach ($this->categories as $category) {
            if (false === $key = $this->collectionContains($categories, $category)) {
                $this->categories->removeElement($category);
            } else {
                $categories->remove($key);
            }
        }
        foreach ($categories as $category) {
            $this->categories->add($category);
        }
    }
    
    /**
     * Checks if a collection contains an element based only on two criteria (categoryRegistryId, category).
     *
     * @param ArrayCollection $collection Given collection
     * @param \RK\FineArtPhotographerModule\Entity\AlbumCategoryEntity $element Element to search for
     *
     * @return bool|int
     */
    private function collectionContains(ArrayCollection $collection, \RK\FineArtPhotographerModule\Entity\AlbumCategoryEntity $element)
    {
        foreach ($collection as $key => $category) {
            /** @var \RK\FineArtPhotographerModule\Entity\AlbumCategoryEntity $category */
            if ($category->getCategoryRegistryId() == $element->getCategoryRegistryId()
                && $category->getCategory() == $element->getCategory()
            ) {
                return $key;
            }
        }
    
        return false;
    }
    
    /**
     * Returns the album items.
     *
     * @return \RK\FineArtPhotographerModule\Entity\AlbumItemEntity[]
     */
    public function getAlbumItems()
    {
        return $this->albumItems;
    }
    
    /**
     * Sets the album items.
     *
     * @param \RK\FineArtPhotographerModule\Entity\AlbumItemEntity[] $albumItems
     *
     * @return void
     */
    public function setAlbumItems($albumItems)
    {
        foreach ($this->albumItems as $albumItemSingle) {
            $this->removeAlbumItems($albumItemSingle);
        }
        foreach ($albumItems as $albumItemSingle) {
            $this->addAlbumItems($albumItemSingle);
        }
    }
    
    /**
     * Adds an instance of \RK\FineArtPhotographerModule\Entity\AlbumItemEntity to the list of album items.
     *
     * @param \RK\FineArtPhotographerModule\Entity\AlbumItemEntity $albumItem The instance to be added to the collection
     *
     * @return void
     */
    public function addAlbumItems(\RK\FineArtPhotographerModule\Entity\AlbumItemEntity $albumItem)
    {
        $this->albumItems->add($albumItem);
        $albumItem->setAlbum($this);
    }
    
    /**
     * Removes an instance of \RK\FineArtPhotographerModule\Entity\AlbumItemEntity from the list of album items.
     *
     * @param \RK\FineArtPhotographerModule\Entity\AlbumItemEntity $albumItem The instance to be removed from the collection
     *
     * @return void
     */
    public function removeAlbumItems(\RK\FineArtPhotographerModule\Entity\AlbumItemEntity $albumItem)
    {
        $this->albumItems->removeElement($albumItem);
        $albumItem->setAlbum(null);
    }
    
    
    
    /**
     * Creates url arguments array for easy creation of display urls.
     *
     * @return array List of resulting arguments
     */
    public function createUrlArgs()
    {
        return [
            'id' => $this->getId()
        ];
    }
    
    /**
     * Returns the primary key.
     *
     * @return integer The identifier
     */
    public function getKey()
    {
        return $this->getId();
    }
    
    /**
     * Determines whether this entity supports hook subscribers or not.
     *
     * @return boolean
     */
    public function supportsHookSubscribers()
    {
        return true;
    }
    
    /**
     * Return lower case name of multiple items needed for hook areas.
     *
     * @return string
     */
    public function getHookAreaPrefix()
    {
        return 'rkfineartphotographermodule.ui_hooks.albums';
    }
    
    /**
     * Returns an array of all related objects that need to be persisted after clone.
     * 
     * @param array $objects Objects that are added to this array
     * 
     * @return array List of entity objects
     */
    public function getRelatedObjectsToPersist(&$objects = [])
    {
        return [];
    }
    
    /**
     * ToString interceptor implementation.
     * This method is useful for debugging purposes.
     *
     * @return string The output string for this entity
     */
    public function __toString()
    {
        return 'Album ' . $this->getKey() . ': ' . $this->getAlbumTitle();
    }
    
    /**
     * Clone interceptor implementation.
     * This method is for example called by the reuse functionality.
     * Performs a quite simple shallow copy.
     *
     * See also:
     * (1) http://docs.doctrine-project.org/en/latest/cookbook/implementing-wakeup-or-clone.html
     * (2) http://www.php.net/manual/en/language.oop5.cloning.php
     * (3) http://stackoverflow.com/questions/185934/how-do-i-create-a-copy-of-an-object-in-php
     */
    public function __clone()
    {
        // if the entity has no identity do nothing, do NOT throw an exception
        if (!$this->id) {
            return;
        }
    
        // otherwise proceed
    
        // unset identifier
        $this->setId(0);
    
        // reset workflow
        $this->setWorkflowState('initial');
    
        $this->setCreatedBy(null);
        $this->setCreatedDate(null);
        $this->setUpdatedBy(null);
        $this->setUpdatedDate(null);
    
    
        // clone categories
        $categories = $this->categories;
        $this->categories = new ArrayCollection();
        foreach ($categories as $c) {
            $newCat = clone $c;
            $this->categories->add($newCat);
            $newCat->setEntity($this);
        }
    }
}
