<?php

include 'db.php';


// Выборка всех товаров с категорией товаров, полом, типом материала, цветом и размером
function selectAllFromProduct($table1, $table2, $table3, $table4, $table5, $table6, $limitOnPage, $offset) {
    global $pdo;
    $selectProduct = "SELECT 
    p.*,
    g.gender_name, 
    m.material_name, 
    pc.category_name, 
    c.color_name, 
    s.size_name
    FROM  $table1 AS p, $table2 AS g, $table3 AS m, $table4 AS pc, $table5 AS c, $table6 AS s
    WHERE p.id_gender = g.id_gender 
        AND p.id_category = pc.id_category 
        AND p.id_material = m.id_material 
        AND p.id_color = c.id_color 
        AND p.id_size = s.id_size 
        -- AND p.blocked = 0 
        -- AND p.store_count > 1 
    
    ORDER BY add_date
    LIMIT $limitOnPage
    OFFSET $offset;";
    
    $allProducts = $pdo->prepare($selectProduct);
    $allProducts->execute();
    return $allProducts->fetchAll(PDO::FETCH_OBJ);
}