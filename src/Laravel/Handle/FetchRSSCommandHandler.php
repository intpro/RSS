<?php namespace Interpro\RSS\Laravel\Handle;

use Illuminate\Support\Facades\Bus;
use Interpro\QuickStorage\Concept\Command\CreateGroupItemCommand;
use Interpro\QuickStorage\Concept\Command\UpdateGroupItemCommand;
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
        $block_name = config('rss')['block_name'];
        $limit = config('rss')['limit'];

//        $feed = new \SimplePie();
//        $feed->set_feed_url($links_config);
//        $feed->enable_cache(false);
//        $feed->init();
//        $feed->handle_content_type();
//
//        $items = $feed->get_items();
//
//        foreach($items as $item)
//        {
//            $co = $item->get_content(true);
//        }

        if(array_key_exists($command->link_name, $links_config))
        {
            $feed = FeedsFacade::make([
                        $links_config[$command->link_name]
                    ], $limit, true);

            $data = array(
                'title'     => $feed->get_title(),
                'permalink' => $feed->get_permalink(),
                'items'     => $feed->get_items(),
            );

//            //$content_type     = $feed->handle_content_type();
//            $feed_title       = $feed->get_title(); // получаем заголовок RSS-ленты, например "Новости@Mail.Ru"
//            $feed_permalink   = $feed->get_permalink(); // постоянная ссылка новостной ленты, например "http://news.mail.ru/"
//            //$feed_favicon     = $feed->get_favicon(); // ссылка на favicon новостной ленты в формате .ico
//            $feed_image_url   = $feed->get_image_url(); // ссылка на картинку, которую использует фид для самоидентификации в формате .jpg, .gif или ином
//            $feed_description = $feed->get_description(); // забираем краткое описание ленты
//            $feed_encoding    = $feed->get_encoding(); // получаем кодировку документа
//            $feed_language    = $feed->get_language(); // узнаём на каком языке выводится данный фид, например "en-us", "ru-ru"

            foreach($data['items'] as $item)
            {
                $item_date    = $item->get_date('Y-m-d H:i:s'); // получаем дату/время в нужном формате
                $item_title   = $item->get_title(); // краткий заголовок новости
                $item_content = $item->get_content(); // содержание новости
                //$item_description = $item->get_description();
                $item_link    = $item->get_link(); // постоянная ссылка на новость на сайте-источнике


                $dataArr = Bus::dispatch(new CreateGroupItemCommand($block_name, 'news', 0));

                $dataobj = [];
                $dataobj['stringfields'] = ['link' => $item_link, 'news_title' => $item_title, 'news_date'=> $item_date, 'agregator'=>$command->link_name];
                $dataobj['textfields'] = ['about_news' => $item_content];

                Bus::dispatch(new UpdateGroupItemCommand($dataArr['id'], $dataobj));


                //$enclosures   = $item->get_enclosures(); // картинки и всякие прикреплённые к новости файлы

//                if(count($enclosures))
//                { // если у нас есть какие-нибудь картинки в новости
//                    foreach($enclosures as $enclosure){
//                        $enclosure_mime = $enclosure->get_real_type(); // получаем MIME-тип вложенного файла
//                        $enclosure_url  = $enclosure->get_link(); // вытягиваем ссылку на картинку
//                    }
//                }
            }

        }


    }

}
