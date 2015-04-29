<?php
use Nette\Diagnostics\Debugger;

class PravidlaPresenter extends UlrikPresenter
{
    /** @var Model */
  private $model;

  /** @var RulesModel */
  private $rulesModel;

  public function injectModel(Model $model){
      $this->model = $model;
  }

  public function injectRulesModel(RulesModel $model){
      $this->rulesModel = $model;
  }

  public function actionDefault($warband = null){
    if ((is_null($warband))and($this->getUser()->isInRole('admin'))) $this->forward('Ulrik:warband', 'Pravidla:');  
    if ($this->getUser()->isInRole('user')) $this->forward('Pravidla:user');
  }

  public function renderDefault($warband = null){    
    if ($this->getUser()->isInRole('superuser')) $warband = $this->getUser()->getIdentity()->warband;
      
    $units = $this->model->getUnitsByWarband($warband);
    $this->template->warband = $warband;
    $this->template->units = $units;
	}
    
  public function renderUser(){          
    $user = $this->model->getUserById($this->getUser()->getId());
    $this->template->currentUser = $user;
  }
  
  public function renderView($id){
    if ($this->getUser()->isInRole('user') and ($this->getUser()->getId() != $id)) {
      $this->flashMessage('K tomuto hráči nemáte přístup');
      $this->redirect('default');
    } 

    $user = $this->model->getUserById($id);
    $sets = $this->model->getWargearFromUser($id);   
    
    $this->sendResponse(new \Nette\Application\Responses\TextResponse(
      $this->rulesModel->getPravidla($user->units_id,$user->units->warband_id,$sets)
    ));
	}

  public function renderPdf($id){
    if ($this->getUser()->isInRole('user') and ($this->getUser()->getId() != $id)) {
      $this->flashMessage('K tomuto hráči nemáte přístup');
      $this->redirect('default');
    } 

    $user = $this->model->getUserById($id);
    $sets = $this->model->getWargearFromUser($id);   
    
    $mpdf = new mPDF('utf-8'); 
    $mpdf->SetDisplayMode('fullpage');
    $mpdf->SetAutoFont(0);
    
    $mpdf->SetTitle('Warhammer - The Other Sides IV');
    $mpdf->SetAuthor('DDarkA');
    $mpdf->SetSubject('Pravidla 2012');
    $mpdf->SetCreator('mPDF 5.0');
    
    $stylesheet = file_get_contents(WWW_DIR.'/css/unit_pdf.css');
    
    $mpdf->WriteHTML($stylesheet,1);
    $mpdf->WriteHTML($this->rulesModel->getPdf($user->units_id,$user->units->warband_id,$sets));
    
    $this->sendResponse(new \Nette\Application\Responses\FileResponse(
      $mpdf->Output($user->units_id.' '.$user->nick.'.pdf','D')
    )); 
  }

}
