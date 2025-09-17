<?php

namespace App\Extensions\DataBase\Query;

use App\Dto\SortDto;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

/**
 * Установка сортировки в запросах на основе данных App\Dto\SortDto
 * Trait SettingSortingInQueriesTrait
 */
trait SettingOrderInQueriesTrait
{
    /**
     * @var string[]
     */
    private $addedRelations = [];

    /**
     * Добавляет сортировку к запросам по всем параметрам
     * !!! Рекомендуется добавить $query->select($user->getTable() . '.*'); в базовом методе, иначе
     * могут быть проблемы при обращении к связанным сущностям через название их свойства, если в этом трейте
     * установится связь по join
     *
     * @param Model $baseModel
     * @param Builder $query
     * @param array $sort
     * @return void
     */
    protected function addOrderIntoQueryAsArray(Model $baseModel, Builder $query, array $sort)
    {
        foreach ($sort as $sortDto) {
            $this->addOrderIntoQuery(
                $baseModel,
                $query,
                $sortDto
            );
        }
    }

    /**
     * Добавляет сортировку к запросам по одному параметру
     *
     * @param Model $baseModel
     * @param Builder $query
     * @param SortDto $sortDto
     * @return void
     */
    protected function addOrderIntoQuery(Model $baseModel, Builder $query, SortDto $sortDto)
    {
        foreach ($sortDto->relates as $relateAlias) {
            $this->addRelateIntoQuery(
                $relateAlias,
                $baseModel,
                $query
            );

            $baseModel = $baseModel->$relateAlias()->getModel();
        }

        $query->orderBy(
            $sortDto->field,
            $sortDto->direction
        );
    }

    /**
     * Устанавливаем связи со связанными таблицами
     *
     * @param string $relateAlias
     * @param Model $baseModel
     * @param Builder $query
     * @return void
     */
    private function addRelateIntoQuery(string $relateAlias, Model $baseModel, Builder $query)
    {
        if (in_array($relateAlias, $this->addedRelations)) {
            return;
        }

        $relation = $baseModel->$relateAlias();
        $relationType = Str::afterLast(get_class($relation), '\\');

        switch ($relationType) {
            case 'BelongsTo':
                $query->leftJoin(
                    $baseModel->$relateAlias()->getModel()->getTable(),
                    $baseModel->getTable() . '.' . $baseModel->$relateAlias()->getForeignKeyName(),
                    '=',
                    $baseModel->$relateAlias()->getModel()->getTable() . '.id'
                );
                break;
            case 'HasOne' :
                $query->leftJoin(
                    $baseModel->$relateAlias()->getModel()->getTable(),
                    $baseModel->$relateAlias()->getModel()->getTable() . '.' . $baseModel->$relateAlias()->getForeignKeyName(),
                    '=',
                    $baseModel->getTable() . '.id'
                );
                break;
        }

        $this->addedRelations[] = $relateAlias;
    }

}
