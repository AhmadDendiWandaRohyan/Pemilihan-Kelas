<?php

namespace App\Http\Controllers;

use App\Helpers\GeneralHelper;
use App\Http\Requests\UpdateConfigRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\Config;
use App\Models\Announcement;
use App\Models\User;
use App\Models\Pick;
use Carbon\Carbon;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use JetBrains\PhpStorm\NoReturn;
use Illuminate\Support\Facades\Hash;

class PageController extends Controller
{
    /**
     * @param Request $request
     * @return View
     */
    public function index(Request $request): View
    {
        // Menghitung jumlah 'Pick' yang statusnya 1
        $sumStudentsPick          = Pick::where('status', 1)->count();

        return view('pages.dashboard', [
            'greeting' => GeneralHelper::greeting(), // Menambahkan sapaan dari helper
            'announcements' => Announcement::render($request->search), // Menampilkan pengumuman berdasarkan pencarian
            'currentDate' => Carbon::now()->isoFormat('dddd, D MMMM YYYY'), // Menambahkan tanggal sekarang dalam format tertentu
            'activeUser' => User::active()->count(), // Menghitung jumlah user yang aktif
            'sumStudentsPick' => $sumStudentsPick, // Menambahkan jumlah 'Pick' yang sudah dihitung
            'sumStudents' => User::active()->where(['role'=> "siswa"])->count(), // Menghitung jumlah siswa yang aktif
        ]);
    }

    /**
     * @param Request $request
     * @return View
     */
    public function profile(Request $request): View
    {
        return view('pages.profile', [
            'data' => auth()->user(),
        ]);
    }

    /**
     * @param UpdateUserRequest $request
     * @return RedirectResponse
     */
    public function profileUpdate(UpdateUserRequest $request): RedirectResponse
    {
        try {
            $newProfile = $request->validated();
            if ($request->hasFile('profile_picture')) {
//               DELETE OLD PICTURE
                $oldPicture = auth()->user()->profile_picture;
                if (str_contains($oldPicture, '/storage/avatars/')) {
                    $url = parse_url($oldPicture, PHP_URL_PATH);
                    Storage::delete(str_replace('/storage', 'public', $url));
                }

//                UPLOAD NEW PICTURE
                $filename = time() .
                    '-' . $request->file('profile_picture')->getFilename() .
                    '.' . $request->file('profile_picture')->getClientOriginalExtension();
                $request->file('profile_picture')->storeAs('public/avatars', $filename);
                $newProfile['profile_picture'] = asset('storage/avatars/' . $filename);
            }
                
            if ($request->password != auth()->user()->password ) {
                $newProfile['password'] = Hash::make($request->password);
            }
            
            auth()->user()->update($newProfile);
            return back()->with('success', __('menu.general.success'));
        } catch (\Throwable $exception) {
            return back()->with('error', $exception->getMessage());
        }
    }

    /**
     * @return RedirectResponse
     */
    public function deactivate(): RedirectResponse
    {
        try {
            auth()->user()->update(['is_active' => false]);
            Auth::logout();
            return back()->with('success', __('menu.general.success'));
        } catch (\Throwable $exception) {
            return back()->with('error', $exception->getMessage());
        }
    }

    /**
     * @param Request $request
     * @return View
     */
    public function settings(Request $request): View
    {
        return view('pages.setting', [
            'configs' => Config::all(),
        ]);
    }

    /**
     * @param UpdateConfigRequest $request
     * @return RedirectResponse
     */
    public function settingsUpdate(UpdateConfigRequest $request): RedirectResponse
    {
        try {
            DB::beginTransaction();
            foreach ($request->validated() as $code => $value) {
                Config::where('code', $code)->update(['value' => $value]);
            }
            DB::commit();
            return back()->with('success', __('menu.general.success'));
        } catch (\Throwable $exception) {
            DB::rollBack();
            return back()->with('error', $exception->getMessage());
        }
    }

    /**
     * @param Request $request
     * @return RedirectResponse
     */
    public function removeAttachment(Request $request): RedirectResponse
    {
        try {
            $attachment = Attachment::find($request->id);
            $oldPicture = $attachment->path_url;
            if (str_contains($oldPicture, '/storage/attachments/')) {
                $url = parse_url($oldPicture, PHP_URL_PATH);
                Storage::delete(str_replace('/storage', 'public', $url));
            }
            $attachment->delete();
            return back()->with('success', __('menu.general.success'));
        } catch (\Throwable $exception) {
            return back()->with('error', $exception->getMessage());
        }
    }
}