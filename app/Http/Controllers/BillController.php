<?php

namespace App\Http\Controllers;

use App\Models\Bill;
use App\Models\Billfold;
use DateTime;
use Illuminate\Http\Request;
use Mockery\Exception;
use Psy\Exception\ErrorException;

class BillController extends Controller
{
    public function showBills($billfoldId)
    {
        $frequencies = [
            '1' => 'Anual',
            '2' => 'Semestral',
            '3' => 'Cuatrimestral',
            '4' => 'Trimestral',
            '6' => 'Bimestral',
            '12' => 'Mensual',
            '24' => 'Quincenal',
            '52' => 'Semanal',
            '360' => 'Diario',
        ];
        // Obtén las facturas desde la base de datos
        $bills = Bill::all()->where('billfold_id',$billfoldId)->all(); // Ajusta esto si necesitas filtros específicos
        $billfold = Billfold::find($billfoldId);

        foreach ($bills as $bill) {
            $bill->interest_type = $bill->interest_type == 1 ? 'Efectiva' : 'Nominal';
            $bill->interest_frequency = $frequencies[(string)$bill->interest_frequency];
            $bill->interest_capitalization = $frequencies[(string)$bill->interest_capitalization] ?? 'N/A';
        }

        $data = ['bills'=>$bills, "billfold"=>$billfold];
        return view('bills.list', compact('data'));
    }





    public function saveBill(Request $request)
    {
        $message = "";

        $billfold = Billfold::find($request->get('billfold_id'));

        if ($billfold == null) $message = "No existe el billfold";

        if (date($request->emission_at) > date($request->expiration_at)) $message = "La fecha de emisión no puede ser mayor a la fecha de vencimiento.";

        if ( date($request->emission_at > date($billfold->discount_date))) $message = "La fecha de emision no puede ser mayor a la fecha de descuento de la cartera: ".$billfold->discount_date;
        if ( date(date($billfold->discount_date) > $request->expiration_at)) $message = "La fecha de vencimiento no puede ser menor a la fecha de descuento de la cartera: ".$billfold->discount_date;

        if ($message!= "") return redirect()->back()->with('error', $message)->withInput();

        try {
            $tempBill = new Bill;
            $tempBill['amount'] = $request->get('amount');
            $tempBill['emission_at'] = $request->get('emission_at');
            $tempBill['expiration_at'] = $request->get('expiration_at');
            $tempBill['interest_rate'] = $request->get('interest_rate');
            $tempBill['interest_type'] = $request->get('interest_type');
            $tempBill['interest_frequency'] = $request->get('interest_frequency');
            $tempBill['interest_capitalization'] = $request->get('interest_type') == 2 ? $request->get('interest_capitalization'): null;
            $tempBill['billfold_id'] = $billfold['id'];
            $tempBill['other_costs'] = $request->get('other_costs') ?? 0;
            $tempBill->save();

            return redirect(route('showBills', $tempBill['billfold_id']));
        } catch (\PDOException $e){
            return redirect()->back()->with('error', 'No se ha podido agregar la Letra / Factura. Por favor valide los datos ingresados.')->withInput();
        }


        //return $billList;
    }
}
