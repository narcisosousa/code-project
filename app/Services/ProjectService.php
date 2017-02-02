<?php
/**
 * Created by PhpStorm.
 * User: Narciso
 * Date: 08/12/2016
 * Time: 16:11
 */

namespace CodeProject\Services;


use CodeProject\Entities\ProjectFile;
use CodeProject\Repositories\ProjectRepository;
use CodeProject\Validators\ProjectValidator;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Prettus\Validator\Exceptions\ValidatorException;
use Illuminate\Database\QueryException;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Contracts\Filesystem\Factory as Storage;


class ProjectService
{

    /**
     * @var ProjectRepository
     */
    protected $repository;
    /**
     * @var ProjectValidator
     */
    private $validator;
    /**
     * @var Filesystem
     */
    private $filesystem;
    /**
     * @var Factory
     */
    private $factory;

    public function __construct(ProjectRepository $repository, ProjectValidator $validator, Filesystem $filesystem, Storage $storage)
    {
        $this->repository = $repository;
        $this->validator = $validator;
        $this->filesystem = $filesystem;
        $this->storage = $storage;
    }

    public function create(array $data)
    {
        try {
            $this->validator->with($data)->passesOrFail();
            return $this->repository->create($data);
        } catch (ValidatorException $e) {
            return [
                'error' => true,
                'message' => $e->getMessageBag()
            ];
        }
    }

    public function update(array $data, $id)
    {
        try {
            $this->validator->with($data)->passesOrFail();
            return $this->repository->skipPresenter()->update($data, $id);
        } catch (ValidatorException $e) {
            return [
                'error' => true,
                'message' => $e->getMessageBag()
            ];
        } catch (QueryException $e) {
            return ['error' => true, 'mensagem' => $e->getMessage()];
        } catch (ModelNotFoundException $e) {
            return ['error' => true, 'mensagem' => 'Projeto Não Encontrado'];
        } catch (\Exception $e) {
            return ['error' => true, 'mensagem' => 'Ocorreu algum erro ao atualizar o Projeto.'];
        }
    }

    public function destroy($id)
    {
        try {
            $this->repository->skipPresenter()->find($id)->delete();
            return ['success' => true, 'mensagem' => 'Projeto deletado com sucesso!'];
        } catch (QueryException $e) {
            return ['error' => true, 'mensagem' => 'Projeto não pode ser apagado pois existe um ou mais clientes vinculados a ele.'];
        } catch (ModelNotFoundException $e) {
            return ['error' => true, 'mensagem' => 'Projeto não encontrado.'];
        } catch (\Exception $e) {
            return ['error' => true, 'mensagem' => 'Ocorreu algum erro ao excluir o projeto.'];
        }
    }

    public function show($id)
    {
        try {
            return $this->repository->find($id);
        } catch (QueryException $e) {
            return ['error' => true, 'mensagem' => $e->getMessage()];
        } catch (ModelNotFoundException $e) {
            return ['error' => true, 'mensagem' => 'Projeto Não Encontrado'];
        } catch (\Exception $e) {
            return ['error' => true, 'mensagem' => 'Ocorreu algum erro ao exibir o Projeto.'];
        }
    }

    public function createFile(array $data)
    {
        //name
        //description
        //extension
        //file
        $project = $this->repository->skipPresenter()->find($data['project_id']);
        $projectFile = $project->files()->create($data);
        $this->storage->put($projectFile->id.".".$data['name'].".".$data['extension'],$this->filesystem->get($data['file']));

    }

}