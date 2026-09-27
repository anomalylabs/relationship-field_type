<?php namespace Anomaly\RelationshipFieldType\Command;

use Anomaly\Streams\Platform\Support\Collection;
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
     * @return Collection
     */
    public function handle()
    {
        try {
            $config = json_decode(Crypt::decrypt($this->key, false), true);
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
