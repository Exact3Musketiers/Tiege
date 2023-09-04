
@extends('errors::minimal')

@if (Session::has('urlTampering'))
    @section('title', 'JIJ SMIEGT!!!')
    @section('code', '403')
    @section('message', 'Het aanpassen van het URL is ten strengste veboden. Je hebt 5 strafpunten gekregen')
@else

    @section('title', __('Forbidden'))
    @section('code', '403')
    @section('message', __($exception->getMessage() ?: 'Forbidden'))

@endif
