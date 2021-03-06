<?php
require_once "Conexion.php";

class DetalleVenta extends database {

  function getDetalleVentas($id_venta)
  {
    $this->conectar();
    $q = "SELECT dv.id_detalle_venta,dv.id_venta,p.id_producto,p.nombre,dv.cantidad,dv.precio FROM detalle_venta dv INNER JOIN producto p ON dv.id_producto = p.id_producto WHERE dv.id_venta = ".$id_venta.";";
    $query = $this->consulta($q);
    $this->disconnect();
    if($this->numero_de_filas($query) > 0){
      while ( $tsArray = $this->fetch_assoc($query) )
        $data[] = $tsArray;   
        return $data;
    }else{
      return array();
    }
  }
  function newDetalleVenta($detalle,$venta){
    $ventaArray = get_object_vars($venta);
    $detalleVentaArray = get_object_vars($detalle);
    $q = "INSERT INTO detalle_venta (id_venta,id_producto,cantidad,precio) VALUES (".$ventaArray['id_venta'].",".$detalleVentaArray['id_producto'].",".$detalleVentaArray['cantidad'].",".$detalleVentaArray['precio'].");";
    $this -> conectar();
    $query = $this->consulta($q);
    $queryObject = $this->consulta("SELECT dv.id_detalle_venta,dv.id_venta,p.id_producto,p.nombre,dv.cantidad,dv.precio FROM detalle_venta dv INNER JOIN producto p ON dv.id_producto = p.id_producto WHERE dv.id_venta = ".$ventaArray['id_venta']." ORDER BY dv.id_detalle_venta DESC LIMIT 1;" );
    $this->disconnect();
    if($this->numero_de_filas($queryObject) > 0){
      while ( $tsArray = $this->fetch_assoc($queryObject) )
        $data[] = $tsArray;   
        return $data;
    }else{
      return array();
    }
  }
	function updateDetalleVenta($gasto){
    echo var_dump($gasto);
		$this -> conectar();
    $q = "update detalle_venta  set  id_producto=".$gasto['id_producto']." ,precio= ".$gasto['precio'].",cantidad = ".$gasto['cantidad']."  where id_detalle_venta = ".$gasto['id_detalle_venta'].";"; 
    $query = $this -> consulta($q);
		$this ->disconnect();
		if($this->numero_de_filas($queryObject) > 0){
			while ( $tsArray = $this->fetch_assoc($queryObject) )
				$data[] = $tsArray;
			return $data;
		}else{
			return '{ }';
		}
	}

function deleteDetailSpend($id){
    $this -> conectar();
    $query = $this -> consulta("delete from detalle_venta where id_detalle_venta = ".$id);
    $this ->disconnect();

    return '{"success":true}';
  }

}

?>

