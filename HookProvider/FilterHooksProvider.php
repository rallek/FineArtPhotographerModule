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

namespace RK\FineArtPhotographerModule\HookProvider;

use Zikula\Bundle\HookBundle\Hook\FilterHook;
use RK\FineArtPhotographerModule\HookProvider\Base\AbstractFilterHooksProvider;

/**
 * Implementation class for filter hooks provider.
 */
class FilterHooksProvider extends AbstractFilterHooksProvider
{
    /**
     * @inheritDoc
     */
    public function applyFilter(FilterHook $hook)
    {
        // replace this by your own filter operation
        parent::applyFilter($hook);
    }

    // feel free to add your own convenience methods here
}