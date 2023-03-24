<?php

namespace App\Http\Controllers\Indicators\_2020;


use App\Http\Controllers\Controller;
use App\Models\Indicators\SingleParameter;


class ComgesController extends Controller
{
    //

    public function index()
    {
        include('comges/comgesglobal.php');
        return view('indicators.comges.2020.index', compact('comgesglobal'));
    }
    

    public function comges1corte1()
    {        
        /***********************************/
        /*********** COMGES1 ***************/
        /***********************************/
        include('comges/comges1.php');
        include('comges/comges1_1.php');
        include('comges/comges1_2.php');
        include('comges/comges1_3.php');
        return view('indicators.comges.2020.comges1corte1',compact('data1', 'data1_1','data1_2','data1_3'));
    }
   
    public function comges2corte1()
    {        
        /***********************************/
        /*********** COMGES2 ***************/
        /***********************************/
        include('comges/comges2.php');
        include('comges/comges2_1.php');
        include('comges/comges2_2.php');
        include('comges/comges2_3.php');
        include('comges/comges2_4.php');
        return view('indicators.comges.2020.comges2corte1',compact('data2', 'data2_1','data2_2','data2_3','data2_4'));
    }

    public function comges3corte1()
    {        
        /***********************************/
        /*********** COMGES3 ***************/
        /***********************************/
        include('comges/comges3.php');
        include('comges/comges3_1.php');
        include('comges/comges3_2.php');
        include('comges/comges3_3.php');
        include('comges/comges3_4.php');
        return view('indicators.comges.2020.comges3corte1',compact('data3', 'data3_1','data3_2','data3_3','data3_4'));
    }

    public function comges4corte1()
    {        
        /***********************************/
        /*********** COMGES4 CORTE 1*******/
        /***********************************/
        include('comges/comges4_1.php');
        include('comges/comges4_2.php');
        include('comges/comges4.php');
        return view('indicators.comges.2020.comges4corte1',compact('data4','data4_1','data4_2'));
    }

    public function comges5corte1()
    {        
        /***********************************/
        /*********** COMGES5 CORTE 1*******/
        /***********************************/
        include('comges/comges5_1.php');
        include('comges/comges5_2.php');
        include('comges/comges5.php');
        return view('indicators.comges.2020.comges5corte1',compact('data5','data5_1','data5_2'));
    }

    public function comges6corte1()
    {        
        /***********************************/
        /*********** COMGES6 CORTE 1*******/
        /***********************************/
        include('comges/comges6.php');
        include('comges/comges6_1.php');
        include('comges/comges6_2.php');
        return view('indicators.comges.2020.comges6corte1',compact('data6','data6_1','data6_2'));
    }

    public function comges7corte1()
    {        
        /***********************************/
        /*********** COMGES7 CORTE 1*******/
        /***********************************/
        include('comges/comges7_1.php');
        include('comges/comges7_2.php');
        include('comges/comges7_3.php');
        include('comges/comges7.php');
        return view('indicators.comges.2020.comges7corte1',compact('data7','data7_1','data7_2','data7_3'));
    }

    public function comges8corte1()
    {        
        /***********************************/
        /*********** COMGES8 CORTE 1*******/
        /***********************************/
        include('comges/comges8.php');
        include('comges/comges8_1.php');
        include('comges/comges8_2.php');
        return view('indicators.comges.2020.comges8corte1',compact('data8','data8_1','data8_2'));
    }

    public function comges9corte1()
    {        
        /***********************************/
        /*********** COMGES9 CORTE 1*******/
        /***********************************/
        include('comges/comges9_1.php');
        include('comges/comges9_2.php');
        include('comges/comges9.php');
        return view('indicators.comges.2020.comges9corte1',compact('data9','data9_1','data9_2'));
    }

    public function comges10corte1()
    {        
        /***********************************/
        /*********** COMGES10 CORTE 1*******/
        /***********************************/
        include('comges/comges10_1.php');
        include('comges/comges10_2.php');
        include('comges/comges10_3.php');
        include('comges/comges10_4.php');
        include('comges/comges10.php');
        return view('indicators.comges.2020.comges10corte1',compact('data10','data10_1','data10_2','data10_3','data10_4'));
    }


    public function comges11corte1()
    {        
        /***********************************/
        /*********** COMGES11 CORTE 1*******/
        /***********************************/
        include('comges/comges11_1.php');
        include('comges/comges11_2.php');
        include('comges/comges11_3.php');
        include('comges/comges11.php');
        return view('indicators.comges.2020.comges11corte1',compact('data11','data11_1','data11_2','data11_3'));
    }

    public function comges12corte1()
    {        
        /***********************************/
        /*********** COMGES12 CORTE 1*******/
        /***********************************/
        include('comges/comges12_1.php');
        include('comges/comges12_2.php');
        include('comges/comges12_3.php');
        include('comges/comges12.php');
        return view('indicators.comges.2020.comges12corte1',compact('data12','data12_1','data12_2','data12_3'));
    }

    public function comges13corte1()
    {        
        /***********************************/
        /*********** COMGES13 CORTE 1*******/
        /***********************************/
        include('comges/comges13_1.php');
        include('comges/comges13_2.php');
        include('comges/comges13_3.php');
        include('comges/comges13.php');
        return view('indicators.comges.2020.comges13corte1',compact('data13','data13_1','data13_2','data13_3'));
    }




    public function comges14corte1()
    {        
        /***********************************/
        /*********** COMGES14 CORTE 1*******/
        /***********************************/
        include('comges/comges14_1.php');
        include('comges/comges14.php');
        return view('indicators.comges.2020.comges14corte1',compact('data14','data14_1'));
    }

    public function comges15corte1()
    {        
        /***********************************/
        /*********** COMGES15 CORTE 1*******/
        /***********************************/
        include('comges/comges15_1.php');
        include('comges/comges15_2.php');
        include('comges/comges15_3.php');
        include('comges/comges15.php');
        return view('indicators.comges.2020.comges15corte1',compact('data15','data15_1','data15_2','data15_3'));
    }

    public function comges16corte1()
    {        
        /***********************************/
        /*********** COMGES16 CORTE 1*******/
        /***********************************/
        include('comges/comges16_1.php');
        include('comges/comges16.php');
        return view('indicators.comges.2020.comges16corte1',compact('data16','data16_1'));
    }

    public function comges17corte1()
    {        
        /***********************************/
        /*********** COMGES17 CORTE 1*******/
        /***********************************/
        include('comges/comges17_1.php');
        include('comges/comges17.php');
        return view('indicators.comges.2020.comges17corte1',compact('data17','data17_1'));
    }

    public function comges18corte1()
    {        
        /***********************************/
        /*********** COMGES18 CORTE 1*******/
        /***********************************/
        include('comges/comges18.php');
        return view('indicators.comges.2020.comges18corte1',compact('data18','data18_1'));
    }

    public function comges19corte1()
    {
        
        /***********************************/
        /*********** COMGES19 CORTE 1*******/
        /***********************************/
        include('comges/comges19.php');
        return view('indicators.comges.2020.comges19corte1',compact('data19','data19_1'));
    }

    public function comges21corte1()
    {
        
        /***********************************/
        /*********** COMGES21 CORTE 1*******/
        /***********************************/
        include('comges/comges21.php');
        return view('indicators.comges.2020.comges21corte1',compact('data21','data21_1', 'data21_2'));
    }


    public function comges22corte1()
    {
        
        /***********************************/
        /*********** COMGES22 CORTE 1*******/
        /***********************************/
        include('comges/comges22.php');
        return view('indicators.comges.2020.comges22corte1',compact('data22','data22_1', 'data22_2', 'data22_3'));
    }

    public function comges24corte1()
    {
        
        /***********************************/
        /*********** COMGES24 CORTE 1*******/
        /***********************************/
        include('comges/comges24.php');
        return view('indicators.comges.2020.comges24corte1',compact('data24','data24_1'));
    }


    public function comges25corte1()
    {
        
        /***********************************/
        /*********** COMGES25 CORTE 1*******/
        /***********************************/
        include('comges/comges25.php');        
        return view('indicators.comges.2020.comges25corte1',compact('data25','data25_1', 'data25_2'));
    }
}
