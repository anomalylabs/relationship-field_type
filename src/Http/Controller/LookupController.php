<?php namespace Anomaly\RelationshipFieldType\Http\Controller;

use Anomaly\RelationshipFieldType\Command\GetConfiguration;
use Anomaly\RelationshipFieldType\Table\LookupTableBuilder;
use Anomaly\RelationshipFieldType\Table\ValueTableBuilder;
use Anomaly\Streams\Platform\Http\Controller\AdminController;
use Anomaly\Streams\Platform\Support\Collection;

/**
 * Class LookupController
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class LookupController extends AdminController
{

    /**
     * Return an index of entries from related stream.
     *
     * @param $key
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function index($key)
    {
        /* @var Collection $config */
        $config = dispatch_now(new GetConfiguration($key));

        $related = app($config->get('related'));

        if ($table = $config->get('lookup_table')) {
            $table = app($table);
        } else {
            $table = $related->newRelationshipFieldTypeLookupTableBuilder();
        }

        /* @var LookupTableBuilder $table */
        $table->setConfig($config)
            ->setModel($related);

        return $table->render();
    }

    /**
     * Return the selected entries.
     *
     * @param $key
     * @return null|string
     */
    public function selected($key)
    {
        /* @var Collection $config */
        $config = dispatch_now(new GetConfiguration($key));

        $related = app($config->get('related'));

        if ($table = $config->get('value_table')) {
            $table = app($table);
        } else {
            $table = $related->newRelationshipFieldTypeValueTableBuilder();
        }

        /* @var ValueTableBuilder $table */
        $table->setSelected(request('uploaded'))
            ->setConfig($config)
            ->setModel($related)
            ->build()
            ->load();

        return $table->getTableContent();
    }
}
