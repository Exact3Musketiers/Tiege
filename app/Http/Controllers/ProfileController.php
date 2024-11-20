<?php

namespace App\Http\Controllers;

use App\Models\SteamReview;
use App\Models\User;
use App\Services\Weather;
use File;
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

        $images = [];
        $bg_count = count(File::files(public_path('images/backgrounds')));
        for ($i=1; $i <= $bg_count; $i++) {
            $images[] = asset('images/backgrounds/'.$i.'.jpg');
        }

        return view('profile.edit', ['profile' => $profile, 'countries' => $countries, 'images' => $images]);
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
            'steamid' => ['sometimes', 'nullable', 'numeric', 'min:3'],
            'lastfm' => ['sometimes', 'nullable', 'string', 'min:3', 'max:255'],
            'name' => ['sometimes', 'required', 'max:255'],
            'country' => ['sometimes', 'nullable', 'required_with:city', 'string', 'min:2', 'max:2', Rule::in($countries)],
            'city' => ['sometimes', 'nullable', 'required_with:country', 'string', 'min:3', 'max:255'],
            'background_image' => ['sometimes', 'integer', 'max:255'],
            'email' => ['sometimes', 'required', 'string', 'email', 'max:255', Rule::unique(User::class)->ignore($profile->getKey())],
        ]);

        $return = $validated;

        if (array_key_exists('city', $validated) &&
            array_key_exists('country', $validated) &&
            !is_null($validated['city']) &&
            !is_null($validated['country'])
        ) {
            $location = ucfirst(strtolower($validated['city'])) .','. $validated['country'];
            unset($validated['city'], $validated['country']);

            $weather =  Weather::apiGet($location);
            if ($weather->status() !== 200) {
                throw ValidationException::withMessages(['city' => 'The given country or city does not exist or another problem has occurred.']);
            }

            $return += ['location' => $location];
        }

        if (array_key_exists('background_image', $validated)) {
            $background_image = $validated['background_image'];
            unset($validated['background_image']);

            if ((integer)$background_image === 0) {
                $background_image = null;
            } else {
                $background_image = asset('images/backgrounds/'.$background_image.'.jpg');
            }

            $return += ['background_image_path' => $background_image];
        }

        $profile->update($return);
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
