<div class="modal-header">
    <h1 class="modal-title fs-5" id="">{{ __('Update Lesson') }}</h1>
    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>

<div class="p-3">
    <form action="{{ route('instructor.course-chapter.lesson.update') }}" method="POST"
        class="update_lesson_form instructor__profile-form">
        @csrf
        <input type="hidden" name="course_id" value="{{ $courseId }}">
        <input type="hidden" name="chapter_item_id" value="{{ $chapterItem->id }}">
        <input type="hidden" name="type" value="{{ $chapterItem->type }}">

        <div class="col-md-12">
            <div class="form-grp">
                <label for="chapter">{{ __('Chapter') }} <code>*</code></label>
                <select name="chapter" id="chapter" class="chapter form-select">
                    <option value="">{{ __('Select') }}</option>
                    @foreach ($chapters as $chapter)
                        <option @selected($chapterItem->chapter_id == $chapter->id) value="{{ $chapter->id }}">{{ $chapter->title }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="col-md-12">
            <div class="form-grp">
                <label for="title">{{ __('Title') }} <code>*</code></label>
                <input id="title" name="title" type="text" value="{{ $chapterItem->lesson->title }}">
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="form-grp">
                    <label for="source">{{ __('Source') }} <code>*</code></label>
                    <select name="source" id="source" class="source form-select">
                        <option value="">{{ __('Select') }}</option>
                        @if($setting?->aws_status == 'active')
                            <option @selected($chapterItem->lesson->storage == "aws") value="aws">{{ config('course.storage_source.aws') }}</option>
                        @endif
                        @foreach (config('course.storage_source') as $key => $value)
                            @if($key != 'aws' && $key != 'wasabi')
                                <option @selected($chapterItem->lesson->storage == $key) value="{{ $key }}">{{ $value }}</option>
                            @endif
                        @endforeach
                        @if($setting?->wasabi_status == 'active')
                            <option @selected($chapterItem->lesson->storage == "wasabi") value="wasabi">{{ config('course.storage_source.wasabi') }}</option>
                        @endif
                    </select>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-grp">
                    <label for="file_type">{{ __('File Type') }} <code>*</code></label>
                    <select name="file_type" id="file_type" class="file_type form-select">
                        <option value="">{{ __('Select') }}</option>
                        @foreach (config('course.file_types') as $key => $value)
                            @if (in_array($key, ['video', 'file', 'other']))
                                <option @selected($chapterItem->lesson->file_type == $key) value="{{ $key }}">{{ $value }}
                                </option>
                            @endif
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="col-md-9 upload {{ $chapterItem->lesson->storage == 'upload' ? '' : 'd-none' }}">
                <div class="from-group mb-3">
                    <label class="form-file-manager-label" for="">{{ __('Path') }}
                        <code>*</code></label>
                    <div class="input-group">
                        <span class="input-group-text" id="basic-addon1">
                            <a data-input="path" data-preview="holder" class="file-manager">
                                <i class="fa fa-picture-o"></i> {{ __('Choose') }}
                            </a>
                        </span>
                        <input id="path" readonly class="form-control file-manager-input" type="text"
                            name="upload_path"
                            value="{{ $chapterItem->lesson->storage == 'upload' ? $chapterItem->lesson->file_path : '' }}">
                    </div>
                </div>
            </div>
            <div class="col-md-12 cloud_storage {{ $chapterItem->lesson->storage != 'wasabi' || $chapterItem->lesson->storage != 'aws' ? 'd-none' : '' }}">
                <div class="form-grp mb-3">
                    <label class="form-file-manager-label" for="">{{ __('Upload') }}</label>
                    <div class="input-group">
                        <div class="input-group">
                            <input id="file-input" type="file" class="form-control">
                            <button type="button" id="cloud-btn" class="input-group-text" id="basic-addon1"><i class="fas fa-upload"></i></button>
                        </div>
                    </div>
                    <div class="progress d-none">
                        <div class="progress-bar progress-bar-striped progress-bar-animated w-100" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                </div>
            </div>
            <div class="col-md-9 link_path {{ $chapterItem->lesson->storage != 'upload' ? '' : 'd-none' }}">
                <div class="form-grp">
                    <label for="meta_description">{{ __('Path') }} <code></code></label>
                    <div class="input-group mb-3">
                        <span class="input-group-text" id="basic-addon1"><i class="fas fa-link"></i></span>
                        <input type="text" class="form-control" id="input_link" name="link_path"
                            placeholder="{{ __('paste source url') }}"
                            value="{{ $chapterItem->lesson->storage != 'upload' ? $chapterItem->lesson->file_path : '' }}" {{ $chapterItem->lesson->storage == 'wasabi' || $chapterItem->lesson->storage == 'aws' ? 'readonly' : '' }}>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="form-grp">
                    <label for="duration">{{ __('Duration') }} <code>* ({{ __('in minutes') }})</code></label>
                    <input id="duration" name="duration" type="text" value="{{ $chapterItem->lesson->duration }}">
                </div>
            </div>
        </div>
        <div class="row is_free_wrapper">
            <div class="col-md-6 mt-2 mb-2">
                <span class="toggle-label">{{ __('Preview') }}</span>
                <div class="switcher">
                    <label for="toggle-0">
                        <input type="checkbox" @checked($chapterItem->lesson->is_free) id="toggle-0" value="1"
                            name="is_free" />
                        <span><small></small></span>
                    </label>
                </div>
            </div>
        </div>
        <div class="col-md-12">
            <div class="form-grp">
                <label for="description">{{ __('Description') }} <code></code></label>
                <textarea name="description" class="form-control">{{ $chapterItem->lesson->description }}</textarea>
            </div>
        </div>
        <div class="modal-footer">
            <button type="submit" class="btn btn-primary submit-btn">{{ __('Update') }}</button>
        </div>
    </form>
</div>
