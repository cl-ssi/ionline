<?php

/* Set active route */

function active($route) {
    if (is_array($route)) {
        echo in_array(request()->routeIs(), $route) ? 'active' : '';
    }
    echo request()->routeIs($route) ? 'active' : '';
    //echo request()->routeIs($route_name) ? 'active' : '';
}

function money($value) {
    echo number_format($value,0,'','.');
}

function trashed($user) {
    if($user->trashed())
        echo '<i class="fas fa-user-slash" title="Usuario eliminado"></i>';
}

function fechasSeSolapan($inicio1, $fin1, $inicio2, $fin2) {
    // Convertir las fechas a objetos DateTime
    $inicio1 = new DateTime($inicio1);
    $fin1 = new DateTime($fin1);
    $inicio2 = new DateTime($inicio2);
    $fin2 = new DateTime($fin2);

    // Verificar si se solapan
    if ($inicio1 <= $fin2 && $fin1 >= $inicio2) {
        return true; // Los rangos se solapan
    } else {
        return false; // Los rangos no se solapan
    }
}

// Función para verificar las superposiciones en un array de fechas
function isOverlapping($dates, $start_date, $end_date) {
    foreach ($dates as $date) {
        $date = new DateTime($date);
        if ($date >= $start_date && $date <= $end_date) {
            return true;
        }
    }
    return false;
}