<?php
    session_start();
    include "../conexion.php";
?>
<!DOCTYPE html>
<html>
<head>
    <title>Sistema de gestion de pedidos</title>
    <?php include "estructura/estructura.php"; ?>
    <script type="text/javascript" src="js/notify.js"></script>

</head>
<body>
<?php include "estructura/header.php"; ?>
    <div class="bloque">
        <div class = "subloque">

        <?php
            $busqueda = strtolower($_REQUEST['busqueda']);
            if(empty($busqueda)){
                header('location: listaProductos.php');
                mysqli_close($conection);
            }
        ?>

        <h2>Lista de productos</h2>
        <form action="buscarProducto.php" method="get">
            <div class="row">
                <div class="cell-md-6">
                    <input type="text" name="busqueda" id="busqueda" placeholder="Buscar producto" value="<?php echo $busqueda; ?> ">
                </div>
            </div>
        </form>
        <br>
        <br>
    <table class="table">
    <thead>
    <tr>
        <th data-sortable="true" data-sort-dir="asc">ID</th>
        <th data-sortable="true">Nombre del producto</th>
        <th data-sortable="true">Precio</th>
        <th data-sortable="true">Stock</th>
        <th data-sortable="true">Proveedor</th>
        <th data-sortable="true">Imagen</th>
        <th >Acciones</th>
    </tr>
    </thead>
    <tbody>
    <?php
        
        $consulta_registros = mysqli_query($conection,"SELECT COUNT(*) AS registros FROM tendero WHERE  estado = 1");
        $resultado_registros = mysqli_fetch_array($consulta_registros);
        $registros = $resultado_registros['registros'];
        
        $por_pagina = 8;
        if(empty($_GET['pagina'])){
            $pagina = 1;
        }else{
            $pagina = $_GET['pagina'];
        }
        $desde = ($pagina-1) * $por_pagina;
        $total_paginas = ceil($registros / $por_pagina);
        


        $consulta = mysqli_query($conection,"SELECT p.pro_id, p.pro_descripcion, p.pro_precio, p.pro_stock, pr.prov_nombre, p.pro_foto
                                                FROM producto p
                                                INNER JOIN proveedor pr
                                                ON p.pro_idProveedor = pr.prov_id
                                                WHERE 
                                                ( p.pro_id LIKE '%$busqueda%'
                                                        OR p.pro_descripcion LIKE '%$busqueda%')
                                                        AND pro_estado = 1 ORDER BY prov_id ASC LIMIT $desde, $por_pagina");
        mysqli_close($conection);
        $resultado = mysqli_num_rows($consulta);
        if($resultado > 0 ){
            while($data = mysqli_fetch_array($consulta)){
                if($data['pro_foto'] != 'img_producto.png'){
                    $foto = 'img/subidas/'.$data['pro_foto'];
                }else{
                    $foto = 'img/'.$data['pro_foto'];
                }
    ?>
    <tr class="rows<?php echo $data['pro_id']; ?>">
        <td><?php echo $data['pro_id']; ?></td>
        <td><?php echo $data['pro_descripcion']; ?></td>
        <td><?php echo $data['pro_precio']; ?></td>
        <td><?php echo $data['pro_stock']; ?></td>
        <td><?php echo $data['prov_nombre']; ?></td>
        <td class="imagen"><img style="width: 70px;" src="<?php echo $foto ?>" alt="<?php echo $data['pro_descripcion'] ?>"></td>
        <td>
        <div data-role="charms" data-position="top"><div>top</div></div>
        <?php  if($_SESSION['rol'] == 1 || $_SESSION['rol'] == 2 ){ ?>
            <!--<a href="#" class="add_product" product="<?php echo $data['pro_id']; ?>"><div class="mif-add fg-blue" data-role="hint" data-hint-text="Añadir mas productos"></div></a>!-->
            
            <a href="actualizarProductos.php?id=<?php echo $data['pro_id']; ?>"><div class="mif-pencil fg-green" data-role="hint" data-hint-text="Editar producto"></div></a>
            |
            <a class="del_product" href="#" product="<?php echo $data['pro_id']; ?>"><div class="mif-bin fg-red" data-role="hint" data-hint-text="Eliminar producto"></div></a>    
            <?php } ?> 
        </td> 
    </tr>
    <?php
            }
        }else{
            echo '<script>
            $.notify("El producto que busca no existe", "warn");
      </script>';
        exit;
        }
    ?>
    </tbody>
    </table>
    </div>
</div>
<?php include "estructura/modal.php"; ?>
</body>
</html>

