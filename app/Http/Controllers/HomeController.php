<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Charts;
use App\User;
use DB;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      $chart = Charts::new('pie', 'highcharts')
           ->setTitle('My nice chart')
           ->setLabels(['First', 'Second', 'Third'])
           ->setValues([5,10,20]);
      $a = User::count();
      $orders_this_month = User::where( DB::raw('MONTH(created_at)'), '=', date('n') )->count();
      // dd($orders_this_month);
      $chart2 = Charts::database(User::all(),'line', 'highcharts')
           ->setData(User::all())
           ->setLabels(['Mês', 'Anterior', 'Third'])
           ->setValues([
               $a,
               $orders_this_month,
               20
             ]);;

        return view('home', compact('chart','chart2'));
    }
}
