<?php

use app\models\entity\Task;
use Framework\Registry;

/* @var $model Task */

$security = Registry::getService('user.security');

$getUrl = function ($view, $params) {
    if ($view === '_self') {
        $view = Registry::getRequest()->get('_route');
    }
    return Registry::getRoute($view, $params);
};

?>

<div class="row">
    <h2>Task <?= $model->getId() ?></h2>
</div>

<?php if ($security->isLogged()): ?>
    <div class="row">
        <div class="btn-toolbar">
            <a class="btn btn-warning" href="<?php echo $getUrl('update', ['id' => $model->getId()]) ?>">Update</a>
            <form>
                <input type="submit"
                       formmethod="post"
                       formaction="<?php echo $getUrl('updateStatus', ['id' => $model->getId()]) ?>"
                       class="btn btn-danger"
                       value="Done"
                    <?= $model->getStatus() ? 'disabled' : '' ?>
                >
            </form>
        </div>
    </div>
<?php endif ?>

<div class="row">
    <table class="table col-sm-6">
        <tr>
            <th>Username</th>
            <td><?= $model->getUsername() ?></td>
        </tr>
        <tr>
            <th>Email</th>
            <td><?= $model->getEmail() ?></td>
        </tr>
        <tr>
            <th>Description</th>
            <td><?= $model->getDescription() ?></td>
        </tr>
        <tr>
            <th>Status</th>
            <td><?= $model->getStatus() ? 'Done' : 'In work' ?></td>
        </tr>
    </table>
</div>
