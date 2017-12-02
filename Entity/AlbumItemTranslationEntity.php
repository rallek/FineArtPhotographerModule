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

use RK\FineArtPhotographerModule\Entity\Base\AbstractAlbumItemTranslationEntity as BaseEntity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Entity extension domain class storing album item translations.
 *
 * This is the concrete translation class for album item entities.
 *
 * @ORM\Entity(repositoryClass="RK\FineArtPhotographerModule\Entity\Repository\AlbumItemTranslationRepository")
 * @ORM\Table(name="rk_faph_albumitem_translation",
 *     indexes={
 *         @ORM\Index(name="translations_lookup_idx", columns={
 *             "locale", "object_class", "foreign_key"
 *         })
 *     }
 * )
 */
class AlbumItemTranslationEntity extends BaseEntity
{
    // feel free to add your own methods here
}