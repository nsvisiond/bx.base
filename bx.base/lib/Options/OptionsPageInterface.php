<?php
declare(strict_types=1);

namespace Bx\Base\Options;


/**
 *  Интерфейс, организующий процесс отрисовки страницы настроек (Options) модуля
 */
interface OptionsPageInterface
{

    /**
     * Возвращает HTML код элемента для показа на странице настроек
     * @return void
     */
    public function display(): void;
}