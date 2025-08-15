<div class="row">
  <div class="col-md-4">
    <div class="card">
      <div class="card-body">
        <h5 class="card-title">{{ __('Level') }}</h5>
        @foreach ($levels as $level)
        <div class="form-group">
          <div class="form-check">
            <input class="form-check-input" name="levels[]" type="checkbox" value="{{ $level->id }}" id="level-checkbox{{ $level->id }}">
            <label class="form-check-label" for="level-checkbox{{ $level->id }}">
              {{ $level->translation?->name }}
            </label>
          </div>
        </div>
        @endforeach
      </div>
    </div>
  </div>

  <div class="col-md-4">
    <div class="card">
      <div class="card-body">
        <h5 class="card-title">{{ __('Language') }}</h5>
        @foreach ($languages as $language)
        <div class="form-group">
          <div class="form-check">
            <input class="form-check-input" name="languages[]" type="checkbox" value="{{ $language->id }}" id="lang-checkbox{{ $language->id }}">
            <label class="form-check-label" for="lang-checkbox{{ $language->id }}">
              {{ $language->name }}
            </label>
          </div>
        </div>
        @endforeach
      </div>
    </div>
  </div>

  @foreach ($category->filters as $filter)
  <div class="col-md-4">
    <div class="card">
      <div class="card-body">
        <h5 class="card-title">{{ $filter->translation?->title }}</h5>
        @foreach ($filter->filterOptions as $option)
        <div class="form-group">
          <div class="form-check">
            <input class="form-check-input" name="filters[{{ $filter->id }}][]" type="checkbox" value="{{ $option->id }}" id="filter-checkbox{{ $option->id }}">
            <label class="form-check-label" for="filter-checkbox{{ $option->id }}">
              {{ $option->name }}
            </label>
          </div>
        </div>
        @endforeach
      </div>
    </div>
  </div>
  @endforeach
</div>