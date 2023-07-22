<?php
// validaciones.php

function integridad($data)
{
    $props = array(
        "name",
        "reference",
        "price",
        "weight",
        "category",
        "stock",
        "date"
    );

    foreach ($props as $key) {
        if (isset($data[$key])) {
            continue;
        } else {
            return ["La propiedad {$key} no está presente en el JSON.", true];
            break;
        }
    }
    return ["El JSON es válido", false];
}

function integridadSold($data)
{
    $props = array(
        "idproduct",
        "quantity"
    );

    foreach ($props as $key) {
        if (isset($data[$key])) {
            continue;
        } else {
            return ["La propiedad {$key} no está presente en el JSON.", true];
            break;
        }
    }
    return ["El JSON es válido", false];
}
