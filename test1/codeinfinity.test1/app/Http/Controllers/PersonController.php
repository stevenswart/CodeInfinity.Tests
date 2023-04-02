<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;

use App\Http\Requests\StorePersonRequest;
use App\Http\Requests\UpdatePersonRequest;
use App\Models\Person;
use Illuminate\Support\Facades\Validator;
use App\Rules\DOBNotInFuture;
use App\Rules\DOBMatchesID;
use App\Rules\ValidSAIDNumber;


class PersonController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('add-person');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $validated = $request->validate([
            'firstName' => ['required', 'regex:/^[^\p{N}()!@#$%^&*()_+\=\[\]{};:"\\|,.<>\/?]+$/'],
            'lastName' => ['required', 'regex:/^[^\p{N}()!@#$%^&*()_+\=\[\]{};:"\\|,.<>\/?]+$/'],
            'idNumber' => ['required',  'string', 'digits:13', 'unique:App\Models\Person,idNumber', new ValidSAIDNumber],
            'dob' => ['required', 'date_format:d/m/Y', new DOBNotInFuture, new DOBMatchesID($request->idNumber)]
            ], [
                'idNumber_dob_match' => 'ID Number does not match Date of Birth!',
        ]);

        $post = new Person;
        $post->firstName = $request->firstName;
        $post->lastName = $request->lastName;
        $post->idNumber = $request->idNumber;
        $post->dob = $request->dob;
        $post->save();

        return redirect('success')->with('status', 'Person has been added.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Person  $person
     * @return \Illuminate\Http\Response
     */
    public function show(Person $person)
    {
        return view('success');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Person  $person
     * @return \Illuminate\Http\Response
     */
    public function edit(Person $person)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdatePersonRequest  $request
     * @param  \App\Models\Person  $person
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatePersonRequest $request, Person $person)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Person  $person
     * @return \Illuminate\Http\Response
     */
    public function destroy(Person $person)
    {
        //
    }
}
