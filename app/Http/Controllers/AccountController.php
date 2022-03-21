<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Services\AccountService;
use App\Services\Company\CompanyService;
use App\Services\Person\PersonService;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;
use App\Models\Account;
use App\Models\Person;

class AccountController extends Controller
{
    private $account;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(Account $account)
    {
        $this->account = $account;
    }

    public function index(Request $request)
    {
        return $this->account->paginate(50);
    }

    public function show($uuid)
    {
        return $this->account->uuid($uuid);
    }

    public function store(Request $request)
    {
        if ($request['person_id']) {
            $person = (new Person)->find($request['person_id']);
            if (!$person) {
                return response()->json(['error' => 'Invalid person!'], 401);
            }
        } else {
            $request['person_uuid'] = (string) Str::uuid();
            $this->validate($request, (new Person)->rules);
            $request['person_id'] = (new Person)->create($request->all())->id;
        }

        $request['account_uuid'] = (string) Str::uuid();
        $this->validate($request, $this->account->rules);
        return $this->account->create($request->all());
    }

    public function update($uuid, Request $request)
    {
        $account = $this->account->uuid($uuid);

        if ($account) {
            try {
                $person = (new Person)->find($account->person_id);
                $person->update($request->all());
                $account->update($request->all());
                return response()->json(['account' => $account, 'person' => $person]);
            } catch (\Throwable $th) {
                throw $th;
            }
        }

        return response()->json(['error' => 'Account not found!'], 401);
    }

    public function block($uuid, Request $request)
    {
        $account_id = $this->account->uuid($uuid)->first()->id;

        if (!$account_id) {
            return response()->json(['error' => 'Invalid account!'], 401);
        }

        $account = $this->account->find($account_id);
        try {
            $updated_id = $account->update(['blocked_at' => Carbon::now()]);
            return response()->json(['msg' => "Account #$updated_id blocked!"], 200);
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()], 401);
        }
    }

    public function unblock($uuid, Request $request)
    {
        $account_id = $this->account->uuid($uuid)->first()->id;

        if (!$account_id) {
            return response()->json(['error' => 'Invalid account!'], 401);
        }

        $account = $this->account->find($account_id);
        try {
            $updated_id = $account->update(['blocked_at' => null]);
            return response()->json(['msg' => "Account #$updated_id unblocked!"], 200);
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()], 401);
        }
    }


    public function storeCompany(Request $request)
    {

        if ($request['person_id']) {

            $person = (new Person)->find($request['person_id']);

            if (!$person) {
                return response()->json(['error' => 'Invalid person!'], 401);
            }

        } else {
            $request['uuid'] = (string) Str::uuid();

//          $this->validate($request, (new Person)->rules);

            //grava a pessoa através do service
            $savePerson = PersonService::store($request->input('person'));

            $request['person_id'] = $savePerson->id;

            //grava a empresa através do service
            $saveCompany = CompanyService::saveCompany($request->input('company'), $savePerson);

            $request['company_id'] = $saveCompany->id;

        }

        $request['account_uuid'] = (string) Str::uuid();

        $this->validate($request, $this->account->rules);
    }


    public function getList(Request $request)
    {
	$accountService = new AccountService();

	$accountList = $accountService->getList(
		$request->order_by,
		$request->sort_by,
		$request->limit
	);

	try {
            return response()->json(['data' => $accountList], 200);
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()], 401);
        }
    }
}
