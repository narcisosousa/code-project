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
        return $this->repository->findWhere(['project_id' => $id]);
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
        $result = $this->repository->findWhere(['project_id' => $id, 'id' => $noteId]);

        if (isset($result) && count($result)) {
            return $result = [
                'data' => $result['data'][0]
            ];
        }
        return $result;
    }

    public function destroy($id, $IdNote)
    {
        if ($this->projectController->checkProjectOwner($id) == false) {
//            return ['error' => 'Access forbidden'];
        }
        return $this->service->destroy($IdNote);
    }

    public function update(Request $request, $id, $noteId)
    {
        if ($this->projectController->checkProjectPermissions($id) == false) {
//            return ['error' => 'Access forbidden'];
        }
        return $this->service->update($request->all(), $noteId);
    }


}