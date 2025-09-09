<?php

namespace App\Http\Controllers\ImprestWarrant;

use App\Actions\Store\StoreAccountAction;
use App\Actions\Update\UpdateAccountAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\Store\StoreAccountRequest;
use App\Http\Requests\Update\UpdateAccountRequest;
use App\Http\Resources\ImprestWarrant\AccountResource;
use App\Models\Account;
use Inertia\Inertia;

class AccountController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $accounts = AccountResource::collection(Account::all());

        return Inertia::render('imprest_warrant/accounts', [
            'accounts' => $accounts,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreAccountRequest $request, StoreAccountAction $action)
    {
        $action->execute($request->validated());
    }

    /**
     * Display the specified resource.
     */
    public function show(Account $account)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateAccountRequest $request, Account $account, UpdateAccountAction $action)
    {
        $action->execute($request->validated(), $account);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Account $account)
    {
        $account->delete();
    }
}
