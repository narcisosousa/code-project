<?php
/**
 * Created by PhpStorm.
 * User: Narciso
 * Date: 08/12/2016
 * Time: 16:42
 */

namespace CodeProject\Http\Controllers;


use CodeProject\Repositories\ProjectNoteRepository;
use CodeProject\Services\ProjectNoteService;
use Illuminate\Http\Request;
use LucaDegasperi\OAuth2Server\Facades\Authorizer;

class ProjectNoteController extends Controller
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

    public function __construct(ProjectNoteRepository $repository, ProjectNoteService $service, ProjectController $projectController)
    {
        $this->repository = $repository;
        $this->service = $service;
        $this->projectController = $projectController;
    }

    public function index($id)
    {
        if ($this->projectController->checkProjectPermissions($id) == false) {
//            return ['error' => 'Access forbidden'];
        }
        return $this->repository->skipPresenter()->findWhere(['project_id' => $id]);
    }

    public function store($id, Request $request)
    {
        if ($this->projectController->checkProjectPermissions($id) == false) {
//            return ['error' => 'Access forbidden'];
        }
        return $this->service->create($request->all());
    }

    public function show($id, $noteId)
    {
        if ($this->projectController->checkProjectPermissions($id) == false) {
//            return ['error' => 'Access forbidden'];
        }
        return $this->repository->skipPresenter()->findWhere(['project_id' => $id, 'id' => $noteId])->first();
    }

    public function destroy($id, $noteId)
    {
        if ($this->projectController->checkProjectOwner($id) == false) {
//            return ['error' => 'Access forbidden'];
        }
        return $this->service->destroy($noteId);
    }

    public function update(Request $request, $id, $noteId)
    {
        if ($this->projectController->checkProjectPermissions($id) == false) {
//            return ['error' => 'Access forbidden'];
        }
        return $this->service->update($request->all(), $noteId);
    }


}