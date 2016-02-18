<?php namespace Anomaly\RelationshipFieldType\Command;

use Anomaly\RelationshipFieldType\Table\LookupTableBuilder;
use Anomaly\Streams\Platform\Support\Hydrator;
use Illuminate\Contracts\Bus\SelfHandling;
use Illuminate\Contracts\Config\Repository;
use Illuminate\Foundation\Bus\DispatchesJobs;

/**
 * Class HydrateLookupTable
 *
 * @link          http://pyrocms.com/
 * @author        PyroCMS, Inc. <support@pyrocms.com>
 * @author        Ryan Thompson <ryan@pyrocms.com>
 * @package       Anomaly\RelationshipFieldType\Command
 */
class HydrateLookupTable implements SelfHandling
{

    use DispatchesJobs;

    /**
     * The lookup table.
     *
     * @var LookupTableBuilder
     */
    protected $table;

    /**
     * Create a new HydrateLookupTable instance.
     *
     * @param LookupTableBuilder $table
     */
    public function __construct(LookupTableBuilder $table)
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
        if (!$definition = $this->dispatch(new GetLookupDefinition($this->table))) {
            return;
        }

        $hydrator->hydrate($this->table, $definition);
    }
}
