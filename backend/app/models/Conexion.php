<?php
session_start();
/*
CLASE PARA LA CONEXION Y LA GESTION DE LA BASE DE DATOS Y LA PAGINA WEB
*/
class database {

 private $conexion;

 
 public function CrearConexion($user,$pass){

     try{
            $conexion = mysql_connect("localhost",$user,$pass); 
            $conecto = mysql_select_db("tmbs",$conexion);
        
                if(!$conecto){
                    return "false";
                }else{return "true";}
 }catch(Exception $ER){}
 
 }
    /* METODO PARA CONECTAR CON LA BASE DE DATOS*/
 public function conectar()
 {
     
     $user=$_SESSION["user"];
     $pass=$_SESSION["pass"];
     
     $this ->conexion = (mysql_connect("localhost",$user,$pass)) or die(mysql_error()); 
            mysql_select_db("tmbs",$this->conexion) or die("Could not open the db");
            
    }
  /* METODO PARA REALIZAR UNA CONSULTA 
 INPUT:
 $sql | codigo sql para ejecutar la consulta
 OUTPUT: $result
 */
 public function consulta($sql)
 {


    $resultado = mysql_query($sql,$this->conexion);

    if(!$resultado){
     echo 'MySQL Error: ' . mysql_error();
     exit;
    }
    return $resultado;
 }

 /*METODO PARA CONTAR EL NUMERO DE RESULTADOS
 INPUT: $result
 OUTPUT: cantidad de registros encontrados
 */
 function numero_de_filas($result){

  if(!is_resource($result)) return false;
  return mysql_num_rows($result);
 }

 /*METODO PARA CREAR ARRAY DESDE UNA CONSULTA
 INPUT: $result
 OUTPUT: array con los resultados de una consulta
 */
 function fetch_assoc($result){
  if(!is_resource($result)) return false;
   return mysql_fetch_assoc($result);
 }

     /* METODO PARA CERRAR LA CONEXION A LA BASE DE DATOS */
 public function disconnect()
 {
  mysql_close();
 }

}
?>

