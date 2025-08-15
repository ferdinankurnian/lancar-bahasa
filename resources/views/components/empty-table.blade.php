<tr>
    <td colspan="{{ $colspan }}" class="py-5 text-center">
        <img src="{{ asset('backend/img/empty-box.png') }}" alt="" width="200px">
        <h4 class="py-2">{{ $message }}</h4>
        @if ($create == 'yes')
            <a href="{{ route($route) }}" class="btn btn-success ">{{ __('Add New') }} {{ $name }}</a>
        @endif
    </td>
</tr>
