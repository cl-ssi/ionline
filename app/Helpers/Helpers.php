<?php

/* Set active route */

function active($route)
{
    if (is_array($route)) {
        echo in_array(request()->routeIs(), $route) ? 'active' : '';
    }
    echo request()->routeIs($route) ? 'active' : '';
    //echo request()->routeIs($route_name) ? 'active' : '';
}

function money($value)
{
    echo number_format($value ?? 0, 0, '', '.');
}

function trashed($user)
{
    if ($user->trashed())
        echo '<i class="fas fa-user-slash" title="Usuario eliminado"></i>';
}

function fechasSeSolapan($inicio1, $fin1, $inicio2, $fin2)
{
    $inicio1 = $inicio1->format('Y-m-d');
    $fin1 = $fin1->format('Y-m-d');
    $inicio2 = $inicio2->format('Y-m-d');
    $fin2 = $fin2->format('Y-m-d');

    if ($inicio1 <= $fin2 && $fin1 >= $inicio2) {
        return true;
    } else {
        return false;
    }
}


function runFormat($run)
{
    $run = preg_replace('/[^0-9K]/', '', $run);
    // Separa el dígito verificador
    $id = substr($run, 0, -1);
    $dv = substr($run, -1);

    return number_format($id, 0, '', '.') . '-' . $dv;
}