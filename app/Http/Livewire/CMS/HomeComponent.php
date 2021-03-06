<?php

namespace App\Http\Livewire\CMS;

use App\Models\Menu;
use Livewire\WithPagination;

class HomeComponent extends Component
{
    use WithPagination;

    public $menu_name = 'Home';

    public $menu_icon = 'bi bi-house-door';

    public $menu_slug = 'home';

    public $menu_table = 'home';

    public function render()
    {
        $this->data_menu = Menu::active()->orderBy('sort')->get();

        return view("{$this->sub_domain}.livewire.{$this->menu_slug}.index")
            ->extends("{$this->sub_domain}.layouts.app")->section('content');
    }
}
