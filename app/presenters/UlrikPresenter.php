<?php
class UlrikPresenter extends BasePresenter
{

/** @var Model */
private $model;

protected function startup()
	{
		parent::startup();

		if (!$this->user->isLoggedIn()) {
			$backlink =  $this->storeRequest();
			$this->redirect('Sign:in', array('backlink' => $backlink));
		}
	}

public function injectModel(Model $model){
  $this->model = $model;
}

public function renderWarband($target){
  $this->template->warbandy = $this->model->getWarbands();
  $this->template->target = $target;
}

}