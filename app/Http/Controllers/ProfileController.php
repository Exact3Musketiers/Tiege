<?php

namespace App\Http\Controllers;

use App\Models\SteamReview;
use App\Models\User;
use App\Services\Weather;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class ProfileController extends Controller
{
    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\User $user
     * @return \Illuminate\View\View
     */
    public function edit(User $profile)
    {
        if ($profile->getKey() !== Auth::user()->id) {
            abort(403);
        }

        $countries = collect(json_decode(file_get_contents('files/countries.json'), true));

        return view('profile.edit', ['profile' => $profile, 'countries' => $countries]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, User $profile)
    {
        if ($profile->getKey() !== Auth::user()->id) {
            abort(403);
        }

        $countries = collect(json_decode(file_get_contents('files/countries.json'), true))
            ->pluck('short_name');

        $validated = $request->validate([
            'steamid' => ['sometimes', 'nullable', 'min:3', 'max:255'],
            'country' => ['sometimes', 'nullable', 'required_with:city', 'min:2', 'max:2', Rule::in($countries)],
            'city' => ['sometimes', 'nullable', 'required_with:country', 'min:3', 'max:255'],
        ]);
        
        $location = ucfirst(strtolower($validated['city'])) .','. $validated['country'];

        unset($validated['city'], $validated['country']);

        $weather =  Weather::apiGet($location);
        if ($weather->status() !== 200) {
            throw ValidationException::withMessages(['city' => 'The given country or city does not exist or another problem has occurred.']);
        }

        $profile->update($validated + ['location' => $location]);
        Cache::forget('weather.' . $profile->getKey());
        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $profile)
    {
        if ($profile->getKey() !== Auth::user()->id)
        {
            abort(403);
        }

        SteamReview::whereUserId($profile->getKey())->delete();
        $profile->delete();
        return view('auth.login');
    }

}
