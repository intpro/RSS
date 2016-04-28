<?php namespace Interpro\RSS\Laravel\Handle;

use Interpro\RSS\Concept\Command\FetchRSSCommand;
use willvincent\Feeds\Facades\FeedsFacade;

class FetchRSSCommandHandler {

    /**
     *
     * @return void
     */
    public function __construct()
    {
    }

    /**
     * Handle the command.
     *
     * @return void
     */
    public function handle(FetchRSSCommand $command)
    {
        $links_config = config('rss')['links'];
        $limit = config('rss')['limit'];

        if(array_key_exists($command->link_name, $links_config))
        {
            $feed = FeedsFacade::make([
                        $links_config[$command->link_name]
                    ], $limit);

            $data = array(
                'title'     => $feed->get_title(),
                'permalink' => $feed->get_permalink(),
                'items'     => $feed->get_items(),
            );
        }

    }

}
