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
    /**
     * @var ProjectController
     */
    private $projectController;

    public function __construct(ProjectTaskRepository $repository, ProjectTaskService $service, ProjectController $projectController)
    {
        $this->repository = $repository;
        $this->service = $service;
        $this->projectController = $projectController;
    }

    public function index($id)
    {
        if ($this->projectController->checkProjectPermissions($id) == false) {
            return ['error' => 'Access forbidden'];
        }
        return $this->repository->findWhere(['project_id' => $id]);
    }

    public function store($id, Request $request)
    {
        if ($this->projectController->checkProjectPermissions($id) == false) {
            return ['error' => 'Access forbidden'];
        }
        return $this->service->create($request->all());
    }

    public function show($id, $taskId)
    {
        if ($this->projectController->checkProjectPermissions($id) == false) {
            return ['error' => 'Access forbidden'];
        }
        return $this->repository->findWhere(['project_id' => $id, 'id' => $taskId]);
    }

    public function destroy($id, $taskId)
    {
        if ($this->projectController->checkProjectOwner($id) == false) {
            return ['error' => 'Access forbidden'];
        }
        return $this->service->destroy($taskId);
    }

    public function update(Request $request, $id, $taskId)
    {
        if ($this->projectController->checkProjectPermissions($id) == false) {
            return ['error' => 'Access forbidden'];
        }
        return $this->service->update($request->all(), $taskId);
    }

}