<?php

use app\models\entity\Task;
use Framework\Registry;
use app\Services\Pagination;


/* @var $models Task[] */
/* @var $pagination Pagination */

$path = Registry::getRequest()->getPathInfo();

$getUrl = function ($view, $params) {
    if ($view === '_self') {
        $view = Registry::getRequest()->get('_route');
    }
    return Registry::getRoute($view, $params);
};

?>

<div class="row">
    <a class="btn btn-primary" href="<?= Registry::getRoute('create') ?>">Add task</a>
</div>


<div class="row">
    <table class="table">
        <thead>
        <tr>
            <th>ID</th>
            <th><a href="<?php echo $getUrl('_self', ['sort' => 'username']) ?>">Username</a></th>
            <th><a href="<?php echo $getUrl('_self', ['sort' => 'email']) ?>">Email</a></th>
            <th><a href="<?php echo $getUrl('_self', ['sort' => 'description']) ?>">Description</a></th>
            <th><a href="<?php echo $getUrl('_self', ['sort' => 'status']) ?>">Status</a></th>
            <th>Link</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($models as $model): ?>
            <tr>
                <td><?= $model->getId() ?></td>
                <td><?= $model->getUsername() ?></td>
                <td><?= $model->getEmail() ?></td>
                <td><?= $model->getDescription() ?></td>
                <td><?= $model->getStatus() ? 'Done' : 'In work' ?></td>
                <td><a href="<?php echo $getUrl('view', ['id' => $model->getId()]) ?>">View</a></td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>

<div>
    <?php echo $pagination->render() ?>
</div>
