<?php

use Kanboard\Model\TaskModel;
use Kanboard\Model\TaskLinkModel;
use PicoDb\Database;
use PicoDb\Table;

if ($task['nb_links'] > 0) {
  $subquery = $database->table(TaskLinkModel::TABLE)->columns(
    TaskLinkModel::TABLE.'.task_id',
    TaskLinkModel::TABLE.'.opposite_task_id',
    TaskModel::TABLE.'.is_active'
  )->join(TaskModel::TABLE, 'id', 'opposite_task_id', TaskLinkModel::TABLE);
  $subquery->eq(TaskLinkModel::TABLE.'.task_id',$task['id']);
  $subquery->eq(TaskLinkModel::TABLE.'.link_id',3);
  $subquery->eq(TaskModel::TABLE.'.is_active',1);
  if (count($subquery->findAll())) {
    echo "<span style='margin-left:10px; display: table-cell;'><i class='fa fa-lock'></i></span>";
  }  
}
