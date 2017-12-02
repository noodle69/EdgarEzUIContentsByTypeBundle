<?php

namespace Edgar\EzUIContentsByTypeBundle\EventListener;

use EzSystems\EzPlatformAdminUi\Menu\Event\ConfigureMenuEvent;
use EzSystems\EzPlatformAdminUi\Menu\MainMenuBuilder;
use JMS\TranslationBundle\Translation\TranslationContainerInterface;
use JMS\TranslationBundle\Model\Message;

class ConfigureMenuListener implements TranslationContainerInterface
{
    const ITEM_CONTENT__LIST = 'main__content__list';

    /**
     * @param ConfigureMenuEvent $event
     */
    public function onMenuConfigure(ConfigureMenuEvent $event)
    {
        $menu = $event->getMenu();

        $contentMenu = $menu->getChild(MainMenuBuilder::ITEM_CONTENT);
        $contentMenu->addChild(self::ITEM_CONTENT__LIST, array('route' => 'edgar.uicontentsbytype.menu'));
    }

    /**
     * @return array
     */
    public static function getTranslationMessages(): array
    {
        return [
            (new Message(self::ITEM_CONTENT__LIST, 'messages'))->setDesc('Contents by type'),
        ];
    }
}
