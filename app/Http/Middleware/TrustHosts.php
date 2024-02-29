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
            $this->allSubdomainsOfApplicationUrl(),
            'i.saludtarapaca.gob.cl',
            'i.saludtarapaca.org',
            'ionline-s26t746c6q-uc.a.run.app'
        ];
    }
}
