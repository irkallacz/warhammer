<?php

use Nette\Security as NS,
    Nette\Utils\Arrays;

/**
 * Users authenticator.
 *
 * @author     John Doe
 * @package    MyApplication
 */
class Authenticator extends Nette\Object implements NS\IAuthenticator
{
	/** @var Nette\Database\Connection */
    public $database;

    public function __construct(Nette\Database\Connection $database){
          $this->database = $database;
    }

	/**
	 * Performs an authentication
	 * @param  array
	 * @return Nette\Security\Identity
	 * @throws Nette\Security\AuthenticationException
	 */

  public function authenticate(array $credentials){
        
        $username = $credentials[self::USERNAME];
        $password = md5($credentials[self::PASSWORD]);

        $data = $this->database->table('users')->select('id, nick, mail, units_id, users_role_id, password')->where('mail', $username)->fetch();
        
        if (!$data) {
            throw new NS\AuthenticationException('Uživatel s e-mailem "'.$username.'" nebyl nalezen', self::IDENTITY_NOT_FOUND);
        }

        if ($data->password !== $password) {
            throw new NS\AuthenticationException('Neplatné heslo', self::INVALID_CREDENTIAL);
        }
        
        unset($data['password']);
        
        $profileData = iterator_to_array($data);
        Arrays::renameKey($profileData, 'users_role_id', 'role_id');
        unset($profileData['id']);
        //unset($profileData['units_id']); 
        
        if (isset($data->units->warband_id)) $profileData['warband']=$data->units->warband_id; else $profileData['warband'] = null;                                       
        
        //$database->table('users')->where('id',$data->id)->update(array('date_visit' => new Datetime));
        
        return new  NS\Identity($data->id,$data->users_role->role,$profileData);
    }

}
