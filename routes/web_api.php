<?php

use App\Http\Resources\ImprestWarrant\AccountResource;
use App\Http\Resources\ImprestWarrant\ProjectResource;
use App\Http\Resources\ImprestWarrant\StaffResource;
use App\Http\Resources\UserResource;
use App\Models\Account;
use App\Models\Project;
use App\Models\Staff;
use App\Models\User;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'api'], function () {
    Route::get('accounts', fn() => AccountResource::collection(Account::get()));
    Route::get('projects', fn() => ProjectResource::collection(Project::get()));
    Route::get('staff', fn() => StaffResource::collection(Staff::get()));
    Route::get('users', fn() => UserResource::collection(User::get()));



    // warrant
    Route::get('/warrants/last-doc-number', function () {
        $lastDocNumber = \App\Models\Warrant::orderByDesc('id')->value('doc_number') ?? 'IW000';
        return response()->json(['lastDocNumber' => $lastDocNumber]);
    });
});
