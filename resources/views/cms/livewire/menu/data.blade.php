<div class="table-responsive">
    <table class="table table-striped table-hover table-bordered text-nowrap table-responsive align-middle">
        <thead>
            <tr class="bg-primary text-white text-center">
                <th><input class="form-check-input" type="checkbox" wire:model="checkbox_all"></th>
                <th>{{ trans("index.#") }}</th>
                <th>{{ trans("index.ID") }}</th>
                <th>{{ trans("index.Menu Category") }}</th>
                <th>{{ trans("index.Name") }}</th>
                <th>{{ trans("index.Name ID") }}</th>
                <th>{{ trans("index.Icon") }}</th>
                <th>{{ trans("index.Sort") }}</th>
                <th>{{ trans("index.Active") }}</th>
                <th>{{ trans("index.Created By") }}</th>
                <th>{{ trans("index.Updated By") }}</th>
                @if ($menu_type == "trash")
                    <th>{{ trans("index.Deleted By") }}</th>
                @endif
                <th>{{ trans("index.Created At") }}</th>
                <th>{{ trans("index.Updated At") }}</th>
                @if ($menu_type == "trash")
                    <th>{{ trans("index.Deleted At") }}</th>
                @endif
                <th>{{ trans("index.Action") }}</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($data_menu as $menu)
                <tr>
                    <td><input class="form-check-input" type="checkbox" wire:model="checkbox_id.{{ $menu->id }}"></td>
                    <td class="text-center">{{ (($data_menu->currentPage() - 1) * $data_menu->perPage()) + $loop->iteration }}</td>
                    <td>
                        <button type="button" class="btn btn-link text-decoration-none" wire:click="view({{ $menu->id }})">
                            {{ $menu->id }}
                        </button>
                    </td>
                    <td>
                        <a draggable="false" href="{{ $menu->menu_category?->id ? route("{$sub_domain}.menu-category.index") . "?menu_type=view&row={$menu->menu_category?->id}" : null }}" target="_blank">
                            {{ $menu->menu_category?->translate_name }}
                        </a>
                    </td>
                    <td>
                        <a draggable="false" href="{{ route("{$sub_domain}.{$menu_slug}.index") . "?menu_type=view&row={$menu->id}" }}">
                            {{ $menu->translate_name }}
                        </a>
                        <a draggable="false" href="{{ route("{$sub_domain}." . Str::slug($menu->name) . ".index") }}" class="btn btn-link btn-sm" target="_blank">
                            <i class="bi bi-box-arrow-up-right"></i>
                        </a>
                    </td>
                    <td>
                        <a draggable="false" href="{{ route("{$sub_domain}.{$menu_slug}.index") . "?menu_type=view&row={$menu->id}" }}">
                            {{ $menu->name_id }}
                        </a>
                        <a draggable="false" href="{{ route("{$sub_domain}." . Str::slug($menu->name) . ".index") }}" class="btn btn-link btn-sm" target="_blank">
                            <i class="bi bi-box-arrow-up-right"></i>
                        </a>
                    </td>
                    <td><i class="{{ $menu->icon }}"></i> ({{ $menu->icon }})</td>
                    <td class="text-center">{{ $menu->sort }}</td>
                    <td>
                        <span class="{{ "badge bg-" . Str::successdanger($menu->active) }}">
                            {{ trans("index." . Str::active($menu->active), '_')) }}
                        </span>
                    </td>
                    <td>
                        <a draggable="false" href="{{ $menu->created_by_admin?->id || $menu->created_by == 0 ? route("{$sub_domain}.admin.index") . "?menu_type=view&row={$menu->created_by_admin?->id}" : null }}" target="_blank">
                            {{ $menu->created_by_admin?->name }}
                        </a>
                    </td>
                    <td>
                        <a draggable="false" href="{{ $menu->updated_by_admin?->id || $menu->updated_by == 0 ? route("{$sub_domain}.admin.index") . "?menu_type=view&row={$menu->updated_by_admin?->id}" : null }}" target="_blank">
                            {{ $menu->updated_by_admin?->name }}
                        </a>
                    </td>
                    @if ($menu_type == "trash")
                        <td>
                            <a draggable="false" href="{{ $menu->deleted_by_admin?->id || $menu->deleted_by == 0 ? route("{$sub_domain}.admin.index") . "?menu_type=view&row={$menu->deleted_by_admin?->id}" : null }}" target="_blank">
                                {{ $menu->deleted_by_admin?->name }}
                            </a>
                        </td>
                    @endif
                    <td>{{ $menu->created_at?->format("H:i:s - l, d F Y") }} ({{ $menu->created_at?->diffForHumans() }})</td>
                    <td>{{ $menu->updated_at?->format("H:i:s - l, d F Y") }} ({{ $menu->updated_at?->diffForHumans() }})</td>
                    @if ($menu_type == "trash")
                        <td>{{ $menu->deleted_at?->format("H:i:s - l, d F Y") }} ({{ $menu->deleted_at?->diffForHumans() }})</td>
                    @endif
                    <td>
                        @if ($menu_type == "index")
                            @if ($menu->active)
                                <button class="btn btn-creative btn-sm btn-danger" wire:click="nonActive({{ $menu->id }})">
                                    <i class="bi bi-x-circle-fill me-1"></i>
                                    {{ trans("index.Non Active") }}
                                </button>
                            @else
                                <button class="btn btn-creative btn-sm btn-success" wire:click="active({{ $menu->id }})">
                                    <i class="bi bi-check-circle-fill me-1"></i>
                                    {{ trans("index.Active") }}
                                </button>
                            @endif

                            <button class="btn btn-creative btn-sm btn-dark" wire:click="view({{ $menu->id }})">
                                <i class="bi bi-eye me-1"></i>
                                {{ trans("index.View") }}
                            </button>

                            <button class="btn btn-creative btn-sm btn-info" wire:click="form('clone', {{ $menu->id }})">
                                <i class="bi bi-clipboard me-1"></i>
                                {{ trans("index.Clone") }}
                            </button>

                            <button class="btn btn-creative btn-sm btn-success" wire:click="form('edit', {{ $menu->id }})">
                                <i class="bi bi-pencil me-1"></i>
                                {{ trans("index.Edit") }}
                            </button>

                            <button class="btn btn-creative btn-sm btn-danger" type="button" data-bs-toggle="modal" data-bs-target="#delete-{{ $menu->id }}">
                                <i class="bi bi-trash me-1"></i>
                                {{ trans("index.Delete") }}
                            </button>

                            <div class="modal fade" id="delete-{{ $menu->id }}" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="delete-{{ $menu->id }}" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h6 class="modal-title" id="delete-{{ $menu->id }}">{{ trans("index.Delete") }} - {{ trans("page.{$menu_name}") }}</h6>
                                            <button class="btn btn-close p-1 ms-auto" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body text-wrap">
                                            <p>{{ trans("message.Are you sure you want to delete") }} {{ trans("page.{$menu_name}") }}</p>
                                            <p class="mb-0">{{ trans("message.You can still restore from Trash") }}</p>
                                        </div>
                                        <div class="modal-footer justify-content-between">
                                            <button class="btn btn-creative btn-sm btn-light" type="button" data-bs-dismiss="modal">
                                                <i class="bi bi-x me-1"></i>
                                                {{ trans("index.Close") }}
                                            </button>
                                            <button class="btn btn-creative btn-sm btn-danger" type="button" data-bs-dismiss="modal" wire:click="delete({{ $menu->id }})">
                                                <i class="bi bi-check me-1"></i>
                                                {{ trans("index.Yes") }}
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif

                        @if ($menu_type == "trash")
                            <button class="btn btn-creative btn-sm btn-success" type="button" data-bs-toggle="modal" data-bs-target="#restore-{{ $menu->id }}">
                                <i class="bi bi-arrow-clockwise me-1"></i>
                                {{ trans("index.Restore") }}
                            </button>

                            <div class="modal fade" id="restore-{{ $menu->id }}" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="restore-{{ $menu->id }}" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h6 class="modal-title" id="restore-{{ $menu->id }}">{{ trans("index.Restore") }} - {{ trans("page.{$menu_name}") }}</h6>
                                            <button class="btn btn-close p-1 ms-auto" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <p class="mb-0">{{ trans("message.Are you sure you want to restore") }} {{ trans("page.{$menu_name}") }}</p>
                                        </div>
                                        <div class="modal-footer justify-content-between">
                                            <button class="btn btn-creative btn-sm btn-light" type="button" data-bs-dismiss="modal">
                                                <i class="bi bi-x me-1"></i>
                                                {{ trans("index.Close") }}
                                            </button>
                                            <button class="btn btn-creative btn-sm btn-success" type="button" data-bs-dismiss="modal" wire:click="restore({{ $menu->id }})">
                                                <i class="bi bi-check me-1"></i>
                                                {{ trans("index.Yes") }}
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <button class="btn btn-creative btn-sm btn-danger" type="button" data-bs-toggle="modal" data-bs-target="#delete-permanent-{{ $menu->id }}">
                                <i class="bi bi-trash2 me-1"></i>
                                {{ trans("index.Delete Permanent") }}
                            </button>

                            <div class="modal fade" id="delete-permanent-{{ $menu->id }}" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="delete-permanent-{{ $menu->id }}" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h6 class="modal-title" id="delete-permanent-{{ $menu->id }}">{{ trans("index.Delete Permanent") }} - {{ trans("page.{$menu_name}") }}</h6>
                                            <button class="btn btn-close p-1 ms-auto" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body text-wrap">
                                            <p>{{ trans("message.Are you sure you want to delete permanent") }} {{ trans("page.{$menu_name}") }}</p>
                                            <p>{{ trans("message.You cant undo this action or restore this data anymore") }}</p>
                                            <p class="mb-0">{{ trans("message.All relation data and files will be deleted forever from server") }}</p>
                                        </div>
                                        <div class="modal-footer">
                                            <button class="btn btn-creative btn-sm btn-light" type="button" data-bs-dismiss="modal">
                                                <i class="bi bi-x me-1"></i>
                                                {{ trans("index.Close") }}
                                            </button>
                                            <button class="btn btn-creative btn-sm btn-danger" type="button" data-bs-dismiss="modal" wire:click="deletePermanent({{ $menu->id }})">
                                                <i class="bi bi-check me-1"></i>
                                                {{ trans("index.Yes") }}
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </td>
                </tr>
            @endforeach
            @if (!$data_menu->count())
                <tr>
                    <td class="text-center" colspan="100%">{{ trans("index.No Data Available") }}</td>
                </tr>
            @endif
        </tbody>
    </table>
</div>

{{ $data_menu->links("{$sub_domain}.layouts.pagination") }}
