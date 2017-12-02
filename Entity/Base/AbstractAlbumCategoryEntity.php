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

namespace RK\FineArtPhotographerModule\Entity\Base;

use Doctrine\ORM\Mapping as ORM;
use Zikula\CategoriesModule\Entity\AbstractCategoryAssignment;

/**
 * Entity extension domain class storing album categories.
 *
 * This is the base category class for album entities.
 */
abstract class AbstractAlbumCategoryEntity extends AbstractCategoryAssignment
{
    /**
     * @ORM\ManyToOne(targetEntity="\RK\FineArtPhotographerModule\Entity\AlbumEntity", inversedBy="categories")
     * @ORM\JoinColumn(name="entityId", referencedColumnName="id")
     * @var \RK\FineArtPhotographerModule\Entity\AlbumEntity
     */
    protected $entity;
    
    /**
     * Get reference to owning entity.
     *
     * @return \RK\FineArtPhotographerModule\Entity\AlbumEntity
     */
    public function getEntity()
    {
        return $this->entity;
    }
    
    /**
     * Set reference to owning entity.
     *
     * @param \RK\FineArtPhotographerModule\Entity\AlbumEntity $entity
     */
    public function setEntity(/*\RK\FineArtPhotographerModule\Entity\AlbumEntity */$entity)
    {
        $this->entity = $entity;
    }
}
