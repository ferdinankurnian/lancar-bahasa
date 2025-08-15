<script>
    var menus = {
        "oneThemeLocationNoMenus": "",
        "moveUp": '{{__("move_up")}}',
        "moveDown": '{{__("move_down")}}',
        "moveToTop": '{{__("move_top")}}',
        "moveUnder": "Move under of %s",
        "moveOutFrom": "Out from under %s",
        "under": "Under %s",
        "outFrom": "Out from %s",
        "menuFocus": "%1\$s. Element menu %2\$d of %3\$d.",
        "enterMenuName": '{{__("enter_menu_name")}}',
        "updated" : '{{__("Updated Successfully")}}',
        "updateItem" : '{{__("Item Updated Successfully")}}',
        "deleteItem" : '{{__("Item deleted successfully")}}',
        "deleteItemAlert" : '{{__("Do you want to delete this item ?")}}',
        "failed" : '{{__("Operation Failed")}}',
        "subMenuFocus" : "%1\$s. Menu of subelement %2\$d of %3\$s."
    };
    var arraydata = [];
    var createnewmenur = '{{ route('admin.menus.create') }}';
    var generatemenucontrolr = '{{ route('admin.menus.update') }}';
    var deletemenugr = '{{ route('admin.menus.delete') }}';

    var addcustommenur = '{{ route('admin.menus.items.create') }}';
    var updateitemr = '{{ route('admin.menus.items.update') }}';
    var deleteitemmenur = '{{ route('admin.menus.items.delete') }}';
    var csrftoken = "{{ csrf_token() }}";
    var menuwr = "{{ url()->current() }}";

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': csrftoken
        }
    });
</script>
{{-- script js --}}
<script src="{{ asset('backend/menubuilder/script.js') }}"></script>
<script src="{{ asset('backend/menubuilder/script2.js') }}"></script>
<script src="{{ asset('backend/menubuilder/menu.js') }}"></script>
