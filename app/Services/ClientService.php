<?php
/**
 * Created by PhpStorm.
 * User: Narciso
 * Date: 08/12/2016
 * Time: 00:26
 */

namespace CodeProject\Services;


use CodeProject\Validators\ClientValidator;
use CodeProject\Repositories\ClientRepository;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Prettus\Validator\Exceptions\ValidatorException;

class ClientService
{
    /**
     * @var ClientRepository
     */
    protected $repository;
    /**
     * @var ClientValidator
     */
    private $validator;

    public function __construct(ClientRepository $repository, ClientValidator $validator)
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
        }

    }

    public function destroy($id)
    {
        try {
            $this->repository->find($id)->delete();
            return ['success' => true, 'mensagem' => 'Cliente deletado com sucesso!'];
        } catch (QueryException $e) {
            return ['error' => true, 'mensagem' => 'Cliente não pode ser apagado.'];
        } catch (ModelNotFoundException $e) {
            return ['error' => true, 'mensagem' => 'Cliente não encontrado.'];
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
            return ['error' => true, 'mensagem' => 'Cliente Não Encontrado'];
        } catch (\Exception $e) {
            return ['error' => true, 'mensagem' => 'Ocorreu algum erro ao exibir o Cliente.'];
        }
    }


}