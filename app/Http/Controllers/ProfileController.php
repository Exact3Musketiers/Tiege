<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\User $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $profile)
    {
        if ($profile->getKey() !== Auth::user()->id)
        {
            abort(403);
        }

        return view('profile.edit', compact('profile'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $profile)
    {
        if ($profile->getKey() !== Auth::user()->id)
        {
            abort(403);
        }

        // dd($request);

        $validated = $request->validate([
            'steamid' => ['required', 'min:3', 'max:255'],
        ]);
// dd($profile, $validated);

        $profile->update($validated);
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

        $profile->destroy();
        return view('auth.login');
    }

}
