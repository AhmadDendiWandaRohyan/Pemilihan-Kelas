<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreGradeRequest;
use App\Http\Requests\UpdateGradeRequest;
use App\Models\Grade;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class GradeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return View
     */
    public function index(Request $request): View
    {        
        return view('pages.grade',[
            'data' => Grade::with('users')->render($request->search),
            'users' => User::where("role", "siswa")->get(),
            'search' => $request->search,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreGradeRequest $request
     * @return RedirectResponse
     */
    public function store(StoreGradeRequest $request): RedirectResponse
    {
        try {
            Grade::create($request->validated());
            return back()->with('success', __('menu.general.success'));
        } catch (\Throwable $exception) {
            return back()->with('error', $exception->getMessage());
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateGradeRequest $request
     * @param Grade $grades
     * @return RedirectResponse
     */
    public function update(UpdateGradeRequest $request, Grade $grade): RedirectResponse
    {
        try {
            $grade->update($request->validated());
            return back()->with('success', __('menu.general.success'));
        } catch (\Throwable $exception) {
            return back()->with('error', $exception->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Grade $grade
     * @return RedirectResponse
     */
    public function destroy(Grade $grade): RedirectResponse
    {
        try {
            $grade->delete();
            return back()->with('success', __('menu.general.success'));
        } catch (\Throwable $exception) {
            return back()->with('error', $exception->getMessage());
        }
    }
}