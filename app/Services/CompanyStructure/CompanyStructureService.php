<?php

namespace App\Services\CompanyStructure;

/**
 * Структура компании
 * Class CompanyStructureService
 */
class CompanyStructureService
{

    /**
     * @var DataProvider
     */
    private $dataProvider;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->dataProvider = new DataProvider($this);
    }

    /**
     * @return DataProvider
     */
    public function dataProvider(): DataProvider
    {
        return $this->dataProvider;
    }

}
