<?php
/**
 * Created by PhpStorm.
 * User: Narciso
 * Date: 08/12/2016
 * Time: 16:42
 */

namespace CodeProject\Http\Controllers;


use CodeProject\Repositories\ProjectTaskRepository;
use CodeProject\Services\ProjectTaskService;
use Illuminate\Http\Request;

class ProjectTaskController extends Controller
{

    /**
     * @var ProjectNoteRepository
     */
    private $repository;
    /**
     * @var ProjectNoteService
     */
    private $service;

    public function __construct(ProjectTaskRepository $repository, ProjectTaskService $service)
    {
        $this->repository = $repository;

        $this->service = $service;
    }

    public function  index($id){
        return $this->repository->findWhere(['project_id' => $id]);
    }

    public function storage(Request $request){
        return $this->service->create($request->all());
    }

    public function show($id, $taskId){
        return $this->repository->findWhere(['project_id' => $id, 'id' => $taskId]);
    }

    public function destroy($id, $taskId){
        return $this->service->destroy($taskId);
    }

    public function update(Request $request, $id, $taskId){
        return $this->service->update($request->all(),$taskId);
    }

}