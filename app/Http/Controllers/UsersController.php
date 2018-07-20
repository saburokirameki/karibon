<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use App\Book;

class UsersController extends Controller
{
 /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::find($id);
        $count_have = $user->books()->count();
        $books = \DB::table('books')->join('book_user', 'books.id', '=', 'book_user.book_id')->select('books.*')->where('book_user.user_id', $user->id)->distinct()->paginate(20);
        
        return view('users.show', [
            'user' => $user,
            'books' => $books,
            'count_have' => $count_have,
        ]);
    }
    
    public function index()
    {
        $users = User::OrderBy('name')->get();

        return view('users.index', [
            'users' => $users,
        ]);
    }
    
    
    
    
    public function taikai()
    {
       $user = \Auth::user();
       
        return view('users.taikai',['user'=> $user]);
    }
    
    public function destroy($id)
    {
        $user = User::find($id);    
       
         $user->delete();
       
        return redirect()->back();
    }
   
}
