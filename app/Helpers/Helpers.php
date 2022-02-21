<?php

/* Set active route */
function active($route_name) { 
    echo request()->routeIs($route_name) ? 'active' : '';
}

function money($value) {
    echo number_format($value,0,'','.');
}

function trashed($user) {
    if($user->trashed())
        echo '<i class="fas fa-user-slash" title="Usuario eliminado"></i>';
}