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
        <h2>Buscar tenderos</h2>
        <form action="buscarTendero.php" method="get">
            <div class="row">
                <div class="cell-md-6">
                    <input type="text" name="busqueda" id="busqueda" placeholder="Buscar tenderos" required>
                </div>
            </div>
        </form>
        <br>
        <a href="registroTenderos.php"><button class="button success"><span class="mif-add">&nbsp;</span>Nuevo tendero</button></a>
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
        <th data-sortable="true" data-sort-dir="asc">ID</th>
        <th data-sortable="true">Nombre</th>
        <th data-sortable="true">Cédula</th>
        <th data-sortable="true">Télefono</th>
        <th data-sortable="true">Dirección</th>
        <th >Acciones</th>
    </tr>
    </thead>
    <tbody>
    
    <tr>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td>
        <div data-role="charms" data-position="top"><div>top</div></div>
                 
        </td>
    </tr>
    
    </tbody>
    </table>
    <div class="paginador">
        <ul>
        
        </ul>
    </div>
    </div>
</div>
</body>
</html>

