<?php namespace Anomaly\RelationshipFieldType\Command;

use Anomaly\Streams\Platform\Support\Collection;
use Illuminate\Contracts\Bus\SelfHandling;
use Illuminate\Contracts\Cache\Repository;

/**
 * Class GetConfiguration
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\RelationshipFieldType\Command
 */
class GetConfiguration implements SelfHandling
{

    /**
     * The config key.
     *
     * @var string
     */
    protected $key;

    /**
     * Create a new GetConfiguration instance.
     *
     * @param string $key
     */
    public function __construct($key)
    {
        $this->key = $key;
    }

    /**
     * Handle the command.
     *
     * @param Repository $cache
     * @return Collection
     */
    public function handle(Repository $cache)
    {
        return new Collection($cache->get('anomaly/relationship-field_type::' . $this->key));
    }
}
