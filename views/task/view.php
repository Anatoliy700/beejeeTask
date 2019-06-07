<?php

use app\models\entity\Task;
use Framework\Registry;

/* @var $model Task */

$pathUpdate = Registry::getRoute('update');
$pathUpdateStatus = Registry::getRoute('updateStatus');
$security = Registry::getService('user.security');

?>

<div class="row">
    <h2>Task <?= $model->getId() ?></h2>
</div>

<?php if ($security->isLogged()): ?>
    <div class="row">
        <div class="btn-toolbar">
            <a class="btn btn-warning" href="<?php echo "{$pathUpdate}?id={$model->getId()}" ?>">Update</a>
            <form>
                <input type="submit"
                       formmethod="post"
                       formaction="<?php echo "{$pathUpdateStatus}?id={$model->getId()}" ?>"
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
