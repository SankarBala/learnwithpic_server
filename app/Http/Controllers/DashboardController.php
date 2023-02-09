<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use App\Models\Visitor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use stdClass;

class DashboardController extends Controller
{
    public function posts()
    {
        // $count = Post::selectRaw('count(*) as count, status')
        //     ->groupBy('status')
        //     ->pluck('count', 'status');
        $count = Post::selectRaw('count(*) as count, status')
            ->groupBy('status')->orderBy('count', 'desc')
            ->get();

        return response()->json(['postCounter' => $count], 200);
    }


    public function users()
    {
        $roles = User::selectRaw('count(*) as count, roles.name as role')
            ->join('model_has_roles', 'users.id', '=', 'model_has_roles.role_id')
            ->join('roles', 'roles.id', '=', 'model_has_roles.role_id')
            ->groupBy('roles.name')
            ->whereIn('roles.name', ['admin', 'writer', 'author'])
            ->get();

        return response()->json(['userRoles' => $roles], 200);
    }

    public function visitors()
    {
        $visitors = Visitor::all();

        $total = $visitors;
        $thisMonth = $visitors->filter(function ($visit) {
            return $visit->created_at->isCurrentMonth();
        });
        $thisWeek =   $thisMonth->filter(function ($visit) {
            return $visit->created_at->isCurrentWeek();
        });
        $today =  $thisWeek->filter(function ($visit) {
            return $visit->created_at->isToday();
        });

        $visit = [
            // ['period' => 'Total', 'count' => $total->count()],
            ['period' => 'This Month', 'count' => $thisMonth->count()],
            ['period' => 'This Week', 'count' => $thisWeek->count()],
            ['period' => 'Today', 'count' => $today->count()],
        ];

        return response()->json(['visitorCounter' => $visit, 'total' => $total->count()], 200);
    }

    public function traffic_chart(Request $request)
    {
        $visitors =  Visitor::select(['id', 'location', 'created_at'])->orderBy('created_at', 'asc')->get();

        $flattenedData = $visitors->map(function ($item) {
            // return array_merge($item->toArray(), collect($item['location'])->toArray());
            return array_merge($item->toArray(), collect($item['location'] !== false ? $item['location'] :  [])->toArray());
        })->map(function ($item) {
            unset($item['location']);
            return $item;
        });

        return response()->json(['visitors' => $flattenedData], 200);
    }
}
