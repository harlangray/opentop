<?php

/**
 * This is the model class for table "user".
 *
 * The followings are the available columns in table 'user':
 * @property integer $id
 * @property integer $country_id
 * @property string $username
 * @property string $email
 * @property string $password
 * @property integer $type
 * @property string $created
 * @property string $modified
 *
 * The followings are the available model relations:
 * @property Country $country
 * @property UserComment[] $userComments
 * @property UserDetail[] $userDetails
 * @property UserMessage[] $userMessages
 */
class User extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return User the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'user';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('country_id, username, email, password, type, created, modified', 'required'),
			array('country_id, type', 'numerical', 'integerOnly'=>true),
			array('username', 'length', 'max'=>20),
			array('email, password', 'length', 'max'=>30),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, country_id, username, email, password, type, created, modified', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'country' => array(self::BELONGS_TO, 'Country', 'country_id'),
			'userComments' => array(self::HAS_MANY, 'UserComment', 'user_id'),
			'userDetails' => array(self::HAS_MANY, 'UserDetail', 'user_id'),
			'userMessages' => array(self::HAS_MANY, 'UserMessage', 'user_id'),
                        'userType' => array(self::BELONGS_TO, 'UserType', 'type'),
                        'messages' => array(self::HAS_MANY, 'Message', 'user_id'),
                    
                        'nofMessages' => array(self::STAT, 'UserMessage', 'user_id'),
                        'nofMessagesRead' => array(self::STAT, 'UserMessage', 'user_id', 'condition' => 'message_read = 1'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'country_id' => 'Country',
			'username' => 'Username',
			'email' => 'Email',
			'password' => 'Password',
			'type' => 'Type',
			'created' => 'Created',
			'modified' => 'Modified',
                    'nofMessages' => 'Nof Messages',
                    'numberOfComments' => 'Number of Comments'
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('country_id',$this->country_id);
		$criteria->compare('username',$this->username,true);
		$criteria->compare('email',$this->email,true);
		$criteria->compare('password',$this->password,true);
		$criteria->compare('type',$this->type);
		$criteria->compare('created',$this->created,true);
		$criteria->compare('modified',$this->modified,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
        public function getNumberOfComments(){
            $messages = $this->messages;
            $nfComments = 0;
            foreach ($messages as $message){
                $nfComments += $message->nofComments;
            }
            return $nfComments;
        }
        
        public function getMessageDetails(){
            $userMessages = $this->userMessages;
            
            $table = '<table>';
            $table .= '<tr><th>Content</th><th>Details</th><th>Views</th><th>Comments</th></tr>';
            foreach ($userMessages as $userMessage){
                $message = $userMessage->message;
                $table .= '<tr>';
                $table .= "<td>$message->content</td>";
                $table .= "<td>$message->details</td>";
                $table .= "<td>$message->nofMessagesRead</td>";
                $table .= "<td>$message->nofComments</td>";
                $table .= '</tr>';
            }
            $table .= '</table>';
            
            return $table;
        }
}