<?php
$currentUrl = url()->current();
$language_code = !empty(request('code')) ? request('code') : getSessionLanguage();
?>
<div>
    <div class="lang_list_top">
        <ul class="lang_list">
            @foreach ($languages as $language)
                <li><a id="{{ request('code') == $language->code ? 'selected-language' : '' }}"
                        href="{{ currectUrlWithQuery($language->code) }}"><i
                            class="fas {{ request('code') == $language->code || ($language->code == config('app.locale') && empty(request('code'))) ? 'fa-eye' : 'fa-edit' }}"></i>
                        {{ $language->name }}</a>
                </li>
            @endforeach
        </ul>
    </div>
    <div class="mt-2 alert alert-danger" role="alert">
        @php
            $current_language = $languages->where('code', $language_code)->first();
        @endphp
        <p>{{ __('Your editing mode') }} :
            <b>{{ $current_language?->name }}</b>
        </p>
    </div>
</div>
<input type="hidden" id="language_code" value="{{ $language_code }}">
<div id="hwpwrap">
    <div class="custom-wp-admin wp-admin wp-core-ui js   menu-max-depth-0 nav-menus-php auto-fold admin-bar">
        <div id="wpwrap">
            <div id="wpcontent">
                <div id="wpbody">
                    <div id="wpbody-content">

                        <div class="wrap">

                            <div class="manage-menus">
                                <form method="get" action="{{ $currentUrl }}">
                                    <label for="menu" class="selected-menu">{{ __('select_menu_edit') }}</label>
                                    <select name="menu">
                                        <option {{ request()->input('menu') == 0 ? 'selected="selected"' : '' }}
                                            value="0">{{ __('select_menu') }}</option>
                                        @foreach ($menulist as $val)
                                            <option
                                                {{ request()->input('menu') == $val->id ? 'selected="selected"' : '' }}
                                                value="{{ $val->id }}">
                                                {{ Str::replace('_', ' ', ucwords($val->getTranslation($language_code)?->name)) }}</option>
                                        @endforeach
                                    </select>
                                    <span class="submit-btn">
                                        <input type="submit" class="btn btn-primary text-white"
                                            value="{{ __('choose') }}">
                                    </span>

                                </form>
                            </div>
                            <div id="nav-menus-frame">
                                <div class="row">
                                    <div class="col-xxl-3 col-lg-4">

                                        @if (request()->has('menu') && !empty(request()->input('menu')))
                                            <div id="menu-settings-column" class="metabox-holder">

                                                <div class="clear"></div>

                                                <form id="nav-menu-meta" action="" class="nav-menu-meta"
                                                    method="post" enctype="multipart/form-data">
                                                    <div id="side-sortables" class="accordion-container">
                                                        <ul class="outer-border">
                                                            <li class="control-section accordion-section open add-page"
                                                                id="add-page">
                                                                <h3 class="accordion-section-title hndle"
                                                                    tabindex="0">
                                                                    {{ __('add_link') }}
                                                                    <span
                                                                        class="screen-reader-text">{{ __('press_enter') }}</span>
                                                                </h3>
                                                                <div class="accordion-section-content ">

                                                                    <p id="menu-item-url-wrap">
                                                                        <label class="howto"
                                                                            for="custom-menu-item-url">
                                                                            <span>{{ __('Pages') }}</span>&nbsp;&nbsp;&nbsp;
                                                                            <select id="existing-menu-select">
                                                                                <option>{{ __('Custom Menu') }}
                                                                                </option>
                                                                                @foreach ($defaultMenusList as $menu)
                                                                                    <option value="1"
                                                                                        data-label="{{ $menu->name }}"
                                                                                        data-url="{{ $menu->url }}">
                                                                                        {{ $menu->name }}</option>
                                                                                @endforeach
                                                                            </select>
                                                                        </label>
                                                                    </p>
                                                                    <div class="inside">
                                                                        <div class="customlinkdiv" id="customlinkdiv">
                                                                            <p id="menu-item-url-wrap">
                                                                                <label class="howto"
                                                                                    for="custom-menu-item-url">
                                                                                    <span>{{ __('URL') }}</span>&nbsp;&nbsp;&nbsp;
                                                                                    <input id="custom-menu-item-url"
                                                                                        name="url" type="text"
                                                                                        class="menu-item-textbox "
                                                                                        placeholder="{{ __('URL') }}">
                                                                                </label>
                                                                            </p>

                                                                            <p id="menu-item-name-wrap">
                                                                                <label class="howto"
                                                                                    for="custom-menu-item-name">
                                                                                    <span>{{ __('label') }}</span>&nbsp;
                                                                                    <input id="custom-menu-item-name"
                                                                                        name="label" type="text"
                                                                                        class="regular-text menu-item-textbox input-with-default-title"
                                                                                        title="{{ __('menu_label') }}">
                                                                                </label>
                                                                            </p>

                                                                            @if (!empty($roles))
                                                                                <p id="menu-item-role_id-wrap">
                                                                                    <label class="howto"
                                                                                        for="custom-menu-item-name">
                                                                                        <span>{{ __('role') }}</span>&nbsp;
                                                                                        <select
                                                                                            id="custom-menu-item-role"
                                                                                            name="role">
                                                                                            <option value="0">
                                                                                                {{ __('select_role') }}
                                                                                            </option>
                                                                                            @foreach ($roles as $role)
                                                                                                <option
                                                                                                    value="{{ $role->$role_pk }}">
                                                                                                    {{ ucfirst($role->$role_title_field) }}
                                                                                                </option>
                                                                                            @endforeach
                                                                                        </select>
                                                                                    </label>
                                                                                </p>
                                                                            @endif

                                                                            <p class="button-controls">

                                                                                <a href="#"
                                                                                    onclick="addcustommenu()"
                                                                                    class="btn btn-primary text-white submit-add-to-menu right">{{ __('add_menu_item') }}</a>
                                                                                <span class="spinner"
                                                                                    id="spincustomu"></span>
                                                                            </p>

                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </li>

                                                        </ul>
                                                    </div>
                                                </form>

                                            </div>
                                        @endif
                                    </div>
                                    <div class="col-xxl-9 col-lg-8">
                                        <div id="menu-management-liquid">
                                            <div id="menu-management">
                                                <form id="update-nav-menu" action="" method="post"
                                                    enctype="multipart/form-data">
                                                    <div class="menu-edit ">
                                                        <div id="nav-menu-header">
                                                            <div class="major-publishing-actions">
                                                                <label class="menu-name-label howto open-label"
                                                                    for="menu-name">
                                                                    <span>{{ __('name') }}</span>
                                                                    <input name="menu-name" id="menu-name"
                                                                        type="text" readonly
                                                                        class="menu-name regular-text menu-item-textbox"
                                                                        title="{{ __('enter_menu_name') }}"
                                                                        value="@if (isset($indmenu)) {{ ucwords(Str::replace('_', ' ', $indmenu->getTranslation($language_code)?->name)) }} @endif">
                                                                    <input type="hidden" id="idmenu"
                                                                        value="@if (isset($indmenu)) {{ $indmenu->id }} @endif" />
                                                                </label>

                                                                @if (request()->has('action'))
                                                                    <div class="publishing-action">
                                                                        <a onclick="createnewmenu()" name="save_menu"
                                                                            id="save_menu_header"
                                                                            class="btn btn-primary text-white menu-save">{{ __('create_menu') }}</a>
                                                                    </div>
                                                                @elseif(request()->has('menu'))
                                                                    <div class="publishing-action">
                                                                        <a onclick="getmenus()" name="save_menu"
                                                                            id="save_menu_header"
                                                                            class="btn btn-primary text-white menu-save">{{ __('save_menu') }}</a>
                                                                        <span class="spinner"
                                                                            id="spincustomu2"></span>
                                                                    </div>
                                                                @else
                                                                    <div class="publishing-action">
                                                                        <a onclick="createnewmenu()" name="save_menu"
                                                                            id="save_menu_header"
                                                                            class="btn btn-primary text-white menu-save">{{ __('create_menu') }}</a>
                                                                    </div>
                                                                @endif
                                                            </div>
                                                        </div>
                                                        <div id="post-body">
                                                            <div id="post-body-content">

                                                                @if (request()->has('menu'))
                                                                    <h3>{{ __('menu_structure') }}</h3>
                                                                    <div class="drag-instructions post-body-plain">
                                                                        <p>
                                                                            {{ __('menu_structure_text') }}
                                                                        </p>
                                                                    </div>
                                                                @else
                                                                    <h3>{{ __('menu_creation') }}</h3>
                                                                    <div class="drag-instructions post-body-plain">
                                                                        <p>
                                                                            {{ __('menu_creation_text') }}
                                                                        </p>
                                                                    </div>
                                                                @endif

                                                                <ul class="menu ui-sortable d-block"
                                                                    id="menu-to-edit">
                                                                    @if (isset($menus))
                                                                        @foreach ($menus as $m)
                                                                            <li id="menu-item-{{ $m->id }}"
                                                                                class="menu-item menu-item-depth-{{ $m->depth }} menu-item-page menu-item-edit-inactive pending">
                                                                                <dl class="menu-item-bar">
                                                                                    <dt class="menu-item-handle">
                                                                                        <span class="item-title"> <span
                                                                                                class="menu-item-title">
                                                                                                <span
                                                                                                    id="menutitletemp_{{ $m->id }}">{{ $m->getTranslation($language_code)->label }}</span>
                                                                                                <span
                                                                                                    class="d-none">|{{ $m->id }}|</span>
                                                                                            </span> <span
                                                                                                class="is-submenu"
                                                                                                style="@if ($m->depth == 0) display: none; @endif">{{ __('subelement') }}</span>
                                                                                        </span>
                                                                                        <span class="item-controls">
                                                                                            <span
                                                                                                class="item-type">{{ __('Link') }}</span>
                                                                                            <span
                                                                                                class="item-order hide-if-js">
                                                                                                <a href="{{ $currentUrl }}?action=move-up-menu-item&menu-item={{ $m->id }}&_wpnonce=8b3eb7ac44"
                                                                                                    class="item-move-up"><abbr
                                                                                                        title="{{ __('move_up') }}">↑</abbr></a>
                                                                                                | <a href="{{ $currentUrl }}?action=move-down-menu-item&menu-item={{ $m->id }}&_wpnonce=8b3eb7ac44"
                                                                                                    class="item-move-down"><abbr
                                                                                                        title="{{ __('move_down') }}">↓</abbr></a>
                                                                                            </span> <a
                                                                                                class="item-edit"
                                                                                                id="edit-{{ $m->id }}"
                                                                                                title=" "
                                                                                                href="{{ $currentUrl }}?edit-menu-item={{ $m->id }}#menu-item-settings-{{ $m->id }}">
                                                                                            </a> </span>
                                                                                    </dt>
                                                                                </dl>

                                                                                <div class="menu-item-settings"
                                                                                    id="menu-item-settings-{{ $m->id }}">
                                                                                    <input type="hidden"
                                                                                        class="edit-menu-item-id"
                                                                                        name="menuid_{{ $m->id }}"
                                                                                        value="{{ $m->id }}" />

                                                                                    <p
                                                                                        class="description description-thin">
                                                                                        <label
                                                                                            for="edit-menu-item-title-{{ $m->id }}">
                                                                                            {{ __('label') }}
                                                                                            <br>
                                                                                            <input type="text"
                                                                                                id="idlabelmenu_{{ $m->id }}"
                                                                                                class="widefat edit-menu-item-title"
                                                                                                name="idlabelmenu_{{ $m->id }}"
                                                                                                value="{{ $m->getTranslation($language_code)->label }}">
                                                                                        </label>
                                                                                    </p>


                                                                                    <p
                                                                                        class="field-css-url description description-wide">
                                                                                        <label
                                                                                            for="edit-menu-item-url-{{ $m->id }}">
                                                                                            {{ __('URL') }}
                                                                                            <br>
                                                                                            <input type="text"
                                                                                                id="url_menu_{{ $m->id }}"
                                                                                                class="widefat code edit-menu-item-url"
                                                                                                id="url_menu_{{ $m->id }}"
                                                                                                value="{{ $m->link }}">
                                                                                        </label>
                                                                                    </p>

                                                                                    @if (!empty($roles))
                                                                                        <p
                                                                                            class="field-css-role description description-wide">
                                                                                            <label
                                                                                                for="edit-menu-item-role-{{ $m->id }}">
                                                                                                {{ __('role') }}
                                                                                                <br>
                                                                                                <select
                                                                                                    id="role_menu_{{ $m->id }}"
                                                                                                    class="widefat code edit-menu-item-role"
                                                                                                    name="role_menu_[{{ $m->id }}]">
                                                                                                    <option
                                                                                                        value="0">
                                                                                                        {{ __('select_url') }}
                                                                                                    </option>
                                                                                                    @foreach ($roles as $role)
                                                                                                        <option
                                                                                                            @if ($role->id == $m->role_id) selected @endif
                                                                                                            value="{{ $role->$role_pk }}">
                                                                                                            {{ ucwords($role->$role_title_field) }}
                                                                                                        </option>
                                                                                                    @endforeach
                                                                                                </select>
                                                                                            </label>
                                                                                        </p>
                                                                                    @endif

                                                                                    <div
                                                                                        class="menu-item-actions description-wide submitbox">

                                                                                        <a class="item-delete submitdelete deletion"
                                                                                            id="delete-{{ $m->id }}"
                                                                                            href="{{ $currentUrl }}?action=delete-menu-item&menu-item={{ $m->id }}&_wpnonce=2844002501">{{ __('delete') }}</a>
                                                                                        <span
                                                                                            class="meta-sep hide-if-no-js">
                                                                                            |
                                                                                        </span>
                                                                                        <a class="item-cancel submitcancel hide-if-no-js button-secondary"
                                                                                            id="cancel-{{ $m->id }}"
                                                                                            href="{{ $currentUrl }}?edit-menu-item={{ $m->id }}&cancel=1424297719#menu-item-settings-{{ $m->id }}">{{ __('cancel') }}</a>
                                                                                        <span
                                                                                            class="meta-sep hide-if-no-js">
                                                                                            |
                                                                                        </span>
                                                                                        <a onclick="getmenus()"
                                                                                            class="btn btn-primary text-white updatemenu"
                                                                                            id="update-{{ $m->id }}"
                                                                                            href="javascript:void(0)">{{ __('update_item') }}</a>

                                                                                    </div>

                                                                                </div>
                                                                                <ul class="menu-item-transport"></ul>
                                                                            </li>
                                                                        @endforeach
                                                                    @endif
                                                                </ul>
                                                                <div class="menu-settings">

                                                                </div>
                                                            </div>
                                                        </div>

                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>

                        <div class="clear"></div>
                    </div>

                    <div class="clear"></div>
                </div>
                <div class="clear"></div>
            </div>

            <div class="clear"></div>
        </div>
    </div>
</div>
