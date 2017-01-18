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

    public function __construct(ProjectMembersRepository $repository, ProjectMembersService $service)
    {
        $this->repository = $repository;

        $this->service = $service;
    }

    public function index($id)
    {
        return $this->service->index($id);
    }

    public function storage(Request $request)
    {
        return $this->service->addMember($request->all());
    }

    public function show($id, $memberId)
    {
        return $this->repository->findWhere(['project_id' => $id, 'id' => $memberId]);
    }

    public function destroy($id, $memberId)
    {
        return $this->service->removeMember($id, $memberId);
    }

    public function member($id, $userId)
    {
        return $this->service->isMember($id, $userId);
    }

    public function update(Request $request, $id, $memberId)
    {
        return $this->service->update($request->all(), $memberId);
    }

}