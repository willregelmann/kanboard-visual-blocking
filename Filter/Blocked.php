<?php

namespace Kanboard\Plugin\VisualBlocking\Filter;

use Kanboard\Core\Filter\FilterInterface;
use Kanboard\Filter\BaseFilter;
use Kanboard\Model\TaskModel;
use Kanboard\Model\TaskLinkModel;
use PicoDb\Database;
use PicoDb\Table;

class Blocked extends BaseFilter implements FilterInterface {
	  
  private $db;
  private $currentUserId = 0;
  
  public function setCurrentUserId($userId){
    $this->currentUserId = $userId;
	return $this;
  }

  public function setDatabase(Database $db){
    $this->db = $db;
	return $this;
  }

  public function getAttributes(){
    return array('blocked');
  }

  public function apply(){
	$task_ids = $this->getSubQuery()->findAllByColumn(TaskLinkModel::TABLE.'.task_id');
	if ($this->value == 'true') {
	  $this->query->in(TaskModel::TABLE.'.id', $task_ids);
	} else if ($this->value == 'false') {
      $this->query->notIn(TaskModel::TABLE.'.id', $task_ids);
	}
    return $this;
  }

  protected function getSubQuery(){
    $subquery = $this->db->table(TaskLinkModel::TABLE)->columns(
		TaskLinkModel::TABLE.'.task_id',
		TaskLinkModel::TABLE.'.opposite_task_id',
		TaskLinkModel::TABLE.'.link_id',
		TaskModel::TABLE.'.is_active'
    )->join(TaskModel::TABLE, 'id', 'opposite_task_id', TaskLinkModel::TABLE);
    return $this->applySubQueryFilter($subquery);
  }

  protected function applySubQueryFilter(Table $subquery){
    $subquery->eq(TaskLinkModel::TABLE.'.link_id',3);
	$subquery->eq(TaskModel::TABLE.'.is_active',1);
	return $subquery;
  }

}
