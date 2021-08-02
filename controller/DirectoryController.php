<?php

namespace app\controllers;

use Yii;
use app\models\Directory;
use app\models\Phones;
use app\models\DirectorySearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\rest\ActiveController;


/**
 * DirectoryController implements the CRUD actions for Directory model.
 */
class DirectoryController extends ActiveController
{
	 public $modelClass = 'app\models\Directory';
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
       // remove rateLimiter which requires an authenticated user to work
        $behaviors=parent::behaviors();
        unset($behaviors['rateLimiter']);
        return $behaviors;
    }
	


public function fields()
    {
        return [
            'lastname' => 'lastname',
			'firstname' => 'firstname',
			'middlename' => 'middlename',
			'date' => 'date',
        ];
		
    }
    
    public function extraFields()
    {
		$phones = Phones::find()->where(['user_id' => 1])->all();
        return [
            'phones' => function($phones){
                return [
                    'phone' => $phones->phone,
                ];
            }
        ];
    }
	
    /**
     * Lists all Directory models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new DirectorySearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Directory model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id){  
		$phones = new Phones();
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Directory model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Directory();
		$phones = new Phones();

        if ($model->load(Yii::$app->request->post()) && $phones->load(Yii::$app->request->post())) {
			if (($model->validate()) && ($phones->validate())) {
				$model->save();
				$phones->user_id = $model->id;
				$phones->save();
			}
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
			'phones' => $phones,
        ]);
    }

    /**
     * Updates an existing Directory model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
		$phones = Phones::find()->where(['user_id' => $id])->one();
		//$phones = Phones::find()->where(['user_id' => $id])->orderBy('id')->all();
		//$phones2 = implode(',',$phones);
        if ($model->load(Yii::$app->request->post()) && $phones->load(Yii::$app->request->post()) ) {
 			if (($model->validate()) && ($phones->validate())) {
				$model->date = new \yii\db\Expression('NOW()');
				$model->save();
				$phones->user_id = $model->id;
				$phones->save();
			return $this->redirect(['view', 'id' => $model->id]);
			}
			
        }

        return $this->render('update', [
            'model' => $model,
			'phones' => $phones,
        ]);
    }

    /**
     * Deletes an existing Directory model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();
		Phones::deleteAll(['user_id' => $id]);

        return $this->redirect(['index']);
    }

    /**
     * Finds the Directory model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Directory the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Directory::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
	
    protected function findPhones($id)
    {
        if (($phones = Phones::findOne($id)) !== null) {
            return $phones;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}