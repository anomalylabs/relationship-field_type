<?php namespace Anomaly\RelationshipFieldType\Command;

use Anomaly\Streams\Platform\Support\Collection;
use Illuminate\Contracts\Cache\Repository;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Support\Facades\Crypt;

class GetConfiguration
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
     * @param  Repository $cache
     * @return Collection
     */
    public function handle(Repository $cache)
    {
        try {
            $config = Crypt::decrypt($this->key);
        } catch (DecryptException $exception) {
            abort(404);
        }

        if (
            !is_array($config)
            || !isset($config['user'], $config['expires'])
            || (int)$config['user'] !== (int)auth()->id()
            || (int)$config['expires'] < time()
        ) {
            abort(404);
        }

        return new Collection(
            array_merge($config, ['key' => $this->key])
        );
    }
}
