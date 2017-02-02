<?php
/**
 * Created by PhpStorm.
 * User: Narciso
 * Date: 08/12/2016
 * Time: 16:11
 */

namespace CodeProject\Services;


use CodeProject\Repositories\ProjectTaskRepository;
use CodeProject\Validators\ProjectTaskValidator;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Prettus\Validator\Exceptions\ValidatorException;
use Illuminate\Database\QueryException;


class ProjectTaskService
{

    /**
     * @var ProjectRepository
     */
    protected $repository;
    /**
     * @var ProjectValidator
     */
    private $validator;

    public function __construct(ProjectTaskRepository $repository, ProjectTaskValidator $validator)
    {
        $this->repository = $repository;

        $this->validator = $validator;
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
            return ['error' => true, 'mensagem' => 'Tarefa Não Encontrada'];
        } catch (\Exception $e) {
            return ['error' => true, 'mensagem' => 'Ocorreu algum erro ao atualizar a Tarefa.'.$e->getMessage()];
        }
    }

    public function destroy($id)
    {
        try {
            $this->repository->skipPresenter()->find($id)->delete();
            return ['success' => true, 'mensagem' => 'Tarefa deletada com sucesso!'];
        } catch (QueryException $e) {
            return ['error' => true, 'mensagem' => 'Tarefa não pode ser apagada.'];
        } catch (ModelNotFoundException $e) {
            return ['error' => true, 'mensagem' => 'Tarefa não encontrada.'];
        } catch (\Exception $e) {
            return ['error' => true, 'mensagem' => 'Ocorreu algum erro ao excluir a Tarefa.'];
        }
    }

    public function show($id)
    {
        try {
            return $this->repository->find($id);
        } catch (QueryException $e) {
            return ['error' => true, 'mensagem' => $e->getMessage()];
        } catch (ModelNotFoundException $e) {
            return ['error' => true, 'mensagem' => 'Tarefa Não Encontrada'];
        } catch (\Exception $e) {
            return ['error' => true, 'mensagem' => 'Ocorreu algum erro ao exibir a Tarefa.'];
        }
    }
}