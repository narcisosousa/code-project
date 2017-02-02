<?php
namespace CodeProject\Transformers;

/**
 * Created by PhpStorm.
 * User: Narciso
 * Date: 01/02/2017
 * Time: 14:51
 */
use CodeProject\Entities\ProjectNote;
use League\Fractal\TransformerAbstract;

class ProjectNoteTransformer extends TransformerAbstract
{

    public function transform(ProjectNote $projectNote)
    {
        return [
            'id' => $projectNote->id,
            'project_id' => $projectNote->project_id,
            'title' => $projectNote->title,
            'note' => $projectNote->note,
        ];
    }

}