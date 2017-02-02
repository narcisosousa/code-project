<?php
/**
 * Created by PhpStorm.
 * User: Narciso
 * Date: 08/12/2016
 * Time: 15:29
 */

namespace CodeProject\Repositories;


use CodeProject\Entities\Project;
use CodeProject\Presenters\ProjectPresenter;
use Prettus\Repository\Eloquent\BaseRepository;

class ProjectRepositoryEloquent extends BaseRepository implements ProjectRepository
{
    public function model()
    {
        return Project::class;
    }

    public function isOwner($projectId, $userId)
    {
        if (count($this->skipPresenter()->findWhere(['id' => $projectId, 'owner_id' => $userId]))) {
            return true;
        }
        return false;
    }

    public function hasMember($projectId, $userId)
    {
        $project = $this->skipPresenter()->find($projectId);
        foreach ($project->member as $member) {
            if ($member->id == $userId) {
                return true;
            }
        }
        return false;
    }

    public function presenter()
    {
        return ProjectPresenter::class;
    }

}