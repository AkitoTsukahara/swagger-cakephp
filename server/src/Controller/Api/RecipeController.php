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

    /**
     * Index method
     *
     * @OA\Get(
     *   path="/api/recipe/index.json",
     *   tags={"Recipe"},
     *   summary="レシピをすべて取得する",
     *   @OA\Response(
     *     response=200,
     *     description="OK",
     *     @OA\JsonContent(
     *       type="object",
     *       @OA\Property(
     *         property="recipes",
     *         type="array",
     *         description="レシピ一覧",
     *         @OA\Items(
     *           @OA\Property(
     *             property="id",
     *             type="string",
     *             description="レシピID",
     *           ),
     *           @OA\Property(
     *             property="title",
     *             type="string",
     *             description="レシピ名",
     *           ),
     *           @OA\Property(
     *             property="description",
     *             type="string",
     *             description="レシピ内容",
     *           ),
     *         ),
     *         example={
     *           {
     *             "id"="c366f5be-360b-45cc-8282-65c80e434f72",
     *             "title"="ハンバーグ",
     *             "description"="ジューシーでご飯がすすむ定番のハンバーグレシピです。ソースの材料もケチャップ、ウスターソース、醤油の３つだけとシンプル。",
     *           },
     *           {
     *             "id"="93d5ef90-be4d-4179-9311-e39bddc26427",
     *             "title"="親子丼",
     *             "description"="ふんわりとろっとろな半熟仕立ての卵とだしの相性が抜群！ご飯にからんで食欲そそる、手軽なのに食べごたえもある満足度高めな一品です。",
     *           },
     *         },
     *       ),
     *     ),
     *   ),
     *   @OA\Response(
     *     response="default",
     *     description="Unexpected Error",
     *     @OA\JsonContent(
     *       type="object",
     *       @OA\Property(
     *         property="message",
     *         type="string",
     *         description="エラーメッセージ",
     *       ),
     *      example={
     *        "message"="予期しないエラーです"
     *      },
     *     ),
     *   ),
     * )
     *
     * @return void
     */
    public function index(): void
    {
        $recipes = $this->Recipes->find('all');

        $this->set('recipes', $recipes);
        $this->viewBuilder()->setOption('serialize', ['recipes']);
    }

    /**
     * View method
     *
     * @OA\Get(
     *   path="/api/recipe/view/{id}.json",
     *   tags={"Recipe"},
     *   summary="レシピを参照する",
     *   @OA\Parameter(
     *     name="id",
     *     in="path",
     *     required=true,
     *     description="レシピID",
     *     @OA\Schema(type="string"),
     *     example="c366f5be-360b-45cc-8282-65c80e434f72"
     *   ),
     *   @OA\Response(
     *     response=200,
     *     description="OK",
     *     @OA\JsonContent(
     *       type="object",
     *       @OA\Property(
     *         property="recipes",
     *         type="object",
     *         description="レシピ",
     *         @OA\Property(
     *           property="id",
     *           type="string",
     *           description="レシピID",
     *         ),
     *         @OA\Property(
     *           property="title",
     *           type="string",
     *           description="レシピ名",
     *         ),
     *         @OA\Property(
     *           property="description",
     *           type="string",
     *           description="レシピ内容",
     *         ),
     *         example={
     *           "id"="c366f5be-360b-45cc-8282-65c80e434f72",
     *           "title"="ハンバーグ",
     *           "description"="ジューシーでご飯がすすむ定番のハンバーグレシピです。ソースの材料もケチャップ、ウスターソース、醤油の３つだけとシンプル。",
     *         },
     *       ),
     *     ),
     *   ),
     *   @OA\Response(
     *     response="default",
     *     description="Unexpected Error",
     *     @OA\JsonContent(
     *       type="object",
     *       @OA\Property(
     *         property="message",
     *         type="string",
     *         description="エラーメッセージ",
     *       ),
     *      example={
     *        "message"="予期しないエラーです"
     *      },
     *     ),
     *   ),
     * )
     *
     * @param string $id id.
     * @return void
     */
    public function view(string $id): void
    {
        $recipe = $this->Recipes->get($id);
        $this->set('recipe', $recipe);
        $this->viewBuilder()->setOption('serialize', ['recipe']);
    }

    /**
     * Add method
     *
     * @OA\Post(
     *   path="/api/recipe/add.json",
     *   tags={"Recipe"},
     *   summary="レシピを登録する",
     *   @OA\RequestBody(
     *     required=true,
     *     @OA\JsonContent(
     *       type="object",
     *       required={"title","description"},
     *       @OA\Property(
     *         property="title",
     *         type="string",
     *         description="レシピ名",
     *       ),
     *       @OA\Property(
     *         property="description",
     *         type="string",
     *         description="レシピ内容",
     *       ),
     *       example={
     *         "title"="ハンバーグ",
     *         "description"="ジューシーでご飯がすすむ定番のハンバーグレシピです。ソースの材料もケチャップ、ウスターソース、醤油の３つだけとシンプル。",
     *       },
     *     ),
     *   ),
     *   @OA\Response(
     *     response=200,
     *     description="OK",
     *     @OA\JsonContent(
     *       type="object",
     *       @OA\Property(
     *         property="recipe",
     *         type="object",
     *         description="レシピ",
     *         @OA\Property(
     *           property="id",
     *           type="string",
     *           description="ID",
     *         ),
     *         example={
     *           "id"="c366f5be-360b-45cc-8282-65c80e434f72",
     *         },
     *       ),
     *     ),
     *   ),
     *   @OA\Response(
     *     response="default",
     *     description="Unexpected Error",
     *     @OA\JsonContent(
     *       type="object",
     *       @OA\Property(
     *         property="message",
     *         type="string",
     *         description="エラーメッセージ",
     *       ),
     *      example={
     *        "message"="予期しないエラーです"
     *      },
     *     ),
     *   ),
     * )
     *
     * @return void
     * @throws \App\Exception\ApplicationException
     */
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

    /**
     * Edit method
     *
     * @OA\Put(
     *   path="/api/recipe/edit/{id}.json",
     *   tags={"Recipe"},
     *   summary="レシピを更新する",
     *   @OA\Parameter(
     *     name="id",
     *     in="path",
     *     required=true,
     *     description="レシピID",
     *     @OA\Schema(type="string"),
     *     example="c366f5be-360b-45cc-8282-65c80e434f72"
     *   ),
     *   @OA\RequestBody(
     *     required=true,
     *     @OA\JsonContent(
     *       type="object",
     *       required={"description"},
     *       @OA\Property(
     *         property="title",
     *         type="string",
     *         description="レシピ名",
     *       ),
     *       @OA\Property(
     *         property="description",
     *         type="string",
     *         description="レシピ内容",
     *       ),
     *       example={
     *         "title"="ハンバーグ",
     *         "description"="ジューシーでご飯がすすむ定番のハンバーグレシピです。ソースの材料もケチャップ、ウスターソース、醤油の３つだけとシンプル。",
     *       },
     *     ),
     *   ),
     *   @OA\Response(
     *     response=200,
     *     description="OK",
     *     @OA\JsonContent(
     *       type="object",
     *       @OA\Property(
     *         property="recipe",
     *         type="object",
     *         description="レシピ",
     *         @OA\Property(
     *           property="id",
     *           type="string",
     *           description="ID",
     *         ),
     *         example={
     *           "id"="c366f5be-360b-45cc-8282-65c80e434f72",
     *         },
     *       ),
     *     ),
     *   ),
     *   @OA\Response(
     *     response="default",
     *     description="Unexpected Error",
     *     @OA\JsonContent(
     *       type="object",
     *       @OA\Property(
     *         property="message",
     *         type="string",
     *         description="エラーメッセージ",
     *       ),
     *      example={
     *        "message"="予期しないエラーです"
     *      },
     *     ),
     *   ),
     * )
     *
     * @param string $id id
     * @return void
     * @throws \App\Exception\ApplicationException
     */
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

    /**
     * Delete method
     *
     * @OA\Delete(
     *   path="/api/recipe/delete/{id}.json",
     *   tags={"Recipe"},
     *   summary="レシピを削除する",
     *   @OA\Parameter(
     *     name="id",
     *     in="path",
     *     required=true,
     *     description="レシピID",
     *     @OA\Schema(type="string"),
     *     example="c366f5be-360b-45cc-8282-65c80e434f72"
     *   ),
     *   @OA\Response(
     *     response=204,
     *     description="No Content",
     *   ),
     *   @OA\Response(
     *     response="default",
     *     description="Unexpected Error",
     *     @OA\JsonContent(
     *       type="object",
     *       @OA\Property(
     *         property="message",
     *         type="string",
     *         description="エラーメッセージ",
     *       ),
     *      example={
     *        "message"="予期しないエラーです"
     *      },
     *     ),
     *   ),
     * )
     *
     * @param string $id id
     * @return void
     * @throws \App\Exception\ApplicationException
     */
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

}
