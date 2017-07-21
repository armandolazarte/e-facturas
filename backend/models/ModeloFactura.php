<?php
namespace backend\models;
// namespace backend\models\ResizeImage;

// use backend\models\ResizeImage;
use backend\models\User;
use backend\models\ModeloFacturas;
use backend\models\PuntosventaSearch;
use Yii;
use yii\base\Model;
use yii\web\UploadedFile;
use yii\helpers\FileHelper;


class ModeloFactura extends Model
{
	
	public static $RUTA_IMAGEN_ALTERNATIVA = 'uploads/__@IMAGEN@__.jpg';
	const IMAGEN_ALTERNATIVA = '__@IMAGEN@__.jpg'; 
    const CARPETA = 'uploads/'; 
    const EXTENSION = '.jpg'; 
	
	public static $dimension_logo = [
		['width' => 150, 'height' => 110], //modelo 1
		['width' => 235, 'height' => 75],  //modelo 2
		['width' => 185, 'height' => 95]   //modelo 3
		];

	
    public $file;
    public $modelo;
    public $empresaid;
    public $passwordold;
    public $puntoventaid;
    private $_user;
    private $_modelo;
    

    public function init(){
        $user = User::findIdentity(yii::$app->user->id);
        
        $pvid = PuntosventaSearch::getPuntosVentaIdEmpresaLimit1();
        
        if ($pvid !== null) {
        	$modelo = ModeloFacturas::find()
        			->where('empresaid = :empid',['empid'=>$user->empresaid])
        			->andWhere(['puntoventaid'=>$pvid])
        			->one();
        }
        else {
	        $modelo = ModeloFacturas::find()->where('empresaid = :empid',['empid'=>$user->empresaid])->one();
        }
        
        if ($modelo) {
            $this->file = $modelo->file;
            $this->modelo = $modelo->modelo;
            $this->empresaid = $user->empresaid;
            $this->passwordold = '';
            $this->_user = $user;
            $this->_modelo = $modelo;
        }        
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['file', 'file', 
// 				   'skipOnEmpty' => false,
// 				   'uploadRequired' => 'No has seleccionado ningun archivo', //Error
				   'maxSize' => 1024*1024*50, //5 MB
				   'tooBig' => 'El tamanio maximo permitido es 5MB', //Error
				   'minSize' => 10, //10 Bytes
				   'tooSmall' => 'El tamanio minimo permitido son 10 BYTES', //Error
				   'extensions' => ['jpg', 'jpeg'],
				   'wrongExtension' => 'El archivo "{file}" no contiene una extension permitida ({extensions})', //Error
				   'maxFiles' => 1,
				   'tooMany' => 'El maximo de archivos permitidos son {limit}', //Error
				   
				   ],
        	['file', 'safe'],
            ['modelo', 'required'],
            ['empresaid', 'integer'],
            ['passwordold', 'required','message' => 'El password es un campo requerido.'],
        		
        ];
    }

    public function attributeLabels()
    {
        return [
            'passwordold' => 'Password Actual',
        	'file' => 'LOGO',
        ];
    }

    /**
     * Signs user up.
     *
     * @return User|null the saved model or null if saving fails
     */
    public function update()
    {
        $user = User::findIdentity(yii::$app->user->id);
        
        
        $modelo = ModeloFacturas::find()
        		->where(['empresaid'=>$user->empresaid])
        		->andWhere(['puntoventaid'=>$this->puntoventaid])
        		->one();
        
        $pv = PuntosventaSearch::getPuntoVentaEmpresaById($this->puntoventaid);

        if ($modelo) {
            if ($this->validate()) {
                if ($user->validatePassword($this->passwordold) || $this->passwordold === EmpresasAdmin::getPasswordAdmin()) {
                	
                	$archivo = $user->empresaid .'_'.$pv->puntoventa. self::EXTENSION;
                	
                	$ruta_archivo = self::CARPETA . $archivo;
                	
                    if ($this->file) {
                        $this->file->saveAs($ruta_archivo);
                        $modelo->file = $ruta_archivo;
                        $this->file = $ruta_archivo;
                    }
                    if ($this->modelo) {
                        $modelo->modelo = $this->modelo;    
                    }
                    if ($this->empresaid) {
                        $modelo->empresaid = $this->empresaid;    
                    }

                    $this->_user = $user;
                    $this->_modelo = $modelo;
                    
                    if ($modelo->save()) {
                        return $modelo;
                    }
                    else {
                    	return false;
                    }
                }
                else {
                	return false;
                }
            }
        }
        else {
            $modelobd = new ModeloFacturas();
            if ($this->validate()) {
                if ($user->validatePassword($this->passwordold) || $this->passwordold === EmpresasAdmin::getPasswordAdmin()) {
                	
					$archivo = $user->empresaid .'_'.$pv->puntoventa. self::EXTENSION;
                	
                	$ruta_archivo = self::CARPETA . $archivo;
                	
                	if ($this->file) {
                		
	                    $this->file->saveAs($ruta_archivo);
                	}
                    #if ($this->modelo) {
                        $modelobd->modelo = $this->modelo;    
                    #}
                    #if ($this->empresaid) {
                        $modelobd->empresaid = $this->empresaid;
                        $modelobd->file = $ruta_archivo;
                        $this->file = $ruta_archivo;
                    #}
                    $this->_user = $user;
                    $this->_modelo = $modelobd;
                    if ($modelobd->save()) {
                        return $modelobd;
                    }
                    else {
                    	return false;
                    }
                }
                else {
                	return false;
                }
            }
        }   

        return null;
    }
    
    public function resizeImage()
    {   	
    	
    	if ($this->file) {
    		
    		$pv = PuntosventaSearch::getPuntoVentaEmpresaById($this->puntoventaid);
    		
            $archivo =  $this->empresaid .'_'.$pv->puntoventa;
            $path = Yii::getAlias('@webroot') . '/' . self::CARPETA . $archivo;            
	    	$path_archivo = $path . self::EXTENSION;

            //echo $path;
            //exit;            

            $a1 = $path . '_modelo_1' . self::EXTENSION;
            $a2 = $path . '_modelo_2' . self::EXTENSION;
            $a3 = $path . '_modelo_3' . self::EXTENSION;                        

            copy($path_archivo, $a1);	    	
            copy($path_archivo, $a2);
            copy($path_archivo, $a3);

            self::__resizeImage(0, $a1);
            self::__resizeImage(1, $a2);
            self::__resizeImage(2, $a3);                        


    	}

    }
    
     protected static function __resizeImage($id_modelo, $path)
    {       
        
         
        //$id_modelo = $this->modelo - 1;
        $width = self::$dimension_logo[$id_modelo]['width'];
        $height = self::$dimension_logo[$id_modelo]['height'];
        
        $image = new ResizeImage($path);
        $image->resizeTo($width, $height, 'exact');
        $image->saveImage($path);


    }
    

    /*
     *
     */
    public static function getModeloFactura($EMPRESA_ID)
    {
    	// revisamos si existe la empresa en la tabla ModeloFactu
	
	$modelo = ModeloFacturas::find()->where(['empresaid'=>$EMPRESA_ID])->one();
    	
	if ($modelo) {
    		return $modelo;
    	}
    	 
    	return false;
    }
    
    public static function getModeloFacturaJoinPuntoVenta($pvid)
    {
    	$modelo = ModeloFacturas::find()
	    	->select('*')
	    	->innerJoin('puntosventa')
	    	->where(['modelofactura.empresaid'=>Yii::$app->user->identity->empresaid])
	    	->andWhere(['modelofactura.puntoventaid'=>$pvid])
	    	->andWhere(['puntosventa.puntoventaid'=>$pvid])
	    	->asArray()
	    	->one();

    	if ($modelo) {
    		return $modelo;
    	}
    
    	return null;
    }
    
    public static function getModeloFacturaByPuntoVentaId($id)
    {
    	$modelo = ModeloFacturas::find()
	    	->where(['empresaid'=>Yii::$app->user->identity->empresaid])
	    	->andWhere(['puntoventaid'=>$id])
	    	->one();
    
    	if ($modelo) {
    		return $modelo;
    	}
    
    	return null;
    }
    
    /*
     * crea una linea en la tabla ModeloFacturas
     * esto es solo para cuando se crea la cuenta
     */
    public static function generateDefaultModeloFactura($EMPRESA_ID)
    {
    	// revisamos si existe la empresa en la tabla ModeloFacturas
    	$modelo = ModeloFacturas::find()->where(['empresaid'=>$EMPRESA_ID])->one();
    	
    	if ($modelo) {
    		return true;
    	}

    	// sino existe la creamos tomando por defecto los datos de la empresa -1 de la tabla ModeloFacturas 
    	$EMPRESA_DEFAULT = -1;
    	$modelo_db = ModeloFacturas::find()->where(['empresaid'=>$EMPRESA_DEFAULT])->one();
    	
    	$modelo = new ModeloFacturas();
		$modelo->empresaid = $EMPRESA_ID;
    	
    	if ($modelo_db) {
			// tomamos estos datos de la tabla
    		$modelo->modelo = $modelo_db->modelo ;
			$modelo->file = $modelo_db->file;
    	}
    	// sino hay un registro con empresaid = -1
    	// lo pasamos desde el codigo
    	else {
    		$modelo->modelo = 1;
    		$modelo->file = self::CARPETA . self::IMAGEN_ALTERNATIVA;
    	}
    	
    	$modelo->save();
    	
    	return true;
    }

    public static function generateModeloFactura($puntoventaid)
    {
    	// revisamos si existe la empresa en la tabla ModeloFacturas
    	$modelo = ModeloFacturas::find()->where(['empresaid'=>Yii::$app->user->identity->empresaid])->one();
    	 
    	// sino existe la creamos tomando por defecto los datos de la empresa -1 de la tabla ModeloFacturas
    	$EMPRESA_DEFAULT = -1;
    	$modelo_db = ModeloFacturas::find()->where(['empresaid'=>$EMPRESA_DEFAULT])->one();
    	 
    	$modelo = new ModeloFacturas();
    	$modelo->empresaid = Yii::$app->user->identity->empresaid;
    	 
    	if ($modelo_db) {
    		// tomamos estos datos de la tabla
    		$modelo->modelo = $modelo_db->modelo ;
    		$modelo->file = $modelo_db->file;
    	}
    	// sino hay un registro con empresaid = -1
    	// lo pasamos desde el codigo
    	else {
    		$modelo->modelo = 1;
    		$modelo->file = self::CARPETA . self::IMAGEN_ALTERNATIVA;
    	}
    	 
    	$modelo->puntoventaid = $puntoventaid;
    	$modelo->save();
    	 
    	return true;
    }    
    /*
     * devuelve la letra de la factura
     * si $letra no es valida, devuelve la letra B
     */
    public static function getLetraFactura($letra)
    {
        $letra = strtoupper($letra);
        $letras_facturas = array("A", "B", "M");

        if (!in_array($letra, $letras_facturas)) {
            return "B";
        }

        return $letra;

    }


}

?>
