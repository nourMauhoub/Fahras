<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;
use App\Http\Resources\BookResource;
use App\Http\Resources\BookCollection;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Elasticsearch\ClientBuilder;

class BookController extends Controller
{

    /*
    /**
     * Display a listing of the resource.
     */  //laravels search query and pagination
    public function index(Request $request)
    {

        $query = Book::query();

        if ($request->has('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', '%' . $search . '%')
                    ->orWhere('author', 'like', '%' . $search . '%')
                    ->orWhere('isbn', 'like', '%' . $search . '%');
            });
        }

        $perPage = $request->input('per_page', 3);
        $books = $query->paginate($perPage);

        if ($books->isEmpty()) {
            return response()->json(['message' => 'No matching results found!'], 404);
        }

        return new BookCollection($books);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|unique:books|max:255',
            'author' => 'required',
            'image' => 'required',
            'description' => 'required',
            'isbn' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $validated = $validator->validated();

        if ($request->hasFile('image')) {
            $bookImagePath = $request->file('image')->store('public/');
            $bookImagePath = str_replace('public/', '', $bookImagePath);
        } else {
            return response()->json(['error' => 'Image is required'], 400);
        }

        $book = Book::create([
            'title' => $validated['title'],
            'author' => $validated['author'],
            'image' => asset('/storage/' . $bookImagePath),
            'description' => $validated['description'],
            'isbn' => $validated['isbn'],
        ]);
        return response()->json($book, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $book = Book::find($id);

        if (!$book) {
            return response()->json(['message' => 'Book not found.'], 404);
        }

        return response()->json($book, 200);

    }

    /**
     * Update the specified resource in storage.
     */

    public function update(Request $request, Book $book)
    {
        if (!\Auth::check()) {
            return response()->json('Unauthenticated. Please log in or register.', 401);
        }
        $validator = Validator::make($request->all(), [
            'title' => 'required|unique:books,title,' . $book->id . '|max:255',
            'author' => 'required',
            'image' => 'required|image',
            'description' => 'required',
            'isbn' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $validated = $validator->validated();

        if ($request->hasFile('image')) {

            $bookImagePath = $request->file('image')->store('public/');
            $bookImagePath = str_replace('public/', '', $bookImagePath);
            $validated['image'] = asset('/storage/' . $bookImagePath);
        }

        $book->update($validated);

        return new BookResource($book);
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $book = Book::find($id);
        if (!$book) {
            return response()->json(['message' => 'Book not found.'], 404);
        }

        $bookImagePath = str_replace(url('/storage/'), 'public/', $book->image);

        if (\Storage::exists($bookImagePath)) {
            \Storage::delete($bookImagePath);
        }

        $book->delete();
        return response()->json(['message' => 'Book deleted successfully.'], 200);
    }


 /**
     * Eliasticsearch 
     */
    public function search(Request $request)
    {
        $client = ClientBuilder::create()->setHosts(['localhost:9200'])->build();
        $query = $request->input('query');

        if (empty($query)) {
            return response()->json(['error' => 'Query parameter is required.'], 400);
        }

        $params = [
            'index' => 'books',
            'body' => [
                'query' => [
                    'multi_match' => [
                        'query' => $query,
                        'fields' => ['title', 'author', 'isbn'],
                    ]
                ]
            ]
        ];

        try {
            $results = $client->search($params);
            return response()->json($results['hits']['hits']);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

}