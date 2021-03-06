<?php
/**
 * Created by PhpStorm.
 * User: Narciso
 * Date: 08/12/2016
 * Time: 16:09
 */

namespace CodeProject\Validators;


use Prettus\Validator\LaravelValidator;

class ProjectTaskValidator extends LaravelValidator
{
    protected $rules = [
        'name' => 'required',
        'project_id' => 'required|integer',
        'start_date' => 'required',
        'due_date' => 'required',
        'status' => 'required'
    ];
}