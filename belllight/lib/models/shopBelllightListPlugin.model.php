<?php

/**
 * Класс для работы с базой данных
 *
 * @author Steemy, created by 23.03.2018
 * @link http://steemy.ru/
 */


class shopBelllightListPluginModel extends waModel
{
    protected $table = 'shop_belllight_list';

    public function count($status = 'new')
    {
    	$sql = '';

	    $sql .= "SELECT COUNT(*) FROM ".$this->table." WHERE `status` = '";

	    if ($status == 'active')
			$status = "active' OR `status` = 'new";

    	$sql .= $status;
    	$sql .= "'";

	    return $this->query($sql)->fetchField();
	}

	public function getList($offset = 0, $limit = null, $status)
	{
		$sql = '';

		$sql .= "SELECT * FROM `{$this->table}` WHERE ";
		$sql .= "`status` = '";

		if($status == 'active')
			$status = "active' OR `status` = 'new";

		if($status == 'all')
			$status = "active' OR `status` = 'delete' OR `status` = 'new";
    	
    	$sql .= $status;
    	$sql .= "'";

    	$sql .= " ORDER BY `id` DESC";
		$sql .= " LIMIT ".($offset ? $offset.',' : '').(int)$limit;

		return $this->query($sql)->fetchAll('id');
	}

	public function updateStatus()
	{
    	$this->query("UPDATE `{$this->table}` SET `status` = 'active' WHERE `status` = 'new'");
    }

	public function updateStatusId($id)
	{
		$data = array(
		    'id' => $id,
		);

    	$this->exec("UPDATE `{$this->table}` SET `status` = 'delete' WHERE `status` = 'active' AND `id` = i:id", $data);
    }

}
