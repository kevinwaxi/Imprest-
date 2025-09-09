<?php

namespace App\Http\Controllers\ImprestWarrant;

use Inertia\Inertia;
use App\Models\Project;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Actions\Store\StoreProjectAction;
use App\Actions\Update\UpdateProjectAction;
use App\Http\Requests\Store\StoreProjectRequest;
use App\Http\Requests\Update\UpdateProjectRequest;
use App\Http\Resources\ImprestWarrant\ProjectResource;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $projects = ProjectResource::collection(Project::all());
        return Inertia::render('imprest_warrant/projects', [
            'projects' => $projects,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProjectRequest $request, StoreProjectAction $action)
    {
        $action->execute($request->validated());
    }

    /**
     * Display the specified resource.
     */
    public function show(Project $project)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProjectRequest $request, Project $project, UpdateProjectAction $action)
    {
        $action->execute($request->validated());
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Project $project)
    {
        $project->delete();
    }
}
