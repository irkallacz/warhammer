<?php
/**
 * Model base class.
 */
class Model extends Nette\Object
{
	/** @var Nette\Database\Connection */
	public $database;

    public function __construct(Nette\Database\Connection $database){
        return $this->database = $database;
    }

	public function getPointsCountFromWarband($warband){
		return $this->database->table('wargear')->select('SUM(points)AS body')->where('warband_id',$warband)->fetch()->body;
	}
	
	public function getMaxPointsFromWarband($warband){
		return $this->database->table('warband')->select('points')->where('id',$warband)->fetch()->points;
	}
	
	public function deleteWargearFromUser($id){
		return $this->database->table('wargear')->where('users_id',$id)->delete();
	}
	
	public function deleteWargearFromWarband($warband){
		return $this->database->table('wargear')->where('warband_id',$warband)->delete();
	}

	public function getUserById($id){
		return $this->database->table('users')->where('users_role_id > ?',0)->get($id);
	}

	public function getWarbands(){
		return $this->database->table('warband');
	}

	public function getUnits(){
		return $this->database->table('units');
	}

	public function getUnitsByWarband($warband){
		return $this->database->table('units')->where('warband_id',$warband)->order('number');
	}

	public function getWargearFromUser($id){
		return $this->database->table('wargear')->select('name')->where('users_id',$id)->fetchPairs('name','name');
	}

	public function addToWargear($node,$user_id,$warband,$price){
		$this->database->table('wargear')
        ->insert(array('name'=>$node,'users_id'=>$user_id,'warband_id'=>$warband,'points'=>$price));
      
	}

	public function deleteFromWargear(array $nodes,$user_id){
		$this->database->table('wargear')->where('users_id',$user_id)->where('name',$nodes)->delete();
	}

}
