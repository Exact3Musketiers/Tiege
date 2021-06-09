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

        //https://free.currencyconverterapi.com/
        $currencies = json_decode($this->fetchCurrencies()->body());

        return view('currency.index', compact('result', 'from', 'to', 'amount', 'currencies'));
    }

    public function fetchCurrencies(): \Illuminate\Http\Client\Response
    {
        return Http::get('https://free.currconv.com/api/v7/currencies', [
            'apiKey' => config('services.currency.key'),
        ]);
    }

    public function fetch(Request $request)
    {
        $validated = $request->validateWithBag('form-feedback', [
            'amount' => ['numeric', 'required'],
            'from' => ['string', 'required', 'max:256'],
            'to' => ['string', 'required', 'max:256'],
        ]);

        $amount = $request->input('amount');
        $from = $request->input('from');
        $to = $request->input('to');
        $fromto = $from . '_' . $to;

        //https://free.currencyconverterapi.com/
        $convertResponse = Http::get('https://free.currconv.com/api/v7/convert', [
            'apiKey' => 'f0cb65cb861fcca63810',
            'q' => $fromto,
            'compact' => 'y'
        ]);

        $currencies = json_decode($this->fetchCurrencies()->body());
        $convert = json_decode($convertResponse->body());

        $convertedValue = $convert->$fromto->val * $amount;
        // dd($currencies->results->$from);
        if (property_exists($currencies->results->$to, 'currencySymbol')) {
            $currencySymbol = $currencies->results->$to->currencySymbol;
        } else {
            $currencySymbol = 'Buckerinos ';
        }


        $result = $currencySymbol . round($convertedValue, 4);
        return view('currency.index', compact('result', 'from', 'to', 'amount', 'currencies'));
    }
}
