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

namespace RK\FineArtPhotographerModule\Entity;

use RK\FineArtPhotographerModule\Entity\Base\AbstractAlbumItemCategoryEntity as BaseEntity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Entity extension domain class storing album item categories.
 *
 * This is the concrete category class for album item entities.
 * @ORM\Entity(repositoryClass="\RK\FineArtPhotographerModule\Entity\Repository\AlbumItemCategoryRepository")
 * @ORM\Table(name="rk_faph_albumitem_category",
 *     uniqueConstraints={
 *         @ORM\UniqueConstraint(name="cat_unq", columns={"registryId", "categoryId", "entityId"})
 *     }
 * )
 */
class AlbumItemCategoryEntity extends BaseEntity
{
    // feel free to add your own methods here
}
