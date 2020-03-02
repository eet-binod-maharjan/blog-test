<?php

namespace App\Http\Controllers;

use App\Book;
use Illuminate\Http\Request;

class BookController extends Controller
{

    public function index()
    {

    }
    public function store()
    {
        $data = $this->validateRequest();
        Book::create($data);
    }

    public function update(Book $book)
    {
        $data = $this->validateRequest();
        $book->update($data);
    }

    public function destroy(Book $book)
    {
        $book->delete();
        return redirect()->route('book.index');
    }

    protected function validateRequest()
    {
        return request()->validate([
            'title' => 'required',
            'author_id' => 'required'
        ]);
    }
}
