<?php namespace Anomaly\RelationshipFieldType\Http\Controller;

use Anomaly\RelationshipFieldType\Command\GetConfiguration;
use Anomaly\RelationshipFieldType\Command\HydrateValueTable;
use Anomaly\RelationshipFieldType\RelationshipFieldType;
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
     * @param RelationshipFieldType $fieldType
     * @param                       $key
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function index(RelationshipFieldType $fieldType, $key)
    {
        /* @var Collection $config */
        $config = dispatch_sync(new GetConfiguration($key));

        $fieldType->mergeConfig($config->all());

        $related = $fieldType->getRelatedModel();

        if ($table = $config->get('lookup_table')) {
            $table = $fieldType->makeTable($table, LookupTableBuilder::class);
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
     * @param RelationshipFieldType $fieldType
     * @param                       $key
     * @return null|string
     */
    public function selected(RelationshipFieldType $fieldType, $key)
    {
        /* @var Collection $config */
        $config = dispatch_sync(new GetConfiguration($key));

        $fieldType->mergeConfig($config->all());

        $related = $fieldType->getRelatedModel();

        if ($table = $config->get('value_table')) {
            $table = $fieldType->makeTable($table, ValueTableBuilder::class);
        } else {
            $table = $related->newRelationshipFieldTypeValueTableBuilder();
        }

        /* @var ValueTableBuilder $table */
        $table->setSelected($this->request->get('uploaded'))
            ->setConfig($config)
            ->setModel($related)
            ->build()
            ->load();

        return $table->getTableContent();
    }
}
