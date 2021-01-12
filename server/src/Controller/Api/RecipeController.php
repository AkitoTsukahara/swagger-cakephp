<?php
declare(strict_types=1);

namespace App\Controller\Api;

use App\Controller\AppController;
use App\Exception\ApplicationException;

/**
 * Recipe Controller
 *
 * @property \App\Model\Table\RecipesTable $Recipes
 */
class RecipeController extends AppController
{

    public function initialize(): void
    {
        parent::initialize();
        $this->loadModel('Recipes');
        $this->loadComponent('RequestHandler');
    }

    public function index(): void
    {
        $recipes = $this->Recipes->find('all');

        $this->set('recipes', $recipes);
        $this->viewBuilder()->setOption('serialize', ['recipes']);
    }

    public function view(string $id): void
    {
        $recipe = $this->Recipes->get($id);
        $this->set('recipe', $recipe);
        $this->viewBuilder()->setOption('serialize', ['recipe']);
    }

    public function add(): void
    {
        $this->request->allowMethod(['post', 'put']);
        $recipe = $this->Recipes->newEntity($this->request->getData());
        if ($this->Recipes->save($recipe)) {
            $message = 'Saved';
        } else {
            $message = 'Error';
        }
        $this->set([
            'message' => $message,
            'recipe' => $recipe,
        ]);
        $this->viewBuilder()->setOption('serialize', ['recipe', 'message']);
    }

    public function edit(string $id): void
    {
        $this->request->allowMethod(['patch', 'post', 'put']);
        $recipe = $this->Recipes->get($id);
        $recipe = $this->Recipes->patchEntity($recipe, $this->request->getData());
        if ($this->Recipes->save($recipe)) {
            $message = 'Saved';
        } else {
            $message = 'Error';
        }
        $this->set([
            'message' => $message,
            'recipe' => $recipe,
        ]);
        $this->viewBuilder()->setOption('serialize', ['recipe', 'message']);
    }

    public function delete(string $id): void
    {
        $this->request->allowMethod(['delete']);
        $recipe = $this->Recipes->get($id);
        $message = 'Deleted';
        if (!$this->Recipes->delete($recipe)) {
            $message = 'Error';
        }
        $this->set('message', $message);
        $this->viewBuilder()->setOption('serialize', ['message']);
    }

//    /**
//     * Index method
//     *
//     * @return \Cake\Http\Response|null|void Renders view
//     */
//    public function index()
//    {
//        $recipe = $this->paginate($this->Recipe);
//
//        $this->set(compact('recipe'));
//    }
//
//    /**
//     * View method
//     *
//     * @param string|null $id Recipe id.
//     * @return \Cake\Http\Response|null|void Renders view
//     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
//     */
//    public function view($id = null)
//    {
//        $recipe = $this->Recipe->get($id, [
//            'contain' => [],
//        ]);
//
//        $this->set(compact('recipe'));
//    }
//
//    /**
//     * Add method
//     *
//     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
//     */
//    public function add()
//    {
//        $recipe = $this->Recipe->newEmptyEntity();
//        if ($this->request->is('post')) {
//            $recipe = $this->Recipe->patchEntity($recipe, $this->request->getData());
//            if ($this->Recipe->save($recipe)) {
//                $this->Flash->success(__('The recipe has been saved.'));
//
//                return $this->redirect(['action' => 'index']);
//            }
//            $this->Flash->error(__('The recipe could not be saved. Please, try again.'));
//        }
//        $this->set(compact('recipe'));
//    }
//
//    /**
//     * Edit method
//     *
//     * @param string|null $id Recipe id.
//     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
//     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
//     */
//    public function edit($id = null)
//    {
//        $recipe = $this->Recipe->get($id, [
//            'contain' => [],
//        ]);
//        if ($this->request->is(['patch', 'post', 'put'])) {
//            $recipe = $this->Recipe->patchEntity($recipe, $this->request->getData());
//            if ($this->Recipe->save($recipe)) {
//                $this->Flash->success(__('The recipe has been saved.'));
//
//                return $this->redirect(['action' => 'index']);
//            }
//            $this->Flash->error(__('The recipe could not be saved. Please, try again.'));
//        }
//        $this->set(compact('recipe'));
//    }
//
//    /**
//     * Delete method
//     *
//     * @param string|null $id Recipe id.
//     * @return \Cake\Http\Response|null|void Redirects to index.
//     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
//     */
//    public function delete($id = null)
//    {
//        $this->request->allowMethod(['post', 'delete']);
//        $recipe = $this->Recipe->get($id);
//        if ($this->Recipe->delete($recipe)) {
//            $this->Flash->success(__('The recipe has been deleted.'));
//        } else {
//            $this->Flash->error(__('The recipe could not be deleted. Please, try again.'));
//        }
//
//        return $this->redirect(['action' => 'index']);
//    }
}
