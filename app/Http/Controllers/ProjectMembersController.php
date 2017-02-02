<?php
/**
 * Created by PhpStorm.
 * User: Narciso
 * Date: 08/12/2016
 * Time: 16:42
 */

namespace CodeProject\Http\Controllers;


use CodeProject\Repositories\ProjectMembersRepository;
use CodeProject\Services\ProjectMembersService;
use Illuminate\Http\Request;

class ProjectMembersController extends Controller
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

    public function __construct(ProjectMembersRepository $repository, ProjectMembersService $service, ProjectController $projectController)
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
        return $this->service->index($id);
    }

    public function store($id, Request $request)
    {
        if ($this->projectController->checkProjectPermissions($id) == false) {
            return ['error' => 'Access forbidden'];
        }
        return $this->service->addMember($request->all());
    }

    public function show($id, $memberId)
    {
        if ($this->projectController->checkProjectPermissions($id) == false) {
            return ['error' => 'Access forbidden'];
        }
        return $this->repository->findWhere(['project_id' => $id, 'id' => $memberId]);
    }

    public function destroy($id, $memberId)
    {
        if ($this->projectController->checkProjectOwner($id) == false) {
            return ['error' => 'Access forbidden'];
        }
        return $this->service->removeMember($id, $memberId);
    }

    public function member($id, $userId)
    {
        if ($this->projectController->checkProjectPermissions($id) == false) {
            return ['error' => 'Access forbidden'];
        }
        return $this->service->isMember($id, $userId);
    }

    public function update(Request $request, $id, $memberId)
    {
        if ($this->projectController->checkProjectPermissions($id) == false) {
            return ['error' => 'Access forbidden'];
        }
        return $this->service->update($request->all(), $memberId);
    }

}