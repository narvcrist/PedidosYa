<?php
session_start();
    include "../conexion.php";
?>
<!DOCTYPE html>
<html>
<head>
    <title>Sistema de gestion de pedidos</title>
    <?php include "estructura/estructura.php"; ?>

</head>
<body>
<?php include "estructura/header.php"; ?>
    <div class="bloque">
        <div class = "subloque">
        <h2>Lista de facturas</h2>
       <!--<form action="buscarTendero.php" method="get">
            <div class="row">
                <div class="cell-md-6">
                    <input type="text" name="busqueda" id="busqueda" placeholder="N° factura" required>
                </div>
            </div>
        </form> -->
        <br>
        <a href="nuevaFactura.php"><button class="button success"><span class="mif-add">&nbsp;</span>Nueva factura</button></a>
        <br>
    <br>
        <table class="table striped table-border mt-4"
    data-role="table"
    data-show-search="false"  
    data-show-table-info="false"  
    data-rownum-title="Hola"
    data-rows-steps="5, 10, 20, 30, 50, 100"
    data-table-rows-count-title= "Número de registros">
    <thead>
    <tr>
        <th data-sortable="true" data-sort-dir="asc">N°</th>
        <th data-sortable="true">Fecha de generación</th>
        <th data-sortable="true">Tendero</th>
        <th data-sortable="true">Vendedor</th>
        <th data-sortable="true">Estado</th>
        <th data-sortable="true">Monto</th>
        <th>Acciones</th>
    </tr>
    </thead>
    <tbody>
    <?php
        $consulta_registros = mysqli_query($conection,"SELECT COUNT(*) AS registros FROM factura WHERE estado != 10");
        $resultado_registros = mysqli_fetch_array($consulta_registros);
        $registros = $resultado_registros['registros'];

        $por_pagina = 15;
        if(empty($_GET['pagina'])){
            $pagina = 1;
        }else{
            $pagina = $_GET['pagina'];
        }
        $desde = ($pagina-1) * $por_pagina;
        $total_paginas = ceil($registros / $por_pagina);

        $consulta = mysqli_query($conection,"SELECT f.fac_id, f.fac_fecha, f.fac_total, f.fac_tendero, f.estado,
                                                    u.usu_nombre as vendedor,
                                                    ten.ten_nombre as tendero
                                            FROM factura f
                                            INNER JOIN usuario u
                                            ON f.fac_usuario = u.usu_id
                                            INNER JOIN tendero ten
                                            ON f.fac_tendero = ten.ten_id
                                            WHERE f.estado !=10
                                            ORDER BY f.fac_fecha DESC LIMIT $desde, $por_pagina");
        mysqli_close($conection);
        $resultado = mysqli_num_rows($consulta);
        if($resultado > 0 ){
            while($data = mysqli_fetch_array($consulta)){
                if($data["estado"] == 1){
                    $estado = '<span class ="pagada">Generada</span>';
                }else{
                    $estado = '<span class ="anulada">Anulada</span>';
                }
    ?>
    <tr id="row<?php echo $data["fac_id"]; ?>">
        <td><?php echo $data["fac_id"] ?></td>
        <td><?php echo $data["fac_fecha"] ?></td>
        <td><?php echo $data["tendero"] ?></td>
        <td><?php echo $data["vendedor"] ?></td>
        <td class="estado"><?php echo $estado; ?></td>
        <td><span>$</span><?php echo $data["fac_total"] ?></td>
        <td>
        
        <div data-role="charms" data-position="top"><div>top</div></div>
        
            <a href="#" class="button link btn_view view_factura" cl="<?php echo $data["fac_tendero"]; ?>" f="<?php echo $data['fac_id']; ?>"><div class="mif-file-text fg-blue" data-role="hint" data-hint-text="Ver factura"></div></a>
        <?php
            if($_SESSION['rol'] == 1 || $_SESSION['rol'] == 2 ){ 
                if($data["estado"] == 1){
        ?>
            
            <a class="anular_factura" href="#" fac="<?php echo $data['fac_id']; ?>"><div class="mif-not fg-red" data-role="hint" data-hint-text="Anular factura"></div></a>
        <?php }else{ ?>
            
            <a class="button link btn_anula inactive" href="#" fac="<?php echo $data['fac_id']; ?>"><div class="mif-not fg-red" data-role="hint" data-hint-text="Anular factura"></div></a>
        
        <?php } 
        } ?>
        </td>
    </tr>
    <?php
            }
        }
    ?>
    </tbody>
    </table>
    <div class="paginador">
        <ul>
        
        </ul>
    </div>
    </div>
</div>
<?php include "estructura/modal.php"; ?>
</body>
</html>

