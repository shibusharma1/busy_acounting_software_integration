<?php

namespace App\Http\Controllers;

use App\Services\BusyService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class BusyController extends Controller
{

    public function create(BusyService $busy)
    {
        return view('busy.sale');
    }

    // public function store(Request $request, BusyService $busy)
    // {
    //     $request->validate([
    //         // 'customer' => 'required',
    //         'vch_no' => 'required',
    //         'date' => 'required|date',
    //         'item' => 'required',
    //         'qty' => 'required|numeric',
    //         'price' => 'required|numeric',
    //     ]);

    //     $date = date('d-m-Y', strtotime($request->date));
    //     $amount = $request->qty * $request->price;

    //     $xml = "<Sale>
    //     <VchSeriesName>Main</VchSeriesName>
    //     <Date>{$date}</Date>
    //     <VchType>9</VchType>
    //     <StockUpdationDate>{$date}</StockUpdationDate>
    //     <VchNo>{$request->vch_no}</VchNo>
    //     <STPTName>VAT/13%</STPTName>
    //     <MasterName1>Customer-Amit Gupta</MasterName1>
    //     <MasterName2>Main Store</MasterName2>
    //     <TranCurName>Rs.</TranCurName>
    //     <InputType>1</InputType>

    //     <ItemEntries>
    //         <ItemDetail>
    //             <Date>{$date}</Date>
    //             <VchType>9</VchType>
    //             <VchNo>{$request->vch_no}</VchNo>
    //             <SrNo>1</SrNo>
    //             <ItemName>{$request->item}</ItemName>
    //             <UnitName>Pcs.</UnitName>
    //             <Qty>{$request->qty}</Qty>
    //             <Price>{$request->price}</Price>
    //             <Amt>{$amount}</Amt>
    //         </ItemDetail>
    //     </ItemEntries>
    // </Sale>";

    //     $response = $busy->sendRequest($xml);

    //     return back()->with('response', $response['description'] ?? 'Done');
    // }
    public function store(Request $request, BusyService $busy)
    {
        $request->validate([
            'vch_no' => 'required',
            // 'date' => 'required|date',
            'item' => 'required',
            'qty' => 'required|numeric',
            'price' => 'required|numeric',
        ]);

        $date = date('d-m-Y', strtotime($request->date));
        // $date = 01-04-2026; // ✅ FIXED DATE FOR TESTING

        // ✅ YOUR FULL WORKING XML (NO CHANGE)
        $xml = '<Sale><VchSeriesName>Main</VchSeriesName><Date>' . $date . '</Date><VchType>9</VchType><StockUpdationDate>' . $date . '</StockUpdationDate><VchNo>' . $request->vch_no . '</VchNo><AutoVchNo>6</AutoVchNo><STPTName>VAT/13%</STPTName><MasterName1>Customer-Amit Gupta</MasterName1><MasterName2>Main Store</MasterName2><TranCurName>Rs.</TranCurName><InputType>1</InputType><BillingDetails><PartyName>Customer-Amit Gupta</PartyName><Address1>New Delhi</Address1><Address2>India</Address2><MobileNo>9992229989</MobileNo></BillingDetails><VchOtherInfoDetails><OFInfo/><Transport>Santosh Transport &amp; Company</Transport><Station>Dadri</Station><PurchaseBillNo>1/2026-27</PurchaseBillNo><PurchaseBillDate>' . $date . '</PurchaseBillDate><Narration1>NA-</Narration1><GrDate>' . $date . '</GrDate></VchOtherInfoDetails><ItemEntries><ItemDetail><Date>' . $date . '</Date><VchType>9</VchType><VchNo>' . $request->vch_no . '</VchNo><SrNo>1</SrNo><ItemName>' . $request->item . '</ItemName><UnitName>Pcs.</UnitName><AltUnitName>Pcs.</AltUnitName><ConFactor>1</ConFactor><Qty>' . $request->qty . '</Qty><QtyMainUnit>' . $request->qty . '</QtyMainUnit><QtyAltUnit>' . $request->qty . '</QtyAltUnit><ItemTaxCategory>GST 18%</ItemTaxCategory><Price>' . $request->price . '</Price><PriceAltUnit>' . $request->price . '</PriceAltUnit><ListPrice>' . $request->price . '</ListPrice><Amt>' . ($request->qty * $request->price) . '</Amt><NettAmount>0</NettAmount><CompoundDiscount>0.00</CompoundDiscount><STAmount>0</STAmount><STPercent>0</STPercent><TaxBeforeSurcharge1>0</TaxBeforeSurcharge1><STPercent1>0</STPercent1><TaxBeforeSurcharge>0</TaxBeforeSurcharge><MC>Main Store</MC><DiscountStructure>Simple Discount, % of Price</DiscountStructure></ItemDetail></ItemEntries></Sale>';

        $response = $busy->sendRequest($xml);

        // Log::info('BUSY API RESPONSE', [
        //     'result' => $response['result'],
        //     'description' => $response['description'],
        //     'body' => $response['raw'],
        //     // 'status' => $response['status'],
        // ]);


        \Log::info('BUSY REQUEST HEADER', [
            'xml_length' => strlen($xml),
        ]);

        // dd($response->headers(), $response->body());
        // return back()->with(
        //     'response',
        //     "Result: " . $response['result'] . " | " . $response->header('description') . " | Body: " . $response['body']
        // );
        return back()->with(
            'response',
            "Result: " . ($response['result'] ?? 'N/A') .
                " | " . ($response['description'] ?? 'No description') .
                " | Body: " . $response['body']
        );
    }
}
