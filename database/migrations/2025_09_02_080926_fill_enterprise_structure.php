<?php

use Illuminate\Database\Migrations\Migration;
use App\Models\CompanyStructure;
use App\Models\CompanyStructureType;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $locationTypeModel = CompanyStructureType::whereSlug('location')->first();
        $departmentTypeModel = CompanyStructureType::whereSlug('department')->first();
        $positionTypeModel = CompanyStructureType::whereSlug('position')->first();

        /** @var CompanyStructure $locationModel */
        $locationModel = (new CompanyStructure())->fill([
            'title' => 'Главная организация',
        ]);
        $locationModel->structureType()->associate($locationTypeModel);
        $locationModel->save();

        foreach ($this->getDatas() as $departament => $positions) {
            /** @var CompanyStructure $departamentModel */
            $departamentModel = (new CompanyStructure())->fill([
                'title' => $departament,
            ]);
            $departamentModel->structureType()->associate($departmentTypeModel);
            $departamentModel->save();
            $departamentModel->parent()->attach($locationModel);


            foreach ($positions as $position) {
                /** @var CompanyStructure $departamentModel */
                $positiontModel = (new CompanyStructure())->fill([
                    'title' => $position,
                ]);
                $positiontModel->structureType()->associate($positionTypeModel);
                $positiontModel->save();
                $positiontModel->parent()->attach($departamentModel);

            }
        }
    }

    /**
     * @return string[][]
     */
    public function getDatas()
    {
        return [
            'администрация отеля'              => [
                'администратор гостиницы',
                'генеральный менеджер',
            ],
            'бухгалтерия'                      => [
                'бухгалтер',
                'главный бухгалтер',
            ],
            'прачечная'                        => [
                'оператор прачечной',
            ],
            'служба безопасности'              => [
                'директор службы безопасности',
            ],
            'служба гостиничного хозяйства'    => [
                'горничная',
                'разнорабочий',
                'руководитель службы гостиничного хозяйства',
                'старшая горничная',
                'супервайзер службы гостиничного хозяйства',
            ],
            'служба закупок'                   => [
                'директор службы закупок',
                'заведующий складом',
                'кладовщик-приемщик',
                'менеджер по закупкам',
                'специалист по закупкам',
            ],
            'служба информационных технологий' => [
                'руководитель службы информационных технологий',
                'системный администратор',
            ],
            'служба персонала'                 => [
                'директор по персоналу',
                'менеджер по кадровому учету',
                'преподаватель в гостиничной сфере',
                'специалист по контролю сервиса и качества',
                'специалист по управлению персоналом в гостиничной сфере',
                'тренинг-менеджер служба персонала',
            ],
            'служба питания'                   => [
                'бармен',
                'менеджер банкетного зала',
                'официант',
                'повар',
                'руководитель службы питания',
                'специалист по пищевой безопасности',
                'стюард',
                'су-шеф',
                'супервайзер ресторанной службы',
                'управляющий рестораном',
                'шеф-повар',
            ],
            'служба приема и размещения'       => [
                'ночной аудитор',
                'руководитель службы приема и размещения',
                'специалист по премиум-сервису в гостиничной сфере',
                'супервайзер службы приема и размещения',
                'директор по продажам и маркетингу',
                'менеджер по маркетингу',
                'менеджер по продажам в сфере гостеприимства',
                'менеджер по продажам',
            ],
            'служба продаж и маркетинга'       => [
                'директор по продажам и маркетингу',
                'менеджер по маркетингу',
                'менеджер по продажам в сфере гостеприимства',
                'менеджер по продажам',
            ],
            'служба управления доходами'       => [
                'директор по управлению доходом',
                'менеджер бронирования',
                'менеджер по управлению доходом',
                'менеджер по управлению доходом в сфере гостеприимства',
            ],
            'техническая служба'               => [
                'главный инженер',
                'инженер-энергетик',
                'техник',
            ],
            'финансовая служба'                => [
                'финансовый контролер в гостиничной сфере',
                'финансовый контролер финансовая служба',
            ],
            'юридическая служба'               => [
                'юрист',
            ],

        ];

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {

    }
};
