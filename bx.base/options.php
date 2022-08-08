<?php

use Bitrix\Main\Localization\Loc;
use Bx\Base\Options\OptionsPage;


Loc::loadMessages(__FILE__);

$optionsPage = new OptionsPage();

// Вкладка "Настройки"
$settingsTab = $optionsPage->addTab('settings', Loc::getMessage("BX_BASE_OPTIONS_SETTINGS"));

$optionsPage->display();