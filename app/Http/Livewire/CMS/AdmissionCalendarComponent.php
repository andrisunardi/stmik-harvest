<?php

namespace App\Http\Livewire\CMS;

use App\Models\Admin;
use App\Models\AdmissionCalendar;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Livewire\WithPagination;

class AdmissionCalendarComponent extends Component
{
    use WithPagination;

    public $menu_name = 'Admission Calendar';

    public $menu_icon = 'bi bi-calendar';

    public $menu_slug = 'admission-calendar';

    public $menu_table = 'admission_calendar';

    public $menu_type = 'index';

    public $page = 1;

    public $per_page = 10;

    public $order_by = 'id';

    public $sort_by = 'desc';

    public $start_created_at;

    public $end_created_at;

    public $start_updated_at;

    public $end_updated_at;

    public $start_deleted_at;

    public $end_deleted_at;

    public $created_by = '';

    public $updated_by = '';

    public $deleted_by = '';

    public $active = '';

    public $row;

    public $checkbox_all;

    public $checkbox_id;

    public $admission_calendar;

    public $name;

    public $name_id;

    public $description;

    public $description_id;

    public $date;

    public $queryString = [
        'menu_type' => ['except' => 'index'],
        'page' => ['except' => 1],
        'per_page' => ['except' => 10],
        'order_by' => ['except' => 'id'],
        'sort_by' => ['except' => 'desc'],
        'created_by' => ['except' => ''],
        'updated_by' => ['except' => ''],
        'deleted_by' => ['except' => ''],
        'start_created_at' => ['except' => ''],
        'end_created_at' => ['except' => ''],
        'start_updated_at' => ['except' => ''],
        'end_updated_at' => ['except' => ''],
        'start_deleted_at' => ['except' => ''],
        'end_deleted_at' => ['except' => ''],
        'active' => ['except' => ''],
        'row' => ['except' => ''],

        'name' => ['except' => ''],
        'name_id' => ['except' => ''],
        'date' => ['except' => ''],
    ];

    public function resetFilter()
    {
        $this->page = 1;
        $this->per_page = 10;
        $this->order_by = 'id';
        $this->sort_by = 'desc';

        $this->reset([
            'created_by',
            'updated_by',
            'start_created_at',
            'end_created_at',
            'start_updated_at',
            'end_updated_at',
            'start_deleted_at',
            'end_deleted_at',
            'active',
            'row',
        ]);

        $this->reset([
            'admission_calendar',
            'name',
            'name_id',
            'description',
            'description_id',
            'date',
        ]);
    }

    public function resetForm()
    {
        if ($this->admission_calendar) {
            $this->active = $this->admission_calendar->active;
            $this->name = $this->admission_calendar->name;
            $this->name_id = $this->admission_calendar->name_id;
            $this->description = $this->admission_calendar->description;
            $this->description_id = $this->admission_calendar->description_id;
            $this->date = $this->admission_calendar->date;
        }
    }

    public function refresh()
    {
        $this->resetErrorBag();
    }

    public function updating()
    {
        $this->resetPage();
    }

    public function mount()
    {
        if (
            $this->menu_type != 'index' &&
            $this->menu_type != 'add' &&
            $this->menu_type != 'clone' &&
            $this->menu_type != 'edit' &&
            $this->menu_type != 'view' &&
            $this->menu_type != 'trash'
        ) {
            Session::flash('danger', trans('index.Menu Type').' '.trans('message.not found or has been deleted'));

            return redirect()->route("{$this->sub_domain}.{$this->menu_slug}.index");
        }

        if ($this->menu_type == 'add') {
            $this->active = true;
            $this->date = now()->format('Y-m-d');
        }

        if ($this->row && ($this->menu_type != 'index' || $this->menu_type != 'trash')) {
            if ($this->menu_type == 'view') {
                $this->admission_calendar = AdmissionCalendar::withTrashed()->find($this->row);
            } else {
                $this->admission_calendar = AdmissionCalendar::find($this->row);
            }

            if (! $this->admission_calendar) {
                Session::flash('danger', trans("page.{$this->menu_name}").' '.trans('message.not found or has been deleted'));

                return redirect()->route("{$this->sub_domain}.{$this->menu_slug}.index");
            }

            if ($this->menu_type != 'view') {
                $this->resetForm();
            }
        }
    }

    public function index()
    {
        $this->resetFilter();
        $this->resetErrorBag();

        $this->menu_type = 'index';
    }

    public function form($menu_type, $id)
    {
        $this->resetFilter();
        $this->resetErrorBag();

        $this->active = true;
        $this->date = now()->format('Y-m-d');

        if ($menu_type != 'add' && $id) {
            $this->admission_calendar = AdmissionCalendar::find($id);

            if (! $this->admission_calendar) {
                return Session::flash('danger', trans("page.{$this->menu_name}").' '.trans('message.not found or has been deleted'));
            }

            $this->resetForm();
        }

        $this->menu_type = $menu_type;
        $this->row = $id;
    }

    public function view($id)
    {
        $this->resetFilter();
        $this->resetErrorBag();

        $this->menu_type = 'view';
        $this->row = $id;

        $this->admission_calendar = AdmissionCalendar::withTrashed()->find($id);

        if (! $this->admission_calendar) {
            return Session::flash('danger', trans("page.{$this->menu_name}").' '.trans('message.not found or has been deleted'));
        }
    }

    public function trash()
    {
        $this->resetFilter();
        $this->resetErrorBag();

        $this->menu_type = 'trash';
    }

    protected function rules()
    {
        $id = $this->menu_type == 'edit' ? $this->admission_calendar->id : null;

        return [
            'active' => 'required',
            'name' => "required|max:100|unique:{$this->menu_table},name,{$id}",
            'name_id' => "required|max:100|unique:{$this->menu_table},name_id,{$id}",
            'description' => 'nullable|max:65535',
            'description_id' => 'nullable|max:65535',
            'date' => 'nullable|max:10|max:10|date_format:Y-m-d',
        ];
    }

    public function submit()
    {
        $this->validate();

        if ($this->menu_type == 'add' || $this->menu_type == 'clone') {
            $this->admission_calendar = new AdmissionCalendar();
            if (env('APP_ENV') != 'testing') {
                DB::statement(DB::raw("ALTER TABLE {$this->menu_table} AUTO_INCREMENT = 1"));
            }
        }

        $this->admission_calendar->active = $this->active;

        $this->admission_calendar->name = $this->name;
        $this->admission_calendar->name_id = $this->name_id;
        $this->admission_calendar->description = Str::of(htmlspecialchars($this->description))->swap(['&lt;' => '<', '&gt;' => '>']);
        $this->admission_calendar->description_id = Str::of(htmlspecialchars($this->description_id))->swap(['&lt;' => '<', '&gt;' => '>']);
        $this->admission_calendar->date = $this->date;
        $this->admission_calendar->save();

        $this->menu_type_message = $this->menu_type == 'add' || $this->menu_type == 'edit' ? $this->menu_type.'ed' : $this->menu_type.'d';
        Session::flash('success', trans("page.{$this->menu_name}").' '.trans("message.has been {$this->menu_type_message} successfully"));

        $this->resetFilter();
        $this->resetErrorBag();

        $this->menu_type = 'index';
    }

    public function active($id)
    {
        $this->admission_calendar = AdmissionCalendar::find($id);

        if (! $this->admission_calendar) {
            return Session::flash('danger', trans("page.{$this->menu_name}").' '.trans('message.not found or has been deleted'));
        }

        $this->admission_calendar->active = true;
        $this->admission_calendar->save();
        $this->admission_calendar->refresh();

        return Session::flash('success', trans("page.{$this->menu_name}").' '.trans('message.has been set active successfully'));
    }

    public function nonActive($id)
    {
        $this->admission_calendar = AdmissionCalendar::find($id);

        if (! $this->admission_calendar) {
            return Session::flash('danger', trans("page.{$this->menu_name}").' '.trans('message.not found or has been deleted'));
        }

        $this->admission_calendar->active = false;
        $this->admission_calendar->save();
        $this->admission_calendar->refresh();

        return Session::flash('success', trans("page.{$this->menu_name}").' '.trans('message.has been set non active successfully'));
    }

    public function delete($id)
    {
        $this->admission_calendar = AdmissionCalendar::find($id);

        if (! $this->admission_calendar) {
            return Session::flash('danger', trans("page.{$this->menu_name}").' '.trans('message.not found or has been deleted'));
        }

        $this->admission_calendar->delete();
        $this->admission_calendar->refresh();

        return Session::flash('success', trans("page.{$this->menu_name}").' '.trans('message.has been deleted successfully'));
    }

    public function restore($id)
    {
        $this->admission_calendar = AdmissionCalendar::onlyTrashed()->find($id);

        if (! $this->admission_calendar) {
            return Session::flash('danger', trans("page.{$this->menu_name}").' '.trans('message.not found or has been deleted'));
        }

        $this->admission_calendar->restore();
        $this->admission_calendar->refresh();

        return Session::flash('success', trans("page.{$this->menu_name}").' '.trans('message.has been deleted successfully'));
    }

    public function deletePermanent($id)
    {
        $this->admission_calendar = AdmissionCalendar::onlyTrashed()->find($id);

        if (! $this->admission_calendar) {
            return Session::flash('danger', trans("page.{$this->menu_name}").' '.trans('message.not found or has been deleted'));
        }

        $this->admission_calendar->forceDelete();
        $this->admission_calendar->refresh();

        if ($this->menu_type == 'view') {
            $this->resetFilter();
            $this->resetErrorBag();

            $this->menu_type = 'index';
        }

        return Session::flash('success', trans("page.{$this->menu_name}").' '.trans('message.has been deleted permanent successfully'));
    }

    public function restoreAll()
    {
        AdmissionCalendar::onlyTrashed()->restore();

        return Session::flash('success', trans("page.{$this->menu_name}").' '.trans('message.has been restored successfully'));
    }

    public function deletePermanentAll()
    {
        AdmissionCalendar::onlyTrashed()->forceDelete();

        return Session::flash('success', trans('message.All')." {$this->menu_name} ".trans('message.at Trash has been Deleted Permanent Successfully'));
    }

    public function getDataCreatedBy()
    {
        $created_by = AdmissionCalendar::groupBy('created_by')->active()->pluck('created_by');

        return Admin::whereIn('id', $created_by)->active()->orderBy('name')->get();
    }

    public function getDataUpdatedBy()
    {
        $updated_by = AdmissionCalendar::groupBy('updated_by')->active()->pluck('updated_by');

        return Admin::whereIn('id', $updated_by)->active()->orderBy('name')->get();
    }

    public function getDataDeletedBy()
    {
        $deleted_by = AdmissionCalendar::groupBy('deleted_by')->active()->pluck('deleted_by');

        return Admin::whereIn('id', $deleted_by)->active()->orderBy('name')->get();
    }

    public function getDataAdmissionCalendar()
    {
        if ($this->menu_type == 'index' || $this->menu_type == 'trash') {
            $data_admission_calendar = AdmissionCalendar::query()
                ->when($this->created_by, function ($query) {
                    $query->where('created_by', $this->created_by);
                })
                ->when($this->updated_by, function ($query) {
                    $query->where('updated_by', $this->updated_by);
                })
                ->when($this->deleted_by, function ($query) {
                    $query->where('deleted_by', $this->deleted_by);
                })
                ->when($this->start_created_at, function ($query) {
                    $query->whereDate('created_at', '>=', $this->start_created_at);
                })
                ->when($this->end_created_at, function ($query) {
                    $query->whereDate('created_at', '<=', $this->end_created_at);
                })
                ->when($this->start_updated_at, function ($query) {
                    $query->whereDate('updated_at', '>=', $this->start_updated_at);
                })
                ->when($this->end_updated_at, function ($query) {
                    $query->whereDate('updated_at', '<=', $this->end_updated_at);
                })
                ->when($this->start_deleted_at, function ($query) {
                    $query->whereDate('deleted_at', '>=', $this->start_deleted_at);
                })
                ->when($this->end_deleted_at, function ($query) {
                    $query->whereDate('deleted_at', '<=', $this->end_deleted_at);
                })
                ->when($this->active, function ($query) {
                    $query->where('active', $this->active);
                })

                ->when($this->name, function ($query) {
                    $query->where('name', 'LIKE', "%{$this->name}%");
                })
                ->when($this->name_id, function ($query) {
                    $query->where('name_id', 'LIKE', "%{$this->name_id}%");
                })
                ->when($this->description, function ($query) {
                    $query->where('description', 'LIKE', "%{$this->description}%");
                })
                ->when($this->description_id, function ($query) {
                    $query->where('description_id', 'LIKE', "%{$this->description_id}%");
                })
                ->when($this->date, function ($query) {
                    $query->where('date', $this->date);
                });

            if ($this->created_by || $this->created_by == '0') {
                $data_admission_calendar->where('created_by', $this->created_by);
            }
            if ($this->updated_by || $this->updated_by == '0') {
                $data_admission_calendar->where('updated_by', $this->updated_by);
            }
            if ($this->deleted_by || $this->deleted_by == '0') {
                $data_admission_calendar->where('deleted_by', $this->deleted_by);
            }
            if ($this->active || $this->active == '0') {
                $data_admission_calendar->where('active', $this->active);
            }

            if ($this->order_by == 'created_by') {
                $data_admission_calendar->join('admin', 'admin.id', "{$this->menu_table}.created_by")
                        ->select("{$this->menu_table}.*", 'admin.name as admin_name')
                        ->orderByRaw("admin_name {$this->sort_by}");
            } elseif ($this->order_by == 'updated_by') {
                $data_admission_calendar->join('admin', 'admin.id', "{$this->menu_table}.updated_by")
                        ->select("{$this->menu_table}.*", 'admin.name as admin_name')
                        ->orderByRaw("admin_name {$this->sort_by}");
            } elseif ($this->order_by == 'deleted_by') {
                $data_admission_calendar->join('admin', 'admin.id', "{$this->menu_table}.deleted_by")
                        ->select("{$this->menu_table}.*", 'admin.name as admin_name')
                        ->orderByRaw("admin_name {$this->sort_by}");
            } else {
                $data_admission_calendar->orderBy($this->order_by ?? 'id', $this->sort_by ?? 'desc');
            }

            if ($this->menu_type == 'trash') {
                $data_admission_calendar->onlyTrashed();
            }

            return $data_admission_calendar->paginate($this->per_page ?? 10);
        }
    }

    public function render()
    {
        return view("{$this->sub_domain}.livewire.{$this->menu_slug}.index", [
            'data_created_by' => $this->getDataCreatedBy(),
            'data_updated_by' => $this->getDataUpdatedBy(),
            'data_deleted_by' => $this->getDataDeletedBy(),
            'data_admission_calendar' => $this->getDataAdmissionCalendar(),
        ])->extends("{$this->sub_domain}.layouts.app")->section('content');
    }
}
