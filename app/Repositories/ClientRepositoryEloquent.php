<?php
/**
 * Created by PhpStorm.
 * User: Narciso
 * Date: 07/12/2016
 * Time: 00:42
 */

namespace CodeProject\Repositories;


use CodeProject\Entities\Client;
use Prettus\Repository\Eloquent\BaseRepository;

class ClientRepositoryEloquent extends BaseRepository implements ClientRepository
{

    public function model()
    {
        return Client::class;
    }

}