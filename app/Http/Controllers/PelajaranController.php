<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePelajaranRequest;
use App\Http\Requests\UpdatePelajaranRequest;
use App\Models\Pelajaran;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class PelajaranController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return View
     */
    public function index(Request $request): View
    {
        return view('pages.paket.pelajaran', [
            'data' => Pelajaran::render($request->search),
            'search' => $request->search,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StorePelajaranRequest $request
     * @return RedirectResponse
     */
    public function store(StorePelajaranRequest $request): RedirectResponse
    {
        try {
            Pelajaran::create($request->validated());
            return back()->with('success', __('menu.general.success'));
        } catch (\Throwable $exception) {
            return back()->with('error', $exception->getMessage());
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdatePelajaranRequest $request
     * @param Pelajaran $pelajaran
     * @return RedirectResponse
     */
    public function update(UpdatePelajaranRequest $request, Pelajaran $pelajaran): RedirectResponse
    {
        try {
            $pelajaran->update($request->validated());
            return back()->with('success', __('menu.general.success'));
        } catch (\Throwable $exception) {
            return back()->with('error', $exception->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Pelajaran $pelajaran
     * @return RedirectResponse
     */
    public function destroy(Pelajaran $pelajaran): RedirectResponse
    {
        try {
            $pelajaran->delete();
            return back()->with('success', __('menu.general.success'));
        } catch (\Throwable $exception) {
            return back()->with('error', $exception->getMessage());
        }
    }
}