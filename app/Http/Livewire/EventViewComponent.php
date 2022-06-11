<?php

namespace App\Http\Livewire;

use App\Http\Livewire\Component;
use App\Models\Banner;
use App\Models\Event;
use App\Models\EventCategory;
use Illuminate\Support\Facades\Session;

class EventViewComponent extends Component
{
    public $menu_name = "Event";
    public $menu_icon = "fas fa-calendar";
    public $menu_slug = "event";
    public $menu_table = "event";

    public $event;
    public $name;
    public $email;
    public $phone;
    public $title;
    public $message;

    public function mount($event_slug)
    {
        $this->banner = Banner::find(15);

        $this->event = Event::where("slug", $event_slug)->onlyActive()->first();

        if (!$this->event) {
            Session::flash("danger", trans("page.{$this->menu_name}") . " " . trans("message.not found or has been deleted"));

            return redirect()->route("{$this->menu_slug}.index");
        }

        $this->data_other_event = Event::where("id", "!=", $this->event->id)
            ->onlyActive()
            ->inRandomOrder()
            ->limit("3")
            ->get();

        $this->data_event_category = EventCategory::onlyActive()->orderByDesc("id")->get();

        $this->data_recent_event = Event::onlyActive()->orderByDesc("id")->limit(3)->get();

        $this->data_popular_tags = Event::onlyActive()->orderByDesc("id")->first();
    }

    public function render()
    {
        $this->event->refresh();

        return view("livewire.{$this->menu_slug}.view")->extends("layouts.app", ["banner" => $this->banner])->section("content");
    }
}
