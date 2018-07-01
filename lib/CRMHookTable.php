<?php
namespace BxUp\CRMHookClient;

use Bitrix\Main;
use Bitrix\Main\Entity;
use Bitrix\Main\Context;
use Bitrix\Main\Type\DateTime;
use Bitrix\Main\Localization\Loc;

Loc::loadLanguageFile(__FILE__);

Class Table extends Main\Entity\DataManager
{
    /**
     * Returns DB table name for entity.
     *
     * @return string
     */
    public static function getTableName()
    {
        return 'crmhooktable';
    }
    /**
     * Returns entity map definition.
     *
     * @return array
     */
    public static function getMap()
    {
        return array(
            'ID' => array(
                'data_type' => 'integer',
                'primary' => true,
                'autocomplete' => true,
                'title' => Loc::getMessage('_ENTITY_ID_FIELD'),
            ),
            'UF_DATE_CREATE' => array(
                'data_type' => 'datetime',
                'title' => Loc::getMessage('_ENTITY_UF_DATE_CREATE_FIELD'),
            ),
            'UF_SUCCESS' => array(
                'data_type' => 'integer',
                'title' => Loc::getMessage('_ENTITY_UF_SUCCESS'),
            ),
            'UF_DATA' => array(
                'data_type' => 'text',
                'title' => Loc::getMessage('_ENTITY_UF_DATA'),
            )
        );
    }
}
