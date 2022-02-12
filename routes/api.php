<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Collection;

// Define custom classes
use App\Models\Upcoming;
use App\Models\Today;
use App\Http\Resources\UpcomingTaskResource;
use App\Http\Resources\TodayTaskResource;

use Illuminate\Support\Facades\DB;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

/* I.  Upcoming tasks */

// 1. READ
// 1.1.  Get all the upcoming task
Route::get('/upcoming', function(){
    $upcomingData = Upcoming::all();      

    return UpcomingTaskResource::collection($upcomingData);   
});

// 1.2. Get task by ID
Route::get('upcoming/searchbyid', function(Request $request){
    $searchTaskId =  $request->query->get('taskId');

    $query = DB::table('upcomings')->where('taskId', $searchTaskId)->get();
    $matchedItems = count($query);

    $results = array();

    if ( 1 === $matchedItems ){
        $results[] = (object) array(
            'id'            => $query[0]->id,
            'taskId'        => $query[0]->taskId,
            'title'         => $query[0]->title,
            'completed'     => $query[0]->completed ? true : false,
            'approved'      => $query[0]->approved ? true : false,
            'waiting'       => $query[0]->waiting ? true : false,
        );

        //return UpcomingTaskResource::collection($result);
    } else if(1 < $matchedItems){      

        foreach ($query as $item){
            $results[] = (object) array(
                'id'            => $item->id,
                'taskId'        => $item->taskId,
                'title'         => $item->title,
                'completed'     => $item->completed ? true : false,
                'approved'      => $item->approved ? true : false,
                'waiting'       => $item->waiting ? true : false,
            );
        }
        
    } else {
        $results[] = $query;
    }    

    // return UpcomingTaskResource::collection($results);
    return collect(['data'=> $results]);
    //return $results; // Merely OK
});

// 1.3. Get task by title
Route::get('upcoming/searchbytitle', function(Request $request){
    $searchTitle =  $request->query->get('title');

    $query = DB::table('upcomings')->where('title', 'LIKE', '%'.$searchTitle.'%')->get();
    $matchedItems = count($query);
    
    $results = array();

    if ( 1 === $matchedItems ){
        $results[] = (object) array(
            'id'            => $query[0]->id,
            'taskId'        => $query[0]->taskId,
            'title'         => $query[0]->title,
            'completed'     => $query[0]->completed ? true : false,
            'approved'      => $query[0]->approved ? true : false,
            'waiting'       => $query[0]->waiting ? true : false,
        );

        
    } else if ( 1 < $matchedItems){
        

        foreach ($query as $item){
            $results[] = (object) array(
                'id'            => $item->id,
                'taskId'        => $item->taskId,
                'title'         => $item->title,
                'completed'     => $item->completed ? true : false,
                'approved'      => $item->approved ? true : false,
                'waiting'       => $item->waiting ? true : false,
            );
        }
        
    } else {
        $results[] = $query;
    }

    //dd($results);
    
    // return UpcomingTaskResource::collection($results);    
    // return $results; // Merely OK
    return collect(['data' => $results]);
});


// 2. CREATE
// 2.1. Add a new task
Route::post('/upcoming', function(Request $request){
    //dd($request);
    
    return Upcoming::create(
        array(
            'title'     => $request->title,
            'taskId'    => $request->taskId,
            'waiting'   => $request->waiting,
        )
    );
});

// 3. UPDATE 
Route::post('/upcoming/updatebyid/{taskId}', function(Request $request, $taskId){
    // taskId OK
    // request OK
    $updatedData = array(
        'title'         => $request->title,
        'completed'     => $request->completed,
        'approved'      => $request->approved,
        'waiting'       => $request->waiting,
    );  
        
    //$query = DB::table('upcomings')->where('taskId', $taskId);
    return Upcoming::where('taskId', $taskId)->update($updatedData);    
});

// 4. DELETE
// Delete the Upcoming task by ID
Route::delete('/upcoming/{taskId}', function($taskId){
    DB::table('upcomings')->where('taskId', $taskId)->delete();

    return 204;
});

/* II. Today tasks */

// Get
Route::get('/dailytask', function(){
    $todayTasks = Today::all();   

    return TodayTaskResource::collection($todayTasks);   
});

Route::get('dailytask/searchbyid', function(Request $request){
    $searchTaskId =  $request->query->get('taskId');

    $query = DB::table('todays')->where('taskId', $searchTaskId)->get();
    $matchedItems = count($query);

    $results = array();

    if ( 1 === $matchedItems ){
        $results[] = (object) array(
            'id'            => $query[0]->id,
            'taskId'        => $query[0]->taskId,
            'title'         => $query[0]->title,
            'completed'     => $query[0]->completed ? true : false,
            'approved'      => $query[0]->approved ? true : false,
            'waiting'       => $query[0]->waiting ? true : false,
        );

        //return UpcomingTaskResource::collection($result);
    } else if(1 < $matchedItems){      

        foreach ($query as $item){
            $results[] = (object) array(
                'id'            => $item->id,
                'taskId'        => $item->taskId,
                'title'         => $item->title,
                'completed'     => $item->completed ? true : false,
                'approved'      => $item->approved ? true : false,
                'waiting'       => $item->waiting ? true : false,
            );
        }
        
    } else {
        $results[] = $query;
    }    

    // return UpcomingTaskResource::collection($results);
    return collect(['data'=> $results]);
    //return $results; // Merely OK
});

// Create
Route::post('/dailytask', function(Request $request){
    /* return Today::create(
        array(
            'id'        => $request->id,
            'taskId'    => $request->taskId,
            'title'     => $request->title,            
        )
    ); */

    return Today::create(
        array(            
            'taskId'    => $request->taskId,
            'title'     => $request->title,            
        )
    );
});

// Update
Route::post('/dailytask/updatebyid/{taskId}', function(Request $request, $taskId){
    
    $updatedData = array(
        'title'         => $request->title,
        'completed'     => $request->completed,
        'approved'      => $request->approved,
        'waiting'       => $request->waiting,
    );      
        
    //$query = DB::table('upcomings')->where('taskId', $taskId);
    // Return > 0 - total matched rows
    return Today::where('taskId', $taskId)->update($updatedData);    
});

// Delete today task
Route::delete('/dailytask/{taskId}', function($taskId){
    DB::table('todays')->where('taskId', $taskId)->delete();

    return 204;
});

