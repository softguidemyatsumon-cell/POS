<?php
function selectData($table, $conn, $where = '', $select = '*', $order = '')
{
    $sql = "SELECT $select FROM $table $where $order";
    return $conn->query($sql);
}
function deleteData($table, $conn, $where)
{
    $sql = "DELETE FROM $table WHERE $where";
    return $conn->query($sql);
}


