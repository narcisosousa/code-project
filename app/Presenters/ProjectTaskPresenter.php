<?php
/**
 * Created by PhpStorm.
 * User: Narciso
 * Date: 01/02/2017
 * Time: 15:01
 */

namespace CodeProject\Presenters;
use CodeProject\Transformers\ProjectTaskTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

class ProjectTaskPresenter extends FractalPresenter
{

    /**
     * Transformer
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
       return new ProjectTaskTransformer();
    }
}