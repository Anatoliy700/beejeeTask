<?php


namespace app\controllers;


use app\models\entity\Task;
use app\models\repositories\Tasks;
use app\Services\Pagination;
use Framework\controllers\BaseController;
use Framework\Registry;
use Symfony\Component\HttpFoundation\Request;

class TaskController extends BaseController
{

    //TODO: Bring logic to the model
    public function indexAction(Request $request)
    {
        $repository = new Tasks();
        $models = $repository->getRange(
            Registry::getDataConfig('limitTasks'),
            $request->get('offset') ?: 0,
            $request->get('sort') ? ['sort' => $request->get('sort')] : []
        );
        $pagination = new Pagination($request, $repository);

        return $this->render('/task/index.php', ['models' => $models, 'pagination' => $pagination]);
    }

    public function createAction(Request $request)
    {
        if ($request->isMethod('POST')) {
            try {
                $model = new Task();
                $model->setUsername($request->get('username'))
                    ->setEmail($request->get('email'))
                    ->setDescription($request->get('description'))
                    ->setStatus(Task::STATUS_IN_WORK);

                (new Tasks($model))->save();
                return $this->redirect('index');
            } catch (\Error $e) {
                var_dump($e);//TODO: Error message for User
            }
        }
        return $this->render('/task/create.php');
    }

    public function viewAction(Request $request)
    {
        $id = $request->get('id');

        $model = (new Tasks())->getById($id);

        return $this->render('/task/view.php', ['model' => $model]);

    }

    public function updateAction(Request $request)
    {
        if (!$this->isLogged()){
            return $this->redirect('index');
        }

        $id = $request->get('id');

        $model = (new Tasks())->getById($id);

        if ($request->isMethod('POST')) {
            try {
                $model->setDescription($request->get('description'));

                (new Tasks($model))->save('description');
                return $this->redirect('view', ['id' => $id]);
            } catch (\Error $e) {
                var_dump($e);//TODO: Error message for User
            }
        }

        return $this->render('/task/update.php', ['model' => $model]);
    }

    public function updateStatusAction(Request $request)
    {
        if (!$this->isLogged()){
            return $this->redirect('index');
        }

        $id = $request->get('id');

        $model = (new Tasks())->getById($id);

        if ($request->isMethod('POST')) {
            try {
                $model->setStatus(Task::STATUS_DONE);

                (new Tasks($model))->save('status');
            } catch (\Error $e) {
                var_dump($e);//TODO: Error message for User
            }
        }

        return $this->redirect('view', ['id' => $id]);
    }

}
