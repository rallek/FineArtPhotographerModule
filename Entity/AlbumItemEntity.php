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

use RK\FineArtPhotographerModule\Entity\Base\AbstractAlbumItemEntity as BaseEntity;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * Entity class that defines the entity structure and behaviours.
 *
 * This is the concrete entity class for album item entities.
 * @Gedmo\TranslationEntity(class="RK\FineArtPhotographerModule\Entity\AlbumItemTranslationEntity")
 * @ORM\Entity(repositoryClass="RK\FineArtPhotographerModule\Entity\Repository\AlbumItemRepository")
 * @ORM\Table(name="rk_faph_albumitem",
 *     indexes={
 *         @ORM\Index(name="workflowstateindex", columns={"workflowState"})
 *     }
 * )
 */
class AlbumItemEntity extends BaseEntity
{
    // feel free to add your own methods here
}
