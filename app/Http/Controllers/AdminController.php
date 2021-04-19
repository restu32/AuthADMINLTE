<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\BooksExport;
use App\Imports\BooksImport;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index()
    {
        $user = Auth::user();
        return view('home',compact('user'));
    }
    public function export() 
    {
        return Excel::download(new BooksExport, 'books.xlsx');
    }


    public function import(Request $request) 
    {
        Excel::import(new BooksImport, $request->file('file'));

        $notification = array(
            'message' => 'Import data berhasil',
            'alert-type' => 'success'
        );
        
        return redirect()->route('admin.books')->with($notification);
    }
}
