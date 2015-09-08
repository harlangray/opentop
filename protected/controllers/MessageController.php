<?php

class MessageController extends Controller {

    /**
     * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
     * using two-column layout. See 'protected/views/layouts/column2.php'.
     */
    public $layout = '//layouts/column2';
    public $defaultAction = 'Admin';

    /**
     * @return array action filters
     */
    public function filters() {
        return array(
            'accessControl', // perform access control for CRUD operations
            'postOnly + delete', // we only allow deletion via POST request
//                    'rights',
        );
    }

    /**
     * Specifies the access control rules.
     * This method is used by the 'accessControl' filter.
     * @return array access control rules
     */
    public function accessRules() {
        return array(
            array('allow', // allow all users to perform 'index' and 'view' actions
                'actions' => array('index', 'view', 'get_user_message_SubForm'),
                'users' => array('*'),
            ),
            array('allow', // allow authenticated user to perform 'create' and 'update' actions
                'actions' => array('create', 'update', 'admin', 'received', 'read', 'delete'),
                'users' => array('@'),
            ),
            array('allow', // allow admin user to perform 'admin' and 'delete' actions
                'actions' => array('admin', 'stats'),
                'users' => array('admin'),
            ),
            array('deny', // deny all users
                'users' => array('*'),
            ),
        );
    }

    /**
     * Displays a particular model.
     * @param integer $id the ID of the model to be displayed
     */
    public function actionView($id) {
        $this->render('view', array(
            'model' => $this->loadModel($id),
        ));
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate() {
        $model = new Message;
        $model->user_id = Yii::app()->user->id;
        $model->modified = date('Y-m-d H:i:s');

        //define original and posted grid details
        $user_messagePost = array();
        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (isset($_POST['Message'])) {
            $validToSave = TRUE;
            //~~~set the posted in models~~~
            $model->attributes = $_POST['Message'];


            if (isset($_POST['UserMessage'])) {
                foreach ($_POST['UserMessage'] as $index => $submittedDetail) {
                    $user_message = new UserMessage();
                    $user_message->attributes = $submittedDetail;
                    $user_message->message_id = 0;
                    $user_message->message_read = 0;
                    $user_message->created = date('Y-m-d H:i:s');
                    //uncoment condition if need condition.
                    //if ($user_message->id > 0) {
                    array_push($user_messagePost, $user_message);
                    //}
                }
            }
            //~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
            //
               //~~~validate all~~~~
            if (!$model->validate()) {
                $validToSave = FALSE;
                die(print_r($model->getErrors()));
            }

            foreach ($user_messagePost as $index => $user_message) {
                //add some condition if needed
                //$user_message->id > 0 && 
                if (!$user_message->validate()) {
                    $validToSave = FALSE;
                    die(print_r($user_message->getErrors()));
                    //break;
                }
            }
            //~~~~~~~~~~~~~~~~~~~~
            if ($validToSave) {
                if ($model->save()) {

                    //~~~save details~~~
                    foreach ($user_messagePost as $index => $user_message) {
                        $user_message->message_id = $model->id;
                        if ($user_message->save()) {
                            //die('saved');
                        } else {
                            die('not saved');
                        }
                    }                         //~~~~~~~~~~~~~~~~~~~~~~~~~
                } else {
                    
                }
                if (isset($_POST["saveandedit"]))
                    $this->redirect(array('update', 'id' => $model->id));
                elseif (isset($_POST["save"]))
                    $this->redirect(array('admin'));
            }
            else {
                
            }
            //~~~~~~~~~~~~~~~~~~~~~~~ 
        } else {//not posted
        }
        $this->render('create', array(
            'model' => $model,
            'user_message' => $user_messagePost,
        ));
    }

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     */
    public function actionUpdate($id) {
        $model = $this->loadModel($id);

        //define original and posted grid details
        $user_messageOrg = UserMessage::model()->findAll("message_id = $id");
        $user_messagePost = array();
        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (isset($_POST['Message'])) {
            $validToSave = TRUE;
            //~~~set the posted in models~~~
            $model->attributes = $_POST['Message'];

            foreach ($_POST['UserMessage'] as $index => $submittedDetail) {
                $user_message = new UserMessage();
                $user_message->attributes = $submittedDetail;
                $user_message->message_id = 0;

                $user_message->message_read = 0;
                $user_message->created = date('Y-m-d H:i:s');
                    
                //uncoment condition if need condition.
                //if ($user_message->id > 0) {
                array_push($user_messagePost, $user_message);
                //}
            }               //~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
            //
               //~~~validate all~~~~
            if (!$model->validate()) {
                $validToSave = FALSE;
            }

            foreach ($user_messagePost as $index => $user_message) {
                //add some condition if needed
                //$user_message->id > 0 && 
                if (!$user_message->validate()) {
                    $validToSave = FALSE;
                    //break;
                }
            }                 //~~~~~~~~~~~~~~~~~~~~
            if ($validToSave) {
                if ($model->save()) {
                    //~~~delete original~~~
                    foreach ($user_messageOrg as $index => $user_message) {
                        $user_message->delete();
                    }                         //~~~~~~~~~~~~~~~~~~~~~~~~~   
                    //~~~save details~~~
                    foreach ($user_messagePost as $index => $user_message) {
                        $user_message->message_id = $model->id;
                        if ($user_message->save()) {
                            //die('saved');
                        } else {
                            die('not saved');
                        }
                    }                        
                    //~~~~~~~~~~~~~~~~~~~~~~~~~
                } else {
                    
                }

                if (isset($_POST["saveandedit"]))
                    $this->redirect(array('update', 'id' => $model->id));
                elseif (isset($_POST["save"]))
                    $this->redirect(array('admin'));
            }
            //~~~~~~~~~~~~~~~~~~~~~~~ 

            $user_message = $user_messagePost;
        }
        else {//not posted
            $user_message = $user_messageOrg;
        }
        $this->render('update', array(
            'model' => $model,
            'user_message' => $user_message,
        ));
    }

    /**
     * Deletes a particular model.
     * If deletion is successful, the browser will be redirected to the 'admin' page.
     * @param integer $id the ID of the model to be deleted
     */
    public function actionDelete($id) {
        $model = $this->loadModel($id);
        
        if($model->user_id == Yii::app()->user->id){//creater of the message is the logged in user
           $model->delete();
        }
        else{
            throw new CHttpException(404, 'You can delete only your own messages.');            
        }
        // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
        if (!isset($_GET['ajax']))
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
    }

    /**
     * Lists all models.
     */
    public function actionIndex() {
        $dataProvider = new CActiveDataProvider('Message');
        $this->render('index', array(
            'dataProvider' => $dataProvider,
        ));
    }

    /**
     * Manages all models.
     */
    public function actionAdmin() {
        $model = new Message('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['Message']))
            $model->attributes = $_GET['Message'];

        $model->user_id = Yii::app()->user->id;
        $this->render('admin', array(
            'model' => $model,
        ));
    }

    public function actionReceived(){
        $model = new Message('searchreceived');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['Message']))
            $model->attributes = $_GET['Message'];

        $this->render('adminReceived', array(
            'model' => $model,
        ));        
    }

    public function actionRead($id){
        $model = $this->loadModel($id);
        
        $userMessage = UserMessage::model()->find("user_id = " . Yii::app()->user->id . " AND message_id = $id");
        if(isset($userMessage)){
            $userMessage->message_read = 1;
            $userMessage->save();
        }
        $comments = $model->userComments;
        $newComment = new UserComment();
        
        if (isset($_POST['UserComment'])) {
            $newComment->attributes = $_POST['UserComment'];
            $newComment->user_id = Yii::app()->user->id;
            $newComment->created = date('Y-m-d H:i:s');
            $newComment->message_id = $id;
            $newComment->modified =  date('Y-m-d H:i:s');
            
            if($newComment->validate()){
                $newComment->save();
                
                $comments = $model->userComments;
                $newComment = new UserComment();
            }
            else{
//                die(print_r($newComment->getErrors()));
            }
        }
        $this->render('readMessage', array(
            'model' => $model,
            'comments' => $comments,
            'newComment' => $newComment,
        ));         
    }
    


    /**
     * Manages all models.
     */
    public function actionViewPDF($id) {
        $model = $this->loadModel($id);

        $mPDF1 = Yii::app()->ePdf->mpdf();

        # You can easily override default constructor's params
        $mPDF1 = Yii::app()->ePdf->mpdf('utf-8', 'A4');
        $mPDF1->SetTopMargin(5);

        $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/main.css');
        $mPDF1->WriteHTML($stylesheet, 1);

        $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/screen.css');
        $mPDF1->WriteHTML($stylesheet, 1);

        $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/print.css');
        $mPDF1->WriteHTML($stylesheet, 1);

        $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/form.css');
        $mPDF1->WriteHTML($stylesheet, 1);

        $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/pdf_styles.css');
        $mPDF1->WriteHTML($stylesheet, 1);

        $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.themes.sltec-theme.css') . '/customcgridview.css');
        $mPDF1->WriteHTML($stylesheet, 1);

        $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.themes.sltec-theme.css') . '/custompager.css');
        $mPDF1->WriteHTML($stylesheet, 1);



        $footer = include 'PDFFooter.php';
        $mPDF1->SetHTMLFooter($footer, 'O');

        $content = $this->renderPartial('pdfview', array(
            'model' => $model,
                ), true);
        //echo $content;
        $mPDF1->WriteHTML($content);



        $mPDF1->Output();
        //$mPDF1->Output('SalesOrder'.$model->sai_order_no,'D');
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer the ID of the model to be loaded
     */
    public function loadModel($id) {
        $model = Message::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param CModel the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'message-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

    public function actionToggle($id) {
        $model = $this->loadModel($id);
        if (isset($_GET["attribute"])) {
            $attribute = $_GET["attribute"];
            $model->$attribute = $model->$attribute == 0 ? 1 : 0;
            $model->validate();

            if ($model->save(false) && $model->validate()) {
                $this->redirect(array('admin'));
            }
        }
    }

    public function actionGet_user_message_SubForm() {
        if (isset($_POST['cnt'])) {
            $form = $this->renderPartial('_user_message', array('model' => new UserMessage(), 'cnt' => $_POST['cnt']), true, false);
            echo $form;
        }
    }

}
