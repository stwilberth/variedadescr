<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\CclinemoveExecution;
use App\GSolutionsOC;
use App\Ccode;
use App\Http\Controllers\cchangeController;
use Illuminate\Http\Request;


class PruebaTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testBasicTest()
    {

        //$changed = [];
        $ccode_id = 664;
        $Ccode = Ccode::findOrFail($ccode_id);
        $total1 = 0;
        foreach ($Ccode->executed as $item) {
            if ($item->gsolutionsoc && ($item->gsolutionsoc->status_id == 7 || $item->gsolutionsoc->status_id == 5)){//  != $item->status_gs_id
                $total1 += $item->details->sum('amount');
            }
        }


        $statusIds = [5, 7];

        $total2 = $Ccode->ocsTotalAmount($statusIds);


        //dd($changed);
        dd($total1, $total2);

                        // $item->status_gs_id = $item->gsolutionsoc->status_id;
                // $item->save();
                //$changed[] = $item->id;


        //$excuted = CclinemoveExecution::findOrFail();


    }
}


