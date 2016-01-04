<?php namespace Anomaly\RelationshipFieldType\Http\Controller;

use Anomaly\RelationshipFieldType\Command\GetConfiguration;
use Anomaly\RelationshipFieldType\Command\HydrateLookupTable;
use Anomaly\RelationshipFieldType\Command\HydrateValueTree;
use Anomaly\RelationshipFieldType\Table\LookupTableBuilder;
use Anomaly\RelationshipFieldType\Tree\ValueTreeBuilder;
use Anomaly\Streams\Platform\Http\Controller\AdminController;
use Anomaly\Streams\Platform\Support\Collection;
use Illuminate\Contracts\Cache\Repository;

/**
 * Class LookupController
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\RelationshipFieldType\Http\Controller
 */
class LookupController extends AdminController
{

    /**
     * Return an index of entries from related stream.
     *
     * @param LookupTableBuilder $table
     * @param                    $key
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function index(LookupTableBuilder $table, $key)
    {
        /* @var Collection $config */
        $config = $this->dispatch(new GetConfiguration($key));

        $table
            ->setConfig($config)
            ->setModel($config->get('related'));

        $this->dispatch(new HydrateLookupTable($table));

        return $table->render();
    }

    /**
     * Return the selected entries.
     *
     * @param ValueTreeBuilder $tree
     * @param                  $key
     * @return null|string
     */
    public function selected(ValueTreeBuilder $tree, $key)
    {
        /* @var Collection $config */
        $config = $this->dispatch(new GetConfiguration($key));

        $tree
            ->setConfig($config)
            ->setModel($config->get('related'))
            ->setSelected($this->request->get('uploaded'));

        $this->dispatch(new HydrateValueTree($tree));

        return $tree->build()->response()->getTreeContent();
    }
}
