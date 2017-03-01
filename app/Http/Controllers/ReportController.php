<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use JasperPHP\JasperPHP, \Config;
use League\Flysystem\Exception;

class ReportController extends Controller
{
    public $conn;

    public function __construct()
    {
        $this->conn = \Config::get('database.connections.mysql');
    }

    public function showEntrysReport()
    {
        return view('report.entrysheets');
    }

    public function entrysReport(Request $request)
    {
        if($request->ajax())
        {
            $start = $request->start;
            $end = $request->end;

            $jasperPHP = new JasperPHP;
            $source = base_path() . '/storage/app/reports/entrysheets.jasper';
            $destination = base_path() . '/storage/app/reports/pdf/entrysheet/entrysheets';

            try
            {
                $jasperPHP->process(
                    $source ,
                    $destination,
                    array('pdf'),
                    array("dateBegin"=>$start, "dateEnd"=>$end),
                    $this->conn
                )->execute();

            }
            catch (\Exception $e)
            {
                return getResponse(500, 501);
            }

            return 200;
        }

    }

    public function showEntryReport($id)
    {
        return view('report.entrysheet')->with(['id'=>$id]);
    }

    public function entryReport(Request $request)
    {
        if($request->ajax())
        {
            $id = $request->id;

            $jasperPHP = new JasperPHP;
            $source = base_path() . '/storage/app/reports/entrysheet.jasper';
            $destination = base_path() . '/storage/app/reports/pdf/entrysheet/entrysheet_'.$id;

            try
            {
                $jasperPHP->process(
                    $source ,
                    $destination,
                    array('pdf'),
                    array('entrysheet_id'=>$id),
                    $this->conn
                )->execute();

            }
            catch (\Exception $e)
            {
                return getResponse(500, 501);
            }

            return 200;
        }

    }

}
