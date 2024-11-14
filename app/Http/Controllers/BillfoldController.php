<?php

namespace App\Http\Controllers;

use App\Models\Bill;
use App\Models\Billfold;
use DateTime;
use Illuminate\Http\Request;
use Mockery\Exception;

class BillfoldController extends Controller
{

    public function saveBillfold(Request $request)
    {
        $message = "";

        if (date($request->emission_at) > date($request->expiration_at)) $message = "La fecha de emisión no puede ser mayor a la fecha de expiración.";

        $tempBill = new Billfold();
        $tempBill['name'] = $request->get('name');
        $tempBill['discount_date'] = $request->get('discount_date');
        $tempBill['user_id'] = 1;
        $tempBill->save();

        return redirect('/billfolds');
        //return $billList;
    }

    public function listBillfold()
    {
        $userId = $this->validateSession();
        if ($userId == '') return redirect()->route('loginView');
        $data = Billfold::where('user_id', $userId)->get();

        return view('billfold.list', compact('data'));
    }

    public function calculateBills($billfoldId, Request $request)
    {
        $result = "";
        $data = [];

        $billfold = Billfold::find($billfoldId);

        $billFoldDate = $billfold['discount_date'];

        //$billFoldDate = "2022-05-25";

        $totalTCEA = 0;
        $count = 0;
        $bills = Bill::where('billfold_id', $billfoldId)->get();
        $netValue = 0;
        for ($i = 0; $i < count($bills); $i++) {
            $tea = $this->convertToTea($bills[$i]);
            $days = $this->diffDays($billFoldDate, $bills[$i]['expiration_at']);
            $amountAndOtherCosts = $bills[$i]['amount'] - $bills[$i]['other_costs'];
            $discount = $amountAndOtherCosts * (1-1/pow(1+$tea, ($days/360)));
//            $netDiscount = $bills[$i]['amount']  - $discount;
            $netDiscount = $amountAndOtherCosts /  pow(1+$tea, ($days/360));

            $tcea = $netDiscount != 0 ? (pow($bills[$i]['amount'] / $netDiscount, 360 / $days) - 1) : 1;
            $totalTCEA = $totalTCEA + ($tcea);

            //$row = [$bills[$i]['amount'], $this->convertToTea($bills[$i]), $discount, $netDiscount, $tcea, $days];
            $row = [
                "amount" => $bills[$i]['amount'],
                "other_costs" => $bills[$i]['other_costs'],
                "tea" => number_format($this->convertToTea($bills[$i]),2) ,
                "discount" => number_format($discount,2),
                "netDiscount" => number_format($netDiscount,2),
                "tcea" => number_format($tcea * 100, 2),
                "days" => $days,
                "discount_date" => substr($billFoldDate,0,10),
                "expiration_at" => substr($bills[$i]['expiration_at'],0,10),
            ];
            $data[] = $row;
            $netValue += $netDiscount;
            $count +=1;
        }

        $matrix = ["data" => $data, "tcea" => number_format(($totalTCEA / $count) * 100,2), "netValue" => number_format($netValue,2), "billfold" => $billfold];

        return view('billfold.calculate', compact('matrix'));
        //return json_encode($matrix);
        //return $result;
        //return $billList;
    }

    public function diffDays($start, $end)
    {
        $startDate = new DateTime($start);
        $endDate = new DateTime($end);

        $diferencia = $startDate->diff($endDate);

        if ($diferencia->invert) return -1;

        return $diferencia->days;
    }

    public function convertToTea($facture){

        $n = $facture['interest_frequency'];
        $m = $facture['interest_capitalization'];
        $rate = $facture['interest_rate'] / 100;

        // Convertir la tasa según el tipo de tasa
        if ($facture['interest_type'] == 1) {
            // Convierte la tasa efectiva a TEA
            $TEA = pow(1 + $rate, $n) - 1;
        } elseif ($facture['interest_type'] == 2) {
            // Convierte la tasa nominal a TEA
            $TEA = pow(1 + ($rate * ($n / $m)), ($m)) - 1;
        } else {
            throw new Exception("Tipo de tasa inválido. Debe ser 'efectiva' o 'nominal'.");
        }

        return $TEA;
    }

    public function destroy($id)
    {
        try {
            $item = Billfold::findOrFail($id); // Encuentra el ítem por ID
            $item->delete(); // Elimina el ítem
            return redirect()->back()->with('message', 'Cartera eliminada correctamente.');
        } catch (Exception $e){
            return redirect()->back()->with('message', 'Error.');
        }

    }


}
