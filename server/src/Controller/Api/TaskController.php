<?php
declare(strict_types=1);

namespace App\Controller\Api;

use App\Controller\AppController;
use App\Exception\ApplicationException;

/**
 * Task Controller
 *
 * @property \App\Model\Table\TasksTable $Tasks
 */
class TaskController extends AppController
{
    /**
     * Index method
     *
     * @return void
     */
    public function index()
    {
        $task = $this->paginate($this->Task);

        $this->set(compact('task'));
        $this->viewBuilder()->setOption('serialize', ['tasks']);
    }

    /**
     * Search method
     *
     * @return void
     */
    public function search(): void
    {
        $this->loadModel('Tasks');
        $tasks = $this->Tasks->find()->all();

        $this->set('tasks', $tasks);
        $this->viewBuilder()->setOption('serialize', ['tasks']);
    }

    /**
     * View method
     *
     * @param string|null $id Task id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $this->loadModel('Tasks');
        $task = $this->Tasks->get($id);

        $this->set('task', $task);
        $this->viewBuilder()->setOption('serialize', ['task']);
    }

    /**
     * Create method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function create(): void
    {
        $this->loadModel('Tasks');
        $data = $this->request->getData();

        $task = $this->Tasks->newEntity($data);
        if ($task->hasErrors()) {
            $this->set('errors', $task->getErrors());
            $this->viewBuilder()->setOption('serialize', ['errors']);

            return;
        }

        if (!$this->Tasks->save($task)) {
            throw new ApplicationException(__('登録できませんでした。'));
        }

        $this->set('task', ['id' => $task->id]);
        $this->viewBuilder()->setOption('serialize', ['task']);
    }

    /**
     * Update method
     *
     * @param string $id Task id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function update(string $id): void
    {
        $this->loadModel('Tasks');
        $data = $this->request->getData();
        $task = $this->Tasks->get($id);

        $task = $this->Tasks->patchEntity($task, $data);
        if ($task->hasErrors()) {
            $this->set('errors', $task->getErrors());
            $this->viewBuilder()->setOption('serialize', ['errors']);

            return;
        }

        if (!$this->Tasks->save($task)) {
            throw new ApplicationException(__('更新できませんでした。'));
        }

        $this->set('task', ['id' => $id]);
        $this->viewBuilder()->setOption('serialize', ['task']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Task id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete(string $id): void
    {
        $this->loadModel('Tasks');
        $task = $this->Tasks->get($id);

        if (!$this->Tasks->delete($task)) {
            throw new ApplicationException(__('削除できませんでした。'));
        }

        $this->response = $this->response->withStatus(204);
        $this->viewBuilder()->setOption('serialize', []);
    }
}
