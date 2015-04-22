    <?php
    
	class userSPDO extends PDO{

        private static $instance=null;

		 CONST driver ='mysql:host=localhost;dbname=RestFul';
		 CONST user='root';
		 CONST password='';
         
		 public function __construct(){          
		 
		 try{
			 
			parent::__construct(self::driver,self::user,self::password);
			
		 }catch(PDOException $e){
			 
		 	echo 'Error de Conexio: ' . $e->getMessage();}
		
		}

        static function singleton(){
			
            if(self::$instance == null){
				
                self::$instance = new self();
				
            }
			
            return self::$instance;
        }
    }
    
