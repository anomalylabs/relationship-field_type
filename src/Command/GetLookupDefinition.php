<?php namespace Anomaly\RelationshipFieldType\Command;

use Anomaly\RelationshipFieldType\RelationshipFieldType;
use Anomaly\RelationshipFieldType\Table\LookupTableBuilder;
use Anomaly\Streams\Platform\Addon\Addon;
use Anomaly\Streams\Platform\Addon\AddonCollection;
use Illuminate\Contracts\Bus\SelfHandling;
use Illuminate\Contracts\Config\Repository;
use Illuminate\Contracts\Container\Container;

/**
 * Class GetLookupDefinition
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\RelationshipFieldType\Command
 */
class GetLookupDefinition implements SelfHandling
{

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
     * @param RelationshipFieldType $fieldType
     * @param AddonCollection       $addons
     * @param Container             $container
     * @param Repository            $config
     * @return array
     */
    public function handle(
        RelationshipFieldType $fieldType,
        AddonCollection $addons,
        Container $container,
        Repository $config
    ) {
        $definition = [];

        $class = get_class($container->make($this->table->config('related')));

        /* @var Addon $addon */
        foreach ($addons->withConfig('lookup.' . $class) as $addon) {
            $definition = $config->get($addon->getNamespace('lookup.' . $class));
        }

        $definition = $config->get($fieldType->getNamespace('lookup.' . $class), $definition);

        return $definition;
    }
}
