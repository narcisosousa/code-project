<?php
/**
 * Created by PhpStorm.
 * User: Narciso
 * Date: 08/12/2016
 * Time: 16:42
 */

namespace CodeProject\Http\Controllers;


use CodeProject\Entities\Project;
use CodeProject\Entities\ProjectFile;
use CodeProject\Repositories\ProjectRepository;
use CodeProject\Services\ProjectService;
use League\Flysystem\FileNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProjectFileController extends Controller
{

    /**
     * @var ProjectRepository
     */
    private $repository;
    /**
     * @var ProjectService
     */
    private $service;
    /**
     * @var ProjectController
     */
    private $projectController;

    public function __construct(ProjectRepository $repository, ProjectService $service, ProjectController $projectController)
    {
        $this->repository = $repository;

        $this->service = $service;
        $this->projectController = $projectController;
    }


    public function store($id, Request $request)
    {
        if ($this->projectController->checkProjectPermissions($id) == false) {
            return ['error' => 'Access forbidden'];
        }
        $file = $request->file('file');
        if (!is_null($file)) {
            $extension = $file->getClientOriginalExtension();
            $data['file'] = $file;
            $data['extension'] = $extension;
            $data['name'] = $request->name;
            $data['project_id'] = $id;
            $this->service->createFile($data);
            return ['error' => false, 'message' => 'Arquivo Inserido com Sucesso!'];
        }
        return ['error' => true, 'message' => 'Insira um arquivo'];


    }

    public function destroy($id, $fileId){
        if ($this->projectController->checkProjectPermissions($id) == false) {
            return ['error' => 'Access forbidden'];
        }
        $file = ProjectFile::find($fileId);
        $file = $fileId.".".$file->name.".".$file->extension;
        try{
            //Storage::delete($file);
            ProjectFile::find($fileId)->delete();
            return ['error' => false, 'message' => 'Arquivo deletado com sucesso!'];
        }catch (FileNotFoundException $e){
            return ['error' => true, 'message' => 'Arquivo não encontrado' ];
        }




    }


}