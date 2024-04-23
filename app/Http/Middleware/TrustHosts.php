<?php

namespace App\Http\Middleware;

use Illuminate\Http\Middleware\TrustHosts as Middleware;

class TrustHosts extends Middleware
{
    /**
     * Get the host patterns that should be trusted.
     *
     * @return array
     */
    public function hosts()
    {
        return [
            /**
             * If this is enables in Kernel.php, You need to add your own domains to the list
             */
            // 'i.saludtarapaca.gob.cl',
            // 'i.saludiquique.gob.cl',
            // 'i.saludtarapaca.org',
            // 'ionline-s26t746c6q-uc.a.run.app',
            $this->allSubdomainsOfApplicationUrl(),
        ];
    }
}
