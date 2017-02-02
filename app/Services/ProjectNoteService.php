<?php
/**
 * Created by PhpStorm.
 * User: Narciso
 * Date: 08/12/2016
 * Time: 16:11
 */

namespace CodeProject\Services;


use CodeProject\Repositories\ProjectNoteRepository;
use CodeProject\Validators\ProjectNoteValidator;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Prettus\Validator\Exceptions\ValidatorException;
use Illuminate\Database\QueryException;


class ProjectNoteService
{

    /**
     * @var ProjectRepository
     */
    protected $repository;
    /**
     * @var ProjectValidator
     */
    private $validator;

    public function __construct(ProjectNoteRepository $repository, ProjectNoteValidator $validator)
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
            $this->validator->skipPresenter()->with($data)->passesOrFail();
            return $this->repository->update($data, $id);
        } catch (ValidatorException $e) {
            return [
                'error' => true,
                'message' => $e->getMessageBag()
            ];
        } catch (QueryException $e) {
            return ['error' => true, 'mensagem' => $e->getMessage()];
        } catch (ModelNotFoundException $e) {
            return ['error' => true, 'mensagem' => 'Nota Não Encontrado'];
        } catch (\Exception $e) {
            return ['error' => true, 'mensagem' => 'Ocorreu algum erro ao atualizar Nota.'.$e->getMessage()];
        }
    }

    public function destroy($id)
    {
        try {
            $this->repository->skipPresenter()->find($id)->delete();
            return ['success' => true, 'mensagem' => 'Nota deletada com sucesso!'];
        } catch (QueryException $e) {
            return ['error' => true, 'mensagem' => 'Nota não pode ser apagado pois existe um ou mais clientes vinculados a ele.'];
        } catch (ModelNotFoundException $e) {
            return ['error' => true, 'mensagem' => 'Nota não encontrado.'];
        } catch (\Exception $e) {
            return ['error' => true, 'mensagem' => 'Ocorreu algum erro ao excluir  Nota.'];
        }
    }

    public function show($id)
    {
        try {
            return $this->repository->find($id);
        } catch (QueryException $e) {
            return ['error' => true, 'mensagem' => $e->getMessage()];
        } catch (ModelNotFoundException $e) {
            return ['error' => true, 'mensagem' => 'Nota Não Encontrado'];
        } catch (\Exception $e) {
            return ['error' => true, 'mensagem' => 'Ocorreu algum erro ao exibir  Nota.'];
        }
    }
}