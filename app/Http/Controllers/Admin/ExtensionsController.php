<?php

namespace Pterodactyl\Http\Controllers\Admin;

use Illuminate\View\View;
use Illuminate\View\Factory as ViewFactory;
use Pterodactyl\Http\Controllers\Controller;
use Pterodactyl\Services\Helpers\SoftwareVersionService;
use Pterodactyl\BlueprintFramework\Services\VariableService\BlueprintVariableService;
use Pterodactyl\BlueprintFramework\Services\PlaceholderService\BlueprintPlaceholderService;

class ExtensionsController extends Controller
{
    /**
     * ExtensionsController constructor.
     */
    public function __construct(
        private SoftwareVersionService $version,
        private ViewFactory $view,
        private BlueprintVariableService $bp,
        private BlueprintPlaceholderService $placeholder)
    {
    }

    /**
     * Return the admin index view.
     */
    public function index(): View
    {
        // Onboarding check.
        if(shell_exec("cd ".escapeshellarg($this->placeholder->folder()).";cat .blueprint/data/internal/db/onboarding") == "*blueprint*") {
            $onboarding = true;
        } else {
            $onboarding = false;
        }
        return $this->view->make('admin.extensions', [
            'version' => $this->version,
            'bp' => $this->bp,
            'root' => "/admin/extensions",

            'onboarding' => $onboarding
        ]);
    }
}
