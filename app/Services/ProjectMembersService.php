<?php
/**
 * Created by PhpStorm.
 * User: Narciso
 * Date: 08/12/2016
 * Time: 16:11
 */

namespace CodeProject\Services;


use CodeProject\Repositories\ProjectMembersRepository;
use CodeProject\Validators\ProjectMembersValidator;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Prettus\Validator\Exceptions\ValidatorException;
use Illuminate\Database\QueryException;


class ProjectMembersService
{

    /**
     * @var ProjectRepository
     */
    protected $repository;
    /**
     * @var ProjectValidator
     */
    private $validator;

    public function __construct(ProjectMembersRepository $repository, ProjectMembersValidator $validator)
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
            return $this->repository->update($data, $id);
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
            return ['error' => true, 'mensagem' => 'Ocorreu algum erro ao atualizar a Tarefa.' . $e->getMessage()];
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

    public function index($projectId)
    {
        $member = $this->repository->findWhere(['project_id' => $projectId]);
        if (!is_null($member)) {
            return [$member];
        }
        return ['mensagem' => 'Não há membros relacionados ao projeto'];
    }

    public function addMember(array $data)
    {
        try {
            $this->validator->with($data)->passesOrFail();
            return $this->repository->create($data);
        } catch (ValidatorException $e) {
            return [
                'error' => true,
                'message' => $e->getMessageBag()
            ];
        } catch (QueryException $e) {
            return ['error' => true, 'mensagem' => 'Membro não pode ser adicionado.'];
        } catch (ModelNotFoundException $e) {
            return ['error' => true, 'mensagem' => 'Membro não encontrado.'];
        } catch (\Exception $e) {
            return ['error' => true, 'mensagem' => 'Ocorreu algum erro ao adicionar Membro.'];
        }
    }

    public function removeMember($id, $memberId)
    {
        try {
            $member = $this->repository->skipPresenter()->findWhere(['project_id' => $id, 'user_id' => $memberId]);
            if (!is_null($member)) {
                $this->repository->delete($member[0]->id);
                return ['success' => true, 'mensagem' => 'Membro deletado com sucesso!'];
            }
        } catch (QueryException $e) {
            return ['error' => true, 'mensagem' => 'Membro não pode ser apagado.'];
        } catch (ModelNotFoundException $e) {
            return ['error' => true, 'mensagem' => 'Membro não encontrado.'];
        } catch (\Exception $e) {
            return ['error' => true, 'mensagem' => 'Ocorreu algum erro ao excluir o Membro.' . var_dump($member)];
        }
    }

    public function isMember($id, $userId)
    {
        try {
            $member = $this->repository->skipPresenter()->findWhere(['project_id' => $id, 'user_id' => $userId]);
            if (!$member->isEmpty()) {
                return ['success' => true, 'mensagem' => 'Membro pertence ao projeto!'];
            }
            return ['success' => false, 'mensagem' => 'Membro não pertence ao projeto!'];
        } catch (QueryException $e) {
            return ['error' => true, 'mensagem' => 'Membro não pode ser encontrado.'];
        } catch (ModelNotFoundException $e) {
            return ['error' => true, 'mensagem' => 'Membro não encontrado.'];
        } catch (\Exception $e) {
            return ['error' => true, 'mensagem' => 'Ocorreu algum erro ao buscar Membro.' . $e->getMessage()];
        }
    }

}