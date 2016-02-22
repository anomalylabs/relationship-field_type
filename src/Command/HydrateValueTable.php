<?php namespace Anomaly\RelationshipFieldType\Command;

use Anomaly\RelationshipFieldType\Table\ValueTableBuilder;
use Anomaly\Streams\Platform\Support\Hydrator;
use Illuminate\Contracts\Bus\SelfHandling;
use Illuminate\Contracts\Config\Repository;
use Illuminate\Foundation\Bus\DispatchesJobs;

/**
 * Class HydrateValueTable
 *
 * @link          http://pyrocms.com/
 * @author        PyroCMS, Inc. <support@pyrocms.com>
 * @author        Ryan Thompson <ryan@pyrocms.com>
 * @package       Anomaly\RelationshipFieldType\Command
 */
class HydrateValueTable implements SelfHandling
{

    use DispatchesJobs;

    /**
     * The value table.
     *
     * @var ValueTableBuilder
     */
    protected $table;

    /**
     * Create a new HydrateValueTable instance.
     *
     * @param ValueTableBuilder $table
     */
    public function __construct(ValueTableBuilder $table)
    {
        $this->table = $table;
    }

    /**
     * Handle the command.
     *
     * @param Hydrator $hydrator
     */
    public function handle(Hydrator $hydrator)
    {
        if (!$definition = $this->dispatch(new GetValueDefinition($this->table))) {
            return;
        }

        $hydrator->hydrate($this->table, $definition);
    }
}
