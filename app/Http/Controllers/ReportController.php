<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\ListPackage;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use DB;

class ReportController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return View
     */
    public function index(Request $request): View
    {
        $checkPicks = DB::table('picks')->where(['user_id' => auth()->user()->id])->first();
        $packagesJoin = ListPackage::with('studies')
            ->join('packages_studies', 'list_packages.package_number', '=', 'packages_studies.package_number')
            ->select('list_packages.*', 'packages_studies.*')
            ->get();
        
        if($checkPicks){
            return view('pages.report',compact('packagesJoin'), [
                'data' => ListPackage::with('studies')->where(['package_number' => $checkPicks->package_number])->render($request->search),
                'checkPicks' => $checkPicks,
                'search' => $request->search,
            ]);
        }else{
            return view('pages.report',compact('packagesJoin'), [
                'checkPicks' => $checkPicks,
                'search' => $request->search,
            ]);
        }
    }
    
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return View
     */
    public function admin(Request $request): View
    {
        $checkPicks = DB::table('picks')->first();
        $packagesJoin = ListPackage::join('picks', 'list_packages.package_number', '=', 'picks.package_number')
            ->join('users', 'users.id', '=', 'picks.user_id')
            ->select('users.*', 'picks.*', 'list_packages.*')
            ->get();
        
        if($checkPicks){
            return view('pages.report',compact('packagesJoin'), [
                'data' => ListPackage::where(['package_number' => $checkPicks->package_number])->render($request->search),
                'search' => $request->search,
            ]);
        }else{
            return view('pages.report',compact('packagesJoin'), [
                'search' => $request->search,
            ]);
        }
    }
}