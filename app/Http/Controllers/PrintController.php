<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ListPackage;
use PDF;
use Illuminate\Support\Carbon;
use DB;

class PrintController extends Controller
{
    public function printPDF(Request $request)
    {
        $dateNow = Carbon::now();
        $packagesJoin = ListPackage::with('studies')
            ->join('packages_studies', 'list_packages.package_number', '=', 'packages_studies.package_number')
            ->select('list_packages.*', 'packages_studies.*')
            ->get();
            
        // $data = [
        //     'title' => 'Unduh KRS',
        //     'data' => ListPackage::with('studies')->where(['package_number' => $request->package_number]),
        // ];

        $pdf = PDF::loadView('pdf_view',compact('packagesJoin'), [
            'title' => 'Unduh KRS',
            'date' => $dateNow,
            'data' => ListPackage::with('studies')->where(['package_number' => $request->package_number])->render($request->search),
        ]);
    
        return $pdf->stream('document.pdf');
    }
    public function reportPDF(Request $request)
    {
        $checkPicks = DB::table('picks')->first();
        $packagesJoin = ListPackage::join('picks', 'list_packages.package_number', '=', 'picks.package_number')
            ->join('users', 'users.id', '=', 'picks.user_id')
            ->select('users.*', 'picks.*', 'list_packages.*')
            ->get();
            
        // $data = [
        //     'title' => 'Unduh KRS',
        //     'data' => ListPackage::with('studies')->where(['package_number' => $request->package_number]),
        // ];

        if($checkPicks){
            $pdf = PDF::loadView('report_view',compact('packagesJoin'), [
                'title' => 'Unduh Rekap',
                'data' => ListPackage::where(['package_number' => $checkPicks->package_number])->render($request->search),
            ]);
        }else{
            $pdf = PDF::loadView('report_view',compact('packagesJoin'), [
                'title' => 'Unduh Rekap',
                // 'data' => ListPackage::where(['package_number' => $checkPicks->package_number])->render($request->search),
            ]);
        }
    
        return $pdf->stream('daftar_paket_pick.pdf');
    }
}