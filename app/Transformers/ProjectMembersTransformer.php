<?php
namespace CodeProject\Transformers;

/**
 * Created by PhpStorm.
 * User: Narciso
 * Date: 01/02/2017
 * Time: 14:51
 */
use CodeProject\Entities\ProjectMembers;
use League\Fractal\TransformerAbstract;

class ProjectMembersTransformer extends TransformerAbstract
{

    public function transform(ProjectMembers $member)
    {
        return [
            'id' => $member->id,
            'project_id' => $member->project_id,
            'user_id' => $member->user_id,
        ];
    }

}