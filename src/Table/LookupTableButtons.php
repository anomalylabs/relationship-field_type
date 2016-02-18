<?php namespace Anomaly\RelationshipFieldType\Table;

use Illuminate\Contracts\Bus\SelfHandling;

/**
 * Class LookupTableButtons
 *
 * @link          http://pyrocms.com/
 * @author        PyroCMS, Inc. <support@pyrocms.com>
 * @author        Ryan Thompson <ryan@pyrocms.com>
 * @package       Anomaly\RelationshipFieldType\Table
 */
class LookupTableButtons implements SelfHandling
{

    /**
     * Handle the command.
     *
     * @param LookupTableBuilder $builder
     */
    public function handle(LookupTableBuilder $builder)
    {
        $builder->setButtons(
            [
                'select' => [
                    'data-entry' => 'entry.id',
                    'data-key'   => $builder->config('key')
                ]
            ]
        );
    }
}
