<?php

namespace App\Console\Commands;
use App\Models\Requirements\Requirement;
use Illuminate\Console\Command;

/**
 * Busca requerimientos que hayan sido enviados a algún authority de tipo manager, y estos requerimientos se marcan con
 * true en el campo to_authority.
 */
class RequirementsSentToAuthorities extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'requirements:mark-to-authorities {--year=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check for requirements sent to authorities';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle(): int
    {
        $requirements = Requirement::whereYear('created_at', $this->option('year'))->get();
        $affectedRequirementsCount = 0;
        $affectedEventsCount = 0;

        foreach ($requirements as $requirement) {
            $isRequirementSentToAuthority = false;
            foreach ($requirement->events as $event) {
                if ($event->isSentToAuthority()) {
                    $event->update(['to_authority' => true]);
                    $isRequirementSentToAuthority = true;
                }else{
                    $event->update(['to_authority' => false]);
                }
                $affectedEventsCount++;
            }
            $requirement->update(['to_authority' => $isRequirementSentToAuthority]);
            $affectedRequirementsCount++;
        }

        echo $affectedRequirementsCount . ' requerimientos modificados.' . PHP_EOL;
        echo $affectedEventsCount . ' eventos modificados.' . PHP_EOL;

        return 0;
    }
}
