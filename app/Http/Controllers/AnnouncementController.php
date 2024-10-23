<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAnnouncementRequest;
use App\Http\Requests\UpdateAnnouncementRequest;
use App\Models\Announcement;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class AnnouncementController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return View
     */
    public function index(Request $request): View
    {
        return view('pages.announcement', [
            'data' => Announcement::render($request->search),
            'search' => $request->search,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreAnnouncementRequest $request
     * @return RedirectResponse
     */
    public function store(StoreAnnouncementRequest $request): RedirectResponse
    {
        try {
            Announcement::create($request->validated());
            return back()->with('success', __('menu.general.success'));
        } catch (\Throwable $exception) {
            return back()->with('error', $exception->getMessage());
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateAnnouncementRequest $requests
     * @param Announcement $announcement
     * @return RedirectResponse
     */
    public function update(UpdateAnnouncementRequest $request, Announcement $announcement): RedirectResponse
    {
        try {
            $announcement->update($request->validated());
            return back()->with('success', __('menu.general.success'));
        } catch (\Throwable $exception) {
            return back()->with('error', $exception->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Announcement $announcement
     * @return RedirectResponse
     */
    public function destroy(Announcement $announcement): RedirectResponse
    {
        try {
            $announcement->delete();
            return back()->with('success', __('menu.general.success'));
        } catch (\Throwable $exception) {
            return back()->with('error', $exception->getMessage());
        }
    }
}