<?php
function selectData($table, $conn, $where = '', $select = '*', $order = ''){
    $sql = "SELECT $select FROM $table $where $order";
    return $conn->query($sql);
}

