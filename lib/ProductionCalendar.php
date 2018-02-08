<?
namespace BxUp;

use Bitrix\Main\Type\DateTime;
use Bitrix\Main\Localization\Loc;
use Bitrix\Main\SystemException; 

Loc::loadMessages(__FILE__);

class ProductionCalendar
{	
	private $json;
	private $month;
	private $days;

	function __construct ($year)
	{
		if(empty($year)) $year = date('Y');

		if(!$this->isExist($year))
		{
			$this->update();
		}

		$result = ProductionCalendar\Table::getList(
			[
				'filter' => ['UF_YEAR' => $year]
			]
		)->fetch()['UF_JSON'];

		$this->json = unserialize($result);

		$n = intVal(date('m'));

		$this->month = explode(',', 
			array_values($this->json)[$n]
		);

	}

	public function update ()
	{	
		$list = ProductionCalendar\DataGovRu::getList();

		if(is_null($list))	die();
		
		try
		{
			foreach ($list as $key => $val)
			{
				if(!is_int(intVal(current($val))))
					throw new SystemException (Loc::getMessage("EXCEPTION_FORMAT_NOTDEFINED"));

				$item['UF_YEAR'] = current($val);
				$item['UF_JSON'] = serialize($val);
				$item['UF_DATE_CREATE'] = new DateTime();
				

				$entry = ProductionCalendar\Table::getList(
					[
						'filter' => ['UF_YEAR' => current($val)]
					]
				)->fetch();

				if(empty($entry))
				{
					ProductionCalendar\Table::add($item);
				}
				elseif(!ProductionCalendar\Table::update($entry['ID'], $item)->isSuccess())
				{
					throw new SystemException (Loc::getMessage("EXCEPTION_UPDATE_FAILED"));
				}
			}

			return true;
		}
		catch (SystemException $e)
		{
			echo $e->getMessage();
		}
	}

	public function isExist (int $year) : bool
	{
		$entry = ProductionCalendar\Table::getList(
			[
				'filter' => ['UF_YEAR' => $year]
			]
		)->fetch();

		if($entry)
		{
			return true;
		}
		else
		{
			return false;
		}
	}

	public function setYear(int $year)
	{
		$entry = ProductionCalendar\Table::getList(
			[
				'filter' => ['UF_YEAR' => $year]
			]
		)->fetch()['UF_JSON'];

		$this->json = unserialize($entry);

		return $this;
	}

	public function setMonth(int $month)
	{	
		$n = intVal($month);
		
		if($n >= 1 && $n <= 12)
		{
			$this->month = explode(',', 
				array_values($this->json)[$n]
			);
		}
		else
		{
			return false;
		}

		return $this;
	}

	public function getWorkingDays ($fromDay, $toDay)
	{
		$totalDays = intVal($toDay) - intVal($fromDay);
		
		for ($i = 1; $i < $totalDays; $i++)
		{
			if(!in_array($i, $this->month))
			{
				$this->days['work'][] = $i;
			}
			else
			{
				$this->days['dayoff'][] = $i;
			}
		}

		return $this;
	}

	public function count (string $type)
	{
		return count($this->days[$type]);
	}

}
?>