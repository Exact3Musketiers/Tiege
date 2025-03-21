@extends('layouts.app')

@section('content')
<div class="container" >
    <div class="mx-auto">
        <div class="content-box">
           <h1>Privacy policy</h1>
           <h2>Steam</h2>
           <p>
               Wij maken gebruik van de steam api voor het weergeven van publiekelijk toegankelijke data.
               Wij hebben alleen toegang tot publieke data. Van de data die we binnenkrijgen slaan we alleen
               data op wanneer dit wordt uitgevoerd door de gebruiker. De gebruiker kan dit alleen doen voor
               data die aan hun account is gekoppeld.
           </p>
           <p>
               De data die we opslaan is het volgende:
           </p>
           <ul>
               <li>Het id van de game die wordt gereviewd</li>
               <li>de naam van de game die wordt gereviewd</li>
               <li>En het aantal uren gespeeld door de gebruiker in de game die wordt gereviewd</li>
           </ul>
           <p>
               Wij hebben niets te maken met Valve of Steam.
           </p>
           <p>
               Als er op wat voor manier dan ook overtreding wordt gemaakt van de Valve of Steam terms of use
               zal dat aan Valve worden geraporteerd.
           </p>
        </div>
    </div>
</div>
@endsection
