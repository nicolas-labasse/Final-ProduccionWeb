<?php

class Conector {

    private $servername;
    private $username;
    private $password;
    private $dbname;

    private $conexion;

    public function __construct() {
        $this->servername = "localhost";
        $this->username = "root";
        $this->password = "Katana88";
        $this->dbname = "retabasse";

        $this->conexion = new mysqli($this->servername, $this->username, $this->password, $this->dbname);
        if ($this->conexion->connect_error) {
            die("Falló la conexión: " . $this->conexion->connect_error);
        }
    }

    // WRAPPER GENERAL

    public function query($qry) {
        return ($this->conexion->query($qry));
    }

    // INTERNOS

    private function BaseProducto() {
        return "SELECT
        p.id, 
        p.nombre, 
        p.marca, 
        p.modelo, 
        p.precio, 
        p.stock, 
        p.cod_categoria,
        c.categoria,
        c.nombre AS nombreCategoria,
        p.cod_subcategoria,
        s.subcategoria, 
        s.nombre AS nombreSubcategoria,
        p.rutaImagen, 
        p.esHabilitado, 
        p.esPromocion
        FROM productos p
        INNER JOIN categorias c ON p.cod_categoria = c.id
        LEFT JOIN categorias_sub s ON p.cod_subcategoria = s.id";
    }

    private function ChequearSiExisteEnCarrito($prodID) {
        $qry = "SELECT
        cantidad
        FROM
        usuarios_carrito
        WHERE cod_producto = {$prodID} AND cod_usuario = {$_SESSION['userID']}";

        if ($res = $this->conexion->query($qry))
            if ($res->num_rows == 0)
                return 0;
            else{
                $row= $res->fetch_assoc();
                return ($row['cantidad']);
            }
    }

    private function CargarListadoHnoH ($habilitado) {
        $qry = $this->BaseProducto() .
        " WHERE p.esHabilitado = {$habilitado}"; 

        return ($this->conexion->query($qry));
    }

    // SELECTs

    public function Login($usr, $pwd) {
        
        $usr = $this->conexion->real_escape_string($usr);
        $pwd = $this->conexion->real_escape_string($pwd);

        $qry = "SELECT 
        id,
        usuario,
        nombre, 
        apellido,
        passwd,
        nivel,
        f_alta,
        f_baja
        FROM usuarios u 
        WHERE u.usuario = '{$usr}'";

        return ($this->conexion->query($qry));
    }

    public function CargarProductoConID($id) {

        $id = $this->conexion->real_escape_string($id);

        $qry = $this->BaseProducto() .
        " WHERE p.id = {$id}";

        return ($this->conexion->query($qry));
    }
    
    public function CargarProductoExtras($categoria, $id) {
       
        $categoria = $this->conexion->real_escape_string($categoria);
        $id = $this->conexion->real_escape_string($id);
        
        $qry = "SELECT
        *
        FROM productos_{$categoria}
        WHERE cod_producto = " . $id;

        return ($this->conexion->query($qry));
    }
    
    public function CargarListadoPorCategoria($categoria,$limit, $rpp) {
        
        $categoria = $this->conexion->real_escape_string($categoria);
        
        $qry = $this->BaseProducto() .
        " WHERE p.esHabilitado = 1 AND c.categoria = '{$categoria}'
        LIMIT {$limit}, {$rpp}";

        return ($this->conexion->query($qry));
    }
    
    public function CargarListadoPorCategoriaMarca($categoria, $marca) {

        $categoria = $this->conexion->real_escape_string($categoria);
        $marca = $this->conexion->real_escape_string($marca);
        
        $qry = $this->BaseProducto() .
        " WHERE p.esHabilitado = 1 AND c.categoria = '{$categoria}' AND p.marca = '{$marca}'";

        return ($this->conexion->query($qry));
    }
    
    public function CargarListadoPorCategoriaSubcategoria($categoria, $subcategoria,$limit, $rpp) {

        $categoria = $this->conexion->real_escape_string($categoria);
        $subcategoria = $this->conexion->real_escape_string($subcategoria);
        
        $qry = $this->BaseProducto() .
        " WHERE p.esHabilitado = 1 AND c.categoria = '{$categoria}' AND s.subcategoria = '{$subcategoria}'
        LIMIT {$limit}, {$rpp}"; 

        return ($this->conexion->query($qry));
    }
    
    public function CargarListadoHabilitados() {
        return $this->CargarListadoHnoH(1);
    }

    public function CargarListadoNoHabilitados() {
        return $this->CargarListadoHnoH(0);
    }

    public function CargarListadoCompleto() {
        $qry = $this->BaseProducto() .
        " ORDER BY p.esHabilitado";

        return ($this->conexion->query($qry));
    }

    public function CargarListadoCompletoPaginado($limit, $rpp) {
        $qry = $this->BaseProducto() .
        " ORDER BY p.esHabilitado LIMIT {$limit}, {$rpp}";

        return ($this->conexion->query($qry));
    }
    
    public function CargarListadoPromociones() {
        $qry = $this->BaseProducto() .
        " WHERE p.esHabilitado = 1 AND p.esPromocion = 1";

        return ($this->conexion->query($qry));        
    }

    public function CargarCategorias () {
        $qry = "SELECT * FROM categorias ORDER BY nombre";

        return ($this->conexion->query($qry));
    }

    public function CargarSubCategoriasPorCategoria ($categoria) {
        $qry = "SELECT * FROM categorias_sub WHERE cod_categoria = {$categoria}";

        return ($this->conexion->query($qry));
    }

    public function CargarEspecialLateral () {
        $qry = "SELECT DISTINCT
        c.plural AS categoriaPlural, c.categoria, s.plural AS subcategoriaPlural, s.subcategoria
        FROM productos p
        INNER JOIN categorias c ON p.cod_categoria = c.id
        INNER JOIN categorias_sub s ON p.cod_subcategoria = s.id
        WHERE p.esHabilitado = 1
        ORDER BY c.nombre, s.nombre";

        return ($this->conexion->query($qry));
    }
    
    public function CargarUsuarios () {
        $qry = "SELECT
        u.id,
        u.usuario,
        u.passwd,
        u.nombre,
        u.apellido,
        u.nivel,
        n.descripcion,
        n.tipoBadge,
        u.email,
        u.f_alta,
        u.f_baja
        FROM usuarios u
        INNER JOIN usuarios_niveles n ON u.nivel = n.nivel
        ORDER BY id;";

        return ($this->conexion->query($qry));
    }

    public function CargarUsuariosPaginado ($limit, $rpp) {
        $qry = "SELECT
        u.id,
        u.usuario,
        u.passwd,
        u.nombre,
        u.apellido,
        u.nivel,
        n.descripcion,
        n.tipoBadge,
        u.email,
        u.f_alta,
        u.f_baja
        FROM usuarios u
        INNER JOIN usuarios_niveles n ON u.nivel = n.nivel
        ORDER BY id LIMIT {$limit}, {$rpp}";

        return ($this->conexion->query($qry));
    }

    public function CargarUsuarioConID ($userID) {
        $qry = "SELECT
        u.id,
        u.usuario,
        u.passwd,
        u.nombre,
        u.apellido,
        u.nivel,
        n.descripcion,
        n.tipoBadge,
        u.email,
        u.f_alta,
        u.f_baja
        FROM usuarios u
        INNER JOIN usuarios_niveles n ON u.nivel = n.nivel
        ORDER BY id;";

        return ($this->conexion->query($qry));
    }

    public function CargarNiveles () {
        $qry = "SELECT
        *
        FROM usuarios_niveles";

        return ($this->conexion->query($qry));
    }

    public function CargarNivelConDescripcion ($desc) {
        $qry = "SELECT
        nivel
        FROM usuarios_niveles
        WHERE descripcion = '{$desc}'";

        return (($this->conexion->query($qry))->fetch_row())[0];
    }

    public function CargarCarrito () {
        $userID = $this->conexion->real_escape_string($_SESSION['userID']);

        $qry = "SELECT
        p.id,
        p.marca,
        p.modelo,
        p.precio,
        p.rutaImagen,
        u.cantidad,
        c.nombre as nombreCategoria
        FROM usuarios_carrito u
        INNER JOIN productos p ON u.cod_producto = p.id
        INNER JOIN categorias c ON p.cod_categoria = c.id
        WHERE u.cod_usuario = {$userID}";

        return ($this->conexion->query($qry));
    }

    public function CargarModeloAdicionales ($categoria) {

        $qry = "SELECT
        *
        FROM categorias_modelo m
        INNER JOIN categorias c
        ON m.cod_categoria = c.id
        WHERE c.categoria = '{$categoria}'";

        return ($this->conexion->query($qry));
    }

    public function BuscarUsuario ($usuario, $email) {
        $qry = "SELECT
        id
        FROM usuarios u
        WHERE u.usuario = '{$usuario}' OR email = '{$email}'";

        return $this->conexion->query($qry);
    }

    public function ContarProductosHabilitados () {
        $qry = "SELECT
        COUNT(1)
        FROM productos
        WHERE esHabilitado = 1";

        return (($this->conexion->query($qry))->fetch_row())[0];
    }

    public function ContarUsuarios () {
        $qry = "SELECT
        COUNT(1)
        FROM usuarios";

        return (($this->conexion->query($qry))->fetch_row())[0];
    }

    public function VistaPedidos($estado){
        $qry = "SELECT
        p.id,
        p.cod_usuario,
        p.fechaCreacion,
        p.fechaDespacho,
        p.cod_estado,
        e.nombre as estado
        FROM pedidos p
        INNER JOIN pedidos_estados e ON p.cod_estado = e.id
        WHERE p.cod_estado ";
        
        $qry .= ($estado == "ensamblado" ? "= " : "<> ");
        
        $qry .= "2 ORDER BY fechaCreacion DESC";

        return ($this->conexion->query($qry));
    }
 
    public function DetallePedido($pedidoID){
        $qry="SELECT
        p.id, 
        p.nombre, 
        p.marca, 
        p.modelo, 
        p.precio, 
        c.nombre AS nombreCategoria,
        s.nombre AS nombreSubcategoria,
        p.rutaImagen
        FROM productos p
        INNER JOIN categorias c ON p.cod_categoria = c.id
        INNER JOIN categorias_sub s ON p.cod_subcategoria = s.id
        join pedidos_items pi on p.id = pi.cod_producto
        where pi.cod_pedido = {$pedidoID}";
        return ($this->conexion->query($qry));
    }

    public function MostrarUsuarioID ($userID) {
        $qry = "SELECT
        u.id,
        u.usuario,
        u.passwd,
        u.nombre,
        u.apellido,
        u.email
        FROM usuarios u
        INNER JOIN usuarios_niveles n ON u.nivel = n.nivel
        where u.id = {$userID}
        ORDER BY id";

        return ($this->conexion->query($qry));
    }

    public function MostrarPedidoPorID($userID){
        $qry = "SELECT
        p.id,
        p.cod_usuario,
        p.fechaCreacion,
        p.fechaDespacho,
        e.nombre as estado
        FROM pedidos p
        INNER JOIN pedidos_estados e ON p.cod_estado = e.id
        WHERE p.cod_usuario = {$userID}";

        return ($this->conexion->query($qry));    
    }
    
    public function mostrarBusqueda($buscar,$limit, $rpp){
        
        $qry = $this->BaseProducto() .
        " WHERE p.esHabilitado = 1 AND  UPPER(p.nombre) like UPPER('%{$buscar}%')
        OR UPPER(p.marca) like UPPER('%{$buscar}%')
        OR UPPER(p.modelo) like UPPER('%{$buscar}%')
        OR UPPER(c.nombre) like UPPER('%{$buscar}%')
        OR UPPER(s.nombre) like UPPER('%{$buscar}%')
        LIMIT {$limit}, {$rpp}";

        return ($this->conexion->query($qry));

    }

    public function contarProductosBuscador($buscar) {

        $qry = "SELECT
        COUNT(1)
        FROM productos p
        INNER JOIN categorias c ON p.cod_categoria = c.id
        LEFT JOIN categorias_sub s ON p.cod_subcategoria = s.id
        WHERE p.esHabilitado = 1 AND  UPPER(p.nombre) like UPPER('%{$buscar}%')
        OR UPPER(p.marca) like UPPER('%{$buscar}%')
        OR UPPER(p.modelo) like UPPER('%{$buscar}%')
        OR UPPER(c.nombre) like UPPER('%{$buscar}%')
        OR UPPER(s.nombre) like UPPER('%{$buscar}%')";

        return (($this->conexion->query($qry))->fetch_row())[0];
      
}

    public function CargarListadoHabilitado ($limit, $rpp) {
        $qry = $this->BaseProducto() .
        " WHERE p.esHabilitado = 1
        LIMIT {$limit}, {$rpp}"; 

        return ($this->conexion->query($qry));
}


public function contarHabilitados(){

    $qry = "SELECT
    COUNT(1)
    FROM productos p
    INNER JOIN categorias c ON p.cod_categoria = c.id
    LEFT JOIN categorias_sub s ON p.cod_subcategoria = s.id
    WHERE p.esHabilitado = 1 ";

    return (($this->conexion->query($qry))->fetch_row())[0];
  
}

public function contarCategorias($categoria){

    $categoria = $this->conexion->real_escape_string($categoria);

    $qry = "SELECT
    COUNT(1)
    FROM productos p
    INNER JOIN categorias c ON p.cod_categoria = c.id
    WHERE p.esHabilitado = 1 
    AND c.categoria = '{$categoria}'";

    return (($this->conexion->query($qry))->fetch_row())[0];

}
public function contarCategoriasSubcategorias($categoria,$subcategoria){

    $categoria = $this->conexion->real_escape_string($categoria);
    $subcategoria = $this->conexion->real_escape_string($subcategoria);

    $qry = "SELECT
    COUNT(1)
    FROM productos p
    INNER JOIN categorias c ON p.cod_categoria = c.id
    LEFT JOIN categorias_sub s ON p.cod_subcategoria = s.id
    WHERE p.esHabilitado = 1 
    AND c.categoria = '{$categoria}'
    AND s.subcategoria = '{$subcategoria}'";

    return (($this->conexion->query($qry))->fetch_row())[0];
        

}



        

    // INSERTs

    public function InsertarUsuario ($usr, $pwd, $nombre, $apellido, $email, $nivel) {
        $usr= $this->conexion->real_escape_string($usr);
        $pwd= $this->conexion->real_escape_string($pwd);
        $pwd= password_hash($pwd, PASSWORD_DEFAULT);
        $nombre= $this->conexion->real_escape_string($nombre);
        $apellido= $this->conexion->real_escape_string($apellido);
        $email= $this->conexion->real_escape_string($email);

        $hoy = date('Y-m-d');

        $qry = "INSERT INTO
        usuarios (usuario, passwd, nivel, nombre, apellido, email, f_alta)
        VALUES
        ('{$usr}', '{$pwd}', $nivel, '{$nombre}', '{$apellido}', '{$email}', '{$hoy}')";

        return ($this->conexion->query($qry));
    }

    public function EnviarCarritoAPedidos(){
        session_start();
        $hoy = date('Y-m-d H:i:s');
        $qry = "INSERT INTO
        pedidos
        (cod_usuario,fechaCreacion, cod_estado)
        VALUES
        ({$_SESSION['userID']},'{$hoy}', 1)";

        $this->conexion->query($qry);

        $ultimoID = $this->conexion->insert_id;

        $qry = "INSERT INTO
        pedidos_items (cod_pedido, cod_producto, cantidad)
        SELECT {$ultimoID},u.cod_producto,u.cantidad FROM usuarios_carrito u WHERE u.cod_usuario = {$_SESSION['userID']}";
        $this->conexion->query($qry);

        $this->BorrarCarro();
        
    }

    public function InsertarProducto ($nombre, $marca, $modelo, $precio, $stock, $categoria, $rutaImagen) {
        
        try {
            $qry = "INSERT INTO
            productos (nombre, marca, modelo, precio, stock, cod_categoria, rutaImagen, esHabilitado, esPromocion)
            SELECT '{$nombre}', '{$marca}', '{$modelo}', {$precio}, {$stock}, c.id, '{$rutaImagen}', 0, 0 FROM categorias c WHERE c.categoria = '{$categoria}'";

            

            $this->conexion->query($qry);

            $ultimoID = $this->conexion->insert_id;

            $qry = "INSERT INTO
            productos_{$categoria} (cod_producto)
            VALUES ({$ultimoID})";

            return ($this->conexion->query($qry));

        } catch (Exception $e) {
            echo $e->getMessage();
        }
        
    }
    


    // UPDATEs

    public function ModificarProducto ($pData) {
        
        $qry = "UPDATE
        productos
        SET
        nombre='{$pData['nombre']}',
        marca='{$pData['marca']}',
        modelo='{$pData['modelo']}',
        precio={$pData['precio']},
        stock={$pData['stock']},
        cod_subcategoria = 
            (SELECT
            s.id FROM
            categorias_sub s
            WHERE s.subcategoria = '{$pData['subcategoria']}'
            AND s.cod_categoria = {$pData['cod_categoria']})
        WHERE id={$pData['prodID']}";

        $this->conexion->query($qry);

        $adicionales = $this->CargarModeloAdicionales($pData['categoria']);

        $guardar = false;
        $nroColumna = 0;

        $pDataComoArray = array();
        foreach ($pData as $key=>$unidad) {
            if (!$guardar) {
                if ($key == "FINBASE") {
                    $guardar = true;
                }
            } else {
                array_push($pDataComoArray, $unidad);
            }
        }        

        $esPrimero = true;
        $construirQry = "UPDATE productos_{$pData['categoria']} SET ";
        foreach ($adicionales as $datoAdicional) {
            if (!$esPrimero) {
                $construirQry .= ',';
            }
            $construirQry .= " {$datoAdicional['columna']} = '{$pDataComoArray[$nroColumna]}'";
            $nroColumna++;
            $esPrimero = false;
        }
        $construirQry .= " WHERE cod_producto = {$pData['prodID']}";

        $this->conexion->query($construirQry);

        return true;
    }

    public function PromocionarProducto ($prodID, $estadoPromocion) {
        $qry = "UPDATE
        productos p
        SET
        esPromocion = {$estadoPromocion}
        WHERE p.id = {$prodID}";

        return ($this->conexion->query($qry));
    }

    public function HabilitarProducto ($prodID, $estadoHabilitado) {
        $qry = "UPDATE
        productos p
        SET
        esHabilitado = {$estadoHabilitado}
        WHERE p.id = {$prodID}";

        return ($this->conexion->query($qry));
    }

    public function ModificarUsuario ($userID, $nombre, $apellido, $email, $nivel) {
        $qry = "UPDATE
        usuarios u
        SET
        nombre = '{$nombre}',
        apellido = '{$apellido}',
        email = '{$email}',
        nivel = {$nivel}
        WHERE u.id = {$userID}";

        return ($this->conexion->query($qry));
    }
    public function ModificarUsuarioPerfil ($nombre, $apellido, $email, $uid) {
        

        $qry = "UPDATE
        usuarios u
        SET
        nombre = '{$nombre}',
        apellido = '{$apellido}',
        email = '{$email}'
        WHERE u.id = {$uid} ";

        return ($this->conexion->query($qry));
    }

    public function ModificarUsuarioPw ($userID, $pwd) {
        $qry = "UPDATE
        usuarios u
        SET
        passwd = '{$pwd}'
        WHERE u.id = {$userID}";

        return ($this->conexion->query($qry));
    }

    public function HabilitarUsuario ($userID, $metodo) {
        
        $seteo = $metodo == "alta" ? 'NULL' : "'".date('Y-m-d')."'";
        
        $qry = "UPDATE
        usuarios u
        SET
        f_baja = $seteo
        WHERE u.id = {$userID}";

        return ($this->conexion->query($qry));
    }

    public function ActualizarEnsambladoADespacho ($pedidoID) {
        $id= $this->conexion->real_escape_string($pedidoID);

        $qry = "UPDATE
        pedidos
        SET
        cod_estado = 1
        WHERE id = {$id}";

        return ($this->conexion->query($qry));
    }

    public function ActualizarFechaDespacho ($pedidoID) {
        $id= $this->conexion->real_escape_string($pedidoID);
        
        $fechaDespacho = date('Y-m-d H:i:s');
        $qry = "UPDATE
        pedidos
        SET
        fechaDespacho = '{$fechaDespacho}',
        cod_estado = 3
        WHERE id = {$id}";

        return ($this->conexion->query($qry));
    }

    // DELETEs

    
    public function BorrarCarro(){
        session_start();  
        $qry="DELETE FROM 
        usuarios_carrito WHERE cod_usuario = {$_SESSION['userID']}";
        $this->conexion->query($qry);
        }

    // SMARTs

    public function AgregarAlCarrito ($prodID) {
        session_start();
        $prodID = $this->conexion->real_escape_string($prodID);

        if ($this->ChequearSiExisteEnCarrito($prodID) != 0) {
            $qry = "UPDATE
            usuarios_carrito
            SET
            cantidad = (cantidad+1)
            WHERE
            cod_producto = {$prodID} AND cod_usuario = {$_SESSION['userID']}";
        } else {
            $qry = "INSERT INTO
            usuarios_carrito (cod_usuario, cod_producto, cantidad)
            VALUES
            ({$_SESSION['userID']},{$prodID},1)";
        }

        return ($this->conexion->query($qry));
    }

    public function QuitarDelCarrito($prodID){
        
        session_start();
        $prodID = $this->conexion->real_escape_string($prodID);

        if ($this->ChequearSiExisteEnCarrito($prodID) > 1) {
            $qry = "UPDATE
            usuarios_carrito
            SET
            cantidad = (cantidad-1)
            WHERE
            cod_producto = {$prodID} AND cod_usuario = {$_SESSION['userID']}";
        } else {
            $qry = "DELETE FROM
            usuarios_carrito
            WHERE
            cod_producto = {$prodID} AND cod_usuario = {$_SESSION['userID']}";
        }

        return ($this->conexion->query($qry));
    }
}