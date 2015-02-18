<?php
namespace TypiCMS\Modules\Categories\Http\Controllers;

use TypiCMS\Http\Controllers\AdminSimpleController;
use TypiCMS\Modules\Categories\Http\Requests\FormRequest;
use TypiCMS\Modules\Categories\Repositories\CategoryInterface;

class AdminController extends AdminSimpleController
{

    public function __construct(CategoryInterface $category)
    {
        parent::__construct($category);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  FormRequest $request
     * @return Redirect
     */
    public function store(FormRequest $request)
    {
        $model = $this->repository->create($request->all());
        return $this->redirect($request, $model);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  $model
     * @param  FormRequest $request
     * @return Redirect
     */
    public function update($model, FormRequest $request)
    {
        $this->repository->update($request->all());
        return $this->redirect($request, $model);
    }
}