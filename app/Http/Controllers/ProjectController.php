<?php
/**
 * Created by PhpStorm.
 * User: Narciso
 * Date: 08/12/2016
 * Time: 16:42
 */

namespace CodeProject\Http\Controllers;


use CodeProject\Repositories\ProjectRepository;
use CodeProject\Services\ProjectService;
use Illuminate\Http\Request;
use LucaDegasperi\OAuth2Server\Facades\Authorizer;

class ProjectController extends Controller
{

    /**
     * @var ProjectRepository
     */
    private $repository;
    /**
     * @var ProjectService
     */
    private $service;

    public function __construct(ProjectRepository $repository, ProjectService $service)
    {
        $this->repository = $repository;

        $this->service = $service;
    }

    public function index()
    {
        return $this->repository->findWhere(['owner_id' => Authorizer::getResourceOwnerId()]);
    }

    public function store(Request $request)
    {
        return $this->service->create($request->all());
    }

    public function show($id)
    {
        if ($this->checkProjectPermissions($id) == false) {
            return ['error' => 'Access forbidden'];
        }
        return $this->service->show($id);
    }

    public function destroy($id)
    {
        if ($this->checkProjectOwner($id) == false) {
            return ['error' => 'Access forbidden'];
        }
        return $this->service->destroy($id);
    }

    public function update(Request $request, $id)
    {
        if ($this->checkProjectOwner($id) == false) {
            return ['error' => 'Access forbidden'];
        }
        return $this->service->update($request->all(), $id);
    }

    public function checkProjectOwner($projectId)
    {
        $userId = Authorizer::getResourceOwnerId();
        return $this->repository->isOwner($projectId, $userId);
    }

    public function checkProjectMember($projectId)
    {
        $userId = Authorizer::getResourceOwnerId();
        return $this->repository->hasMember($projectId, $userId);
    }

    public function checkProjectPermissions($projectId)
    {
        if ($this->checkProjectOwner($projectId) or $this->checkProjectMember($projectId)) {
            return true;
        }

        return false;

    }

}