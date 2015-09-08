<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Login
 *
 * @author Maurice
 */
class Login extends CFormModel {
	public $username;
	public $password;    
        public $rememberMe;
        private $_identity;
        
        
	public function rules()
	{
		return array(
			// username and password are required
			array('username, password', 'required'),
			// rememberMe needs to be a boolean
			array('rememberMe', 'boolean'),
			// password needs to be authenticated
			array('password', 'authenticate'),
		);
	}       
        
	public function attributeLabels()
	{
		return array(
			'rememberMe'=>'Remember me next time',
		);
	}    
        
	public function authenticate($attribute,$params)
	{
		if(!$this->hasErrors())
		{
//			$this->_identity=new UserIdentity($this->username,$this->password);
//			if(!$this->_identity->authenticate())
//				$this->addError('password','Incorrect username or password.');
                    
                    if(!$this->userPassMatching()){
                        $this->addError('password','Incorrect username or password.');
                    }
		}
	}
        
	public function login()
	{
//		if($this->_identity===null)
//		{
//			$this->_identity=new UserIdentity($this->username,$this->password);
//			$this->_identity->authenticate();
//		}
//		if($this->_identity->errorCode===UserIdentity::ERROR_NONE)
//		{
//			$duration=$this->rememberMe ? 3600*24*30 : 0; // 30 days
//			Yii::app()->user->login($this->_identity,$duration);
//			return true;
//		}
//		else
//			return false;
            
            if($this->userPassMatching()){
                return true;
            }
            else{
                return false;
            }
	}     
        
        private function userPassMatching(){
            $user = $this->username;
            $password = $this->password;
            
            $model = User::model()->find('username = :username AND password = :password', array(':username' => $user, ':password' => $password));
            if(isset($model)){
                $_SESSION['userType'] = $model->type;
                $_SESSION['userID'] = $model->id;
//                die($_SESSION['userID']);
                return true;
            }
            $_SESSION['userType'] = 0;
            $_SESSION['userID'] = 0;
            return false;
        }
}
