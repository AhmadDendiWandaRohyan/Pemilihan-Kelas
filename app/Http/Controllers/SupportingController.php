<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreSupportingRequest;
use App\Http\Requests\UpdateSupportingRequest;
use App\Models\Supporting;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class SupportingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return View
     */
    public function index(Request $request): View
    {
        return view('pages.supporting', [
            'data' => Supporting::render($request->search),
            'search' => $request->search,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreSupportingRequest $request
     * @return RedirectResponse
     */
    public function store(StoreSupportingRequest $request): RedirectResponse
    {
        try {
            Supporting::create($request->validated());
            return back()->with('success', __('menu.general.success'));
        } catch (\Throwable $exception) {
            return back()->with('error', $exception->getMessage());
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateSupportingRequest $requests
     * @param Supporting $supportings
     * @return RedirectResponse
     */
    public function update(UpdateSupportingRequest $request, Supporting $supporting): RedirectResponse
    {
        try {
            $supporting->update($request->validated());
            return back()->with('success', __('menu.general.success'));
        } catch (\Throwable $exception) {
            return back()->with('error', $exception->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Supporting $supporting
     * @return RedirectResponse
     */
    public function destroy(Supporting $supporting): RedirectResponse
    {
        try {
            // dd($supporting);
            $supporting->delete();
            return back()->with('success', __('menu.general.success'));
        } catch (\Throwable $exception) {
            return back()->with('error', $exception->getMessage());
        }
    }
}