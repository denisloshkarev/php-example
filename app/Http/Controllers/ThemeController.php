<?php

namespace App\Http\Controllers;

use App\Filters\ThemesFilter;
use App\Http\Requests\Admin\FilterThemeRequest;
use App\Http\Requests\ShowThemeRequest;
use App\Http\Resources\Front\ThemeListResource;
use App\Http\Resources\Front\ThemeResource;
use App\Models\Themes\Theme;
use Illuminate\Database\Eloquent\Builder;

class ThemeController extends Controller
{

    public function index(FilterThemeRequest $request)
    {
        $query = $this->getFilteredQuery($request->validated());
        if(!is_null($query)) {
            $themes = $query->orderBy('sort', 'asc')->get();
            return response()->json(ThemeListResource::collection($themes));
        }
        return response()->json([]);
    }

    public function show(ShowThemeRequest $request, Theme $theme)
    {
        return response()->json(new ThemeResource($theme));
    }

    protected function getFilteredQuery($filter): ?Builder
    {
        $themesQuery = auth()->user()->getThemesQuery();
        if(!is_null($themesQuery)) {
            return (new ThemesFilter($themesQuery, $filter))->filter();
        }
        return null;
    }

}
