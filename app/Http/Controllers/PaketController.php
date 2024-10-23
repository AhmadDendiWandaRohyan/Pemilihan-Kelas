<?php

namespace App\Http\Controllers;

use DB;
use App\Http\Requests\StoreListPackageRequest;
use App\Models\Config;
use App\Models\Paket;
use App\Models\Grade;
use App\Models\ListPackage;
use App\Models\PackagesStudy;
use App\Models\Pelajaran;
use App\Models\Pick;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Carbon\Carbon;

class PaketController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return View
     */
    public function index(Request $request): View
    {

        $now = Carbon::now();
        $dateNow = $now->format('Y-m-d');   
        $today = $now->format('Y-m-d H:i:s');
        $timeNow = $now->format('H:i:s');
        $packagesJoin = ListPackage::with('studies')
            ->join('packages_studies', 'list_packages.package_number', '=', 'packages_studies.package_number')
            ->select('list_packages.*', 'packages_studies.*')
            ->get();
        
        return view('pages.paket.index',compact('packagesJoin'), [
            'data' => ListPackage::with('studies')->where(['status' => '1'])->render($request->search),
            'search' => $request->search,
            'dateNow' => $dateNow,
            'grade' => Grade::with('users')->where('user_id',auth()->user()->id)->first(),
            'timeNow' => $timeNow,
            'today' => $today,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return View
     */
    public function create(): View
    {
        return view('pages.paket.create', [
            'studies' => Pelajaran::all(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     * 
     * @param Request $request
     * @return RedirectResponse
     */
    public function store(Request $request): RedirectResponse
    {
        // Memvalidasi data yang diterima dari permintaan POST.
        $request->validate([
            'title'   => 'required|string|max:255',
        ]);
        
        DB::beginTransaction();
        try {
            $packages = new ListPackage;
            $packages->title = $request->title;
            $packages->description= $request->description;
            // $packages->recommanded= $request->recommanded;
            $packages->nilai_mtk= $request->nilai_mtk;
            $packages->nilai_fisika= $request->nilai_fisika;
            $packages->nilai_kimia= $request->nilai_kimia;
            $packages->nilai_biologi= $request->nilai_biologi;
            $packages->nilai_sosiologi= $request->nilai_sosiologi;
            $packages->nilai_ekonomi= $request->nilai_ekonomi;
            $packages->nilai_sejarah= $request->nilai_sejarah;
            $packages->nilai_geografi= $request->nilai_geografi;
            $packages->maximum= $request->maximum;
            $packages->date_open= $request->date_open;
            $packages->date_expired= $request->date_expired;
            $packages->time_open= $request->time_open;
            $packages->save();

            $package_number = DB::table('list_packages')->orderBy('package_number','DESC')->select('package_number')->first();

            $package_number = $package_number->package_number;

            foreach($request->study as $key => $studies)
            {
                $packagesStudies['study']            = $studies;
                $packagesStudies['type']             = $request->type[$key];
                $packagesStudies['package_number']          = $package_number;

                PackagesStudy::create($packagesStudies);
            }
            DB::commit();

            return redirect()
                ->route('paket.paket-pelajaran.index')
                ->with('success', __('menu.general.success'));
        } catch (\Throwable $exception) {
            return back()->with('error', $exception->getMessage());
        }
    }

    public function edit($package_number): View
    {
        $packages          = DB::table('list_packages') ->where('package_number',$package_number)->first();
        $packagesJoin = ListPackage::with('studies')
            ->join('packages_studies', 'list_packages.package_number', '=', 'packages_studies.package_number')
            ->select('list_packages.*', 'packages_studies.*')
            ->where('packages_studies.package_number',$package_number)
            ->get();
        $study = DB::table('pelajarans')->get();
        // dd($study);
        
            // dd($packagesJoin[]);
        return view('pages.paket.edit',compact('packages','packagesJoin'), ['studies' => $study]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function update(Request $request): RedirectResponse
    {        
        DB::beginTransaction();
        
        try {           
            $update = [
                'id'                => $request->id,
                'title'            => $request->title,
                'description'           => $request->description,
                'nilai_mtk'           => $request->nilai_mtk,
                'nilai_fisika'           => $request->nilai_fisika,
                'nilai_kimia'           => $request->nilai_kimia,
                'nilai_biologi'           => $request->nilai_biologi,
                'nilai_sosiologi'           => $request->nilai_sosiologi,
                'nilai_ekonomi'           => $request->nilai_ekonomi,
                'nilai_sejarah'           => $request->nilai_sejarah,
                'nilai_geografi'           => $request->nilai_geografi,
                'maximum'           => $request->maximum,
                'date_open'           => $request->date_open,
                'date_expired'           => $request->date_expired,
                'time_open'           => $request->time_open,
            ];
            ListPackage::where('id',$request->id)->update($update);
            
                DB::table('packages_studies')->where('package_number', $request->package_number)->delete();
            // }

            /** insert new record */
            foreach($request->study as $key => $studies)
            {
                $packagesStudies['study']            = $studies;
                $packagesStudies['type']            = $request->type[$key];
                $packagesStudies['package_number']          = $request->package_number;

                // dd($packagesStudies);
                PackagesStudy::create($packagesStudies);
            }
           
            DB::commit();

            return redirect()
                ->route('paket.paket-pelajaran.index')
                ->with('success', __('menu.general.success'));
        } catch (\Throwable $exception) {
            return back()->with('error', $exception->getMessage());
        }
    }

    /**
     * Store a newly created resource in storage.
     * 
     * @param Request $request
     * @return RedirectResponse
     */
    public function storePick(Request $request): RedirectResponse
    {
        DB::beginTransaction();
        
        try {
            $package_number = $request->package_number;
            $user = auth()->user()->id;
            $checkPick          = Pick::where(['user_id'=> $user, 'status'=> 1])->first(); 
            $checkAdmin          = auth()->user()->role == 'admin'; 
            $checkSumPicks          = Pick::where(['package_number'=> $package_number])->count(); 
            $checkMaxPick         = ListPackage::where(['package_number'=> $package_number])->first(); 
            // dd($checkMaxPick->maximum);

            if($checkAdmin){
                return back()->with('error', 'Admin tidak bisa memilih paket tersebut!');
            }elseif (!$checkPick && !$checkAdmin && $checkSumPicks != $checkMaxPick->maximum) {
                $pick = new Pick;
                $pick->package_number = $request->package_number;
                $pick->user_id= $request->user_id;
                $pick->status= 1;
                $pick->save();
            }elseif ($checkPick && !$checkAdmin) {
                return back()->with('error', 'Anda sudah memilih paket tersebut!');
            }elseif ($checkSumPicks == $checkMaxPick->maximum) {
                return back()->with('error', 'Kuota sudah penuh!');
            }
            
            DB::commit();

            return redirect()
                ->route('paket.paket-pelajaran.index')
                ->with('success', __('menu.general.success'));
        } catch (\Throwable $exception) {
            return back()->with('error', $exception->getMessage());
        }
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function destroyPick(Request $request): RedirectResponse
    {
        // dd($package);    
        DB::beginTransaction();
        
        try {       
            $user = auth()->user()->id;
            DB::table('picks')->where(['package_number' => $request->package_number, 'user_id' => $user])->delete();
           
            DB::commit();

            return back()->with('success', __('menu.general.success'));
        } catch (\Throwable $exception) {
            return back()->with('error', $exception->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function destroyPackage(Request $request): RedirectResponse
    {
        // dd($package);    
        DB::beginTransaction();
        
        try {           
            $update = [
                'status'                => 0,
            ];
            ListPackage::where('id',$request->id)->update($update);
           
            DB::commit();

            return back()->with('success', __('menu.general.success'));
        } catch (\Throwable $exception) {
            return back()->with('error', $exception->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     */
    public function destroyPicksAll(): RedirectResponse
    {
        try {
            DB::table('picks')->truncate();

            return back()->with('success', __('menu.general.success'));
        } catch (\Throwable $exception) {
            return back()->with('error', $exception->getMessage());
        }
    }
}