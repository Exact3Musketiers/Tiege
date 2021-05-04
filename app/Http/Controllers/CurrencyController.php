<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\Currency;

class CurrencyController extends Controller
{
    public function index()
    {
        $result = $from = $to = $amount = '';
        return view('currency.index', compact('result', 'from', 'to', 'amount'));
    }

    public function fetch(Request $request)
    {
        $amount = $request->input('amount');
        $from = $request->input('from');
        $to = $request->input('to');
        $fromto = $from . '_' . $to;

        //https://free.currencyconverterapi.com/
        //TODO: use currencies for select form input or something
        $currenciesResponse = Http::get('https://free.currconv.com/api/v7/currencies', [
            'apiKey' => 'f0cb65cb861fcca63810',
        ]);

        $convertResponse = Http::get('https://free.currconv.com/api/v7/convert', [
            'apiKey' => 'f0cb65cb861fcca63810',
            'q' => $fromto,
            'compact' => 'y'
        ]);

        $currencies = json_decode($currenciesResponse->body());
        $convert = json_decode($convertResponse->body());

        $convertedValue = $convert->$fromto->val * $amount;
        $result = $currencies->results->$to->currencySymbol . round($convertedValue, 4);
        return view('currency.index', compact('result', 'from', 'to', 'amount'));
    }
}
