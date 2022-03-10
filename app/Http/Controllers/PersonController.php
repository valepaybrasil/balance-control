<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\Person;

class PersonController extends Controller
{
    private $person;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(Person $person)
    {
        $this->person = $person;
    }

    public function index()
    {
        return $this->person->paginate(50);
    }

    public function show($person)
    {
        return $this->person->uuid($person);
    }

    public function store(Request $request)
    {
        $request['person_uuid'] = (string) Str::uuid();
        $this->validate($request, $this->person->rules);

        return $this->person->create($request->all());
    }

    public function update($person, Request $request)
    {
        $this->validate($request, $this->person->rules);

        $person = $this->person->find($person);

        return $person->update($request->all());
    }

}
