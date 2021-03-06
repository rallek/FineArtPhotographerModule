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

namespace RK\FineArtPhotographerModule;

use RK\FineArtPhotographerModule\Base\AbstractFineArtPhotographerModuleInstaller;

/**
 * Installer implementation class.
 */
class FineArtPhotographerModuleInstaller extends AbstractFineArtPhotographerModuleInstaller
{
    // feel free to extend the installer here
	
public function install()

{

    $result = parent::install();

    if (true === $result) {

        // eigene Werte setzen
        // set up all our vars with initial values
        // $this->setVar('albumEntriesPerPage', 10);
        // $this->setVar('linkOwnAlbumsOnAccountPage', true);
        // $this->setVar('albumItemEntriesPerPage', 10);
        // $this->setVar('linkOwnAlbumItemsOnAccountPage', true);
        // $this->setVar('enableShrinkingForAlbumItemImage', false);
        $this->setVar('shrinkWidthAlbumItemImage', 3600);
        $this->setVar('shrinkHeightAlbumItemImage', 1200);
        $this->setVar('thumbnailModeAlbumItemImage', 'inset');
        $this->setVar('thumbnailWidthAlbumItemImageView', 150);
        $this->setVar('thumbnailHeightAlbumItemImageView', 50);
        $this->setVar('thumbnailWidthAlbumItemImageDisplay', 900);
        $this->setVar('thumbnailHeightAlbumItemImageDisplay', 300);
        $this->setVar('thumbnailWidthAlbumItemImageEdit', 480);
        $this->setVar('thumbnailHeightAlbumItemImageEdit', 180);
        // $this->setVar('enabledFinderTypes', 'album###albumItem');
		
    }

    return $result;
}
