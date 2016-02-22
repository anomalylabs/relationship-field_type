<?php namespace Anomaly\RelationshipFieldType\Http\Controller;

use Anomaly\RelationshipFieldType\Command\GetConfiguration;
use Anomaly\RelationshipFieldType\Command\HydrateLookupTable;
use Anomaly\RelationshipFieldType\Command\HydrateValueTable;
use Anomaly\RelationshipFieldType\Table\LookupTableBuilder;
use Anomaly\RelationshipFieldType\Table\ValueTableBuilder;
use Anomaly\Streams\Platform\Http\Controller\AdminController;
use Anomaly\Streams\Platform\Support\Collection;
use Illuminate\Contracts\Cache\Repository;

/**
 * Class LookupController
 *
 * @link          http://pyrocms.com/
 * @author        PyroCMS, Inc. <support@pyrocms.com>
 * @author        Ryan Thompson <ryan@pyrocms.com>
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
     * @param ValueTableBuilder $table
     * @param                   $key
     * @return null|string
     */
    public function selected(ValueTableBuilder $table, $key)
    {
        /* @var Collection $config */
        $config = $this->dispatch(new GetConfiguration($key));

        $table
            ->setConfig($config)
            ->setModel($config->get('related'))
            ->setSelected($this->request->get('uploaded'));

        $this->dispatch(new HydrateValueTable($table));

        return $table->build()->response()->getTableContent();
    }
}
