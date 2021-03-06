<?php

namespace App\Http\Livewire\CMS;

use App\Models\Admin;
use App\Models\Testimony;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class TestimonyComponent extends Component
{
    use WithPagination, WithFileUploads;

    public $menu_name = 'Testimony';

    public $menu_icon = 'bi bi-chat-text';

    public $menu_slug = 'testimony';

    public $menu_table = 'testimony';

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

    public $testimony;

    public $name;

    public $description;

    public $graduate;

    public $image;

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
        'graduate' => ['except' => ''],
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
            'testimony',
            'name',
            'description',
            'graduate',
            'image',
        ]);
    }

    public function resetForm()
    {
        if ($this->testimony) {
            $this->active = $this->testimony->active;
            $this->name = $this->testimony->name;
            $this->description = $this->testimony->description;
            $this->graduate = $this->testimony->graduate;
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

    public function updated($propertyName)
    {
        if ($this->menu_type != 'index' && $this->menu_type != 'trash') {
            $this->validateOnly($propertyName);
        }
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
        }

        if ($this->row && ($this->menu_type != 'index' || $this->menu_type != 'trash')) {
            if ($this->menu_type == 'view') {
                $this->testimony = Testimony::withTrashed()->find($this->row);
            } else {
                $this->testimony = Testimony::find($this->row);
            }

            if (! $this->testimony) {
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

        if ($menu_type != 'add' && $id) {
            $this->testimony = Testimony::find($id);

            if (! $this->testimony) {
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

        $this->testimony = Testimony::withTrashed()->find($id);

        if (! $this->testimony) {
            return Session::flash('danger', trans("page.{$this->menu_name}").' '.trans('message.not found or has been deleted'));
        }
    }

    public function trash()
    {
        $this->resetFilter();
        $this->resetErrorBag();

        $this->menu_type = 'trash';
    }

    public function rules()
    {
        $id = $this->menu_type == 'edit' ? $this->testimony->id : null;

        return [
            'active' => 'required',
            'name' => "required|max:100|unique:{$this->menu_table},name,{$id}",
            'description' => 'nullable|max:65535',
            'graduate' => 'nullable|max:65535',
            'image' => 'nullable|image|max:102400|mimes:jpg,jpeg,png,gif,webp',
        ];
    }

    public function submit()
    {
        $this->validate();

        if ($this->menu_type == 'add' || $this->menu_type == 'clone') {
            if ($this->menu_type == 'clone') {
                $image = $this->testimony->image;
            }
            $this->testimony = new Testimony();
            if (env('APP_ENV') != 'testing') {
                DB::statement(DB::raw("ALTER TABLE {$this->menu_table} AUTO_INCREMENT = 1"));
            }
        }

        $this->testimony->active = $this->active;

        $this->testimony->name = $this->name;
        $this->testimony->description = Str::of(htmlspecialchars($this->description))->swap(['&lt;' => '<', '&gt;' => '>']);
        $this->testimony->graduate = $this->graduate;

        if ($this->image) {
            if ($this->menu_type == 'edit') {
                $this->testimony->deleteImage();
            }

            $this->testimony->image = date('YmdHis').".{$this->image->getClientOriginalExtension()}";
            $this->image->storePubliclyAs($this->menu_slug, $this->testimony->image, 'images');
        } else {
            if ($this->menu_type == 'clone') {
                if ($image && File::exists(public_path("images/{$this->menu_slug}/{$image}"))) {
                    $this->testimony->image = date('YmdHis').'.'.explode('.', $image)[1];
                    File::copy(public_path("images/{$this->menu_slug}/{$image}"), public_path("images/{$this->menu_slug}/{$this->testimony->image}"));
                }
            }
        }

        $this->testimony->save();

        $this->menu_type_message = $this->menu_type == 'add' || $this->menu_type == 'edit' ? $this->menu_type.'ed' : $this->menu_type.'d';
        Session::flash('success', trans("page.{$this->menu_name}").' '.trans("message.has been {$this->menu_type_message} successfully"));

        $this->resetFilter();
        $this->resetErrorBag();

        $this->menu_type = 'index';
    }

    public function active($id)
    {
        $this->testimony = Testimony::find($id);

        if (! $this->testimony) {
            return Session::flash('danger', trans("page.{$this->menu_name}").' '.trans('message.not found or has been deleted'));
        }

        $this->testimony->active = true;
        $this->testimony->save();
        $this->testimony->refresh();

        return Session::flash('success', trans("page.{$this->menu_name}").' '.trans('message.has been set active successfully'));
    }

    public function nonActive($id)
    {
        $this->testimony = Testimony::find($id);

        if (! $this->testimony) {
            return Session::flash('danger', trans("page.{$this->menu_name}").' '.trans('message.not found or has been deleted'));
        }

        $this->testimony->active = false;
        $this->testimony->save();
        $this->testimony->refresh();

        return Session::flash('success', trans("page.{$this->menu_name}").' '.trans('message.has been set non active successfully'));
    }

    public function delete($id)
    {
        $this->testimony = Testimony::find($id);

        if (! $this->testimony) {
            return Session::flash('danger', trans("page.{$this->menu_name}").' '.trans('message.not found or has been deleted'));
        }

        $this->testimony->delete();
        $this->testimony->refresh();

        return Session::flash('success', trans("page.{$this->menu_name}").' '.trans('message.has been deleted successfully'));
    }

    public function restore($id)
    {
        $this->testimony = Testimony::onlyTrashed()->find($id);

        if (! $this->testimony) {
            return Session::flash('danger', trans("page.{$this->menu_name}").' '.trans('message.not found or has been deleted'));
        }

        $this->testimony->restore();
        $this->testimony->refresh();

        return Session::flash('success', trans("page.{$this->menu_name}").' '.trans('message.has been deleted successfully'));
    }

    public function deletePermanent($id)
    {
        $this->testimony = Testimony::onlyTrashed()->find($id);

        if (! $this->testimony) {
            return Session::flash('danger', trans("page.{$this->menu_name}").' '.trans('message.not found or has been deleted'));
        }

        $this->testimony->deleteImage();
        $this->testimony->forceDelete();
        $this->testimony->refresh();

        if ($this->menu_type == 'view') {
            $this->resetFilter();
            $this->resetErrorBag();

            $this->menu_type = 'index';
        }

        return Session::flash('success', trans("page.{$this->menu_name}").' '.trans('message.has been deleted permanent successfully'));
    }

    public function restoreAll()
    {
        Testimony::onlyTrashed()->restore();

        return Session::flash('success', trans("page.{$this->menu_name}").' '.trans('message.has been restored successfully'));
    }

    public function deletePermanentAll()
    {
        $data_testimony = Testimony::onlyTrashed()->get();

        foreach ($data_testimony as $testimony) {
            $testimony->deleteImage();
            $testimony->forceDelete();
        }

        return Session::flash('success', trans('message.All')." {$this->menu_name} ".trans('message.at Trash has been Deleted Permanent Successfully'));
    }

    public function getDataCreatedBy()
    {
        $created_by = Testimony::groupBy('created_by')->active()->pluck('created_by');

        return Admin::whereIn('id', $created_by)->active()->orderBy('name')->get();
    }

    public function getDataUpdatedBy()
    {
        $updated_by = Testimony::groupBy('updated_by')->active()->pluck('updated_by');

        return Admin::whereIn('id', $updated_by)->active()->orderBy('name')->get();
    }

    public function getDataDeletedBy()
    {
        $deleted_by = Testimony::groupBy('deleted_by')->active()->pluck('deleted_by');

        return Admin::whereIn('id', $deleted_by)->active()->orderBy('name')->get();
    }

    public function getDataStudyProgram()
    {
        return StudyProgram::active()->orderBy('name')->get();
    }

    public function getDataTestimony()
    {
        if ($this->menu_type == 'index' || $this->menu_type == 'trash') {
            $data_testimony = Testimony::query()
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
                ->when($this->description, function ($query) {
                    $query->where('description', 'LIKE', "%{$this->description}%");
                })
                ->when($this->graduate, function ($query) {
                    $query->where('graduate', 'LIKE', "%{$this->graduate}%");
                });

            if ($this->created_by || $this->created_by == '0') {
                $data_testimony->where('created_by', $this->created_by);
            }
            if ($this->updated_by || $this->updated_by == '0') {
                $data_testimony->where('updated_by', $this->updated_by);
            }
            if ($this->deleted_by || $this->deleted_by == '0') {
                $data_testimony->where('deleted_by', $this->deleted_by);
            }
            if ($this->active || $this->active == '0') {
                $data_testimony->where('active', $this->active);
            }

            if ($this->order_by == 'created_by') {
                $data_testimony->join('admin', 'admin.id', "{$this->menu_table}.created_by")
                        ->select("{$this->menu_table}.*", 'admin.name as admin_name')
                        ->orderByRaw("admin_name {$this->sort_by}");
            } elseif ($this->order_by == 'updated_by') {
                $data_testimony->join('admin', 'admin.id', "{$this->menu_table}.updated_by")
                        ->select("{$this->menu_table}.*", 'admin.name as admin_name')
                        ->orderByRaw("admin_name {$this->sort_by}");
            } elseif ($this->order_by == 'deleted_by') {
                $data_testimony->join('admin', 'admin.id', "{$this->menu_table}.deleted_by")
                        ->select("{$this->menu_table}.*", 'admin.name as admin_name')
                        ->orderByRaw("admin_name {$this->sort_by}");
            } else {
                $data_testimony->orderBy($this->order_by ?? 'id', $this->sort_by ?? 'desc');
            }

            if ($this->menu_type == 'trash') {
                $data_testimony->onlyTrashed();
            }

            return $data_testimony->paginate($this->per_page ?? 10);
        }
    }

    public function render()
    {
        return view("{$this->sub_domain}.livewire.{$this->menu_slug}.index", [
            'data_created_by' => $this->getDataCreatedBy(),
            'data_updated_by' => $this->getDataUpdatedBy(),
            'data_deleted_by' => $this->getDataDeletedBy(),
            'data_testimony' => $this->getDataTestimony(),
        ])->extends("{$this->sub_domain}.layouts.app")->section('content');
    }
}
