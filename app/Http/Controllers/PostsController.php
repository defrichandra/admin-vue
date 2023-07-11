<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Posts;
use Illuminate\Support\Facades\Storage;

class PostsController extends Controller
{
    //
    public function uploadFile(Request $request)
    {
        if ($request->hasFile('file')) {
            $file = $request->file('file');

            $fileName = $file->getClientOriginalName();
            $filePath = $file->store('upload');

            return response()->json(['message' => 'File uploaded successfully', 'fileName' => $fileName, 'filePath' => $filePath]);
        } else {
            return response()->json(['message' => 'No file uploaded'], 400);
        }
    }

    public function getFilePath($filename)
    {
        $path = 'upload/' . $filename;
        $filePath = Storage::path($path);

        if (file_exists($filePath)) {
            return response()->file($filePath);
        } else {
            abort(404);
        }
    }

    public function save_post(Request $request)
    {

        $post = Posts::create([
            'file' => $request->input(key: 'file'),
            'thumbnail' => $request->input(key: 'thumbnail'),
            'title' => $request->input(key: 'title'),
            'content' => $request->input(key: 'content'),
            'publish_status' => $request->input(key: 'publishStatus'),
            'publish_date' => $request->input(key: 'publishDate'),
        ]);
        return response()->json([
            'message' => 'success',
            'data' => $post
        ]);
    }

    public function view_post(Request $request)
    {
        return Posts::all();
    }

    public function update_post($id, Request $request)
    {
        $posts = Posts::find($id);
        $posts->update($request->all());
        return response()->json([
            'message' => 'success',
            'data' => $posts
        ]);
    }


    public function delete_post($id)
    {
        $posts = Posts::find($id);
        $posts->delete();
        return response()->json([
            'message' => 'success',
            'data' => $posts
        ]);
    }
}