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

    public function  index(){
        return $this->repository->with(['owner','client'])->all();
    }

    public function storage(Request $request){
        return $this->service->create($request->all());
    }

    public function show($id){
        return $this->service->show($id);
    }

    public function destroy($id){
        return $this->service->destroy($id);
    }
    public function update(Request $request, $id){
        return $this->service->update($request->all(),$id);
    }

}