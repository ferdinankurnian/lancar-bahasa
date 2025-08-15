<?php

namespace Modules\Location\app\Http\Controllers;

use App\Enums\RedirectType;
use App\Http\Controllers\Controller;
use App\Traits\RedirectHelperTrait;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Cache;
use Modules\Location\app\Http\Requests\CountryStoreRequest;
use Modules\Location\app\Models\Country;

class CountryController extends Controller
{
    use RedirectHelperTrait;
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        checkAdminHasPermissionAndThrowException('location.view');

        $query = Country::query();
        $query->when($request->keyword, fn($q) => $q->where('name', 'like', "%{$request->keyword}%"));
        $query->when($request->filled('status'), fn($q) => $q->where('status', $request->status));
        $orderBy = $request->order_by == 1 ? 'asc' : 'desc';
        $countries = $request->get('par-page') == 'all' ?
            $query->orderBy('id', $orderBy)->get() :
            $query->orderBy('id', $orderBy)->paginate($request->get('par-page') ?? null)->withQueryString();

        return view('location::country.index', compact('countries'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        checkAdminHasPermissionAndThrowException('location.create');

        return view('location::country.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CountryStoreRequest $request): RedirectResponse
    {
        checkAdminHasPermissionAndThrowException('location.store');

        $country = new Country();
        $country->name = $request->name;
        $country->status = $request->status;
        $country->save();

        Cache::forget('countries');

        return $this->redirectWithMessage(
            RedirectType::CREATE->value,
            'admin.country.create'
        );
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        checkAdminHasPermissionAndThrowException('location.edit');

        $country = Country::findOrFail($id);
        return view('location::country.edit', compact('country'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CountryStoreRequest $request, $id): RedirectResponse
    {
        checkAdminHasPermissionAndThrowException('location.update');

        $country = Country::findOrFail($id);
        $country->name = $request->name;
        $country->status = $request->status;
        $country->save();
        Cache::forget('countries');

        return $this->redirectWithMessage(
            RedirectType::UPDATE->value,
            'admin.country.edit',
            ['country' => $country->id]
        );
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        checkAdminHasPermissionAndThrowException('location.delete');

        $country = Country::findOrFail($id);
        $country->delete();
        Cache::forget('countries');

        return $this->redirectWithMessage(RedirectType::DELETE->value, 'admin.country.index');

    }
}
