<?php

namespace App\Models\Traits;

use App\Dictionaries\EntityEventDictionary;

/**
 * Управляет действиями для внешних ресурсов (фронта)
 * Trait ExternalEventsTrait
 */
trait ExternalEventsTrait
{
    /**
     * Возвращает действия
     *
     * @return array
     */
    public function getExternalEvents(): array
    {
        return [];
    }

    /**
     * Возвращает только разрешенные действия
     *
     * @return array
     */
    public function getExternalEventsWithTitle(): array
    {
        $result = [];

        foreach ($this->getExternalEvents() as $event => $b) {
            $result[] = [
                'name'   => $event,
                'allowed' => $b,
                'title'   => EntityEventDictionary::getTitleById($event),
            ];
        }

        return $result;
    }

}
