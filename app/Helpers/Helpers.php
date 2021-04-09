<?php

/* Set active route */
function active($route_name) { 
    echo request()->routeIs($route_name) ? 'active' : '';
}

function money($value) {
    echo number_format($value,0,'','.');
}

