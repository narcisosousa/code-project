<?php
/**
 * Created by PhpStorm.
 * User: Narciso
 * Date: 08/12/2016
 * Time: 16:09
 */

namespace CodeProject\Validators;


use Prettus\Validator\LaravelValidator;

class ProjectMembersValidator extends LaravelValidator
{
    protected $rules = [
        'project_id' => 'required|integer',
        'user_id' => 'required|integer'
    ];
}