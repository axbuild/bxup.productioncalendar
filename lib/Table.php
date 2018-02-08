<?php
namespace BxUp\ProductionCalendar;

defined('B_PROLOG_INCLUDED') and (B_PROLOG_INCLUDED === true) or die();

use Bitrix\Main;
use Bitrix\Main\Entity;
use Bitrix\Main\Context;
use Bitrix\Main\Type\DateTime;
use Bitrix\Main\Localization\Loc;

Loc::loadLanguageFile(__FILE__);

/**
 * Class Table
 * 
 * Fields:
 * <ul>
 * <li> ID int mandatory
 * <li> UF_DATE_CREATE datetime optional
 * <li> UF_USER int optional
 * <li> UF_LEAD string optional
 * <li> UF_LEVEL int optional
 * </ul>
 *
 * @package Bitrix\
 **/

class ProductionCalendarTable extends Main\Entity\DataManager
{
    /**
     * Returns DB table name for entity.
     *
     * @return string
     */
    public static function getTableName()
    {
        return 'productioncalendar';
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
            'UF_YEAR' => array(
                'data_type' => 'integer',
                'title' => Loc::getMessage('_ENTITY_UF_USER_FIELD'),
            ),
            'UF_JSON' => array(
                'data_type' => 'text',
                'title' => Loc::getMessage('_ENTITY_UF_LEAD_FIELD'),
            )
        );
    }

}

class Table extends ProductionCalendarTable
{

}