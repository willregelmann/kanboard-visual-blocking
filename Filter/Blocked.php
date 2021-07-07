<?php

namespace Kanboard\Plugin\VisualBlocking\Filter;

use Kanboard\Core\Filter\FilterInterface;
use Kanboard\Filter\BaseFilter;
use Kanboard\Model\{
    TaskModel,
    TaskLinkModel
};
use PicoDb\{
    Database,
    Table
};

class Blocked extends BaseFilter implements FilterInterface {
	  
  private Database $db;
  private int $currentUserId = 0;
  
  public function setCurrentUserId(int $userId):Blocked {
    $this->currentUserId = $userId;
	return $this;
  }

  public function setDatabase(Database $db):Blocked {
    $this->db = $db;
	return $this;
  }

  public function getAttributes():array {
    return ['blocked'];
  }

  public function apply():Blocked {
	$task_ids = $this->getSubQuery()->findAllByColumn(TaskLinkModel::TABLE.'.task_id');
    $fn = $this->value ? 'in' : 'notIn';
    $this->query->$fn(TaskModel::TABLE.'.id', $task_ids);
    return $this;
  }

  protected function getSubQuery():Table {
    $subquery = $this->db->table(TaskLinkModel::TABLE)->columns(
		TaskLinkModel::TABLE.'.task_id',
		TaskLinkModel::TABLE.'.opposite_task_id',
		TaskLinkModel::TABLE.'.link_id',
		TaskModel::TABLE.'.is_active'
    )->join(TaskModel::TABLE, 'id', 'opposite_task_id', TaskLinkModel::TABLE);
    return $this->applySubQueryFilter($subquery);
  }

  protected function applySubQueryFilter(Table $subquery):Table {
    $subquery->eq(TaskLinkModel::TABLE.'.link_id',3);
	$subquery->eq(TaskModel::TABLE.'.is_active',1);
	return $subquery;
  }

}
