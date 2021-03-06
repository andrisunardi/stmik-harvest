<div>
    <form wire:submit.prevent="submit" enctype="multipart/form-data" class="was-validated-delete" method="post" role="form" action="{{ route("{$sub_domain}.{$menu_slug}.index") }}">
        @csrf

        <div class="row">
            @php $input = "name" @endphp
            <div class="form-group col-sm-6">
                <label class="form-label" for="{{ $input }}">{{ trans("validation.attributes.{$input}") }} <span class="text-danger">*</span></label>
                <div class="input-group has-validation">
                    <div class="input-group-text"><span class="bi bi-person-fill"></span></div>
                    <input wire:model="{{ $input }}" wire:keydown.enter="submit" id="{{ $input }}" name="{{ $input }}"
                        type="text" class="form-control @if($errors->any() || Session::has("info") || Session::has("success") || Session::has("warning") || Session::has("danger")) {{ $errors->has($input) ? "is-invalid" : "is-valid" }}@endif" minlength="1" maxlength="50" value="{{ old($input) }}"
                        placeholder="{{ trans("validation.attributes.{$input}") }}" aria-label="{{ trans("validation.attributes.{$input}") }}" aria-describedby="{{ trans("validation.attributes.{$input}") }}"
                        autocomplete="off" autocapitalize="none" required>
                    @error($input)
                        <div class="invalid-feedback rounded bg-danger p-2 ms-0 mt-2 text-white">{{ $message }}</div>
                    @else
                        <div class="valid-feedback rounded bg-success p-2 ms-0 mt-2 text-white">{{ trans("validation.success") }}</div>
                    @enderror
                </div>
            </div>

            @php $input = "gender" @endphp
            <div class="form-group col-sm-6">
                <label class="form-label" for="{{ $input }}">{{ trans("validation.attributes.{$input}") }} <span class="text-danger">*</span></label>
                <div class="input-group has-validation">
                    <div class="input-group-text"><span class="bi bi-gender-ambiguous"></span></div>
                    <select wire:model="{{ $input }}" class="form-select select2 @if($errors->any() || Session::has("info") || Session::has("success") || Session::has("warning") || Session::has("danger")) {{ $errors->has($input) ? "is-invalid" : "is-valid" }}@endif" id="{{ $input }}" name="{{ $input }}" required>
                        <option value="">{{ trans("index.Select") }} {{ trans("validation.attributes.{$input}") }}</option>
                        <option value="1">{{ trans("index.Man") }}</option>
                        <option value="2">{{ trans("index.Woman") }}</option>
                    </select>
                    @error($input)
                        <div class="invalid-feedback rounded bg-danger p-2 ms-0 mt-2 text-white">{{ $message }}</div>
                    @else
                        <div class="valid-feedback rounded bg-success p-2 ms-0 mt-2 text-white">{{ trans("validation.success") }}</div>
                    @enderror
                </div>
            </div>
        </div>

        <div class="row">
            @php $input = "email" @endphp
            <div class="form-group col-sm-6">
                <label class="form-label" for="{{ $input }}">{{ trans("validation.attributes.{$input}") }} <span class="text-danger">*</span></label>
                <div class="input-group has-validation">
                    <div class="input-group-text"><span class="bi bi-envelope-fill"></span></div>
                    <input wire:model="{{ $input }}" wire:keydown.enter="submit" id="{{ $input }}" name="{{ $input }}"
                        type="email" class="form-control @if($errors->any() || Session::has("info") || Session::has("success") || Session::has("warning") || Session::has("danger")) {{ $errors->has($input) ? "is-invalid" : "is-valid" }}@endif" minlength="1" maxlength="50" value="{{ old($input) }}"
                        placeholder="{{ trans("validation.attributes.{$input}") }}" aria-label="{{ trans("validation.attributes.{$input}") }}" aria-describedby="{{ trans("validation.attributes.{$input}") }}"
                        autocomplete="off" autocapitalize="none" required>
                    @error($input)
                        <div class="invalid-feedback rounded bg-danger p-2 ms-0 mt-2 text-white">{{ $message }}</div>
                    @else
                        <div class="valid-feedback rounded bg-success p-2 ms-0 mt-2 text-white">{{ trans("validation.success") }}</div>
                    @enderror
                </div>
            </div>

            @php $input = "phone" @endphp
            <div class="form-group col-sm-6">
                <label class="form-label" for="{{ $input }}">{{ trans("validation.attributes.{$input}") }} <span class="text-danger">*</span></label>
                <div class="input-group has-validation">
                    <div class="input-group-text"><span class="bi bi-telephone-fill"></span></div>
                    <input wire:model="{{ $input }}" wire:keydown.enter="submit" id="{{ $input }}" name="{{ $input }}"
                        type="text" class="form-control @if($errors->any() || Session::has("info") || Session::has("success") || Session::has("warning") || Session::has("danger")) {{ $errors->has($input) ? "is-invalid" : "is-valid" }}@endif" minlength="1" maxlength="20" value="{{ old($input) }}"
                        placeholder="{{ trans("validation.attributes.{$input}") }}" aria-label="{{ trans("validation.attributes.{$input}") }}" aria-describedby="{{ trans("validation.attributes.{$input}") }}"
                        autocomplete="off" autocapitalize="none" required>
                    @error($input)
                        <div class="invalid-feedback rounded bg-danger p-2 ms-0 mt-2 text-white">{{ $message }}</div>
                    @else
                        <div class="valid-feedback rounded bg-success p-2 ms-0 mt-2 text-white">{{ trans("validation.success") }}</div>
                    @enderror
                </div>
            </div>
        </div>

        <div class="row">
            @php $input = "school" @endphp
            <div class="form-group col-sm-6">
                <label class="form-label" for="{{ $input }}">{{ trans("validation.attributes.{$input}") }} <span class="text-danger">*</span></label>
                <div class="input-group has-validation">
                    <div class="input-group-text"><span class="bi bi-building"></span></div>
                    <input wire:model="{{ $input }}" wire:keydown.enter="submit" id="{{ $input }}" name="{{ $input }}"
                        type="text" class="form-control @if($errors->any() || Session::has("info") || Session::has("success") || Session::has("warning") || Session::has("danger")) {{ $errors->has($input) ? "is-invalid" : "is-valid" }}@endif" minlength="1" maxlength="50" value="{{ old($input) }}"
                        placeholder="{{ trans("validation.attributes.{$input}") }}" aria-label="{{ trans("validation.attributes.{$input}") }}" aria-describedby="{{ trans("validation.attributes.{$input}") }}"
                        autocomplete="off" autocapitalize="none" required>
                    @error($input)
                        <div class="invalid-feedback rounded bg-danger p-2 ms-0 mt-2 text-white">{{ $message }}</div>
                    @else
                        <div class="valid-feedback rounded bg-success p-2 ms-0 mt-2 text-white">{{ trans("validation.success") }}</div>
                    @enderror
                </div>
            </div>

            @php $input = "major" @endphp
            <div class="form-group col-sm-6">
                <label class="form-label" for="{{ $input }}">{{ trans("validation.attributes.{$input}") }} <span class="text-danger">*</span></label>
                <div class="input-group has-validation">
                    <div class="input-group-text"><span class="bi bi-book"></span></div>
                    <input wire:model="{{ $input }}" wire:keydown.enter="submit" id="{{ $input }}" name="{{ $input }}"
                        type="text" class="form-control @if($errors->any() || Session::has("info") || Session::has("success") || Session::has("warning") || Session::has("danger")) {{ $errors->has($input) ? "is-invalid" : "is-valid" }}@endif" minlength="1" maxlength="50" value="{{ old($input) }}"
                        placeholder="{{ trans("validation.attributes.{$input}") }}" aria-label="{{ trans("validation.attributes.{$input}") }}" aria-describedby="{{ trans("validation.attributes.{$input}") }}"
                        autocomplete="off" autocapitalize="none" required>
                    @error($input)
                        <div class="invalid-feedback rounded bg-danger p-2 ms-0 mt-2 text-white">{{ $message }}</div>
                    @else
                        <div class="valid-feedback rounded bg-success p-2 ms-0 mt-2 text-white">{{ trans("validation.success") }}</div>
                    @enderror
                </div>
            </div>
        </div>

        <div class="row">
            @php $input = "city" @endphp
            <div class="form-group col-sm-6">
                <label class="form-label" for="{{ $input }}">{{ trans("validation.attributes.{$input}") }} <span class="text-danger">*</span></label>
                <div class="input-group has-validation">
                    <div class="input-group-text"><span class="bi bi-house"></span></div>
                    <input wire:model="{{ $input }}" wire:keydown.enter="submit" id="{{ $input }}" name="{{ $input }}"
                        type="text" class="form-control @if($errors->any() || Session::has("info") || Session::has("success") || Session::has("warning") || Session::has("danger")) {{ $errors->has($input) ? "is-invalid" : "is-valid" }}@endif" minlength="1" maxlength="50" value="{{ old($input) }}"
                        placeholder="{{ trans("validation.attributes.{$input}") }}" aria-label="{{ trans("validation.attributes.{$input}") }}" aria-describedby="{{ trans("validation.attributes.{$input}") }}"
                        autocomplete="off" autocapitalize="none" required>
                    @error($input)
                        <div class="invalid-feedback rounded bg-danger p-2 ms-0 mt-2 text-white">{{ $message }}</div>
                    @else
                        <div class="valid-feedback rounded bg-success p-2 ms-0 mt-2 text-white">{{ trans("validation.success") }}</div>
                    @enderror
                </div>
            </div>

            @php $input = "type" @endphp
            <div class="form-group col-sm-6">
                <label class="form-label" for="{{ $input }}">{{ trans("validation.attributes.{$input}") }} <span class="text-danger">*</span></label>
                <div class="input-group has-validation">
                    <div class="input-group-text"><span class="bi bi-clock"></span></div>
                    <select wire:model="{{ $input }}" class="form-select select2 @if($errors->any() || Session::has("info") || Session::has("success") || Session::has("warning") || Session::has("danger")) {{ $errors->has($input) ? "is-invalid" : "is-valid" }}@endif" id="{{ $input }}" name="{{ $input }}" required>
                        <option value="">{{ trans("index.Select") }} {{ trans("validation.attributes.{$input}") }}</option>
                        <option value="1">{{ trans("index.Morning - Afternoon Lecturer") }}</option>
                        <option value="2">{{ trans("index.Study & Work (Evening Lecture)") }}</option>
                    </select>
                    @error($input)
                        <div class="invalid-feedback rounded bg-danger p-2 ms-0 mt-2 text-white">{{ $message }}</div>
                    @else
                        <div class="valid-feedback rounded bg-success p-2 ms-0 mt-2 text-white">{{ trans("validation.success") }}</div>
                    @enderror
                </div>
            </div>
        </div>

        @php $input = "active" @endphp
        <label class="form-label" for="{{ $input }}">{{ trans("validation.attributes.{$input}") }} <span class="text-danger">*</span></label>
        <div class="row mb-3">
            <div class="col-sm-6">
                <div class="single-plan-check {{ $active || $menu_type == "add" ? "active" : null }} shadow-sm active-effect">
                    <div class="form-check mb-0">
                        <input wire:model="{{ $input }}" class="form-check-input" type="radio" name="{{ $input }}" id="active" value="1" required>
                        <label class="form-check-label" for="active">{{ trans("index.Active") }}</label>
                    </div>
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-check-circle-fill text-success" viewBox="0 0 16 16">
                        <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z"/>
                    </svg>
                </div>
            </div>
            <div class="col-sm-6 mt-3 mt-sm-0">
                <div class="single-plan-check {{ is_null($input)&& $menu_type != "add" ? "active" : null }} shadow-sm active-effect">
                    <div class="form-check mb-0">
                        <input wire:model="{{ $input }}" class="form-check-input" type="radio" name="{{ $input }}" id="non-active" value="0" required>
                        <label class="form-check-label" for="non-active">{{ trans("index.Non Active") }}</label>
                    </div>
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-x-circle-fill text-danger" viewBox="0 0 16 16">
                        <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM5.354 4.646a.5.5 0 1 0-.708.708L7.293 8l-2.647 2.646a.5.5 0 0 0 .708.708L8 8.707l2.646 2.647a.5.5 0 0 0 .708-.708L8.707 8l2.647-2.646a.5.5 0 0 0-.708-.708L8 7.293 5.354 4.646z"/>
                    </svg>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-6 col-sm-auto">
                <button type="button" class="btn btn-creative btn-primary w-100" wire:click="submit" wire:loading.attr="disabled">
                    <i class="bi bi-save-fill me-1"></i>
                    {{ trans("index.Save") }}
                </button>
            </div>
            <div class="col-6 col-sm-auto">
                <button type="button" class="btn btn-creative btn-warning w-100" wire:click="{{ $menu_type == "add" ? "resetFilter" : "resetForm" }}" wire:loading.attr="disabled">
                    <i class="bi bi-arrow-repeat me-1"></i>
                    {{ trans("index.Reset") }}
                </button>
            </div>
        </div>
    </form>
</div>
