<?php namespace Anomaly\RelationshipFieldType\Command;

use Anomaly\RelationshipFieldType\RelationshipFieldType;
use Anomaly\RelationshipFieldType\Table\ValueTableBuilder;
use Anomaly\Streams\Platform\Addon\Addon;
use Anomaly\Streams\Platform\Addon\AddonCollection;
use Illuminate\Contracts\Bus\SelfHandling;
use Illuminate\Contracts\Config\Repository;

/**
 * Class GetValueDefinition
 *
 * @link          http://pyrocms.com/
 * @author        PyroCMS, Inc. <support@pyrocms.com>
 * @author        Ryan Thompson <ryan@pyrocms.com>
 * @package       Anomaly\RelationshipFieldType\Command
 */
class GetValueDefinition implements SelfHandling
{

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
     * @param RelationshipFieldType $fieldType
     * @param AddonCollection       $addons
     * @param Repository            $config
     * @return array
     */
    public function handle(RelationshipFieldType $fieldType, AddonCollection $addons, Repository $config)
    {
        $definition = [];

        /* @var Addon $addon */
        foreach ($addons->withConfig('value.' . $this->table->config('related')) as $addon) {
            $definition = $config->get($addon->getNamespace('value.' . $this->table->config('related')));
        }

        $definition = $config->get($fieldType->getNamespace('value.' . $this->table->config('related')), $definition);

        return $definition;
    }
}
