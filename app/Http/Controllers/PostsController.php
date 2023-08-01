<?php

namespace App\Http\Controllers;

use App\Http\Services\PostsService;
use Illuminate\Http\Request;
use App\Models\Posts;
use Illuminate\Support\Facades\Storage;

class PostsController extends Controller
{
    //
    public function uploadFile(Request $request)
    {
        if ($request->hasHeader('Authorization')) {
            if ($request->hasFile('file')) {
                $file = $request->file('file');

                $fileName = $file->getClientOriginalName();
                $filePath = $file->store('upload');

                return response()->json(['message' => 'File uploaded successfully', 'fileName' => $fileName, 'filePath' => $filePath]);
            } else {
                return response()->json(['message' => 'No file uploaded'], 400);
            }
        } else {
            return response()->json(['message' => 'Authorization not existed'], 500);
        }
    }

    public function getFilePath($filename, Request $request)
    {
        if ($request->hasHeader('Authorization')) {
            $path = 'upload/' . $filename;
            $filePath = Storage::path($path);

            if (file_exists($filePath)) {
                return response()->file($filePath);
            } else {
                abort(404);
            }
        } else {
            return response()->json(['message' => 'Authorization not existed'], 500);
        }
    }

    public function search_post(Request $request)
    {
        if ($request->hasHeader('Authorization')) {
            $query = $request->input('searchValue');

            // Perform the search query on the posts table
            $posts = Posts::where('title', 'LIKE', "%$query%")
                ->orWhere('content', 'LIKE', "%$query%")
                ->get();

            // Return the search results as a JSON response
            return response()->json(['message' => 'success', 'data' => $posts]);
        } else {
            return response()->json(['message' => 'Authorization not existed'], 500);
        }
    }

    public function save_post(Request $request)
    {
        if ($request->hasHeader('Authorization')) {
            $request->validate([
                'thumbnail' => 'required|string|max:255',
                'title' => 'required|string|max:255',
                'content' => 'required|string|max:255',
                'publishStatus' => 'required|string|max:255',
                'publishDate' => 'required|string|max:255',
                'publishBy' => 'required|string|max:255',
            ]);

            $post = Posts::create([
                'file' => $request->input(key: 'file'),
                'thumbnail' => $request->input(key: 'thumbnail'),
                'title' => $request->input(key: 'title'),
                'content' => $request->input(key: 'content'),
                'publish_status' => $request->input(key: 'publishStatus'),
                'publish_date' => $request->input(key: 'publishDate'),
                'created_by' => $request->input(key: 'publishBy'),
            ]);

            return response()->json([
                'message' => 'success',
                'data' => $post
            ]);
        } else {
            return response()->json(['message' => 'Authorization not existed'], 500);
        }
    }

    public function view_post(Request $request)
    {
        if ($request->hasHeader('Authorization')) {
            $post = Posts::all();

            return response()->json([
                'message' => 'success',
                'data' => $post
            ]);
        } else {
            return response()->json(['message' => 'Authorization not existed'], 500);
        }
    }

    public function update_post($id, Request $request)
    {
        if ($request->hasHeader('Authorization')) {
            $posts = Posts::find($id);

            $request->validate([
                'thumbnail' => 'required|string|max:255',
                'title' => 'required|string|max:255',
                'content' => 'required|string|max:255',
                'publishStatus' => 'required|string|max:255',
                'publishDate' => 'required|date',
                'rewriteBy' => 'required|string|max:255',
            ]);

            $posts->update([
                'file' => $request->input(key: 'file'),
                'thumbnail' => $request->input(key: 'thumbnail'),
                'title' => $request->input(key: 'title'),
                'content' => $request->input(key: 'content'),
                'publish_status' => $request->input(key: 'publishStatus'),
                'publish_date' => $request->input(key: 'publishDate'),
                'updated_by' => $request->input(key: 'rewriteBy'),
            ]);

            return response()->json([
                'message' => 'success',
                'data' => $posts
            ]);
        } else {
            return response()->json(['message' => 'Authorization not existed'], 500);
        }
    }


    public function delete_post($id, Request $request)
    {
        if ($request->hasHeader('Authorization')) {
            $posts = Posts::find($id);

            $posts->delete();

            return response()->json([
                'message' => 'success',
                'data' => $posts
            ]);
        } else {
            return response()->json(['message' => 'Authorization not existed'], 500);
        }
    }
}