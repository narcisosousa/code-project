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

    public function __construct(ProjectNoteRepository $repository, ProjectNoteService $service)
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

    public function show($id, $noteId){
        return $this->repository->findWhere(['project_id' => $id, 'id' => $noteId]);
    }

    public function destroy($id, $noteId){
        return $this->service->destroy($noteId);
    }

    public function update(Request $request, $id, $noteId){
        return $this->service->update($request->all(),$noteId);
    }

}