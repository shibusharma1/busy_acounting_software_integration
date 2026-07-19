<?php

namespace App\Http\Controllers;

use App\Services\BusyService;
use Illuminate\Http\Request;

class BusyAccountController extends Controller
{
    public function create()
    {
        return view('busy.account');
    }

    public function store(Request $request, BusyService $busy)
    {
        $request->validate([
            'name' => 'required',
            'mobile' => 'required',
        ]);

        //  Build XML
        $xml = '<Account><Name>' . $request->name . '</Name><Alias>' . $request->name . '</Alias><PrintName>' . $request->name . '</PrintName><ParentGroup>Sundry Debtors</ParentGroup><BillByBillBalancing>True</BillByBillBalancing><Address><Address1>' . $request->address1 . '</Address1><Address2>' . $request->address2 . '</Address2><Mobile>' . $request->mobile . '</Mobile><WhatsAppNo>' . $request->whatsapp . '</WhatsAppNo><ITPAN>' . $request->pan . '</ITPAN><GSTNo>' . $request->gst . '</GSTNo><CountryName>India</CountryName><StateName>' . $request->state . '</StateName><AreaName>---Others---</AreaName><AccNo>' . $request->acc_no . '</AccNo><C3>' . $request->ifsc . '</C3><C4>' . $request->bank . '</C4><C5>' . $request->branch . '</C5></Address><SupplierType>1</SupplierType><PriceLevel>@</PriceLevel><PriceLevelForPurc>@</PriceLevelForPurc><TaxType>Others</TaxType><TypeOfDealerGST>Registered</TypeOfDealerGST><ChequePrintName>' . $request->name . '</ChequePrintName><ReverseChargeType>Not Applicable</ReverseChargeType><InputType>Section 17(5)-ITC None</InputType></Account>';

        $response = $busy->sendRequest($xml);

        return back()->with(
            'response',
            "Result: " . ($response['result'] ?? 'N/A') .
                " | " . ($response['description'] ?? 'No description') .
                " | Body: " . $response['body']
        );
    }
}
