<?php
use Nette\Diagnostics\Debugger;

class WargearPresenter extends UlrikPresenter
{
	/** @var Model */
  private $model;

  /** @var RulesModel */
  private $rulesModel;

  private $body;
  private $max;

  public function injectModel(Model $model){
      $this->model = $model;
  }

  public function injectRulesModel(RulesModel $model){
      $this->rulesModel = $model;
  }

  protected function najdi($name, &$condition, &$delete = array()){
   foreach ($condition as $node => $cond) 
     if ($cond == $name){
       $delete[]=$node;
       $this->najdi($node,$condition,$delete);
     }
   return $delete;
  }
 
	protected function getPoints($warband){
    $this->body = $this->model->getPointsCountFromWarband($warband);

    $this->max = $this->model->getMaxPointsFromWarband($warband);
    $this->body = $this->max - $this->body;
  
    $this->template->body = $this->body;
    $this->template->max = $this->max;
  }

  	public function handlePrehled($name,$warband){ 
      $this->sendResponse(new \Nette\Application\Responses\TextResponse(
        $this->rulesModel->getPrehled($name,$warband)
      ));
    }
    
    public function actionErase($id){
      $user = $this->model->getUserById($id);
      $unit = $user->units;
      
      if (!(($this->getUser()->isInRole('admin'))or(($this->getUser()->isInRole('superuser'))and($unit->warband_id==$this->getUser()->getIdentity()->warband)))) {
        $this->flashMessage('K této warbandě nemáte přístup','error');
        $this->redirect('Wargear:default');
      }
      
      $this->model->deleteWargearFromUser($id);
      $this->flashMessage('Wargear tohoto hráče byl vymazán');
      $this->redirect('view',$id);
    }
    
    public function actionWarbandErase($warband = null){
      if (!(($this->getUser()->isInRole('admin'))or(($this->getUser()->isInRole('superuser'))and($warband==$this->getUser()->getIdentity()->warband)))) {
        $this->flashMessage('K této warbandě nemáte přístup','error');
        $this->redirect('Wargear:default');
      }

      $this->model->deleteWargearFromWarband($warband);
      $this->flashMessage('Wargear této warbandy byl vymazán');
      $this->redirect('Wargear:default',$warband);
    }
    
    public function actionBuy($id,array $name){
      $name = $name[0];
      
      $user = $this->model->getUserById($id);
      $unit = $user->units;
      
      if (!(($this->getUser()->isInRole('admin'))or(($this->getUser()->isInRole('superuser'))and($unit->warband_id==$this->getUser()->getIdentity()->warband)))) {
        $this->flashMessage('K tomuto hráči nemáte přístup');
        $this->redirect('Wargear:default');
      }

      $this->getPoints($unit->warband_id);

      $node = $this->rulesModel->getNodeFromRules($name, $unit->id,$unit->warband_id);
         
      $sets = $this->model->getWargearFromUser($id);
      
      if ((($node['cond'])and(!array_key_exists($node['cond'],$sets)))or(array_key_exists($name,$sets))) {
        $this->flashMessage('Tuto položku si nemůžete pořídit','error');
        $this->redirect('Wargear:view',$id);
      }

      if ($node['points'] > $this->body) {
        $this->flashMessage('Nedostatek bodů','error');
        $this->redirect('Wargear:view',$id);
      }
  
      $this->model->addToWargear($name,$id,$unit->warband_id,$node['points']);

      $this->redirect("Wargear:view#$name", $id);
    }
    
    public function actionSell($id,array $name){
      $name = $name[0];
      
      $user = $this->model->getUserById($id);
      $unit = $user->units;
      
      if (!(($this->getUser()->isInRole('admin'))or(($this->getUser()->isInRole('superuser'))and($unit->warband_id==$this->getUser()->getIdentity()->warband)))) {
        $this->flashMessage('K tomuto hráči nemáte přístup');
        $this->redirect('Wargear:default');
      }

      $node = $this->rulesModel->getNodeFromRules($name, $unit->id,$unit->warband_id);
      
      $conditions = $this->rulesModel->getConditionsFromNode($unit->id,$unit->warband_id);
      
      $sets = $this->model->getWargearFromUser($id);
      
      if (!array_key_exists($name,$sets)) {
        $this->flashMessage('Tuto položku si nemůžete odebrat','error');
        $this->redirect('Wargear:view',$id);
      }
  
      $delete = $this->najdi($name,$conditions);
      $delete[] = $name;
  
      $this->model->deleteFromWargear($delete,$id);
      
      $this->redirect("Wargear:view#$name", $id);
    }
    
  public function actionDefault($warband = null){
    if ($this->getUser()->isInRole('user')) $this->redirect('Wargear:view',$this->getUser()->getId());
    if ((is_null($warband))and($this->getUser()->isInRole('admin'))) $this->forward('Ulrik:warband', 'Wargear:');   
  }
  
  public function renderDefault($warband = null){    
    if ($this->getUser()->isInRole('superuser')) $warband = $this->getUser()->getIdentity()->warband;

    $this->getPoints($warband);
     
    $units = $this->model->getUnitsByWarband($warband);
    
    $this->template->units = $units;
    $this->template->warband = $warband;
	}

  public function renderView($id){
    $user = $this->model->getUserById($id);
    $postava = $user->units;

    $this->template->nick = $user->nick;
  
    if (!(($this->getUser()->isInRole('admin'))
      or($this->getUser()->isInRole('user') and $this->getUser()->getId()==$id)
      or(($this->getUser()->isInRole('superuser'))and($postava->warband_id==$this->getUser()->getIdentity()->warband)))) {
      
      $this->flashMessage('K tomuto hráči nemáte přístup','error');
      $this->redirect('Wargear:default');
    }
    
    $this->getPoints($postava->warband_id);
     
    $sets = $this->model->getWargearFromUser($id);
    
    $xml = $this->rulesModel->getXMLFile($postava->id,$postava->warband_id,true);
    
    $nodes = array();
    $xpath = new DOMXPath($xml);    
    foreach($xpath->query('/wargear/*/*[1]') as $node) $nodes[$node->parentNode->tagName]=$node->tagName;
    $this->template->childs = $nodes;
    unset($nodes,$xpath);
    
    $this->template->xml = simplexml_import_dom($xml);
    
    $this->template->uid = $id;
    $this->template->sets = $sets;
    $this->template->postava = $postava;
	}

}