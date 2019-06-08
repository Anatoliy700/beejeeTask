<?php

use app\models\entity\Task;

/* @var $create bool */
/* @var $model Task | null */

?>

<div class="row">
    <form method="post" class="col-sm-4">
        <div class="form-group">
            <label for="exampleFormControlInput1">Username</label>
            <input type="text" class="form-control" id="exampleFormControlInput1"
                   value="<?= $model ? $model->getUsername() : '' ?>"
                   name="username" <?= $create ? 'required' : 'readonly' ?>>
        </div>
        <div class="form-group">
            <label for="exampleFormControlInput2">Email</label>
            <input type="email" class="form-control" id="exampleFormControlInput2"
                   value="<?= $model ? $model->getEmail() : '' ?>"
                   name="email" <?= $create ? 'required' : 'readonly' ?>
                   placeholder="name@example.com">
        </div>
        <div class="form-group">
            <label for="exampleFormControlTextarea1">Example textarea</label>
            <textarea class="form-control" id="exampleFormControlTextarea1" name="description" rows="3"
                      required><?= $model ? $model->getDescription() : '' ?></textarea>
        </div>
        <button type="submit" class="btn btn-primary"><?= $create ? 'Create' : 'Update' ?></button>
    </form>
</div>
