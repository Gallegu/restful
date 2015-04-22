<?php



	class UserController extends AbstractController{
		
		protected $gdb=null;
		
		function __construct(){
			
			$this->gdb=userSPDO::singleton();
			
		}
		
		
		public function get($request){
			
			$users = $this->llistar_usuarios();
			
			switch(count($request->url_elements)){
				
				case 1:
				
					return $users;
					break;
					
				case 2:
				
					$users_id = $request->url_elements[1];
					$users = $this->llistar_usuarios($users_id);
					return $users;
					break;
			
			}
		}
		
		public function post($request){ 
			
			$consulta= "INSERT INTO usuarios (id_usuari,nom,cognom,usuari,contrasenya) VALUES (?,?,?,?,?);";
			
			$consulta_sql = $this->gdb->prepare($consulta);
			
			$consulta_sql->bindParam(1,$_POST["id_usuari"]);
			$consulta_sql->bindParam(2,$_POST["nom"]);
			$consulta_sql->bindParam(3,$_POST["cognom"]);
			$consulta_sql->bindParam(4,$_POST["usuari"]);
			$consulta_sql->bindParam(5,$_POST["contrasenya"]);
			
			$consulta_sql->execute();
			
			$consulta_sql->fetch(PDO::FETCH_ASSOC);
			
			return "Nou usuari introduit";
			   
		}
		
		public function put($request){ 
			
			$id_user = $request->parameters['id_usuari'];
			$name = $request->parameters['nom'];
			$lastname = $request->parameters['cognom'];
			$user = $request->parameters['usuari'];
			$passwd = $request->parameters['contrasenya'];
	
			$consulta= "UPDATE usuarios SET nom =:nom, usuari =:usuari, contrasenya =:contrasenya WHERE id_usuari = :id_usuari";
			
			$consulta_sql = $this->gdb->prepare($consulta);
			
			$consulta_sql->bindValue(":id_usuari",$id_user);
			$consulta_sql->bindValue(":nom",$name);
			$consulta_sql->bindValue(":usuari",$user);
			$consulta_sql->bindValue(":contrasenya",$passwd);
			
			$consulta_sql->execute();
			
			$consulta_sql->fetch(PDO::FETCH_ASSOC);
			
			return "L'usuari a estat actualitzat"; 
			
		}
		
		public function login_usuarios($request){ 
	
			try{
				
				$consulta= "SELECT * FROM usuarios WHERE usuari = ? AND contrasenya = ?";
				
				$consulta_sql = $this->gdb->prepare($consulta);
				
				$consulta_sql->bindParam(1,$_POST['usuari']);
				$consulta_sql->bindParam(2,$_POST['contrasenya']);
				
				$consulta_sql->execute();
				
				$consulta_sql->fetch(PDO::FETCH_ASSOC);
						
				$Filas= $consulta_sql->RowCount();
			   
					if($Filas >= 1){
					
						//return true;
						return "Entrada Correctament.";
						
					}else{
						
						//return false;
						return "Error de login";
						
					}
	
			  }catch (Exception $ex){
				  
				  print "Error:".$ex->getMessage();
				  
			 }
			 
			return "login..."; 
			
		}
		
		public function delete($request){
			$id_user = $request->parameters['id_usuari'];
	
			$consulta= "DELETE FROM usuarios WHERE id_usuari = :id_usuari";
			
			$consulta_sql = $this->gdb->prepare($consulta);
			
			$consulta_sql->bindValue(":id_usuari",$id_user);
			
			$consulta_sql->execute();
			
			$consulta_sql->fetch(PDO::FETCH_ASSOC);
			
			return "Usuari Borrat.";
			   
		}
		
	   
		
		
		
		protected function llistar_usuarios($id = NULL){
		
				try{
					
					if(!empty($id)){
						
						$con = $this->gdb->query("SELECT * FROM usuarios WHERE id_usuari =".$id);
						$users = $con->fetchAll(PDO::FETCH_OBJ);
					
					 }else{
						 
						$con = $this->gdb->query("SELECT * FROM usuarios");
						$users = $con->fetchAll(PDO::FETCH_OBJ);
					
					}
				
				}catch (Exception $ex) {
					
					echo 'Error: '.$ex->getMessage();
				
				}
			
				return $users;
	
		}
	
	}
		
	   